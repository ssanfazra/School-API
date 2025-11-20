<?php

namespace App\Http\Requests\Classroom;

use App\Helpers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
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
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'grade_id' => ['required', 'exists:grades,id'],
            'major_id' => ['required', 'exists:majors,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'class_code' => ['sometimes', 'required', 'string', 'max:255', 'unique:classrooms,class_code,' . $this->route('classroom')],
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
            'academic_year_id.required' => 'Tahun akademik harus diisi.',
            'grade_id.required' => 'Kelas harus diisi.',
            'major_id.required' => 'Jurusan harus diisi.',
            'name.required' => 'Nama kelas harus diisi.',
            'description.string' => 'Deskripsi kelas harus berupa string.',
            'description.max' => 'Deskripsi kelas maksimal 255 karakter.',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'academic_year_id' => 'Tahun akademik',
            'grade_id' => 'Kelas',
            'major_id' => 'Jurusan',
            'name' => 'Nama kelas',
            'description' => 'Deskripsi kelas',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHelper::validationError($validator->errors()));
    }
}
