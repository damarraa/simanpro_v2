<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectWorkItemResource\Pages;
use App\Filament\Resources\ProjectWorkItemResource\RelationManagers;
use App\Filament\Resources\ProjectWorkItemResource\RelationManagers\WorkItemLaborsRelationManager;
use App\Filament\Resources\ProjectWorkItemResource\RelationManagers\WorkItemMaterialsRelationManager;
use App\Models\ProjectWorkItem;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectWorkItemResource extends Resource
{
    protected static ?string $model = ProjectWorkItem::class;
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Item Pekerjaan')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Item Pekerjaan')
                            ->required(),

                        TextInput::make('unit')
                            ->label('Satuan')
                            ->required(),

                        TextInput::make('volume')
                            ->label('Volume')
                            ->numeric()
                            ->required(),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('Ringkasan Biaya (Dihitung Otomatis)')
                    ->schema([
                        TextInput::make('unit_price')
                            ->label('Total Harga Satuan (Material + Jasa)')
                            // ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->formatStateUsing(fn($state) => number_format($state, 0, ',', '.'))
                            ->helperText('Nilai ini dihitung dari total rincian biaya di bawah.'),

                        TextInput::make('total_planned_amount')
                            ->label('Total Rencana Anggaran (Volume x Harga Satuan)')
                            // ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->formatStateUsing(fn($state) => number_format($state, 0, ',', '.')),
                    ])->columnSpan(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
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
            WorkItemMaterialsRelationManager::class,
            WorkItemLaborsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectWorkItems::route('/'),
            'create' => Pages\CreateProjectWorkItem::route('/create'),
            'edit' => Pages\EditProjectWorkItem::route('/{record}/edit'),
        ];
    }
}
