<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StockMovementResource extends JsonResource
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
            'quantity' => (float) $this->quantity,
            'type' => $this->type,
            'remarks' => $this->remarks,
            'transaction_date' => $this->created_at->toIso8601String(),

            'material' => $this->whenLoaded('material', fn() => [
                'id' => $this->material->id,
                'name' => $this->material_name,
                'sku' => $this->material->sku,
            ]),
            'warehouse' => $this->whenLoaded('warehouse', fn() => [
                'id' => $this->warehouse->id,
                'name' => $this->warehouse->name,
            ]),
            'recorded_by' => $this->whenLoaded('user', fn() => [
                'id' => $this->user->id,
                'name' => $this->user->name,
            ]),
        ];
    }
}
