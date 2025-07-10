<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', User::class);
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
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'required|boolean',
            'roles' => 'required|array',
            'roles.*' => 'integer|exists:roles,id',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi untuk file upload
            'signature' => 'nullable|string', // Validasi untuk data Base64
        ];
    }
}
