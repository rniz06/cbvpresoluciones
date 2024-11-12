<?php

namespace App\Filament\Resources\ResolucionResource\Pages;

use Illuminate\Database\Eloquent\Builder;
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

    protected static ?string $title = 'Detalles de Documento';

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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select('id', 'n_resolucion', 'concepto', 'fecha', 'ano', 'usuario_id', 'compania_id', 'personal_id', 'tipo_documento_id', 'fuente_origen_id')
            ->with(['usuario:id,name', 'tipoDocumento:id,tipo', 'fuenteOrigen:id,origen']);
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
                        TextEntry::make('tipoDocumento.tipo')->label('Tipo Documento:')->badge(),
                        TextEntry::make('fuenteOrigen.origen')->label('Origen:')->badge(),
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
