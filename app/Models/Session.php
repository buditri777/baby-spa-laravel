<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Session extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    protected $guarded = [];
    protected $casts = ['started_at'=>'datetime','ended_at'=>'datetime'];
    public function booking() { return $this->belongsTo(Booking::class); }
    public function child() { return $this->belongsTo(Child::class); }
    public function therapist() { return $this->belongsTo(User::class, 'therapist_id'); }
    public function media() { return $this->hasMany(SessionMedia::class); }
}