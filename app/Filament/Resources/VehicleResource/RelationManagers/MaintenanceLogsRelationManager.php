<?php

namespace App\Filament\Resources\VehicleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaintenanceLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenanceLogs';
    protected static ?string $navigationLabel = 'Log Pemeliharaan';
    protected static ?string $title = 'Histori Service & Perawatan Kendaraan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('maintenance_date')
                    ->label('Tanggal Servis')
                    ->default(now())
                    ->required(),

                TextInput::make('odometer')
                    ->label('KM/HM saat Servis')
                    ->numeric()
                    ->required(),

                Select::make('type')
                    ->options([
                        'Rutin' => 'Rutin',
                        'Insidental' => 'Insidental',
                        'Darurat' => 'Darurat'
                    ])
                    ->required(),

                TextInput::make('location')
                    ->label('Lokasi Servis (Bengkel)')
                    ->required(),

                Textarea::make('notes')
                    ->label('Deskripsi Pekerjaan Servis')
                    ->columnSpanFull(),

                FileUpload::make('docs_path')
                    ->label('Dokumen Servis (Nota)')
                    ->directory('maintenance-docs'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('maintenance_date')
            ->columns([
                TextColumn::make('maintenance_date')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('type')
                    ->badge(),

                TextColumn::make('location')
                    ->searchable(),

                TextColumn::make('notes')
                    ->limit(50)
                    ->wrap(),
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
