<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user')->id;

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:8|confirmed',
            'address' => 'sometimes|nullable|string',
            'phone' => 'sometimes|nullable|string|max:20',
            'is_active' => 'sometimes|required|boolean',
            'roles' => 'sometimes|array',
            'roles.*' => 'integer|exists:roles,id',
            'profile_picture' => 'sometimes|nullable|image|max:2048',
            'signature' => 'sometimes|nullable|image|max:2048',
        ];
    }
}
