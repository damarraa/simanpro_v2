<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyProjectReportResource extends JsonResource
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
            'report_date' => $this->report_date,
            'weather' => $this->weather,
            'personnel_count' => $this->personnel_count,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'notes' => $this->notes,
            'project' => $this->whenLoaded('project', fn() => [
                'id' => $this->project->id,
                'name' => $this->project->job_name,
            ]),
            'submitted_by' => $this->whenLoaded('submittedBy', fn() => [
                'id' => $this->submittedBy->id,
                'name' => $this->submittedBy->name,
            ]),
            // Nanti kita akan isi ini dengan WorkActivityLogResource
            'activities' => WorkActivityLogResource::collection($this->whenLoaded('workActivities')),
        ];
    }
}
