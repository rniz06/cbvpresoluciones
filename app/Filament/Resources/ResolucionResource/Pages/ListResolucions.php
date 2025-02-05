<?php

namespace App\Filament\Resources\ResolucionResource\Pages;

use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ResolucionResource;
use App\Models\Resolucion;
use App\Models\vistas\ResolucionView;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Resources\Pages\ListRecords;

class ListResolucions extends ListRecords
{
    protected static string $resource = ResolucionResource::class;

    protected static ?string $title = 'Resoluciones';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Añadir Resolución'),
            Actions\Action::make('pdf')
                ->label('Pdf')
                ->icon('fas-file-pdf')
                ->form([
                    DatePicker::make('fecha_desde')->label('Fecha desde')->required(),
                    DatePicker::make('fecha_hasta')->label('Fecha hasta'),
                ])
                ->action(function (array $data) {
                    $resoluciones = ResolucionView::select('id_resolucion','n_resolucion', 'nro_acta', 'concepto', 'fecha', 'tipo_documento', 'fuente_origen')
                        ->when(
                            $data['fecha_desde'],
                            fn(Builder $query, $date): Builder => $query->whereDate('fecha', '>=', $date)
                        )
                        ->when(
                            $data['fecha_hasta'],
                            fn(Builder $query, $date): Builder => $query->whereDate('fecha', '<=', $date)
                        )->get();

                    $pdf = Pdf::loadView('resoluciones.pdf.lista-resoluciones', [
                        'resoluciones' => $resoluciones,
                        'fecha_desde' => $data['fecha_desde'],
                        'fecha_hasta' => $data['fecha_hasta'],
                        //'filters' => $tableFilters
                    ]);

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, 'Listado de Resoluciones.pdf');
                })
                ->modalHeading('Exportar Listado de Resoluciones a PDF')
                ->modalDescription('Se generará un PDF con las resoluciones filtradas segun las fechas ingresadas.')
                ->modalSubmitActionLabel('Exportar')
                ->color('warning')
                ->closeModalByClickingAway(false) // Cerrar el modal haciendo clic fuera false
                ->modalWidth(MaxWidth::Medium) // Cambiar el ancho modal
            //->requiresConfirmation()
        ];
    }
}
