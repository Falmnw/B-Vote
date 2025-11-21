<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\OrganizationUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Admin extends Controller
{
    public function index(){
        $user = Auth::user();
        $organizations = Organization::all();
        $roles = Role::all();
        return view('admin.dashboard', compact('user', 'organizations', 'roles'));
    }
    public function storeEmail(){
        $user = Auth::user();
        $organizations = Organization::all();
        $roles = Role::all();
        return view('admin.storeEmail', compact('user', 'organizations', 'roles'));
    }
    public function viewOrganization(){
        $organizations = Organization::all();
        return view('admin.viewOrganization', compact('organizations'));
    }
    public function viewUserRole(Request $request, $id)
    {
        $organization = Organization::with('users')->findOrFail($id);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'users' => $organization->users->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'email' => $user->email,
                    ];
                })
            ]);
            
        }
        $roles = Role::all(); // Asumsi Model Role ada
        
        return view('admin.viewUserRole', compact('organization', 'roles'));
    }

    public function changeUserRole(Request $request){
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'organization_id' => ['required', 'integer', 'exists:organizations,id'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        if ($user->organizations()->where('organization_id', $validated['organization_id'])->exists()) {
            $user->organizations()->updateExistingPivot(
                $validated['organization_id'],
                ['role_id' => $validated['role_id']]
            );
        } 
        else {
            $user->organizations()->attach($validated['organization_id'], [
                'role_id' => $validated['role_id']
            ]);
        }

        return back()->with('success', 'Role berhasil disimpan untuk user di organisasi.');
    }

}
