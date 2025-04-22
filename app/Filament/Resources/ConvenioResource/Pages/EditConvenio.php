<?php

namespace App\Filament\Resources\ConvenioResource\Pages;

use App\Filament\Resources\ConvenioResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EditConvenio extends EditRecord
{
    protected static string $resource = ConvenioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updater_id'] = Auth::id();

        $data['archivo_tipo'] = Storage::disk('public')->mimeType($data['archivo']);

        $data['archivo_tamano'] = Storage::disk('public')->size($data['archivo']);

        $data['anho_suscrito'] = Carbon::parse($data['fecha_suscrito'])->year;

        $data['anho_fin'] = Carbon::parse($data['fecha_fin'])->year;

        return $data;
    }
}
