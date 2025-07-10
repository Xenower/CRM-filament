<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\DailySeguimentosKpiChartRecovery;
use App\Filament\Admin\Widgets\SeguimentosTableRecovery;
use App\Helpers\Helpers;
use Filament\Pages\Page;

class Kpis extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-chart-bar-square';
    protected static ?string $navigationLabel = 'Kpi Recovery';
    protected static ?string $navigationGroup = 'KPIs';
    protected static ?string $title = 'KPI Recovery';

    public static function canAccess(): bool
    {
        return Helpers::isSuperAdmin() || Helpers::isCrmJunior();
    }

    protected static string $view = 'filament.admin.pages.kpis';

    public function getHeader(): \Illuminate\Contracts\View\View|null
    {
        return view('filament.admin.pages.kpi-header');
    }

    public function getHeaderWidgets(): array
    {
        return [
            DailySeguimentosKpiChartRecovery::class,
            SeguimentosTableRecovery::class,
        ];
    }
}
