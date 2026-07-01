<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Expense extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    protected $guarded = [];
    protected $casts = ['expense_date'=>'date','amount'=>'decimal:2'];
    public function branch() { return $this->belongsTo(Branch::class); }
}