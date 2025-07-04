<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockMovementResource\Pages;
use App\Filament\Resources\StockMovementResource\RelationManagers;
use App\Models\StockMovement;
use Filament\Actions\ViewAction;
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

class StockMovementResource extends Resource
{
    protected static ?string $model = StockMovement::class;
    protected static ?string $navigationLabel = 'Pergerakan Stok';
    protected static ?string $navigationGroup = 'Manajemen Inventory & Material';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('warehouse_id')
                    ->relationship('warehouse', 'warehouse_name')
                    ->searchable()
                    ->preload()
                    ->label('Gudang')
                    ->required(),

                Select::make('material_id')
                    ->relationship('material', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Material')
                    ->required(),

                Select::make('type')
                    ->label('Tipe Transaksi')
                    ->options([
                        'in' => 'Stok Masuk (Pembelian)',
                        'out' => 'Stok Keluar (Digunakan Proyek)',
                        'return' => 'Stok Kembali (Sisa Proyek)',
                        'adjustment' => 'Penyesuaian Stok'
                    ])
                    ->required(),

                TextInput::make('quantity')
                    ->label('Kuantitas')
                    ->numeric()
                    ->required()
                    ->helperText('Masukkan angka positif. Tipe transaksi akan menentukan penambahan/pengurangan.'),

                Textarea::make('remarks')
                    ->label('Keterangan/Catatan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
                TextColumn::make('material.name')->searchable(),
                TextColumn::make('warehouse.warehouse_name')->label('Gudang'),
                TextColumn::make('quantity')
                    ->color(fn(string $state): string => $state > 0 ? 'success' : 'danger')
                    ->formatStateUsing(fn(string $state): string => ($state > 0 ? '+' : '') . $state),
                TextColumn::make('type')->badge()->color(fn(string $state): string => match ($state) {
                    'in' => 'success',
                    'out' => 'danger',
                    'return' => 'info',
                    'adjustment' => 'warning',
                }),
                TextColumn::make('user.name')->label('Dicatat Oleh'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockMovements::route('/'),
            'create' => Pages\CreateStockMovement::route('/create'),
            'edit' => Pages\EditStockMovement::route('/{record}/edit'),
        ];
    }
}
