<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaintenanceLogRequest;
use App\Http\Requests\UpdateMaintenanceLogRequest;
use App\Http\Resources\MaintenanceLogResource;
use App\Models\MaintenanceLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MaintenanceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = MaintenanceLog::with('vehicle')->latest()->get();
        return MaintenanceLogResource::collection($logs);
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
    public function store(StoreMaintenanceLogRequest $request)
    {
        $log = MaintenanceLog::create($request->validated());
        return (new MaintenanceLogResource($log))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceLog $maintenanceLog)
    {
        return new MaintenanceLogResource($maintenanceLog->load('vehicle'));
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
    public function update(UpdateMaintenanceLogRequest $request, MaintenanceLog $maintenanceLog)
    {
        $this->authorize('update', $maintenanceLog);
        $maintenanceLog->update($request->validated());
        return new MaintenanceLogResource($maintenanceLog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceLog $maintenanceLog)
    {
        $this->authorize('delete', $maintenanceLog);
        $maintenanceLog->delete();
        return response()->noContent();
    }
}
