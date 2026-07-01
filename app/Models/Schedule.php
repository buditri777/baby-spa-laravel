<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Schedule extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['is_active'=>'boolean'];
    public function therapist() { return $this->belongsTo(User::class, 'therapist_id'); }
}