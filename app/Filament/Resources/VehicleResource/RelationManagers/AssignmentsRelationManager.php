<?php

namespace App\Filament\Resources\VehicleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';
    protected static ?string $title = 'Histori Penugasan Proyek';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_id')
                    ->relationship('project', 'job_name')
                    ->label('Digunakan untuk Proyek')
                    ->required(),

                Select::make('user_id')
                    ->relationship('driver', 'name')
                    ->label('Driver/Operator')
                    ->required(),

                DatePicker::make('start_datetime')
                    ->label('Waktu Mulai')
                    ->default(now())
                    ->required(),

                DatePicker::make('end_datetime')
                    ->label('Waktu Selesai'),

                TextInput::make('start_odometer')
                    ->label('KM/HM Awal')
                    ->numeric(),

                TextInput::make('end_odometer')
                    ->label('KM/HM Akhir')
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('project_id')
            ->columns([
                TextColumn::make('project.job_name')
                    ->label('Proyek'),

                TextColumn::make('driver.name')
                    ->label('Driver/Operator'),

                TextColumn::make('start_datetime')
                    ->label('Mulai')
                    ->dateTime('d M Y'),

                TextColumn::make('end_datetime')
                    ->label('Selesai')
                    ->dateTime('d M Y')
                    ->default('-'),
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
