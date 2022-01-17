<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCreditStudentRequest extends FormRequest
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
            'subjectIds.required' => 'Chưa Chọn Môn Học',
            'subjectIds.array' => 'Danh Sách Môn Học Phải Là Mảng',
        ];
    }
}
