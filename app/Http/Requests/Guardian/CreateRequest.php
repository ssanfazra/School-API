<?php

namespace App\Http\Requests\Guardian;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ResponseHelper;

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
            'user_id' => ['required', 'exists:users,id'],
            'nik' => ['nullable', 'string', 'min:16', 'max:255', 'unique:guardians,nik'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User ID harus diisi',
            'user_id.exists' => 'User ID tidak ditemukan',
            'nik.string' => 'NIK harus string',
            'nik.max' => 'NIK harus kurang dari 255 karakter',
            'nik.min' => 'NIK harus lebih dari 16 karakter',
            'nik.unique' => 'NIK sudah terdaftar',
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus string',
            'name.max' => 'Nama harus kurang dari 255 karakter',
            'phone.string' => 'Phone harus string',
            'phone.max' => 'Phone harus kurang dari 255 karakter',
            'address.string' => 'Address harus string',
            'address.max' => 'Address harus kurang dari 255 karakter',
            'occupation.string' => 'Occupation harus string',
            'occupation.max' => 'Occupation harus kurang dari 255 karakter',
            'is_active.required' => 'Is active harus diisi',
            'is_active.boolean' => 'Is active harus boolean',
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'User ID',
            'nik' => 'NIK',
            'name' => 'Nama',
            'phone' => 'Phone',
            'address' => 'Address',
            'occupation' => 'Occupation',
            'is_active' => 'Is active',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHelper::validationError($validator->errors()));
    }
}
