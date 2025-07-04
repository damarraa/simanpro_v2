<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssetAssignmentResource\Pages;
use App\Filament\Resources\AssetAssignmentResource\RelationManagers;
use App\Models\AssetAssignment;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssetAssignmentResource extends Resource
{
    protected static ?string $model = AssetAssignment::class;
    protected static ?string $navigationLabel = 'Peminjaman Alat';
    protected static ?string $navigationGroup = 'Manajemen Inventory & Material';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tool_id')
                    ->relationship('tool', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('project_id')
                    ->relationship('project', 'job_name')
                    ->searchable()
                    ->preload()
                    ->required(),

                DatePicker::make('assigned_date')
                    ->label('Tanggal Peminjaman')
                    ->default(now())
                    ->required(),

                DatePicker::make('returned_date')
                    ->label('Tanggal Pengembalian'),

                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tool.name')
                    ->label('Nama alat')
                    ->searchable(),

                TextColumn::make('project.job_name')
                    ->label('Untuk Proyek'),

                IconColumn::make('returned_date')
                    ->label('Sudah Kembali')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->color('success')
                    ->falseIcon('heroicon-o-x-circle')
                    ->color('warning'),

                TextColumn::make('assigned_date')
                    ->date('d M Y'),

                TextColumn::make('returned_date')
                    ->date('d M Y')
                    ->default('-'),

                TextColumn::make('assignedBy.name')
                    ->label('Diberikan Oleh'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // EditAction::make(),
                Action::make('markAsReturned')
                    ->label('Tandai Sudah Kembali')
                    ->icon('heroicon-s-check-circle')
                    ->action(fn(AssetAssignment $record) => $record->update(['returned_date' => now()]))
                    // ->requiresConfirmation()
                    ->hidden(fn(AssetAssignment $record): bool => $record->returned_date !== null),
            ]);
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ]);
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
            'index' => Pages\ListAssetAssignments::route('/'),
            'create' => Pages\CreateAssetAssignment::route('/create'),
            'edit' => Pages\EditAssetAssignment::route('/{record}/edit'),
        ];
    }
}
