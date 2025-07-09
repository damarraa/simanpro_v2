<?php

namespace App\Http\Requests;

use App\Models\Vehicle;
use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Vehicle::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'vehicle_type' => 'required|in:Mobil,Truk,Alat Berat',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255|unique:vehicles,license_plate',
            'purchase_year' => 'required|digits:4|integer|min:1900',
            'capacity' => 'required|string|max:255',
            'vehicle_license' => 'required|string|max:255|unique:vehicles,vehicle_license',
            'license_expiry_date' => 'required|date',
            'vehicle_identity_number' => 'required|string|max:255|unique:vehicles,vehicle_identity_number',
            'engine_number' => 'required|string|max:255|unique:vehicles,engine_number',
            'tax_due_date' => 'required|date',
            'notes' => 'nullable|string',
            'pic_user_id' => 'nullable|integer|exists:users,id',
            'document' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048', // Validasi untuk file upload
        ];
    }
}
