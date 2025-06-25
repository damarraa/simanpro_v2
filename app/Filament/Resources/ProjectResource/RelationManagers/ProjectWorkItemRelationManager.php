<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Filament\Resources\ProjectWorkItemResource;
use App\Models\ProjectWorkItem;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectWorkItemRelationManager extends RelationManager
{
    protected static string $relationship = 'workItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Item Pekerjaan')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('unit')
                    ->label('Satuan')
                    ->required(),

                TextInput::make('volume')
                    ->label('Volume')
                    ->numeric()
                    ->required(),

                Textarea::make('description')
                    ->label('Deskripsi')
                    ->nullable()
                    ->columnSpanFull(),
            ]);
        // return $form
        //     ->schema([
        //         TextInput::make('name')
        //             ->label('Nama Item Pekerjaan')
        //             ->required(),

        //         TextInput::make('unit')
        //             ->label('Satuan')
        //             ->required(),

        //         TextInput::make('volume')
        //             ->label('Volume')
        //             ->numeric()
        //             ->required()
        //             ->live(onBlur: true)
        //             ->afterStateUpdated(function (Get $get, Set $set) {
        //                 $volume = floatval($get('volume'));
        //                 $unitPrice = floatval($get('unit_price'));
        //                 $set('total_planned_amount', $volume * $unitPrice);
        //             }),

        //         TextInput::make('unit_price')
        //             ->label('Harga Satuan')
        //             ->numeric()
        //             ->prefix('Rp')
        //             ->required()
        //             ->live(onBlur: true)
        //             ->afterStateUpdated(function (Get $get, Set $set) {
        //                 $volume = floatval($get('volume'));
        //                 $unitPrice = floatval($get('unit_price'));
        //                 $set('total_planned_amount', $volume * $unitPrice);
        //             }),

        //         TextInput::make('total_planned_amount')
        //             ->label('Total Harga')
        //             ->numeric()
        //             ->prefix('Rp')
        //             ->required()
        //             ->disabled()
        //             ->dehydrated(),

        //         Textarea::make('description')
        //             ->label('Deskripsi')
        //             ->nullable(),
        //     ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('unit'),
                TextColumn::make('volume'),
                TextColumn::make('unit_price')
                    ->label('Harga Satuan')
                    ->money('IDR'),
                TextColumn::make('total_planned_amount')
                    ->label('Total Rencana')
                    ->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(
                        fn(ProjectWorkItem $record): string =>
                        ProjectWorkItemResource::getUrl('edit', ['record' => $record])
                    ),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
