<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateUserRequest extends FormRequest
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
            'name' => 'required|min:3',
            'phone' => 'required|min:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'photo' => 'sometimes|mimes:jpeg,png,jpg,gif',
            'phone' => 'sometimes|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'type' => ['required', Rule::in(User::TYPE)]
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
