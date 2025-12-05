<?php

namespace App\Http\Requests\Classroom;

use App\Helpers\ResponseHelper;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'major_id' => ['required', 'exists:majors,id'],
            'grade_id' => ['required', 'exists:grades,id'],
            'name' => ['required', 'string', 'max:255'],
            'class_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('classrooms', 'class_code')->where(function ($q) {
                    return $q->where('academic_year_id', $this->academic_year_id);
                }),
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'academic_year_id.required' => 'Tahun ajaran harus diisi.',
            'major_id.required' => 'Jurusan harus diisi.',
            'grade_id.required' => 'Kelas harus diisi.',
            'name.required' => 'Nama kelas harus diisi.',
            'class_code.required' => 'Kode kelas harus diisi.',
        ];
    }

    public function attributes(): array
    {
        return [
            'academic_year_id' => 'Tahun ajaran',
            'major_id' => 'Jurusan',
            'grade_id' => 'Kelas',
            'name' => 'Nama kelas',
            'class_code' => 'Kode kelas',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHelper::validationError(
            $validator->errors()));
    }
}
