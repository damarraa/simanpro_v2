<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WarehouseResource\Pages;
use App\Filament\Resources\WarehouseResource\RelationManagers;
use App\Filament\Resources\WarehouseResource\RelationManagers\StockMovementsRelationManager;
use App\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WarehouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;
    protected static ?string $navigationLabel = 'Manajemen Gudang';
    protected static ?string $navigationGroup = 'Manajemen Inventory & Material';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('warehouse_name')
                    ->label('Nama Gudang')
                    ->required(),

                Textarea::make('address')
                    ->label('Alamat')
                    ->columnSpanFull(),

                TextInput::make('phone')
                    ->label('Telepon Gudang')
                    ->tel(),

                Select::make('pic_user_id')
                    ->label('Penanggung Jawab (PIC)')
                    // ->relationship('pic', 'name')
                    // Tips: Filter agar hanya user dengan role 'Logistic' yang muncul
                    ->relationship('pic', 'name', fn(Builder $query) => $query->whereHas('roles', fn($query) => $query->where('name', 'Logistic')))
                    ->searchable()
                    ->preload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('warehouse_name')
                    ->searchable(),

                TextColumn::make('pic.name')
                    ->label('Nama PIC'),

                TextColumn::make('phone')
                    ->label('Nomor Telepon')
                    ->prefix('+62'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            StockMovementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWarehouses::route('/'),
            'create' => Pages\CreateWarehouse::route('/create'),
            'edit' => Pages\EditWarehouse::route('/{record}/edit'),
        ];
    }
}
