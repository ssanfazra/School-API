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
            'description' => $this->description,
            'grade_id' => $this->grade_id,
            'grade_name' => $this->grade->name,
            'major_id' => $this->major_id,
            'major_name' => $this->major->name,
            'academic_year_id' => $this->academic_year_id,
            'academic_year_name' => $this->academic_year->name,
            'class_code' => $this->class_code,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
