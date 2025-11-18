<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AllowedMember;
use App\Models\Organization;

class AllowedMemberController extends Controller
{
    private function getAuthorizedOrganization($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $organization = $user->organizations()->where('organization_id', $id)->first();

        if($user->role == 'admin'){
            return true;
        }
        if (!$organization) {
            abort(404, 'Organization not found');
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


    public function check(Request $request, $id){
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $isAllowed = AllowedMember::where('email', $user->email)->where('organization_id', $id)->exists();

        if (!$isAllowed) {
            return redirect('/')->with('error', 'Email Anda tidak diizinkan untuk bergabung ke organisasi ini.');
        }
        $user->organizations()->syncWithoutDetaching([$request->organization_id]);

        return redirect('/')->with('success', 'Berhasil bergabung ke organisasi!');
    }
    
    public function show($id){
        $this->getAuthorizedOrganization($id);
        $organization = Organization::findOrFail($id);
        return view('organization.store-email', compact('organization'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'organization_id' => ['required', 'integer', 'exists:organizations,id'],
        ]);
        $id = $validated['organization_id'];
        $check = $this->getAuthorizedOrganization($id);
        $exists = AllowedMember::where('email', $validated['email'])
            ->where('organization_id', $validated['organization_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Email ini sudah diizinkan untuk organisasi tersebut.');
        }

        AllowedMember::create([
            'email' => $validated['email'],
            'organization_id' => $validated['organization_id'],
        ]);

        return redirect()->back()->with('success', 'Email berhasil diimport!');
    }
}
