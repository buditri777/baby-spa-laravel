<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Payslip extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    protected $guarded = [];
    protected $casts = ['base_salary'=>'decimal:2','session_fee'=>'decimal:2','net_salary'=>'decimal:2'];
    public function period() { return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id'); }
    public function therapist() { return $this->belongsTo(User::class, 'therapist_id'); }
}