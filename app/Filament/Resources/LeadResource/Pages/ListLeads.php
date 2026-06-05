<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Filament\Resources\LeadResource;
use App\Models\Lead;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListLeads extends ListRecords
{
    protected static string $resource = LeadResource::class;

    /** Tab lọc nhanh theo trạng thái. */
    public function getTabs(): array
    {
        $tabs = [
            'all' => Tab::make('Tất cả'),
        ];

        foreach (Lead::STATUSES as $key => $label) {
            $tabs[$key] = Tab::make($label)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', $key))
                ->badge(Lead::where('status', $key)->count());
        }

        return $tabs;
    }
}
