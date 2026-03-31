<?php

namespace App\Livewire\Catalogos;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

abstract class CatalogoTablaBase extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public string $search = '';

    abstract protected function config(): array;

    public function getListeners(): array
    {
        return [
            $this->config()['events']['filter'] => 'filtrar',
            $this->config()['events']['delete'] => 'eliminar',
            $this->config()['events']['refresh'] => '$refresh',
        ];
    }

    public function filtrar(string $search = ''): void
    {
        $this->search = trim($search);
        $this->resetPage();
    }

    public function eliminar(int $id): void
    {
        $config = $this->config();
        $class = $config['model'];
        $record = $class::query()->findOrFail($id);
        $nameField = $config['name_field'];
        $label = $record->{$nameField};

        $record->estado = 0;
        if (in_array('deleted_by', $record->getFillable(), true)) {
            $record->deleted_by = Auth::id();
        }
        if (in_array('updated_by', $record->getFillable(), true)) {
            $record->updated_by = Auth::id();
        }
        $record->save();

        $this->dispatch($config['events']['refresh']);
        $this->dispatch(
            'swal',
            type: 'success',
            title: 'Registro eliminado',
            text: 'Se elimino "' . $label . '" correctamente.'
        );
    }

    public function render()
    {
        $config = $this->config();
        $class = $config['model'];

        $records = $class::query()
            ->where('estado', 1)
            ->when($this->search !== '', function (Builder $query) use ($config) {
                $query->where(function (Builder $subQuery) use ($config) {
                    foreach ($config['search_fields'] as $index => $field) {
                        if ($index === 0) {
                            $subQuery->where($field, 'like', '%' . $this->search . '%');
                            continue;
                        }

                        $subQuery->orWhere($field, 'like', '%' . $this->search . '%');
                    }
                });
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('livewire.catalogos.tabla', [
            'config' => $config,
            'records' => $records,
        ]);
    }
}




