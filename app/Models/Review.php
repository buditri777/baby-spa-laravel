<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Review extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
    public function booking() { return $this->belongsTo(Booking::class); }
    public function therapist() { return $this->belongsTo(User::class, 'therapist_id'); }
    public function parent() { return $this->belongsTo(User::class, 'parent_id'); }
}