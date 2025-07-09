<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMaintenanceLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('maintenance_log'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'maintenance_date' => 'sometimes|required|date',
            'odometer' => 'sometimes|required|integer|min:0',
            'type' => 'sometimes|required|string|in:Rutin,Insidental,Darurat',
            'location' => 'sometimes|required|string|max:255',
            'notes' => 'sometimes|nullable|string',
            'docs_path' => 'sometimes|nullable|string',
        ];
    }
}
