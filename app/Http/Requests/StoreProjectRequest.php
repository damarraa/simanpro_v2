<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->can('create', Project::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contract_num' => 'required|string|max:255|unique:projects,contract_num',
            'job_name' => 'required|string|max:255',
            'client_id' => 'required|integer|exists:clients,id',
            'job_id' => 'required|integer|exists:job_types,id',
            'project_manager_id' => 'required|integer|exists:users,id',
            'default_warehouse_id' => 'required|integer|exists:warehouses,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'contract_value' => 'required|numeric|min:0',
            'total_budget' => 'required|numeric|min:0',
            'status' => 'required|in:On-Progress,Completed,Cancelled,Pending',
        ];
    }
}
