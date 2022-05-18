<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChooseSubject extends FormRequest
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
            'subjectIds' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'subjectIds.required' => 'Chưa Chọn Subject',
            'subjectIds.array' => 'List Subject Phải Là Mảng',
        ];
    }
}
