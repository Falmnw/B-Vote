<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class buat_sesi extends Model
{
    protected $fillable = [
        'organization_id',
        'title',
        'start_time',
        'end_time'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

}
