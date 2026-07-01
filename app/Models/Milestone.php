<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Milestone extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['achieved'=>'boolean','achieved_at'=>'date'];
    public function child() { return $this->belongsTo(Child::class); }
}