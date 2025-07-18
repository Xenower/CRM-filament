<?php

namespace App\Filament\Admin\Resources\SeguimientoKpiDiarioResource\Pages;

use App\Filament\Admin\Resources\SeguimientoKpiDiarioResource;
// use App\Filament\Admin\Resources\SeguimientoKpiDiarioResource\Widgets\ResumenKpiMensual;
// use App\Filament\Admin\Resources\SeguimientoKpiDiarioResource\Widgets\WeeklyKpiAsesorsChart;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSeguimientoKpiDiarios extends ListRecords
{
    protected static string $resource = SeguimientoKpiDiarioResource::class;

    protected function getFooterWidgets(): array
    {
        return [
            // WeeklyKpiAsesorsChart::class,
            // ResumenKpiMensual::class,
        ];
    }
}
