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
    
    public function updating($key): void
    {
        if ($key === 'buscar') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $resoluciones = Resolucion::select('id', 'n_resolucion', 'concepto', 'fecha', 'ano')
        ->where('concepto', 'like', '%' . $this->buscar . '%')
        ->orWhere('n_resolucion', 'like', '%' . $this->buscar . '%')
        ->paginate(10);
        return view('livewire.resoluciones-public', ['resoluciones' => $resoluciones]);
    }

    // public function render()
    // {
    //     $resoluciones = Resolucion::select('id', 'n_resolucion', 'concepto', 'fecha', 'ano')
    //     ->when($this->buscar !== '', fn(Builder $query) => $query->where('concepto', 'like', '%'. $this->buscar .'%'))
    //     ->paginate(10);
    //     return view('livewire.resoluciones-public', ['resoluciones' => $resoluciones]);
    // }
}
