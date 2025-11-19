<?php

namespace App\Http\Controllers\Api;

use App\Models\Grade;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\GradeResource;
use App\Http\Requests\Grade\CreateRequest;
use App\Http\Requests\Grade\UpdateRequest;

class GradeController extends Controller
{
    public function index()
    {
        return ResponseHelper::success(GradeResource::collection(Grade::all()), 'Grades retrieved successfully', 200);
    }

    public function store(CreateRequest $request)
    {
        $request = $request->validated();

        try {
            
            DB::beginTransaction();

            $grade = Grade::query()->create($request);

            DB::commit();

            return ResponseHelper::success(new GradeResource($grade), 'Grade created successfully', 201);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error creating grade: ' . $e->getMessage());
            return ResponseHelper::error('Error', 'Error creating grade', 500);

        }
    }

    public function show(Grade $grade)
    {
        return ResponseHelper::success(new GradeResource($grade), 'Grade retrieved successfully', 200);
    }

    public function update(UpdateRequest $request, Grade $grade)
    {
        $validatedData = $request->validated();

        try {
            
            DB::beginTransaction();

            $grade->update($validatedData);

            DB::commit();

            return ResponseHelper::success(new GradeResource($grade), 'Grade updated successfully', 200);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error updating grade: ' . $e->getMessage());
            return ResponseHelper::error('Error', 'Error updating grade', 500);

        }
    }

    public function destroy(Grade $grade)
    {
        try {
            
            DB::beginTransaction();

            $grade->delete();

            DB::commit();

            return ResponseHelper::success(new GradeResource($grade), 'Grade deleted successfully', 200);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error deleting grade: ' . $e->getMessage());
            return ResponseHelper::error('Error', 'Error deleting grade', 500);

        }
    }
}
