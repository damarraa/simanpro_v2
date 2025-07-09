<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssetAssignmentResource extends JsonResource
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
            'assigned_date' => $this->assigned_date,
            'returned_date' => $this->returned_date,
            'notes' => $this->notes,
            'is_returned' => !is_null($this->returned_date),

            'tool' => $this->whenLoaded('tool', fn() => [
                'id' => $this->tool->id,
                'name' => $this->tool->name,
                'tool_code' => $this->tool->tool_code,
            ]),
            'project' => $this->whenLoaded('project', fn() => [
                'id' => $this->project->id,
                'name' => $this->project->job_name,
            ]),
            'assigned_by' => $this->whenLoaded('assignedBy', fn() => [
                'id' => $this->assignedBy->id,
                'name' => $this->assignedBy->name,
            ]),
        ];
    }
}
