<?php

namespace App\Http\Requests;

use App\Models\Tool;
use Illuminate\Foundation\Http\FormRequest;

class StoreToolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->can('create', Tool::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tool_code' => 'required|string|max:255|unique:tools,tool_code',
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:tools,serial_number',
            'purchase_date' => 'nullable|date',
            'unit_price' => 'nullable|numeric|min:0',
            'condition' => 'required|in:Baik,Perlu Perbaikan,Rusak',
            'warranty_period' => 'nullable|date|after_or_equal:purchase_date',
            'picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
