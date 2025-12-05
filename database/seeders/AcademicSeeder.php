<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\Major;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicYear = AcademicYear::create([
            'year_start' => '2025',
            'year_end' => '2026',
            'name' => '2025/2026',
            'semester' => 1,
            'is_active' => true,
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'description' => '2025/2026',
        ]);

        $grade = Grade::create([
            'name' => 'X',
            'level' => 10,
        ]);

        $major = Major::create([
            'name' => 'Rekayasa Perangkat Lunak',
            'code' => 'RPL',
            'description' => 'Rekayasa Perangkat Lunak',
        ]);
    }
}
