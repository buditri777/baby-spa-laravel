<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'child_id', 'therapist_id', 'service_id', 'branch_id',
        'scheduled_at', 'duration_min', 'status', 'total_price', 'notes',
        'is_walk_in', 'is_homecare', 'homecare_distance_km',
        'homecare_transport_fee', 'homecare_queue_fee',
        'homecare_arrived_at', 'homecare_finished_at',
        'dp_amount', 'dp_forfeited', 'dp_forfeited_at',
        'cancel_reason', 'cancelled_at',
    ];

    protected $casts = [
        'is_homecare'          => 'boolean',
        'is_walk_in'           => 'boolean',
        'dp_forfeited'         => 'boolean',
        'scheduled_at'         => 'datetime',
        'homecare_arrived_at'  => 'datetime',
        'homecare_finished_at' => 'datetime',
        'dp_forfeited_at'      => 'datetime',
        'cancelled_at'         => 'datetime',
        'total_price'          => 'decimal:2',
    ];

    // Accessor: agar view lama yang pakai ->scheduled_date / ->scheduled_time tetap jalan
    public function getScheduledDateAttribute()
    {
        return $this->scheduled_at?->setTimezone('Asia/Jakarta');
    }

    public function getScheduledTimeAttribute()
    {
        return $this->scheduled_at?->setTimezone('Asia/Jakarta')->format('H:i');
    }

    public function getBookingCodeAttribute()
    {
        return 'BSP-' . strtoupper(substr($this->id, 0, 8));
    }

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
