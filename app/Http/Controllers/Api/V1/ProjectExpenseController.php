<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectExpenseRequest;
use App\Http\Requests\UpdateProjectExpenseRequest;
use App\Http\Resources\ProjectExpenseResource;
use App\Models\Project;
use App\Models\ProjectExpense;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProjectExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        $expenses = $project->expenses()->with('createdBy')->latest()->get();
        return ProjectExpenseResource::collection($expenses);
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
    public function store(StoreProjectExpenseRequest $request, Project $project)
    {
        $validatedData = $request->validated();
        $validatedData['created_by'] = auth()->id();

        $expense = $project->expenses()->create($validatedData);

        return (new ProjectExpenseResource($expense))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectExpense $expense)
    {
        return new ProjectExpenseResource($expense->load('createdBy'));
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
    public function update(UpdateProjectExpenseRequest $request, ProjectExpense $expense)
    {
        $this->authorize('update', $expense);
        $expense->update($request->validated());
        return new ProjectExpenseResource($expense);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectExpense $expense)
    {
        $this->authorize('delete', $expense);
        $expense->delete();
        return response()->noContent();
    }
}
