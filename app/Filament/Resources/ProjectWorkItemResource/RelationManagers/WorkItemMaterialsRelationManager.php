<?php

namespace App\Filament\Resources\ProjectWorkItemResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component;

class WorkItemMaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'workItemMaterials';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('material_name')
                    ->label('Nama Material')
                    ->required(),

                TextInput::make('quantity')
                    ->label('Qty')
                    ->numeric()
                    ->required(),

                TextInput::make('unit')
                    ->label('Unit')
                    ->required(),

                TextInput::make('unit_price')
                    ->label('Harga Satuan')
                    ->numeric()
                    ->prefix('Rp')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('material_name')
            ->columns([
                TextColumn::make('material_name'),
                TextColumn::make('quantity'),
                TextColumn::make('unit'),
                TextColumn::make('unit_price')->money('IDR'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(fn(Component $livewire) => $livewire->dispatch('refreshWorkItemCosts')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(fn(Component $livewire) => $livewire->dispatch('refreshWorkItemCosts')),
                Tables\Actions\DeleteAction::make()
                    ->after(fn(Component $livewire) => $livewire->dispatch('refreshWorkItemCosts')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
