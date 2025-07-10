<?php

namespace App\Filament\Admin\Widgets;

use App\Helpers\Helpers;
use App\Models\Asesor;
use App\Models\Seguimiento;
use Filament\Widgets\ChartWidget;

class DailySeguimentosKpiChartRecovery extends ChartWidget
{
    protected static ?string $heading = 'Seguimientos diarios por asesor recovery ';
    protected static ?string $pollingInterval = '60s';
    protected int|string|array $columnSpan = 'full';
    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $start = now()->startOfDay();
        $end   = now()->endOfDay();

        $asesores = Asesor::query()
                ->where('tipo_asesor','recovery')
                ->whereHas('user.roles',fn($q) => $q->whereIn('name',['asesor', 'team recovery']))
                ->with('user:id,name')
                ->get();
        
            $labels = [];
            $data   = [];
            $colors = [];
        
            foreach ($asesores as $asesor){
                $totalClientes = Seguimiento::query()
                    ->where('asesor_id',$asesor->id)
                    ->whereBetween('created_at',[$start, $end])
                    ->distinct('user_id')
                    ->count('user_id');
                
                $labels[] = $asesor->user->name ?? "Asesor {$asesor->id}";
                $data[]   = $totalClientes;
                $colors[] = $totalClientes >= 180 ?'rgba(16,185,129,1)' : 'rgba(239,68,68,1)';
            }
        return [
            'labels'  => $labels,
            'datasets'=>[
                [
                    'label'  =>'Clientes distintos contactados Hoy',
                    'data'   => $data,
                    'backgroundColor' => $colors,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'chart' => [
                'type' => $this->getType(),
                'data' => $this->getData(),

                /* Aquí van opciones nativas de Chart.js */
                'options' => [
                    /* Barras horizontales */
                    'indexAxis' => 'y',

                    /* Espacio y aspecto */
                    'responsive'           => true,
                    'maintainAspectRatio'  => false,

                    /* Eje X con ticks 0-200 */
                    'scales' => [
                        'x' => [
                            'beginAtZero' => true,
                            'max'         => 200,
                            'ticks'       => [
                                'stepSize' => 20,        // marcas cada 20
                                'color'    => '#e5e7eb', // gris-200
                            ],
                            'grid'        => [
                                'color' => 'rgba(255,255,255,0.08)',
                            ],
                        ],
                        'y' => [
                            'ticks' => [
                                'color' => '#e5e7eb',
                            ],
                            'grid'  => [
                                'display' => false,
                            ],
                        ],
                    ],
                    /* Tooltip simplificado */
                    'plugins' => [
                        'tooltip' => [
                            'callbacks' => [
                                'label' => \Illuminate\Support\Js::from(
                                    "ctx.parsed.x + ' clientes'"
                                ),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function canView(): bool
    {
        return Helpers::isSuperAdmin() || Helpers::isTeamRCVRY();
    }

}
