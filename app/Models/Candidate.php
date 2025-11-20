<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $fillable = [
        'session_id',
        'organization_id',
        'user_id',
        'email',
        'picture',
        'divisi',
        'visi',
        'misi'
    ];
    public function session()
    {
        return $this->belongsTo(buat_sesi::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
