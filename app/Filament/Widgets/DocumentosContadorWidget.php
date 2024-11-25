<?php

namespace App\Filament\Widgets;

use Filament\Support\Enums\IconPosition;
use App\Models\Resolucion;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DocumentosContadorWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('', Resolucion::query()->count())
            ->description('Documentos digitalizados a la fecha')
            ->descriptionIcon('heroicon-o-clipboard-document-check', IconPosition::Before),
            // Stat::make('Resoluciones', Resolucion::query()->where('tipo_documento_id', 2)->count()),
            // Stat::make('Circulares', Resolucion::query()->where('tipo_documento_id', 1)->count()),
            // Stat::make('Memorandos', Resolucion::query()->where('tipo_documento_id', 3)->count()),
        ];
    }
}
