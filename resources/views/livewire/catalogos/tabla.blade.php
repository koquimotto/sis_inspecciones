<div
    class="box-body"
    x-data="{
        openModal(id) {
            Livewire.dispatch('{{ $config['events']['open_modal'] }}', {
                id: id,
                title: 'Editar {{ ucfirst($config['singular']) }}'
            });
        },
        confirmarEliminar(id, nombre) {
            window.dispatchEvent(new CustomEvent('confirmar-eliminar-{{ $config['module'] }}', {
                detail: {
                    id: id,
                    text: `Se eliminara el registro ${nombre}.`
                }
            }));
        }
    }"
>
    <div class="table-responsive">
        <table class="table whitespace-nowrap ti-striped-table table-hover min-w-full ti-custom-table-hover">
            <thead>
                <tr class="border-b border-defaultborder">
                    <th scope="col" class="text-start w-1">#</th>
                    @foreach ($config['fields'] as $field)
                        <th scope="col" class="text-start">{{ $field['label'] }}</th>
                    @endforeach
                    <th scope="col" class="text-start">Estado</th>
                    <th scope="col" class="text-start w-1"></th>
                </tr>
            </thead>

            <tbody>
                @forelse ($records as $record)
                    <tr class="border-b border-defaultborder" wire:key="{{ $config['module'] }}-{{ $record->id }}">
                        <th scope="row">{{ $records->firstItem() + $loop->index }}</th>

                        @foreach ($config['fields'] as $field)
                            <td>
                                <span class="{{ $field['name'] === $config['name_field'] ? 'font-semibold' : '' }}">
                                    {{ $record->{$field['name']} ?: '—' }}
                                </span>
                            </td>
                        @endforeach

                        <td>
                            @if ((int) $record->estado === 1)
                                <span class="badge bg-success/10 text-success">
                                    <i class="ri-checkbox-circle-line align-middle me-1"></i>
                                    Activo
                                </span>
                            @else
                                <span class="badge bg-danger/10 text-danger">
                                    <i class="ri-close-circle-line align-middle me-1"></i>
                                    Inactivo
                                </span>
                            @endif
                        </td>

                        <td>
                            <div class="flex items-center gap-2">
                                <button
                                    class="ti-btn btn-wave ti-btn-icon ti-btn-sm ti-btn-info-full waves-effect waves-light"
                                    @click="openModal({{ $record->id }})"
                                    title="Editar"
                                >
                                    <i class="ri-edit-line"></i>
                                </button>

                                <button
                                    class="ti-btn btn-wave ti-btn-icon ti-btn-sm ti-btn-danger-full waves-effect waves-light"
                                    @click="confirmarEliminar({{ $record->id }}, @js($record->{$config['name_field']}))"
                                    title="Eliminar"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($config['fields']) + 3 }}" class="text-center py-8 text-[#8c9097]">
                            No se encontraron registros para {{ strtolower($config['title']) }}.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $records->links() }}
    </div>
</div>
