<?php

namespace App\Filament\Resources\WorkflowStepResource\Pages;

use App\Filament\Resources\WorkflowStepResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkflowStep extends EditRecord
{
    protected static string $resource = WorkflowStepResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
