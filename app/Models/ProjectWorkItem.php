<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectWorkItem extends Model
{
    protected $table = 'project_work_items';

    protected $fillable = [
        'name',
        'description',
        'unit',
        'volume',
        'unit_price',
        'total_planned_amount',
        'project_id'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(WorkActivityLog::class, 'work_item_id');
    }

    /**
     * Relasi ke rincian material (HasMany).
     * Ini adalah method yang hilang dan menyebabkan error.
     */
    public function workItemMaterials(): HasMany
    {
        return $this->hasMany(WorkItemMaterials::class, 'work_item_id');
    }

    /**
     * Relasi ke rincian tenaga kerja (HasMany).
     * Ini juga method yang hilang.
     */
    public function workItemLabors(): HasMany
    {
        return $this->hasMany(WorkItemLabors::class, 'work_item_id');
    }

    /**
     * Method untuk mengkalkulasi ulang biaya secara otomatis.
     * Sekarang akan berjalan tanpa error karena relasi di atas sudah ada.
     */
    public function calculateAndUpdateCosts(): void
    {
        /**
         * PENTING: Memuat ulang atribut model dari database untuk memastikan
         * kita mendapatkan nilai 'volume' yang paling baru sebelum kalkulasi.
         */
        $this->refresh();

        Log::info('[Model] Method calculateAndUpdateCosts DIJALANKAN untuk Work Item ID: ' . $this->id);

        // LOG BARU UNTUK MEMERIKSA NILAI VOLUME
        Log::info('[Model] Nilai Volume yang digunakan untuk kalkulasi: ' . $this->volume);

        $totalMaterialCost = $this->workItemMaterials()->sum(DB::raw('quantity * unit_price'));
        Log::info('[Model] Total Biaya Material Terhitung: ' . $totalMaterialCost);

        $totalLaborCost = $this->workItemLabors()->sum(DB::raw('quantity * rate'));
        Log::info('[Model] Total Biaya Jasa Terhitung: ' . $totalLaborCost);

        $this->unit_price = $totalMaterialCost + $totalLaborCost;
        $this->total_planned_amount = $this->unit_price * $this->volume; // Di sini perhitungannya terjadi

        Log::info('[Model] Harga Satuan Baru: ' . $this->unit_price . ' | Total Rencana Baru: ' . $this->total_planned_amount);

        $this->saveQuietly();
        Log::info('[Model] Proses saveQuietly() selesai.');
    }
}
