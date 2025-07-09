<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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

            // Sertakan daftar permission hanya jika relasinya sudah di-load
            'permissions' => $this->whenLoaded('permissions', function () {
                // Kita hanya ambil nama permission-nya saja agar response lebih ramping
                return $this->permissions->pluck('name');
            }),
        ];
    }
}
