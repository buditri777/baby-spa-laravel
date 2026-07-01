<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;

class ServiceRate extends Model {
    use HasCuid;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];
    protected $casts = [
        'fee_value'           => 'decimal:2',
        'homecare_base_fee'   => 'decimal:2',
        'homecare_per_km_fee' => 'decimal:2',
    ];
    public function service() { return $this->belongsTo(Service::class); }
}
