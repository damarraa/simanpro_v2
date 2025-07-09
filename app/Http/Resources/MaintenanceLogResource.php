<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MaintenanceLogResource extends JsonResource
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
            'maintenance_date' => $this->maintenance_date,
            'odometer' => $this->odometer,
            'type' => $this->type,
            'location' => $this->location,
            'notes' => $this->notes,
            'document_url' => $this->docs_path ? Storage::url($this->docs_path) : null,
            'vehicle' => $this->whenLoaded('vehicle', fn() => [
                'id' => $this->vehicle->id,
                'name' => $this->vehicle->name,
            ]),
        ];
    }
}
