<?php

namespace App\Filament\Resources\ProjectWorkItemResource\Pages;

use App\Filament\Resources\ProjectWorkItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectWorkItems extends ListRecords
{
    protected static string $resource = ProjectWorkItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
