<?php

namespace App\Filament\Resources\ConvenioResource\Pages;

use Illuminate\Support\Str;
use App\Filament\Resources\ConvenioResource;
use App\Models\Convenio\Archivo;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreateConvenio extends CreateRecord
{
    protected static ?string $title = 'Registrar Convenio';

    protected function getRedirectUrl(): string
    {
        return ConvenioResource::getUrl('index');
    }

    protected static string $resource = ConvenioResource::class;

    

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['creador_id'] = Auth::id();

        $data['presidente_id'] = 507;

        $data['secretario_id'] = 497;

        $data['archivo_tipo'] = Storage::disk('public')->mimeType($data['archivo']);

        $data['archivo_tamano'] = Storage::disk('public')->size($data['archivo']);

        $data['cod'] = (string) Str::uuid7(time: now());

        $data['anho_suscrito'] = Carbon::parse($data['fecha_suscrito'])->year;

        $data['anho_fin'] = Carbon::parse($data['fecha_fin'])->year;

        return $data;
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Convenio Registrado';
    }
}
