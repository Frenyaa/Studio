<?php

namespace App\Filament\Resources\ClientFeedbackResource\Pages;

use App\Filament\Resources\ClientFeedbackResource;
use Filament\Resources\Pages\CreateRecord;

class CreateClientFeedback extends CreateRecord
{
    protected static string $resource = ClientFeedbackResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
