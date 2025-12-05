<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassroomResource extends JsonResource
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
            'name' => $this->name,
            'class_code' => $this->class_code,
            'description' => $this->description,
            'grade' => $this->whenLoaded('grade', function () {
                return new GradeResource($this->grade);
            }),
            'major' => $this->whenLoaded('major', function () {
                return new MajorResource($this->major);
            }),
            'academic_year' => $this->whenLoaded('academicYear', function () {
                return new AcademicYearResource($this->academicYear);
            }),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
