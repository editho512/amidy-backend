<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestRules\UserRequestRules;

class UserCreateRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',

        ];
    }

    public function messages()
    {
        return [

        ];
    }


}
