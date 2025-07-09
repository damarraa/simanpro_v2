<?php

namespace App\Http\Requests;

use App\Models\AssetAssignment;
use Illuminate\Foundation\Http\FormRequest;

class StoreAssetAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->can('create', AssetAssignment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tool_id' => 'required|integer|exists:tools,id',
            'project_id' => 'required|integer|exists:projects,id',
            'assigned_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
