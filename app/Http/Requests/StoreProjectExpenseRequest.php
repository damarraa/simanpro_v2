<?php

namespace App\Http\Requests;

use App\Models\ProjectExpense;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', ProjectExpense::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => 'required|string|max:1000',
            'amount' => 'required|numeric|min:0',
            'expense_date' => 'required|date',
        ];
    }
}
