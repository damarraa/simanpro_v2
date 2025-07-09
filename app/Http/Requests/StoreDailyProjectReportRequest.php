<?php

namespace App\Http\Requests;

use App\Models\DailyProjectReport;
use Illuminate\Foundation\Http\FormRequest;

class StoreDailyProjectReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', DailyProjectReport::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'report_date' => 'required|date',
            'weather' => 'nullable|string|in:Cerah,Berawan,Hujan',
            'personnel_count' => 'required|integer|min:0',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
            'notes' => 'nullable|string',
        ];
    }
}
