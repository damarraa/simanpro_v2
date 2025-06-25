<?php

namespace App\Filament\Resources\ProjectWorkItemResource\Pages;

use App\Filament\Resources\ProjectWorkItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectWorkItem extends EditRecord
{
    protected static string $resource = ProjectWorkItemResource::class;

    protected $listeners = [
        'refreshWorkItemCosts' => '$refresh',
    ];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
