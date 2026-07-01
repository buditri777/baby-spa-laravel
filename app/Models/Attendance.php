<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Attendance extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    protected $guarded = [];
    protected $casts = ['date'=>'date','clock_in'=>'datetime','clock_out'=>'datetime'];
    public function therapist() { return $this->belongsTo(User::class, 'therapist_id'); }
}