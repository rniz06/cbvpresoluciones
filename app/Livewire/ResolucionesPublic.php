<?php

namespace App\Livewire;

use App\Models\FuenteOrigen;
use App\Models\Resolucion;
use App\Models\vistas\ResolucionView;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ResolucionesPublic extends Component
{
    use WithPagination;

    public string $buscar = "";
    public $paginado = 5;
    public $anosFilter = '';
    public $fechaDesde = '';
    public $fechaHasta = '';
    public $origen = '';

    public function updating($key): void
    {
        if ($key === 'buscar' || $key === 'paginado' || $key === 'anosFilter' || $key === 'fechaDesde' || $key === 'fechaHasta' || $key === 'origen') {
            $this->resetPage();
        }
    }

    public function render()
    {
        //
        $anos = Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();

        //
        $origenes = FuenteOrigen::select('id', 'origen')->get();

        $resoluciones = ResolucionView::select('id_resolucion', 'n_resolucion', 'nro_acta', 'concepto', 'fecha', 'ano', 'fuente_origen', 'tipo_documento', 'fuente_origen_id', 'tipo_documento_id')
        // ->with(['tipoDocumento:id,tipo', 'fuenteOrigen:id,origen'])
        ->buscar($this->buscar)
        ->when($this->anosFilter !== '', function($query){
            $query->where('ano', $this->anosFilter);
        })
        ->when($this->origen !== '', function($query){
            $query->where('fuente_origen_id', $this->origen);
        })

        ->when($this->fechaDesde || $this->fechaHasta, function ($query) {
            if ($this->fechaDesde && $this->fechaHasta) {
                // Filtra por el rango de fechas si ambos campos están completos
                $query->whereBetween('fecha', [$this->fechaDesde, $this->fechaHasta]);
            } elseif ($this->fechaDesde) {
                // Filtra desde la fecha de inicio si solo fechaInicio está completa
                $query->where('fecha', '>=', $this->fechaDesde);
            } elseif ($this->fechaHasta) {
                // Filtra hasta la fecha de fin si solo fechaFin está completa
                $query->where('fecha', '<=', $this->fechaHasta);
            }
        })
        // ->when($this->fechaDesde && $this->fechaHasta, function ($query) {
        //     $query->whereBetween('fecha', [$this->fechaDesde, $this->fechaHasta]);
        // })
        ->paginate($this->paginado);

        return view('livewire.resoluciones-public', [
            'resoluciones' => $resoluciones,
            'anos' => $anos,
            'origenes' => $origenes,
        ]);
    }

    // public function render()
    // {
    //     $resoluciones = Resolucion::select('id', 'n_resolucion', 'concepto', 'fecha', 'ano')
    //     ->when($this->buscar !== '', fn(Builder $query) => $query->where('concepto', 'like', '%'. $this->buscar .'%'))
    //     ->paginate(10);
    //     return view('livewire.resoluciones-public', ['resoluciones' => $resoluciones]);
    // }
}
