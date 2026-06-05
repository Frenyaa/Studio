<?php

namespace App\Filament\Widgets;

use App\Models\Lead;
use App\Models\Project;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadStatsWidget extends BaseWidget
{
    protected static ?int $sort = -3;

    protected function getStats(): array
    {
        return [
            Stat::make('Khách đăng ký mới', Lead::where('status', 'new')->count())
                ->description('Cần liên hệ')
                ->descriptionIcon('heroicon-m-bell-alert')
                ->color('danger'),

            Stat::make('Đang liên hệ', Lead::where('status', 'contacting')->count())
                ->color('warning'),

            Stat::make('Đã chốt hợp đồng', Lead::where('status', 'won')->count())
                ->color('success'),

            Stat::make('Tổng dự án', Project::count())
                ->description(Project::where('is_published', true)->count() . ' đang xuất bản')
                ->color('gray'),
        ];
    }
}
