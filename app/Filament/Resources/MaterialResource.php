<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Filament\Resources\MaterialResource\RelationManagers\InventoryStocksRelationManager;
use App\Filament\Resources\WarehouseResource\RelationManagers\StockMovementsRelationManager;
use App\Models\Material;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;
    protected static ?string $navigationLabel = 'Material';
    protected static ?string $navigationGroup = 'Manajemen Inventory & Material';
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama Material')
                    ->schema([
                        FileUpload::make('picture_path')
                            ->label('Foto Material')
                            ->image()
                            ->directory('material-pictures')
                            ->columnSpanFull(),

                        TextInput::make('sku')
                            ->label('SKU (Kode Unik Material)')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('name')
                            ->label('Nama Material')
                            ->required(),

                        TextInput::make('unit')
                            ->label('Satuan (Contoh: sak, btg, m³)')
                            ->required(),

                        Select::make('supplier_id')
                            ->relationship('supplier', 'name')
                            ->label('Supplier Utama')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nama Supplier')
                                    ->required(),

                                TextInput::make('phone')
                                    ->label('Nomor Telepon'),

                                Textarea::make('address')
                                    ->label('Alamat')
                                    ->columnSpanFull(),
                            ]),

                        Toggle::make('is_dpt')
                            ->label('Material Daftar Pengadaan Tetap (DPT)?')
                            ->helperText('Aktifkan jika ini adalah material standar yang sering diadakan.'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('picture_path')
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama Material')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->searchable(),
                IconColumn::make('is_dpt')
                    ->label('DPT')
                    ->boolean(),
                TextColumn::make('unit')
                    ->label('Satuan'),
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
            InventoryStocksRelationManager::class,
            StockMovementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
