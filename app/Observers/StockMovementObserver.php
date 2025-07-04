<?php

namespace App\Observers;

use App\Models\InventoryStock;
use App\Models\StockMovement;

class StockMovementObserver
{
    /**
     * Handle the StockMovement "created" event.
     */
    public function created(StockMovement $stockMovement): void
    {
        // Cari atau buat record stok untuk material ini di gudang ini
        $inventoryStock = InventoryStock::firstOrCreate([
            'warehouse_id' => $stockMovement->warehouse_id,
            'material_id' => $stockMovement->material_id,
        ]);

        // Tentukan apakah kuantitas akan menambah atau mengurangi
        $quantityChange = match ($stockMovement->type) {
            'in', 'return' => $stockMovement->quantity,
            'out' => -$stockMovement->quantity,
            'adjustment' => $stockMovement->quantity - $inventoryStock->current_stock,
            default => 0,
        };

        // Update stok saat ini menggunakan increment/decrement agar aman dari race condition
        $inventoryStock->increment('current_stock', $quantityChange);
    }

    /**
     * Handle the StockMovement "updated" event.
     */
    public function updated(StockMovement $stockMovement): void
    {
        //
    }

    /**
     * Handle the StockMovement "deleted" event.
     */
    public function deleted(StockMovement $stockMovement): void
    {
        //
    }

    /**
     * Handle the StockMovement "restored" event.
     */
    public function restored(StockMovement $stockMovement): void
    {
        //
    }

    /**
     * Handle the StockMovement "force deleted" event.
     */
    public function forceDeleted(StockMovement $stockMovement): void
    {
        //
    }
}
