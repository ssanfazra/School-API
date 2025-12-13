<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\AcademicYearResource;
use App\Http\Resources\MajorResource;
use App\Http\Resources\GradeResource;
use App\Http\Resources\ClassroomResource;
use App\Http\Resources\GuardianResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nis' => $this->nis,
            'name' => $this->name,
            'photo' => $this->photo,
            'phone' => $this->phone,
            'address' => $this->address,
            'gender' => $this->gender,
            'religion' => $this->religion,
            'blood_type' => $this->blood_type,
            'birth_place' => $this->birth_place,
            'birth_date' => $this->birth_date ? $this->birth_date->format('Y-m-d') : null,
            'user' => new UserResource($this->whenLoaded('user')),
            'academic_year' => new AcademicYearResource($this->whenLoaded('academicYear')),
            'major' => new MajorResource($this->whenLoaded('major')),
            'grade' => new GradeResource($this->whenLoaded('grade')),
            'classroom' => new ClassroomResource($this->whenLoaded('classroom')),
            'guardian' => new GuardianResource($this->whenLoaded('guardian')),
        ];
    }
}
