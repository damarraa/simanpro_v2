<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->can('update', $this->route('warehouse'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'warehouse_name' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|numeric',
            'pic_user_id' => 'sometimes|nullable|integer|exists:users,id',
        ];
    }
}
