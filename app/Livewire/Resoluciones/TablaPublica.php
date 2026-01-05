<?php

namespace App\Livewire\Resoluciones;

use App\Models\FuenteOrigen;
use App\Models\Resolucion;
use App\Models\TipoDocumento;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TablaPublica extends Component
{
    use WithPagination;

    // Define el tema de paginación como 'bootstrap'
    protected $paginationTheme = 'bootstrap';

    public $buscarNResolucion = '', $buscarNActa = '', $buscarConcepto = '', $buscarFecha = '', $buscarOrigenId = '';
    public $buscarTipoId = '', $buscarAnho = '', $paginado = 10;

    public $origenes = [], $tipos = [], $anhos = [];

    public function mount()
    {
        $this->origenes = FuenteOrigen::orderBy('origen')->get(['id', 'origen']);
        $this->tipos    = TipoDocumento::orderBy('tipo')->get(['id', 'tipo']);
        $this->anhos    = Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();
    }

    #[On('recargar')]
    public function cargarDatos()
    {
        return Resolucion::select('id', 'n_resolucion', 'nro_acta', 'concepto', 'fecha', 'ano', 'fuente_origen_id', 'tipo_documento_id')
                ->buscarNResolucion($this->buscarNResolucion)
                ->buscarNActa($this->buscarNActa)
                ->buscarConcepto($this->buscarConcepto)
                ->buscarFecha($this->buscarFecha)
                ->buscarOrigenId($this->buscarOrigenId)
                ->buscarTipoId($this->buscarTipoId)
                ->buscarAnho($this->buscarAnho)
                ->with(['fuenteOrigen:id,origen','tipoDocumento:id,tipo'])
                ->orderByDesc('ano')
                ->orderByDesc('fecha')
                ->paginate($this->paginado);
    }

    public function render()
    {
        return view('livewire.resoluciones.tabla-publica', [
            'resoluciones' => $this->cargarDatos()
        ]);
    }
    #[On('filtrar')]
    public function filtrar()
    {
        $this->resetPage();
        $this->dispatch('recargar');
    }
}
