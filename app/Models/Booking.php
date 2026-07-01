<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'parent_id', 'child_id', 'therapist_id', 'service_id', 'branch_id',
        'scheduled_date', 'scheduled_time', 'status', 'notes',
        'is_homecare', 'homecare_arrived_at', 'homecare_finished_at',
        'booking_code', 'cancellation_reason', 'cancelled_at',
    ];

    protected $casts = [
        'is_homecare'          => 'boolean',
        'scheduled_date'       => 'date',
        'homecare_arrived_at'  => 'datetime',
        'homecare_finished_at' => 'datetime',
        'cancelled_at'         => 'datetime',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function parent()    { return $this->belongsTo(User::class, 'parent_id'); }
    public function child()     { return $this->belongsTo(Child::class); }
    public function therapist() { return $this->belongsTo(User::class, 'therapist_id'); }
    public function service()   { return $this->belongsTo(Service::class); }
    public function branch()    { return $this->belongsTo(Branch::class); }
    public function session()   { return $this->hasOne(Session::class); }
    public function payment()   { return $this->hasOne(Payment::class); }
}
