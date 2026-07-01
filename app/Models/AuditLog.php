<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class AuditLog extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['before'=>'array','after'=>'array'];
    public function user() { return $this->belongsTo(User::class); }
}