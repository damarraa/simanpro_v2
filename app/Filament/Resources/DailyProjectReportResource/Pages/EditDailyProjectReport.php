<?php

namespace App\Filament\Resources\DailyProjectReportResource\Pages;

use App\Filament\Resources\DailyProjectReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyProjectReport extends EditRecord
{
    protected static string $resource = DailyProjectReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
