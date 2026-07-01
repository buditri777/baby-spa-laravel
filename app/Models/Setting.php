<?php
namespace App\Models;
use App\Traits\HasCuid;
use Illuminate\Database\Eloquent\Model;
class Setting extends Model {
    use HasCuid;
    protected $keyType = 'string'; public $incrementing = false;
    protected $guarded = [];
    public static function get(string $key, $default = null) {
        return static::where('key', $key)->value('value') ?? $default;
    }
    public static function set(string $key, $value): void {
        static::updateOrCreate(['key'=>$key],['value'=>$value,'id'=>static::generateCuid()]);
    }
}