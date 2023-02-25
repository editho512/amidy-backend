<?php

namespace App\Rules;

use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;

class CheckProductQuantityRule implements Rule
{
    protected $data;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //first we have to get the product index
        $attributes = explode('.', $attribute);
        $index = isset($attributes[1]) ? intval($attributes[1]) : null;
        $product_id = isset($this->data[$index]) ? $this->data[$index] : null;


        if($product_id) {
            $product = Product::find($product_id);
            if($product->stock && doubleVal($product->stock) >= doubleval($value)) return true;
        }
        return false ;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The quantity is not enougth';
    }
}
