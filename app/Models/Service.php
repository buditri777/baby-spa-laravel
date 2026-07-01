<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'id', 'name', 'slug', 'category', 'duration_min', 'price',
        'description', 'photo_url', 'is_active',
        'age_min_months', 'age_max_months', 'branch_id',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'price'           => 'decimal:2',
        'duration_min'    => 'integer',
        'age_min_months'  => 'integer',
        'age_max_months'  => 'integer',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function branch()   { return $this->belongsTo(Branch::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function fees()     { return $this->hasMany(TherapistFee::class); }
}
