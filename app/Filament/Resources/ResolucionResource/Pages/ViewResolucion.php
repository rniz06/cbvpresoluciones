<?php

namespace App\Filament\Resources\ResolucionResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;
use App\Filament\Resources\ResolucionResource;
use App\Models\Resolucion;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewResolucion extends ViewRecord
{
    protected static string $resource = ResolucionResource::class;

    protected static ?string $title = 'Detalles de la resolución';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('descargar')
                ->label('Descargar')
                ->icon('heroicon-c-arrow-down-tray')
                ->url(fn () => route('descargar.resolucion', $this->record))
                ->openUrlInNewTab(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('')
                    ->schema([
                        TextEntry::make('n_resolucion')->label('N Resolución:')->badge(),
                        TextEntry::make('fecha')->label('Fecha:')->date(),
                        TextEntry::make('ano')->label('Año:')->badge(),
                        TextEntry::make('usuario.name')->label('Agregado Por:'),
                        Section::make([
                            TextEntry::make('concepto')->label('Concepto:')->columnSpanFull(),
                        ])
                    ])->columns(2),

                Section::make('')
                    ->schema([
                        TextEntry::make('getCompaniasNamesAttribute')->label('Compañias:')
                            ->getStateUsing(fn($record) => $record->getCompaniasNamesAttribute())
                            ->listWithLineBreaks()
                            ->bulleted(),

                        TextEntry::make('getPersonalView')->label('Personal:')
                            ->getStateUsing(fn($record) => $record->getPersonalView())
                            ->listWithLineBreaks()
                            ->bulleted(),
                    ])->columns(),                
            ]);
    }
}
