<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class WorkActivityLogResource extends JsonResource
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
            'realized_volume' => (float) $this->realized_volume,
            'notes' => $this->notes,
            'realization_docs_url' => $this->realization_docs_path ? Storage::url($this->realization_docs_path) : null,
            'control_docs_url' => $this->control_docs_path ? Storage::url($this->control_docs_path) : null,
            'work_item' => $this->whenLoaded('workItem', fn() => [
                'id' => $this->workItem->id,
                'name' => $this->workItem->name,
                'unit' => $this->workItem->unit,
            ]),
        ];
    }
}
