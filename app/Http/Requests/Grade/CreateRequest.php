<?php

namespace App\Http\Requests\Grade;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['required', 'string', 'unique:grades,name'],
            'level' => ['required', 'integer'],
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
}
