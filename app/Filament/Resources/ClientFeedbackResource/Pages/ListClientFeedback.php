<?php

namespace App\Filament\Resources\ClientFeedbackResource\Pages;

use App\Filament\Resources\ClientFeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientFeedback extends ListRecords
{
    protected static string $resource = ClientFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('Thêm feedback')];
    }
}
