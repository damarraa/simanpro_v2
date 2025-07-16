<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->can('update', $this->route('project'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contract_num' => 'sometimes|required|string|max:255|unique:projects,contract_num,' . $this->route('project')->id,
            'job_name' => 'sometimes|required|string|max:255',
            'client_id' => 'sometimes|required|integer|exists:clients,id',
            'job_id' => 'sometimes|required|integer|exists:job_types,id',
            'project_manager_id' => 'sometimes|required|integer|exists:users,id',
            'default_warehouse_id' => 'sometimes|required|integer|exists:warehouses,id',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
            'contract_value' => 'sometimes|required|numeric|min:0',
            'total_budget' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|in:On-Progress,Completed,Cancelled,Pending',

            /**
             * Update 11/07/2025
             * Modifikasi dan penambahan assign team.
             */
            'team_members' => 'sometimes|nullable|array',
            'team_members.*' => 'sometimes|integer|exists:users,id',
        ];
    }
}
