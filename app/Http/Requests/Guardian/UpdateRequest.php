<?php

namespace App\Http\Requests\Guardian;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Exceptions\HttpResponseException as ExceptionsHttpResponseException;

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
            'user_id' => 'required|exists:users,id',
            'nik' => 'string|max:255|unique:guardians,nik,' . $this->guardian->id,
            'name' => 'string|max:255',
            'phone' => 'string|max:255',
            'address' => 'string|max:255',
            'occupation' => 'string|max:255',
            'is_active' => 'boolean',
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
    
    public function messages()
    {
        return [
            'user_id.required' => 'User ID harus diisi',
            'user_id.exists' => 'User ID tidak ditemukan',
            'nik.required' => 'NIK harus diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'name.required' => 'Nama harus diisi',
            'phone.required' => 'Phone harus diisi',
            'address.required' => 'Address harus diisi',
            'occupation.required' => 'Occupation harus diisi',
            'is_active.required' => 'Is active harus diisi',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ExceptionsHttpResponseException(ResponseHelper::validationError($validator->errors()));
    }
}
