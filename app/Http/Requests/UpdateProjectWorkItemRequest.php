<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectWorkItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('work_item'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Validasi untuk data utama
            'name' => 'sometimes|required|string|max:255',
            'unit' => 'sometimes|required|string|max:100',
            'volume' => 'sometimes|required|numeric|min:0',
            'description' => 'sometimes|nullable|string',

            // Validasi untuk array materials
            'materials' => 'sometimes|array',
            'materials.*.id' => 'nullable|integer|exists:work_item_materials,id', // Untuk update data yang ada
            'materials.*.material_id' => 'required|integer|exists:materials,id',
            'materials.*.quantity' => 'required|numeric|min:0',
            'materials.*.unit' => 'required|string|max:100',
            'materials.*.unit_price' => 'required|numeric|min:0',

            // Validasi untuk array labors
            'labors' => 'sometimes|array',
            'labors.*.id' => 'nullable|integer|exists:work_item_labors,id', // Untuk update data yang ada
            'labors.*.labor_type' => 'required|string|max:255',
            'labors.*.quantity' => 'required|numeric|min:0',
            'labors.*.rate' => 'required|numeric|min:0',
        ];
    }
}
