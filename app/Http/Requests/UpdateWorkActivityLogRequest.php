<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkActivityLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('activity_log'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'work_item_id' => 'sometimes|required|integer|exists:project_work_items,id',
            'realized_volume' => 'sometimes|required|numeric|min:0',
            'realization_date' => 'sometimes|required|date',
            'notes' => 'sometimes|nullable|string',
            'realization_docs_path' => 'sometimes|nullable|string',
            'control_docs_path' => 'sometimes|nullable|string',
        ];
    }
}
