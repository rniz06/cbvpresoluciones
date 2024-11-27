<?php

namespace App\Livewire;

use Livewire\WithPagination;
use App\Models\vistas\ResolucionCompaniaView;
use App\Models\vistas\ResolucionPersonalView;
use App\Models\vistas\ResolucionView;
use Livewire\Component;

class ResolucionDetalle extends Component
{
    use WithPagination;

    public ResolucionView $resolucionView;

    public function mount($resolucion)
    {
        $this->resolucionView = ResolucionView::findOrFail($resolucion);
    }

    public function render()
    {
        // $companiasAfectadas = ResolucionCompaniaView::where('id_resolucion', $this->resolucionView->id)
        //     ->paginate(5);

        // $personalesAfectados = ResolucionPersonalView::where('id_resolucion', $this->resolucionView->id)
        //     ->paginate(5);

        return view('livewire.resolucion-detalle', [
            // 'companiasAfectadas' => $companiasAfectadas,
            // 'personalesAfectados' => $personalesAfectados,
        ]);
    }
}
