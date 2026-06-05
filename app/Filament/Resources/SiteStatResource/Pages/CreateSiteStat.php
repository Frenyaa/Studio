<?php

namespace App\Filament\Resources\SiteStatResource\Pages;

use App\Filament\Resources\SiteStatResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSiteStat extends CreateRecord
{
    protected static string $resource = SiteStatResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
