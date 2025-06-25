<?php

namespace App\Filament\Resources\DailyProjectReportResource\Pages;

use App\Filament\Resources\DailyProjectReportResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDailyProjectReport extends CreateRecord
{
    protected static string $resource = DailyProjectReportResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['submitted_by'] = auth()->id();
        return $data;
    }
}
