<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateToolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->can('update', $this->route('tool'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $toolId = $this->route('tool')->id;

        return [
            'tool_code' => 'sometimes|required|string|max:255|unique:tools,tool_code,' . $toolId,
            'name' => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|nullable|string|max:255',
            'serial_number' => 'sometimes|nullable|string|max:255|unique:tools,serial_number,' . $toolId,
            'purchase_date' => 'sometimes|nullable|date',
            'unit_price' => 'sometimes|nullable|numeric|min:0',
            'condition' => 'sometimes|required|in:Baik,Perlu Perbaikan,Rusak',
            'warranty_period' => 'sometimes|nullable|date|after_or_equal:purchase_date',
            'picture' => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
