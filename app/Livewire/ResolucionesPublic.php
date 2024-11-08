<?php

namespace App\Livewire;

use App\Models\Resolucion;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class ResolucionesPublic extends Component
{
    use WithPagination;

    public string $buscar = "";
    public $paginado = 5;
    public $anosFilter = '';

    public function updating($key): void
    {
        if ($key === 'buscar') {
            $this->resetPage();
        }
    }

    public function render()
    {
        //
        $anos = Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();

        $resoluciones = Resolucion::select('id', 'n_resolucion', 'concepto', 'fecha', 'ano')
        ->buscar($this->buscar)
        ->when($this->anosFilter !== '', function($query){
            $query->where('ano', $this->anosFilter);
        })
        ->paginate($this->paginado);

        return view('livewire.resoluciones-public', [
            'resoluciones' => $resoluciones,
            'anos' => $anos,
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
