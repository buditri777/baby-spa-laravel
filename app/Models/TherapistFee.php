<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TherapistFee extends Model
{
    protected $fillable = [
        'id', 'therapist_id', 'service_id',
        'fee_type', 'fee_value', 'honor_per_session',
    ];

    protected $casts = [
        'fee_value'        => 'decimal:2',
        'honor_per_session' => 'decimal:2',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function therapist() { return $this->belongsTo(Therapist::class); }
    public function service()   { return $this->belongsTo(Service::class); }
}
