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

class WorkItemLaborsRelationManager extends RelationManager
{
    protected static string $relationship = 'workItemLabors';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('labor_type')
                    ->required(),

                TextInput::make('quantity')
                    ->label('Jumlah Petugas')
                    ->numeric()
                    ->required(),

                TextInput::make('rate')
                    ->label('Harga')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('labor_type')
            ->columns([
                TextColumn::make('labor_type'),
                TextColumn::make('quantity'),
                TextColumn::make('rate')->money('IDR'),
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
