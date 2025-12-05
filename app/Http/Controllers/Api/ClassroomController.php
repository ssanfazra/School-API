<?php

namespace App\Http\Controllers\Api;

use App\Models\Classroom;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClassroomResource;
use App\Http\Requests\Classroom\CreateRequest;
use App\Http\Requests\Classroom\UpdateRequest;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success(ClassroomResource::collection(Classroom::all()), 'Classrooms retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $request = $request->validated();

        try {
            
            DB::beginTransaction();

            $nameToUppercase = strtoupper($request['name']);
            $classCodeToUppercase = strtoupper($request['class_code']);

            $classroom = Classroom::query()->create([
                'major_id' => $request['major_id'],
                'academic_year_id' => $request['academic_year_id'],
                'grade_id' => $request['grade_id'],
                'name' => $nameToUppercase,
                'class_code' => $classCodeToUppercase,
                'description' => $request['description'],
            ]);

            DB::commit();

            return ResponseHelper::success(new ClassroomResource($classroom), 'Classroom created successfully', 201);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error creating classroom: ' . $e->getMessage());
            return ResponseHelper::error('Error', 'Error creating classroom', 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        if (!$classroom) {
            return ResponseHelper::error('Error', 'Classroom not found', 404);
        }

        return ResponseHelper::success(new ClassroomResource($classroom), 'Classroom retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Classroom $classroom)
    {
        $request = $request->validated();
        
        try {
            
            DB::beginTransaction();

            if (!$classroom) {
                return ResponseHelper::error('Error', 'Classroom not found', 404);
            }

            $nameToUppercase = strtoupper($request['name']);
            $classCodeToUppercase = strtoupper($request['class_code']);

            $classroom->update([
                'major_id' => $request['major_id'],
                'academic_year_id' => $request['academic_year_id'],
                'grade_id' => $request['grade_id'],
                'name' => $nameToUppercase,
                'class_code' => $classCodeToUppercase,
                'description' => $request['description'],
            ]);

            DB::commit();

            return ResponseHelper::success(new ClassroomResource($classroom), 'Classroom updated successfully', 200);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error updating classroom: ' . $e->getMessage());
            return ResponseHelper::error('Error', 'Error updating classroom', 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Classroom $classroom)
    {
        try {
            
            DB::beginTransaction();

            if (!$classroom) {
                return ResponseHelper::error('Error', 'Classroom not found', 404);
            }

            $classroom->delete();

            DB::commit();

            return ResponseHelper::success(new ClassroomResource($classroom), 'Classroom deleted successfully', 200);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error deleting classroom: ' . $e->getMessage());
            return ResponseHelper::error('Error', 'Error deleting classroom', 500);

        }
    }
}
