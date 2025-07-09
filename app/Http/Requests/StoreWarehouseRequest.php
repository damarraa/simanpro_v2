<?php

namespace App\Http\Requests;

use App\Models\Warehouse;
use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
        return $this->user()->can('create', Warehouse::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'warehouse_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'pic_user_id' => 'nullable|integer|exists:users,id',
        ];
    }
}
