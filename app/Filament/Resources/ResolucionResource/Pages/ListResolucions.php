<?php

namespace App\Filament\Resources\ResolucionResource\Pages;

use App\Filament\Resources\ResolucionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResolucions extends ListRecords
{
    protected static string $resource = ResolucionResource::class;

    protected static ?string $title = 'Resoluciones';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Añadir Resolución'),
        ];
    }
}
