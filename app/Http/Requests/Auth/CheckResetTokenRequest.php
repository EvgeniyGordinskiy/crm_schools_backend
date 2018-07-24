<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\BaseRequest;

class CheckResetTokenRequest extends BaseRequest
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

    protected function prepareForValidation()
    {
        $this->replace([
            'token' => $this->sanitizeString('token'),
        ]);
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token' => 'required|string'
        ];
    }
}
