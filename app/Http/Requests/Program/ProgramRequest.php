<?php

namespace App\Http\Requests\Program;

use App\Http\Requests\BaseRequest;

class ProgramRequest extends BaseRequest
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
            'program_name' => $this->sanitizeString('program_name'),
            'program_description' => $this->sanitizeString('program_description'),
            'repeat_time' => $this->sanitizeString('repeat_time'),
            'schedule' => $this->input('schedule'),
            'teacher_id' => $this->input('teacher_id'),
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
            'program_name' => 'required|string',
            'program_description' => 'string',
            'schedule' => 'array',
            'repeat_time' => 'string',
            'teacher_id' => 'required|integer',
        ];
    }
}
