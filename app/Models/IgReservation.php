<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class IgReservation extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    protected $guarded = [];
    public function user() { return $this->belongsTo(User::class); }
    public function service() { return $this->belongsTo(Service::class); }
    public function handler() { return $this->belongsTo(User::class, 'handler_id'); }
}