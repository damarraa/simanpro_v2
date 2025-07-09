<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectExpenseResource extends JsonResource
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
            'description' => $this->description,
            'amount' => (float) $this->amount,
            'expense_date' => $this->expense_date,
            'created_by' => $this->whenLoaded('createdBy', fn() => $this->createdBy->name),
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
