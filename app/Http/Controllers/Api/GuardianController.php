<?php

namespace App\Http\Controllers\Api;

use App\Models\Guardian;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\GuardianResource;
use App\Http\Requests\Guardian\CreateRequest;
use App\Http\Requests\Guardian\UpdateRequest;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success(
            GuardianResource::collection(Guardian::all()), 'Guardians retrieved successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {

        $request = $request->validated();

        try {
            
            DB::beginTransaction();

            $guardian = Guardian::query()->create([
                'user_id' => $request['user_id'],
                'nik' => $request['nik'],
                'name' => $request['name'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'occupation' => $request['occupation'],
                'is_active' => $request['is_active'],
            ]);

            DB::commit();

            return ResponseHelper::success(new GuardianResource($guardian), 'Guardian created successfully', 201);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error creating guardian: ' . $e->getMessage());
            return ResponseHelper::error('Error', 'Error creating guardian', 500);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Guardian $guardian)
    {
        if (!$guardian) {
            return ResponseHelper::error('Error', 'Guardian not found', 404);
        }

        return ResponseHelper::success(new GuardianResource($guardian), 'Guardian retrieved successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Guardian $guardian)
    {
        $request = $request->validated();

        try {
            
            DB::beginTransaction();

            if (!$guardian) {
                return ResponseHelper::error('Error', 'Guardian not found', 404);
            }

            $guardian->update([
                'user_id' => $request['user_id'],
                'nik' => $request['nik'],
                'name' => $request['name'],
                'phone' => $request['phone'],
                'address' => $request['address'],
                'occupation' => $request['occupation'],
                'is_active' => $request['is_active'],
            ]);

            DB::commit();

            return ResponseHelper::success(new GuardianResource($guardian), 'Guardian updated successfully', 200);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error updating guardian: ' . $e->getMessage());
            return ResponseHelper::error('Error', 'Error updating guardian', 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guardian $guardian)
    {
        try {
            
            DB::beginTransaction();

            $guardian->delete();

            DB::commit();

            return ResponseHelper::success(new GuardianResource($guardian), 'Guardian deleted successfully', 200);

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error('Error deleting guardian: ' . $e->getMessage());
            return ResponseHelper::error('Error', 'Error deleting guardian', 500);

        }
    }
}
