<?php

namespace App\Filament\Resources\ToolResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('project_id')
                    ->relationship('project', 'job_name')
                    ->label('Ditugaskan ke Proyek')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('assigned_date')
                    ->label('Tanggal Penugasan / Peminjaman')
                    ->default(now())
                    ->required(),

                DatePicker::make('returned_date')
                    ->label('Tanggal Pengembalian'),

                Textarea::make('notes')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('project_id')
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('project.job_name')
                    ->label('Digunakan di Proyek'),

                TextColumn::make('assigned_date')
                    ->label('Tanggal Dipinjam')
                    ->date('d M Y'),

                TextColumn::make('returned_date')
                    ->label('Tanggal Kembali')
                    ->date('d M Y')
                    ->default('-'),

                TextColumn::make('assignedBy.name')
                    ->label('Diberikan Oleh'),
            ])
            ->defaultSort('assigned_date', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    // Otomatis isi kolom 'assigned_by' dengan ID user yang login
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['assigned_by'] = auth()->id();
                        return $data;
                    }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
