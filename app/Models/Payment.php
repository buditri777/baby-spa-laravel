<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    protected $guarded = [];
    protected $casts = ['paid_at'=>'datetime','amount'=>'decimal:2'];
    public function booking() { return $this->belongsTo(Booking::class); }
}