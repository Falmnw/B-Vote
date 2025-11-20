<?php

namespace App\Http\Controllers;

use App\Models\AllowedMember;
use App\Models\Candidate;
use App\Models\Organization;
use App\Models\OrganizationUser;
use App\Models\Poll;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class OrganizationController extends Controller
{
    private function getAdminAuthorizedOrganization($id, $with = [])
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $organization = $user->organizations()->where('organization_id', $id)->first();
        if (!$organization) {
            abort(403, $id);
        }
        if ($organization->pivot->role_id) {
            $roleName = $organization->pivot->role->name;

            if ($roleName !== 'Admin') {
                abort(403, 'Unauthorized access');
            }
        } else {
            abort(403, 'Unauthorized access');
        }
        return true;
    }

    private function getAuthorizedOrganization($id, $with = []){
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $organization = $user->organizations()->where('organization_id', $id)->first();
        if (!$organization) {
            abort(403, 'Unauthorized access');
        }
        return Organization::with($with)->findOrFail($id);
    }

    public function store(Request $request){
        $request->validate([
            'organization_id' => 'required|integer|exists:organizations,id',
        ]);
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isAllowed = AllowedMember::where('email', $user->email)->where('organization_id', $request->organization_id)->exists();
        if (!$isAllowed) {
            return redirect('/')->with('error', 'Email Anda tidak diizinkan untuk bergabung ke organisasi ini.');
        }
        $user->organizations()->syncWithoutDetaching([$request->organization_id]);

        return redirect('/')->with('success', 'Berhasil bergabung ke organisasi!');
    }

    public function list(){
        $organizations = Organization::all();
        return view('organization.list', compact('organizations'));
    }

    public function show($id)
    {
        $sesi = Poll::where('organization_id', $id)->first();
        $organization = Organization::with('candidates')->findOrFail($id);
        $user = Auth::user();
        $winner = $organization->candidates()->orderByDesc('total')->first();
        return view('organization.show', compact('sesi', 'organization','user', 'winner'));
    }

    public function candidate($id)
    {
        $organization = $this->getAuthorizedOrganization($id, ['candidates']);
        $user = Auth::user();
        return view('organization.candidate', compact('organization', 'user'));
    }

    public function member($id)
    {
        $organization = $this->getAuthorizedOrganization($id);
        return view('organization.member', compact('organization'));
    }
    public function giveRole($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $adminRoleId = Role::where('name', 'Admin')->value('id');
        $exists = $user->organizations()->where('organization_id', $id)->where('role_id', $adminRoleId)->exists();
        if (!$exists) {
            abort(403, 'Unauthorized access');
        }
        $organization = Organization::findOrFail($id);
        return view('organization.give-role', compact('organization'));
    }
    public function storeRole(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'organization_id' => 'required|integer|exists:organizations,id',
            'role_id' => 'required|integer|exists:roles,id',
        ]);
        $this->getAdminAuthorizedOrganization($request->organization_id);
        $organization = $this->getAuthorizedOrganization($request->organization_id);
        $adminRoleId = Role::where('name', 'Admin')->value('id');
        $candidateRoleId = Role::where('name', 'Candidate')->value('id');

        $user_id = $request->input('user_id');
        $organization_id = $request->input('organization_id');
        $role_id = $request->input('role_id');

        if ($user->id == $user_id) {
            abort(403, 'You cannot change your own role.');
        }

        OrganizationUser::where('user_id', $user_id)
                        ->where('organization_id', $organization_id)
                        ->update(['role_id' => $role_id]);
        if ($request->role_id == $candidateRoleId) {
            Candidate::firstOrCreate([
                'user_id' => $request->user_id,
                'organization_id' => $organization->id,
            ], ['total' => 0]);
        }

        return view('organization.give-role', compact('organization'));
    }
    public function profile($id){
        $organization = Organization::with('candidates')->findOrFail($id);
        return view('organization.profile', compact('organization'));
    }

    public function changeProfile(Request $request, $id)
    {
        // Validasi aman
        $request->validate([
            'logo' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
                'dimensions:min_width=50,min_height=50,max_width=4000,max_height=4000'
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:2000' // batas aman
            ],
        ]);

        $this->getAdminAuthorizedOrganization($id);
        $organization = $this->getAuthorizedOrganization($id);

        // Cek polyglot / validitas gambar
        if (! @getimagesize($request->file('logo')->getRealPath())) {
            return back()->withErrors(['logo' => 'File tidak valid sebagai gambar.']);
        }

        // Baca file pakai Intervention v3
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->file('logo')->getRealPath());

        // Normalisasi EXIF dan format
        // Resize prevent BOM attack / overly huge files
        $image->scale(width: 800); // optional

        // Encode ke webp aman
        $encoded = $image->toWebp(80);

        // Nama file aman
        $filename = uniqid('org_', true) . '.webp';

        // Simpan binary ke storage
        Storage::disk('public')->put('photos/' . $filename, $encoded);

        // Update DB
        $organization->logo = 'photos/' . $filename;
        $organization->deskripsi = $request->deskripsi; 
        $organization->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }


}
