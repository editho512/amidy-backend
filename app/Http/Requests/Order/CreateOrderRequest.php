<?php

namespace App\Http\Requests\Order;

use App\Rules\CheckProductQuantityRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order' => 'required|array',
            'order.*.id' => 'required|exists:products',
            'order.*.quantity' => ['required', new CheckProductQuantityRule($this->input('order.*.id'))]
        ];
    }
}
