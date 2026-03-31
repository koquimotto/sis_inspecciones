<?php

namespace App\Livewire\Catalogos;

use Livewire\Component;

abstract class CatalogoFiltroBase extends Component
{
    public string $search = '';

    abstract protected function config(): array;

    public function updatedSearch(): void
    {
        $this->dispatch($this->config()['events']['filter'], search: $this->search);
    }

    public function limpiar(): void
    {
        $this->search = '';
        $this->dispatch($this->config()['events']['filter'], search: '');
    }

    public function render()
    {
        return view('livewire.catalogos.filtro', [
            'config' => $this->config(),
        ]);
    }
}
