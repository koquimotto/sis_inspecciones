<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use Livewire\WithPagination;
use App\Actions\Usuarios\UsuarioAction;

class Tabla extends Component
{
    use WithPagination;

    public int $perPage = 10;

    public array $filters = [
        'q' => '',
        'estado' => null,
        'order_by' => 'id',
        'order_dir' => 'desc',
    ];

    protected $listeners = [
      'usuarios-tabla:refresh' => '$refresh',
      'usuarios-filtros:apply' => 'applyFilters',
      'usuarios-filtros:reset' => 'resetFilters',
    ];

    public function applyFilters(array $payload = []): void
    {
        $this->filters['q']        = trim((string)($payload['q'] ?? $this->filters['q']));
        $this->filters['estado']   = $payload['estado'] ?? $this->filters['estado'];
        $this->filters['order_by'] = (string)($payload['order_by'] ?? $this->filters['order_by']);
        $this->filters['order_dir'] = (string)($payload['order_dir'] ?? $this->filters['order_dir']);

        if (isset($payload['perPage']) && (int)$payload['perPage'] > 0) {
            $this->perPage = (int)$payload['perPage'];
        }

        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->filters = [
            'q' => '',
            'estado' => null,
            'order_by' => 'id',
            'order_dir' => 'desc',
        ];

        $this->perPage = 10;
        $this->resetPage();
    }

    public function render(UsuarioAction $action)
    {
        $usuarios = $action->listaUsuarios($this->filters, $this->perPage);

        return view('livewire.usuarios.tabla', compact('usuarios'));
    }
}
