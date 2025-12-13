<?php

namespace App\Http\Requests\Student;

use App\Helpers\ResponseHelper;
use Illuminate\Validation\Rule;
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
            'user_id' => ['nullable', 'exists:users,id'],
            'current_academic_year_id' => ['required', 'exists:academic_years,id'],
            'current_major_id' => ['required', 'exists:majors,id'],
            'current_grade_id' => ['required', 'exists:grades,id'],
            'current_classroom_id' => ['required', 'exists:classrooms,id'],
            'guardian_id' => ['nullable', 'exists:guardians,id'],
            'nis' => [
                'sometimes', 
                'string', 
                'max:20', 
                Rule::unique('students', 'nis')->ignore($this->student)
            ],
            'name' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048', 'mimetypes:image/jpeg,image/png,image/jpg'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:male,female'],
            'religion' => ['nullable', 'in:islam,kristen,hindu,buddha,konghucu,other'],
            'blood_type' => ['nullable', 'in:A,B,AB,O'],
            'birth_place' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'User tidak ditemukan.',
            'current_academic_year_id.exists' => 'Tahun akademik tidak ditemukan.',
            'current_major_id.exists' => 'Jurusan tidak ditemukan.',
            'current_grade_id.exists' => 'Kelas tidak ditemukan.',
            'current_classroom_id.exists' => 'Kelas tidak ditemukan.',
            'guardian_id.exists' => 'Wali murid tidak ditemukan.',
            'nis.unique' => 'NIS sudah digunakan.',
            'name.string' => 'Nama harus berupa string.',
            'name.max' => 'Nama harus kurang dari 255 karakter.',
            'photo.image' => 'Foto harus berupa gambar.',
            'photo.mimes' => 'Foto harus berupa gambar dengan format jpeg, png, atau jpg.',
            'photo.max' => 'Foto harus kurang dari 2048 kilobyte.',
            'phone.string' => 'Nomor telepon harus berupa string.',
            'phone.max' => 'Nomor telepon harus kurang dari 255 karakter.',
            'address.string' => 'Alamat harus berupa string.',
            'address.max' => 'Alamat harus kurang dari 255 karakter.',
            'gender.in' => 'Jenis kelamin harus berupa male atau female.',
            'religion.in' => 'Agama harus berupa islam, kristen, hindu, buddha, konghucu, atau other.',
            'blood_type.in' => 'Golongan darah harus berupa A, B, AB, atau O.',
            'birth_place.max' => 'Tempat lahir harus kurang dari 255 karakter.',
            'birth_date.date' => 'Tanggal lahir harus berupa tanggal.',
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id' => 'User',
            'current_academic_year_id' => 'Tahun akademik',
            'current_major_id' => 'Jurusan',
            'current_grade_id' => 'Kelas',
            'current_classroom_id' => 'Kelas',
            'guardian_id' => 'Wali murid',
            'nis' => 'NIS',
            'name' => 'Nama',
            'photo' => 'Foto',
            'phone' => 'Nomor telepon',
            'address' => 'Alamat',
            'gender' => 'Jenis kelamin',
            'religion' => 'Agama',
            'blood_type' => 'Golongan darah',
            'birth_place' => 'Tempat lahir',
            'birth_date' => 'Tanggal lahir',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(ResponseHelper::validationError($validator->errors()));
    }
}
