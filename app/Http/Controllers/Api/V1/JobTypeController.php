<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobTypeRequest;
use App\Http\Requests\UpdateJobTypeRequest;
use App\Http\Resources\JobTypeResource;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JobTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobTypes = JobType::all();
        return JobTypeResource::collection($jobTypes);
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
    public function store(StoreJobTypeRequest $request)
    {
        $jobType = JobType::create($request->validated());

        return (new JobTypeResource($jobType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(JobType $jobType)
    {
        return new JobTypeResource($jobType);
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
    public function update(UpdateJobTypeRequest $request, JobType $jobType)
    {
        $jobType->update($request->validated());

        return new JobTypeResource($jobType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobType $jobType)
    {
        $this->authorize('delete', $jobType);

        $jobType->delete();

        return response()->noContent();
    }
}
