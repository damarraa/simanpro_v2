<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleAssignmentRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Http\Resources\VehicleAssignmentResource;
use App\Models\VehicleAssignment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VehicleAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignments = VehicleAssignment::with(['vehicle', 'project', 'driver'])->latest()->get();
        return VehicleAssignmentResource::collection($assignments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVehicleAssignmentRequest $request)
    {
        $assignment = VehicleAssignment::create($request->validated());
        return (new VehicleAssignmentResource($assignment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(VehicleAssignment $vehicleAssignment)
    {
        return new VehicleAssignmentResource($vehicleAssignment->load(['vehicle', 'project', 'driver']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVehicleRequest $request, VehicleAssignment $vehicleAssignment)
    {
        $this->authorize('update', $vehicleAssignment);
        $vehicleAssignment->update($request->validated());
        return new VehicleAssignmentResource($vehicleAssignment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VehicleAssignment $vehicleAssignment)
    {
        $this->authorize('delete', $vehicleAssignment);
        $vehicleAssignment->delete();
        return response()->noContent();
    }
}
