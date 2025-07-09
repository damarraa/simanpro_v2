<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleAssignmentResource extends JsonResource
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
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'start_odometer' => $this->start_odometer,
            'end_odometer' => $this->end_odometer,
            'notes' => $this->notes,
            'is_returned' => !is_null($this->end_datetime),

            // Menampilkan data dari relasi
            'vehicle' => $this->whenLoaded('vehicle', fn() => [
                'id' => $this->vehicle->id,
                'name' => $this->vehicle->name,
                'license_plate' => $this->vehicle->license_plate,
            ]),
            'project' => $this->whenLoaded('project', fn() => [
                'id' => $this->project->id,
                'name' => $this->project->job_name,
            ]),
            'driver' => $this->whenLoaded('driver', fn() => [
                'id' => $this->driver->id,
                'name' => $this->driver->name,
            ]),
        ];
    }
}
