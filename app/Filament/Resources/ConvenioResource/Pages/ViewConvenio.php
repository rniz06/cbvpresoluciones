<?php

namespace App\Filament\Resources\ConvenioResource\Pages;

use App\Filament\Resources\ConvenioResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewConvenio extends ViewRecord
{
    protected static string $resource = ConvenioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('descargar')
                ->label('Descargar')
                ->icon('heroicon-c-arrow-down-tray')
                ->url(fn () => route('descargar.convenio', $this->record))
                ->openUrlInNewTab(),
        ];
    }
}
