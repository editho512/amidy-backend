<?php

namespace App\Traits\RequestRules;

use App\Models\User;
use Illuminate\Validation\Rule;


Trait UserRequestRules {

    public function validationRules() : array {
        return [
            'name' => 'required|min:3',
            'phone' => 'required|min:10',
            'photo' => 'sometimes|mimes:jpeg,png,jpg,gif',
            'phone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'type' => ['required', Rule::in(User::TYPE)]
        ];
    }
}
