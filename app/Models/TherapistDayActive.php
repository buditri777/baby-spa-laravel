<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class TherapistDayActive extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['date'=>'date'];
}
