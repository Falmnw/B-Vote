<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    protected $fillable = [
        'organization_id',
        'created_by',
        'title',
        'start_time',
        'end_time',
    ];
    protected $casts = [
        'start_time' => 'datetime', // <-- Dipindahkan ke sini
        'end_time' => 'datetime',   // <-- Dipindahkan ke sini
    ];
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
