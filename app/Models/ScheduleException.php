<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleException extends Model
{
    protected $fillable = [
        'id', 'therapist_id', 'date', 'reason', 'is_available',
    ];

    protected $casts = [
        'date'         => 'date',
        'is_available' => 'boolean',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function therapist() { return $this->belongsTo(Therapist::class); }
}
