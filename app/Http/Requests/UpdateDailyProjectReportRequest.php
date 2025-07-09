<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDailyProjectReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('daily_report'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $dailyReport = $this->route('daily_report');

        return [
            // 'sometimes' berarti hanya validasi jika field ini dikirim dalam request
            'report_date' => [
                'sometimes',
                'required',
                'date',
                // Pastikan tanggal unik untuk proyek ini, kecuali untuk record ini sendiri
                Rule::unique('daily_project_reports')->where(function ($query) use ($dailyReport) {
                    return $query->where('project_id', $dailyReport->project_id);
                })->ignore($dailyReport->id),
            ],
            'weather' => 'sometimes|nullable|string|in:Cerah,Berawan,Hujan',
            'personnel_count' => 'sometimes|required|integer|min:0',
            'start_time' => 'sometimes|nullable|date_format:H:i',
            'end_time' => 'sometimes|nullable|date_format:H:i|after_or_equal:start_time',
            'notes' => 'sometimes|nullable|string',
        ];
    }
}
