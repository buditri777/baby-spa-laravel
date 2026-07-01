<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Therapist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'user_id', 'branch_id', 'specialization', 'bio',
        'certificate_url', 'years_experience', 'is_active',
        'base_salary', 'join_date',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'years_experience' => 'integer',
        'base_salary'      => 'decimal:2',
        'join_date'        => 'date',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function user()       { return $this->belongsTo(User::class); }
    public function branch()     { return $this->belongsTo(Branch::class); }
    public function schedules()  { return $this->hasMany(Schedule::class); }
    public function fees()       { return $this->hasMany(TherapistFee::class); }
    public function dayActives() { return $this->hasMany(TherapistDayActive::class); }
    public function exceptions() { return $this->hasMany(ScheduleException::class); }
    public function attendances(){ return $this->hasMany(Attendance::class); }
}
