<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Organization;
use App\Models\OrganizationUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index(){
        $user = Auth::user();
        $organizations = Organization::all();
        $orguser = OrganizationUser::all();
        return view('dashboard', compact('user', 'organizations', 'orguser'));

    }
    public function other(){
        $user = Auth::user();
        $organizations = Organization::all();
        $orguser = OrganizationUser::all();
        return view('other-organization', compact('user', 'organizations', 'orguser'));

    }
}
