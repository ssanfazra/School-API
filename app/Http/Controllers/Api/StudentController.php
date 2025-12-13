<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Student\CreateRequest;
use App\Http\Requests\Student\UpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success(StudentResource::collection(Student::with('user', 'academicYear', 'major', 'grade', 'classroom', 'guardian')->get()), 'Student data successfully retrieved', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $request = $request->validated();

        try {

            DB::beginTransaction();

            $student = Student::create($request);

            DB::commit();

            return ResponseHelper::success(new StudentResource($student->load('user', 'academicYear', 'major', 'grade', 'classroom', 'guardian')), 'Student data successfully created', 201);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error creating Student: '. $e->getMessage());
            return ResponseHelper::error('Error creating Student: '. $e->getMessage(), 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return ResponseHelper::success(new StudentResource($student->load('user', 'academicYear', 'major', 'grade', 'classroom', 'guardian')), 'Student data successfully retrieved', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Student $student)
    {
        $request = $request->validated();

        try {

            DB::beginTransaction();

            $student->update($request);

            DB::commit();
            return ResponseHelper::success(new StudentResource($student), 'Student data successfully updated', 200);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error updating Student: '. $e->getMessage());
            return ResponseHelper::error('Error updating Student: '. $e->getMessage(), 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        try {

            DB::beginTransaction();

            $student->delete();

            DB::commit();

            return ResponseHelper::success(new StudentResource($student), 'Student data successfully deleted', 200);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error deleting Student: '. $e->getMessage());
            return ResponseHelper::error('Error deleting Student: '. $e->getMessage(), 500);

        }
    }
}
