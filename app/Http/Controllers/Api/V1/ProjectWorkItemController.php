<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectWorkItemRequest;
use App\Http\Requests\UpdateProjectWorkItemRequest;
use App\Http\Resources\ProjectWorkItemResource;
use App\Models\Project;
use App\Models\ProjectWorkItem;
use Illuminate\Http\Request;

class ProjectWorkItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        return ProjectWorkItemResource::collection($project->workItems);
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
    public function store(StoreProjectWorkItemRequest $request, Project $project)
    {
        // Menggunakan relasi untuk membuat record baru, project_id terisi otomatis
        $workItem = $project->workItems()->create($request->validated());
        return new ProjectWorkItemResource($workItem);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectWorkItem $workItem)
    {
        // Load relasi detailnya
        return new ProjectWorkItemResource($workItem->load(['workItemMaterials', 'workItemLabors']));
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
    public function update(UpdateProjectWorkItemRequest $request, ProjectWorkItem $workItem)
    {
        $validated = $request->validated();

        // 1. Update data utama dari work item (name, volume, dll.)
        // Kita gunakan array_filter untuk hanya mengambil data yang dikirim oleh request
        $workItem->update(array_filter([
            'name' => $validated['name'] ?? null,
            'unit' => $validated['unit'] ?? null,
            'volume' => $validated['volume'] ?? null,
            'description' => $validated['description'] ?? null,
        ]));

        // 2. Proses sinkronisasi untuk materials jika ada dalam request
        if (isset($validated['materials'])) {
            $materialIdsToKeep = [];
            foreach ($validated['materials'] as $materialData) {
                // Jika ada ID, update. Jika tidak ada, buat baru.
                $material = $workItem->workItemMaterials()->updateOrCreate(
                    ['id' => $materialData['id'] ?? null],
                    $materialData
                );
                $materialIdsToKeep[] = $material->id;
            }
            // Hapus material lain yang tidak ada dalam request (yang dihapus oleh user di frontend)
            $workItem->workItemMaterials()->whereNotIn('id', $materialIdsToKeep)->delete();
        }

        // 3. Proses sinkronisasi yang sama untuk labors
        if (isset($validated['labors'])) {
            $laborIdsToKeep = [];
            foreach ($validated['labors'] as $laborData) {
                $labor = $workItem->workItemLabors()->updateOrCreate(
                    ['id' => $laborData['id'] ?? null],
                    $laborData
                );
                $laborIdsToKeep[] = $labor->id;
            }
            $workItem->workItemLabors()->whereNotIn('id', $laborIdsToKeep)->delete();
        }

        // Kembalikan data terbaru setelah semua Observer selesai berjalan
        return new ProjectWorkItemResource($workItem->fresh()->load(['workItemMaterials', 'workItemLabors']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectWorkItem $workItem)
    {
        // Jalankan otorisasi dari policy
        $this->authorize('delete', $workItem);

        $workItem->delete();

        // Kembalikan response kosong yang menandakan sukses
        return response()->noContent();
    }
}
