<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends BaseRequest
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
     * @return string[] The validation rules
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'unique:users|required|email',
            'password' => 'required|confirmed',
            'fromSocial' => 'array',
            'avatar'    => 'string',
            'phone'    => 'required|string',
            'role_name' => [
                'required',
                Rule::notIn(['super-admin']),
            ],
        ];
    }

    public function messages()
    {
        $messages = [
            'email.required' => 'The :attribute field is required.',
        ];

        return $messages;
    }
}
