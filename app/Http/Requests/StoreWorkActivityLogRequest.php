<?php

namespace App\Http\Requests;

use App\Models\WorkActivityLog;
use Illuminate\Foundation\Http\FormRequest;

class StoreWorkActivityLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', WorkActivityLog::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'work_item_id' => 'required|integer|exists:project_work_items,id',
            'realized_volume' => 'required|numeric|min:0',
            
            // TAMBAHKAN VALIDASI UNTUK TANGGAL REALISASI
            'realization_date' => 'required|date',
            'notes' => 'nullable|string',
            
            // Validasi untuk path file (string), karena file sudah di-handle di controller
            'realization_docs_path' => 'nullable|string',
            'control_docs_path' => 'nullable|string',
        ];
    }
}
