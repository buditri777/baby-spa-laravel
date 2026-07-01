<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $fillable = [
        'id', 'user_id', 'phone', 'code', 'type',
        'expires_at', 'used_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at'    => 'datetime',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function user() { return $this->belongsTo(User::class); }
}
