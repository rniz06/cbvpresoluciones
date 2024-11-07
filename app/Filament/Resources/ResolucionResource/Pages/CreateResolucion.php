<?php

namespace App\Filament\Resources\ResolucionResource\Pages;

use App\Filament\Resources\ResolucionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateResolucion extends CreateRecord
{
    protected static string $resource = ResolucionResource::class;

    protected static ?string $title = 'Añadir Resolución';

    protected function getRedirectUrl(): string
    {
        return ResolucionResource::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['archivo_nombre_generado'] = basename($data['ruta_archivo']);

        $data['archivo_tipo'] = Storage::disk('public')->mimeType($data['ruta_archivo']);

        $data['archivo_tamano'] = Storage::disk('public')->size($data['ruta_archivo']);

        return $data;
    }
}
