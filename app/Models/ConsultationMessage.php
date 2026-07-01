<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class ConsultationMessage extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['read_at'=>'datetime'];
    public function consultation() { return $this->belongsTo(Consultation::class); }
    public function sender() { return $this->belongsTo(User::class, 'sender_id'); }
}