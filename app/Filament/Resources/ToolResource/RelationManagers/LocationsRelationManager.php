<?php

namespace App\Filament\Resources\ToolResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationsRelationManager extends RelationManager
{
    protected static string $relationship = 'locations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('warehouse_id')
                    ->relationship('warehouse', 'warehouse_name')
                    ->label('Gudang')
                    ->searchable()
                    ->preload()
                    ->required(),
                    
                TextInput::make('quantity')
                    ->label('Jumlah Alat di Lokasi Ini')
                    ->numeric()
                    ->required()
                    ->default(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('warehouse_id')
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('warehouse.warehouse_name')
                    ->label('Lokasi Gudang'),

                TextColumn::make('quantity')
                    ->label('Jumlah di Lokasi Ini'),

                TextColumn::make('last_moved_at')->label('Terakhir Dipindahkan')
                    ->since(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
