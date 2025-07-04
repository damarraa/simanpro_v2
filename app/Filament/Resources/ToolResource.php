<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ToolResource\Pages;
use App\Filament\Resources\ToolResource\RelationManagers;
use App\Filament\Resources\ToolResource\RelationManagers\AssignmentsRelationManager;
use App\Filament\Resources\ToolResource\RelationManagers\LocationsRelationManager;
use App\Models\Tool;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ToolResource extends Resource
{
    protected static ?string $model = Tool::class;
    protected static ?string $navigationLabel = 'Alat-alat';
    protected static ?string $modelLabel = 'Alat';
    protected static ?string $pluralModelLabel = 'Alat-Alat';
    protected static ?string $navigationGroup = 'Manajemen Inventory & Material';
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama Alat')
                    ->schema([
                        TextInput::make('tool_code')
                            ->label('Kode Alat')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('name')
                            ->label('Nama Alat')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('brand')
                            ->label('Merek'),
                        TextInput::make('serial_number')
                            ->label('Nomor Seri'),
                    ])->columns(2),

                Section::make('Informasi Pembelian & Kondisi')
                    ->schema([
                        DatePicker::make('purchase_date')
                            ->label('Tanggal Pembelian'),
                        TextInput::make('unit_price')
                            ->label('Harga Beli')
                            ->numeric()
                            ->prefix('Rp'),
                        Select::make('condition')
                            ->label('Kondisi')
                            ->options([
                                'Baik' => 'Baik',
                                'Perlu Perbaikan' => 'Perlu Perbaikan',
                                'Rusak' => 'Rusak',
                            ])
                            ->required()
                            ->default('Baik'),
                        DatePicker::make('warranty_period')
                            ->label('Masa Garansi Berakhir'),
                    ])->columns(2),

                Section::make('Dokumentasi')
                    ->schema([
                        FileUpload::make('picture_path')
                            ->label('Foto Alat')
                            ->image()
                            ->directory('tool-pictures'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('picture_path')->label('Foto')->circular(),
                TextColumn::make('name')
                    ->label('Nama Alat')
                    ->description(fn(Tool $record): string => $record->tool_code)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('brand')->label('Merek')->searchable(),
                TextColumn::make('condition')->label('Kondisi')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Baik' => 'success',
                        'Perlu Perbaikan' => 'warning',
                        'Rusak' => 'danger',
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            LocationsRelationManager::class,
            AssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTools::route('/'),
            'create' => Pages\CreateTool::route('/create'),
            'edit' => Pages\EditTool::route('/{record}/edit'),
        ];
    }
}
