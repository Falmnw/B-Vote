<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AllowedMemberController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\OrganizationController;
use App\Models\AllowedMember;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/auth/google/callback', function () {
    $googleUser = Socialite::driver('google')->user();

    $user = User::updateOrCreate([
        'google_id' => $googleUser->id,
    ], [
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'google_token' => $googleUser->token,
        'google_refresh_token' => $googleUser->refreshToken,
    ]);

    $raw = $googleUser->user ?? [];
    $emailVerified = isset($raw['email_verified']) ? (bool)$raw['email_verified'] : true;
    if ($emailVerified) {
        $allowed = \App\Models\AllowedMember::where('email', $user->email)->get();
        foreach ($allowed as $a) {
            $user->organizations()->syncWithoutDetaching([$a->organization_id]);
        }
    }


    if ($user->email === 'irwanirwansyah783@gmail.com') {
        $user->role = 'admin';
        $user->save();
    }

    Auth::login($user);
    if ($user->role === 'admin') {
        return redirect('/admin');
    }
    return redirect('/dashboard');
});

Route::middleware('auth','securityHeader')->group(function (){
    Route::get('/',[Dashboard::class, 'index']);
    Route::get('/dashboard',[Dashboard::class, 'index']);

    Route::post('/pick-organization',[OrganizationController::class, 'store']);
    Route::get('/want-candidate',[CandidateController::class, 'want'])->name('candidate.want');
    Route::post('/store-candidate',[CandidateController::class, 'store'])->name('candidate.store');
    Route::get('/list-organization',[OrganizationController::class, 'list']);
    Route::get('/organization/{id}',[OrganizationController::class, 'show'])->name('organization.show');
    Route::get('/organization/{id}/member',[OrganizationController::class, 'member'])->name('organization.member');
    Route::get('/organization/{id}/candidate',[OrganizationController::class, 'candidate'])->name('organization.candidate');
    Route::get('/organization/{id}/give-role',[OrganizationController::class, 'giveRole'])->name('organization.give-role');
    Route::post('/organization/{id}/give-role',[OrganizationController::class, 'storeRole'])->name('organization.give-role');
    Route::get('/organization/{id}/organizatoinProfile', [OrganizationController::class, 'profile'])->name('organization.profile');
    Route::post('/organization/{id}/organizationChangeProfile', [OrganizationController::class, 'changeProfile'])->name('organization.changeProfile');
    Route::get('/organization/{id}/store-email',[AllowedMemberController::class, 'show'])->name('organization.store-email');
    Route::post('/organization/{id}/store-email',[AllowedMemberController::class, 'store'])->name('organization.store-email');
    Route::get('/organization/{id}/store-candidate',[CandidateController::class, 'show'])->name('organization.store-candidate');
    Route::post('/organization/{id}/store-candidate',[CandidateController::class, 'storeCandidate'])->name('organization.store-candidate');
    Route::post('/organization/{id}/store-vote',[CandidateController::class, 'storeVote'])->name('organization.store-vote');
    Route::get('/organization/{id}/create-session',[CandidateController::class, 'createSession'])->name('organization.create-session');
    Route::post('/organization/{id}/create-session',[CandidateController::class, 'storeSession'])->name('organization.create-session');
    Route::get('/candidate/{candidate}',[CandidateController::class, 'detail'])->name('candidate.show');
    Route::post('/organization/{id}/delete-session',[CandidateController::class, 'deleteSession'])->name('organization.delete-session');
    Route::get('/logout', function (Request $request) {
    Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

Route::middleware('auth', 'isAdmin', 'securityHeader')->group(function (){
    Route::get('/admin',[Admin::class, 'index']);
    Route::get('/adminStoreEmail', [Admin::class, 'storeEmail'])->name('admin.storeEmail');
    Route::post('/adminStoreEmail', [AllowedMemberController::class, 'store']);
    Route::get('/viewOrganization', [Admin::class, 'viewOrganization'])->name('admin.viewOrganization');
    Route::get('/viewUserRole/{id}', [Admin::class, 'viewUserRole'])->name('viewUserRole');
    Route::post('/changeUserRole', [Admin::class, 'changeUserRole'])->name('changeUserRole');
});
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


