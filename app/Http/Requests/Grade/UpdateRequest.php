<?php

namespace App\Http\Requests\Grade;

use App\Helpers\ResponseHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
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
            'name' => ['sometimes', 'required', 'string', 'unique:grades,name,' . $this->grade->id],
            'level' => ['sometimes', 'required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama grade harus diisi.',
            'name.string' => 'Nama grade harus berupa string.',
            'name.unique' => 'Nama grade sudah terdaftar.',
            'level.required' => 'Level grade harus diisi.',
            'level.integer' => 'Level grade harus berupa angka.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Nama grade',
            'level' => 'Level grade',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHelper::validationError($validator->errors()));
    }
}
