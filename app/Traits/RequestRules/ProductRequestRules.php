<?php

namespace App\Traits\RequestRules;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Validation\Rule;


trait ProductRequestRules
{

    public function validationRules(): array
    {
        return [
            'stock_alert' => 'sometimes|numeric|min:0',
            'photos' => 'sometimes|array',
            'photos.*' => 'mimes:jpeg,png,jpg,gif',
            'category' => 'sometimes|array',
            'catgory.*' => ['sometimes', Rule::in(Category::where("type", 0)->get()->pluck("id")->toArray())],
            'tag' => 'sometimes|array',
            'tag.*' => ['sometimes', Rule::in(Tag::where("type", 0)->get()->pluck("id")->toArray())],
            'description' => 'required|string|min:3',
            'attributs' => 'sometimes|array',
            'attributs.*' => 'sometimes|array',
            'attributs.*.*' => 'required|string|min:1',
            'unit' => 'required|string|min:1'
        ];
    }

    public function before(){
        $this->merge([
            'attributs' => is_array($this->attributs) ? $this->attributs : json_decode($this->attributs, true)
        ]);

        if (isset($this->category) && !is_array($this->category)) {
            $this->merge([
                'category' => $this->category == "" ? null : explode(',', $this->category)
            ]);
        }

        if (isset($this->tag) && !is_array($this->tag)) {
            $this->merge([
                'tag'      => $this->tag == "" ? null : explode(',', $this->tag),
            ]);
        }

    }
}
