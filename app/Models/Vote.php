<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = [
        'poll_id',
        'organization_id',
        'user_id',
    ];

    public function session()
    {
        return $this->belongsTo(buat_sesi::class);
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
