<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleAssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('vehicle_assignment'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $assignment = $this->route('vehicle_assignment');

        return [
            'end_datetime' => 'sometimes|required|date|after_or_equal:' . $assignment->start_datetime,
            'end_odometer' => 'sometimes|nullable|string|max:255',
            'notes' => 'sometimes|nullable|string',
        ];
    }
}
