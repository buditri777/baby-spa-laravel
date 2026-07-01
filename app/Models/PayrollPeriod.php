<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class PayrollPeriod extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    protected $guarded = [];
    protected $casts = ['finalized_at'=>'datetime'];
    public function branch() { return $this->belongsTo(Branch::class); }
    public function payslips() { return $this->hasMany(Payslip::class); }
}