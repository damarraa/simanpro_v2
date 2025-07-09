<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectWorkItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'unit' => $this->unit,
            'volume' => (float) $this->volume,
            'unit_price' => (float) $this->unit_price, // Hasil kalkulasi otomatis
            'total_planned_amount' => (float) $this->total_planned_amount, // Hasil kalkulasi otomatis
            'description' => $this->description,
            // Tampilkan juga detail material & jasa jika sudah di-load
            'materials' => WorkItemMaterialResource::collection($this->whenLoaded('workItemMaterials')),
            'labors' => WorkItemLaborResource::collection($this->whenLoaded('workItemLabors')),
        ];
    }
}
