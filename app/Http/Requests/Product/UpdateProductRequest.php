<?php

namespace App\Http\Requests\Product;

use App\Models\PhotoProduct;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestRules\ProductRequestRules;


class UpdateProductRequest extends FormRequest
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
        return $this->validationRules()  + [
            'name' => ['required', 'min:2', Rule::unique('products', 'name')->ignore($this->id)],
            'photos_updated' => ['sometimes', 'array'],
            'photos_updated.*.id' => ['sometimes', Rule::in(PhotoProduct::where("product_id", $this->id)->get()->pluck("id")->toArray())],
            'photos_updated.*.photo' => ['sometimes', Rule::in(PhotoProduct::where("product_id", $this->id)->get()->pluck("photo")->toArray())],

        ];
    }

    protected function prepareForValidation(): void
    {
        $this->before();

        if($this->photos_updated && $this->photos_updated !== "") $this->merge(['photos_updated' => json_decode($this->photos_updated, true)]);
    }
}
