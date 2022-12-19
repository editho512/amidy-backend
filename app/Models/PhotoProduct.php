<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoProduct extends Model
{
    use HasFactory;

    public $fillable = ['product_id', 'photo', 'order'];
    public $timestamps = false;
}
