<?php
namespace App\Traits;

trait HasCuid
{
    public static function bootHasCuid(): void
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = static::generateCuid();
            }
        });
    }

    public static function generateCuid(): string
    {
        return strtolower(substr(str_replace(['+','/','='], '', base64_encode(random_bytes(16))), 0, 20)) . uniqid();
    }
}
