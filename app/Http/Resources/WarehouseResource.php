<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseResource extends JsonResource
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
            'warehouse_name' => $this->warehouse_name,
            'address' => $this->address,
            'phone' => $this->phone,

            // Data dari Relasi
            'pic' => $this->whenLoaded('pic', fn() => [
                'id' => $this->pic->id,
                'name' => $this->pic->name,
            ]),
        ];
    }
}
