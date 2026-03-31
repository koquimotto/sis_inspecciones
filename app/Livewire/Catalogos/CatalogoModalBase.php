<?php

namespace App\Livewire\Catalogos;

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

abstract class CatalogoModalBase extends Component
{
    public bool $modal = false;
    public string $titleModal = '';
    public ?int $editingId = null;
    public array $state = [];

    abstract protected function config(): array;

    public function mount(): void
    {
        $this->titleModal = 'Nuevo registro';
        $this->resetState();
    }

    public function getListeners(): array
    {
        return [
            $this->config()['events']['open_modal'] => 'open',
        ];
    }

    public function open(int $id = 0, string $title = 'Nuevo registro'): void
    {
        $this->resetValidation();
        $this->resetState();

        $this->editingId = $id > 0 ? $id : null;
        $this->titleModal = $title;
        $this->modal = true;

        if (!$this->editingId) {
            return;
        }

        $model = $this->newModelQuery()->findOrFail($this->editingId);

        foreach ($this->config()['fields'] as $field) {
            $this->state[$field['name']] = $model->{$field['name']};
        }

        $this->state['estado'] = (int) $model->estado;
    }

    public function save(): void
    {
        $validated = $this->validate($this->rules(), [], $this->attributes());

        /** @var Model $model */
        $model = $this->editingId
            ? $this->newModelQuery()->findOrFail($this->editingId)
            : $this->newModel();

        $model->fill($validated['state']);
        $model->save();

        $this->modal = false;
        $this->dispatch($this->config()['events']['refresh']);
        $this->dispatch(
            'swal',
            type: 'success',
            title: $this->editingId ? 'Registro actualizado' : 'Registro creado',
            text: $this->successMessage($model)
        );

        $this->resetValidation();
        $this->resetState();
    }

    protected function rules(): array
    {
        $rules = [];

        foreach ($this->config()['fields'] as $field) {
            $fieldRules = $field['rules'] ?? ['string'];
            $rules['state.' . $field['name']] = array_merge(
                [$field['required'] ? 'required' : 'nullable'],
                $fieldRules
            );
        }

        $rules['state.estado'] = ['required', 'boolean'];

        return $rules;
    }

    protected function attributes(): array
    {
        $attributes = [
            'state.estado' => 'estado',
        ];

        foreach ($this->config()['fields'] as $field) {
            $attributes['state.' . $field['name']] = mb_strtolower($field['label']);
        }

        return $attributes;
    }

    protected function resetState(): void
    {
        $this->state = [];

        foreach ($this->config()['fields'] as $field) {
            $this->state[$field['name']] = $field['default'] ?? '';
        }

        $this->state['estado'] = 1;
    }

    protected function successMessage(Model $model): string
    {
        $nameField = $this->config()['name_field'];
        $entity = $this->config()['singular'];

        return 'El ' . $entity . ' "' . $model->{$nameField} . '" se guardo correctamente.';
    }

    protected function newModel(): Model
    {
        $class = $this->config()['model'];

        return new $class();
    }

    protected function newModelQuery()
    {
        $class = $this->config()['model'];

        return $class::query();
    }

    public function render()
    {
        return view('livewire.catalogos.modal', [
            'config' => $this->config(),
        ]);
    }
}
