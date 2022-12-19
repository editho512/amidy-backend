<?php

namespace App\Http\Requests\Product;

use App\Models\Tag;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestRules\ProductRequestRules;

class CreateProductRequest extends FormRequest
{

    use ProductRequestRules;
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

        return $this->validationRules() + [
            'name' => 'required|unique:products,name|min:2',
        ];

    }

    // Form request class...
    protected function prepareForValidation(): void
    {
        $this->before();
    }
}
