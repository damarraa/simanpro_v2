<?php

namespace App\Filament\Resources\DailyProjectReportResource\Pages;

use App\Filament\Resources\DailyProjectReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyProjectReports extends ListRecords
{
    protected static string $resource = DailyProjectReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
