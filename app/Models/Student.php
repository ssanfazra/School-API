<?php

namespace App\Models;

use App\Models\User;
use App\Models\Grade;
use App\Models\Major;
use App\Models\Guardian;
use App\Models\Classroom;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'current_academic_year_id',
        'current_major_id',
        'current_grade_id',
        'current_classroom_id',
        'guardian_id',
        'nis',
        'name',
        'photo',
        'phone',
        'address',
        'gender',
        'religion',
        'blood_type',
        'birth_place',
        'birth_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'current_academic_year_id', 'id');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'current_major_id', 'id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'current_grade_id', 'id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'current_classroom_id', 'id');
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
}
