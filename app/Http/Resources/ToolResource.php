<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ToolResource extends JsonResource
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
            'tool_code' => $this->tool_code,
            'name' => $this->name,
            'brand' => $this->brand,
            'serial_number' => $this->serial_number,
            'purchase_date' => $this->purchase_date,
            'unit_price' => $this->unit_price,
            'condition' => $this->condition,
            'warranty_period' => $this->warranty_period,
            'picture_path' => $this->picture_path ? Storage::url($this->picture_path) : null,
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
        ];
    }
}
