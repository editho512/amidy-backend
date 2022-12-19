<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $fillable = ['name', 'type'];

    CONST TYPE = ["article", "customer"];

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $this->getUserTypeByValue($value);
    }

    public function getTypeAttribute()
    {
        return self::TYPE[$this->attributes['type']];
    }

    private function getUserTypeByValue(String $userType): int
    {
        foreach (self::TYPE as $key => $type) {
            if ($type === $userType) return $key;
        }
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tags');
    }
}
