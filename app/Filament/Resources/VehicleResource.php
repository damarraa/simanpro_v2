<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VehicleResource\Pages;
use App\Filament\Resources\VehicleResource\RelationManagers;
use App\Filament\Resources\VehicleResource\RelationManagers\AssignmentsRelationManager;
use App\Filament\Resources\VehicleResource\RelationManagers\MaintenanceLogsRelationManager;
use App\Models\Vehicle;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
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

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;
    protected static ?string $navigationLabel = 'Kendaraan & Alat Berat';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Kendaraan')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Kendaraan')
                            ->required(),

                        Select::make('vehicle_type')
                            ->label('Jenis Kendaraan')
                            ->options([
                                'Mobil' => 'Mobil',
                                'Truk' => 'Truk',
                                'Alat Berat' => 'Alat Berat',
                            ])
                            ->required(),

                        TextInput::make('merk')
                            ->label('Merek Kendaraan')
                            ->required(),

                        TextInput::make('model')
                            ->label('Model Kendaraan'),

                        TextInput::make('license_plate')
                            ->unique(ignoreRecord: true)
                            ->label('Plat Nomor'),

                        TextInput::make('purchase_year')
                            ->numeric()
                            ->label('Tahun Pembelian')
                    ])->columns(2),

                Section::make('Informasi Teknis & Legal')
                    ->schema([
                        TextInput::make('capacity')
                            ->label('Kapasitas (L)'),

                        TextInput::make('vehicle_identity_number')
                            ->label('Nomor Rangka'),

                        TextInput::make('vehicle_license')
                            ->label('Nomor STNK')
                            ->unique(ignoreRecord: true),

                        DatePicker::make('license_expiry_date')
                            ->label('Tanggal Jatuh Tempo STNK'),

                        TextInput::make('engine_number')
                            ->label('Nomor Mesin'),

                        DatePicker::make('tax_due_date')
                            ->label('Tanggal Jatuh Tempo Pajak')
                    ])->columns(2),

                Section::make('Catatan & Dokumen')
                    ->schema([
                        FileUpload::make('docs_path')
                            ->directory('vehicle-docs')
                            ->label('Dokumen Kendaraan'),

                        Textarea::make('notes')
                            ->label('Catatan Tambahan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kendaraan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('vehicle_type')
                    ->label('Jenis Kendaraan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('model')
                    ->label('Model Kendaraan')
                    ->searchable(),

                TextColumn::make('license_plate')
                    ->label('Plat Nomor')
                    ->searchable(),
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
            MaintenanceLogsRelationManager::class,
            AssignmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
        ];
    }
}
