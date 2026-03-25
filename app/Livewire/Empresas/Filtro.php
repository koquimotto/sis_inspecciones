<?php

namespace App\Livewire\Empresas;

use Livewire\Component;

class Filtro extends Component
{
    public string $search = '';

    public function updatedSearch(): void
    {
        $this->dispatch('empresas-filtrar', search: $this->search);
    }

    public function limpiar(): void
    {
        $this->search = '';
        $this->dispatch('empresas-filtrar', search: '');
    }

    public function render()
    {
        return view('livewire.empresas.filtro');
    }
}