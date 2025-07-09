<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('vehicle'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $vehicleId = $this->route('vehicle')->id;

        return [
            'name' => 'sometimes|required|string|max:255',
            'vehicle_type' => 'sometimes|required|in:Mobil,Truk,Alat Berat',
            'merk' => 'sometimes|required|string|max:255',
            'model' => 'sometimes|required|string|max:255',
            'license_plate' => 'sometimes|required|string|max:255|unique:vehicles,license_plate,' . $vehicleId,
            'purchase_year' => 'sometimes|required|digits:4|integer|min:1900',
            'capacity' => 'sometimes|required|string|max:255',
            'vehicle_license' => 'sometimes|required|string|max:255|unique:vehicles,vehicle_license,' . $vehicleId,
            'license_expiry_date' => 'sometimes|required|date',
            'vehicle_identity_number' => 'sometimes|required|string|max:255|unique:vehicles,vehicle_identity_number,' . $vehicleId,
            'engine_number' => 'sometimes|required|string|max:255|unique:vehicles,engine_number,' . $vehicleId,
            'tax_due_date' => 'sometimes|required|date',
            'notes' => 'sometimes|nullable|string',
            'pic_user_id' => 'sometimes|nullable|integer|exists:users,id',
            'document' => 'sometimes|nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ];
    }
}
