<?php

namespace App\Filament\Resources\DailyProjectReportResource\RelationManagers;

use App\Models\InventoryStock;
use App\Models\ProjectWorkItem;
use App\Models\WorkActivityLog;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component as Livewire;

class WorkActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'workActivities';
    protected static ?string $title = 'Realisasi Aktivitas Pekerjaan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('work_item_id')
                    ->label('Item Pekerjaan')
                    ->options(function (Livewire $livewire) {
                        $projectId = $livewire->ownerRecord->project_id;
                        if (!$projectId) {
                            return [];
                        }
                        return ProjectWorkItem::where('project_id', $projectId)->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required()
                    ->live(),

                TextInput::make('realized_volume')
                    ->label('Volume Realisasi')
                    ->numeric()
                    ->required()
                    // Menampilkan helper text dinamis
                    ->helperText(function (Get $get, Livewire $livewire): string {
                        $workItemId = $get('work_item_id');
                        $warehouseId = $livewire->ownerRecord->project->default_warehouse_id;

                        if (!$workItemId || !$warehouseId) {
                            return 'Pilih item pekerjaan untuk melihat info stok.';
                        }

                        $workItem = ProjectWorkItem::with('workItemMaterials.material')->find($workItemId);
                        if (!$workItem || $workItem->workItemMaterials->isEmpty()) {
                            return 'Item pekerjaan ini tidak memiliki kebutuhan material.';
                        }

                        $stockInfo = 'Info Stok di Gudang:';
                        foreach ($workItem->workItemMaterials as $reqMaterial) {
                            $stock = InventoryStock::where('warehouse_id', $warehouseId)
                                ->where('material_id', $reqMaterial->material_id)
                                ->first();

                            $currentStock = $stock->current_stock ?? 0;
                            $stockInfo .= "\n- {$reqMaterial->material->name}: {$currentStock} {$reqMaterial->material->unit}";
                        }

                        return nl2br(e($stockInfo)); // Tampilkan sebagai HTML dengan line break
                    })
                    ->rules([
                        function (Get $get, $component) {
                            return function (string $attribute, $value, Closure $fail) use ($get, $component) {
                                $work_item_id = $get('work_item_id');
                                if (!$work_item_id) {
                                    return; // Lewati jika item pekerjaan belum dipilih
                                }

                                $workItem = ProjectWorkItem::find($work_item_id);
                                $plannedVolume = $workItem->volume;

                                // Hitung volume yang sudah direalisasikan sebelumnya untuk item ini
                                $alreadyRealizedVolume = WorkActivityLog::where('work_item_id', $work_item_id)
                                    // Jika sedang edit, jangan hitung record saat ini
                                    ->when($component->getRecord(), fn($query, $record) => $query->where('id', '!=', $record->id))
                                    ->sum('realized_volume');

                                $remainingVolume = $plannedVolume - $alreadyRealizedVolume;

                                if ($value > $remainingVolume) {
                                    // Tampilkan pesan error jika input melebihi sisa volume
                                    $fail("Volume realisasi tidak boleh melebihi sisa volume yang direncanakan. Sisa volume: {$remainingVolume} {$workItem->unit}");
                                }
                            };
                        }
                    ]),

                DatePicker::make('realization_date')
                    ->label('Tanggal')
                    ->required(),

                FileUpload::make('realization_docs_path')
                    ->label('Dokumentasi Realisasi'),

                FileUpload::make('control_docs_path')
                    ->label('Dokumentasi Project Control'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('work_item_id')
            ->columns([
                TextColumn::make('workItem.name')
                    ->label('Item Pekerjaan'),

                TextColumn::make('realized_volume'),



                TextColumn::make('workItem.unit')
                    ->label('Satuan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
