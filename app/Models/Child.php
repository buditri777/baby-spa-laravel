<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Child extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'parent_id', 'name', 'birth_date', 'gender',
        'birth_weight_kg', 'birth_height_cm', 'blood_type',
        'notes', 'photo_url',
    ];

    protected $casts = [
        'birth_date'       => 'date',
        'birth_weight_kg'  => 'decimal:2',
        'birth_height_cm'  => 'decimal:2',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function parent()           { return $this->belongsTo(User::class, 'parent_id'); }
    public function bookings()         { return $this->hasMany(Booking::class); }
    public function growthMeasurements() { return $this->hasMany(GrowthMeasurement::class); }
    public function milestones()       { return $this->hasMany(Milestone::class); }
    public function homeExercises()    { return $this->hasMany(HomeExercise::class); }
}
