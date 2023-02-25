<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const METHODS = ['Pay On delivry', "Visa card", "Paypal"];

    public $fillable = ["order_id", "amount", "attributes", "payment_method"];
}
