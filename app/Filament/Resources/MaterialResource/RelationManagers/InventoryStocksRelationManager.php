<?php

namespace App\Filament\Resources\MaterialResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryStocksRelationManager extends RelationManager
{
    protected static string $relationship = 'inventoryStocks';
    protected static ?string $title = 'Stok di Gudang';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('warehouse_id')
            ->columns([
                TextColumn::make('warehouse.warehouse_name')
                    ->label('Lokasi Gudang'),

                TextColumn::make('current_stock')
                    ->label('Stok Saat Ini'),

                TextColumn::make('min_stock')
                    ->label('Stok Minimum'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form(
                        [
                            TextInput::make('min_stock')
                                ->numeric()
                                ->required(),
                        ]
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
