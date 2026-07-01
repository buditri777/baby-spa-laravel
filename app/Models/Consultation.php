<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Consultation extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    protected $guarded = [];
    protected $casts = ['claimed_at'=>'datetime','closed_at'=>'datetime','expired_at'=>'datetime','last_activity_at'=>'datetime'];
    public function parent() { return $this->belongsTo(User::class, 'parent_id'); }
    public function therapist() { return $this->belongsTo(User::class, 'therapist_id'); }
    public function child() { return $this->belongsTo(Child::class); }
    public function messages() { return $this->hasMany(ConsultationMessage::class)->orderBy('created_at'); }
}