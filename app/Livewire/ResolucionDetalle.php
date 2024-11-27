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
        //$companias = ResolucionCompaniaView::select('compania', 'compania_departamento', 'compania_ciudad')->where('id_resolucion', $this->resolucionView->id_resolucion)->orderby('compania', 'asc')->paginate(5);

        //$personales = ResolucionPersonalView::select('nombre_completo', 'codigo', 'categoria')->where('id_resolucion', $this->resolucionView->id_resolucion)->orderby('nombre_completo', 'asc')->paginate(5);
        // $personalesAfectados = ResolucionPersonalView::where('id_resolucion', $this->resolucionView->id)
        //     ->paginate(5);

        $companias = ResolucionCompaniaView::select('compania', 'compania_departamento', 'compania_ciudad')
            ->where('id_resolucion', $this->resolucionView->id_resolucion)
            ->orderBy('compania', 'asc')
            ->paginate(5)
            ->withQueryString()
            ->appends(['personal_page' => request('personal_page')]);

        $personales = ResolucionPersonalView::select('nombre_completo', 'codigo', 'categoria')
            ->where('id_resolucion', $this->resolucionView->id_resolucion)
            ->orderBy('nombre_completo', 'asc')
            ->paginate(5, ['*'], 'personal_page')
            ->withQueryString()
            ->appends(['page' => request('page')]);

        return view('livewire.resolucion-detalle', [
            'companias' => $companias,
            'personales' => $personales,
            // 'companiasAfectadas' => $companiasAfectadas,
            // 'personalesAfectados' => $personalesAfectados,
        ]);
    }
}
