<?php

namespace App\Filament\Resources\WarehouseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StockMovementsRelationManager extends RelationManager
{
    protected static string $relationship = 'stockMovements';
    protected static ?string $title = 'Histori Pergerakan Stok';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable(),

                TextColumn::make('material.name')
                    ->label('Material')
                    ->searchable(),

                TextColumn::make('quantity')
                    ->label('Kuantitas')
                    ->color(fn($state): string => $state > 0 ? 'success' : 'danger')
                    ->formatStateUsing(fn($state): string => ($state > 0 ? '+' : '') . number_format($state, 2)),

                TextColumn::make('type')->label('Tipe')->badge()->color(fn(string $state): string => match ($state) {
                    'in' => 'success',
                    'out' => 'danger',
                    'return' => 'info',
                    'adjustment' => 'warning',
                }),

                TextColumn::make('user.name')
                    ->label('Dicatat Oleh'),

                TextColumn::make('remarks')
                    ->label('Keterangan')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                // 
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
