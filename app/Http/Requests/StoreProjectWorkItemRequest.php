<?php

namespace App\Http\Requests;

use App\Models\ProjectWorkItem;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectWorkItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', ProjectWorkItem::class);
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
            'unit' => 'required|string|max:100',
            'volume' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ];
    }
}
