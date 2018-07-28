<?php

namespace App\Http\Requests\School;

use App\Http\Requests\BaseRequest;

class CreateSchoolRequest extends BaseRequest
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
            'name' => $this->sanitizeString('name'),
            'address' => $this->sanitizeString('address'),
            'phone' => $this->input('phone')
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
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ];
    }
}
