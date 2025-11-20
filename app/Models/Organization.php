<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'member'];
    public function users()
    {
        return $this->belongsToMany(User::class, 'organization_users')
                    ->using(OrganizationUser::class)
                    ->withPivot('role_id')
                    ->withTimestamps();
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function getRoleUser(){
        $user_id =  Auth::user()->id;

        if (!$user_id) {
            return null;
        }
        $userOrganization = $this->users()->where('user_id', $user_id)->first();
        if (!$userOrganization) {
            return 'guest';
        }

        $role = $this->users()->where('user_id', $user_id)->first()->pivot->role->name;
        return $role;
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
    public function allowedMembers() {
        return $this->hasMany(AllowedMember::class);
    }
    public function polls()
    {
        return $this->hasMany(Poll::class);
    }
}
