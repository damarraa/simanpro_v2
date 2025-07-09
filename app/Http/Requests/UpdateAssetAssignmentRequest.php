<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->can('update', $this->route('asset_assignment'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $assignment = $this->route('asset_assignment');
        $assignedDate = $assignment->assigned_date;

        return [
            'returned_date' => 'sometimes|nullable|date|after_or_equal:' . $assignedDate,
            'notes' => 'sometimes|nullable|string|max:1000',
        ];
    }
}
