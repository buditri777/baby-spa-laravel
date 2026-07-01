<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    protected $fillable = [
        'id', 'code', 'name', 'address', 'phone', 'email',
        'logo_url', 'is_active', 'latitude', 'longitude',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function users() { return $this->hasMany(User::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function services() { return $this->hasMany(Service::class); }
    public function therapists() { return $this->hasMany(Therapist::class); }
    public function expenses() { return $this->hasMany(Expense::class); }
}
