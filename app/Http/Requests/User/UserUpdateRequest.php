<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestRules\UserRequestRules;

class UserUpdateRequest extends FormRequest
{

    use UserRequestRules;

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
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->id)],
            'password' => 'sometimes|confirmed|min:6',

        ];

    }
}
