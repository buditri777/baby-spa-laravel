<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'password',
        'branch_id',
        'is_active',
        'phone_verified_at',
        'fcm_token',
        'avatar',
        'address_line',
        'province',
        'city',
        'district',
        'village',
        'homecare_latitude',
        'homecare_longitude',
        'referral_source',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password'           => 'hashed',
            'is_active'          => 'boolean',
            'phone_verified_at'  => 'datetime',
            'homecare_latitude'  => 'decimal:7',
            'homecare_longitude' => 'decimal:7',
        ];
    }

    // Relations
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class, 'parent_id');
    }

    public function therapist()
    {
        return $this->hasOne(Therapist::class);
    }

    public function bookingsAsTherapist()
    {
        return $this->hasMany(Booking::class, 'therapist_id');
    }

    public function bookingsAsParent()
    {
        return $this->hasMany(Booking::class, 'parent_id');
    }

    public function consultations()
    {
        return $this->hasMany(Consultation::class, 'parent_id');
    }

    public function personalAccessTokens()
    {
        return $this->morphMany(\Laravel\Sanctum\PersonalAccessToken::class, 'tokenable');
    }

    // Helpers
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function hasAnyRoleOf(array $roles): bool
    {
        return $this->hasAnyRole($roles);
    }
}
