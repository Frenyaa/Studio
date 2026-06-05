<?php

namespace App\Filament\Resources\ClientFeedbackResource\Pages;

use App\Filament\Resources\ClientFeedbackResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientFeedback extends EditRecord
{
    protected static string $resource = ClientFeedbackResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
