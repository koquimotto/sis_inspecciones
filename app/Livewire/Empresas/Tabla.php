<?php

namespace App\Livewire\Empresas;

use App\Actions\Empresas\EmpresaAction;
use App\Models\Empresa;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Tabla extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public string $search = '';

    protected $listeners = [
        'empresas:refresh' => '$refresh',
    ];

    #[On('empresas-filtrar')]
    public function filtrar(string $search = ''): void
    {
        $this->search = trim($search);
        $this->resetPage();
    }

    #[On('empresas:confirmar-desactivar')]
    public function desactivar(int $id, EmpresaAction $action): void
    {
        try {
            $empresa = Empresa::findOrFail($id);

            $action->desactivar($id);

            $this->dispatch('empresas:refresh');
            $this->dispatch(
                'swal',
                type: 'success',
                title: 'Empresa desactivada',
                text: "Se desactivó correctamente la empresa {$empresa->razon_social}."
            );
        } catch (\Throwable $e) {
            report($e);

            $this->dispatch(
                'swal',
                type: 'error',
                title: 'Error',
                text: 'No se pudo desactivar la empresa.'
            );
        }
    }

    public function render()
    {
        $empresas = Empresa::query()
            ->with([
                'contactoPrincipal.persona:id,nombres,apellido_paterno,apellido_materno,email,telefono'
            ])
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('ruc', 'like', "%{$this->search}%")
                      ->orWhere('razon_social', 'like', "%{$this->search}%")
                      ->orWhere('nombre_comercial', 'like', "%{$this->search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.empresas.tabla', compact('empresas'));
    }
}