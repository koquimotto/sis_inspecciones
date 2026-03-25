<div
    class="box-body"
    x-data="{
        openModal(id) {
            Livewire.dispatch('empresas-modal:open', {
                id: id,
                title: 'Editar Empresa'
            });
        },
        confirmarDesactivar(id, nombre) {
            window.dispatchEvent(new CustomEvent('confirmar-desactivar-empresa', {
                detail: {
                    id: id,
                    text: `Se desactivará la empresa ${nombre}.`
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
                    <th scope="col" class="text-start">RUC</th>
                    <th scope="col" class="text-start">Razón social</th>
                    <th scope="col" class="text-start">Estado</th>
                    <th scope="col" class="text-start">Contacto</th>
                    <th scope="col" class="text-start">Teléfono contacto</th>
                    <th scope="col" class="text-start">Email contacto</th>
                    <th scope="col" class="text-start w-1"></th>
                </tr>
            </thead>

            <tbody>
                @forelse ($empresas as $empresa)
                    @php
                        $contacto = optional($empresa->contactoPrincipal)->persona;
                        $nombreContacto = $contacto
                            ? trim($contacto->nombres . ' ' . $contacto->apellido_paterno . ' ' . $contacto->apellido_materno)
                            : '—';
                    @endphp

                    <tr class="border-b border-defaultborder" wire:key="empresa-{{ $empresa->id }}">
                        <th scope="row">{{ $empresas->firstItem() + $loop->index }}</th>

                        <td>
                            <span class="font-semibold">{{ $empresa->ruc ?: '—' }}</span>
                        </td>

                        <td>
                            <div class="leading-none">
                                <span class="font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70">
                                    {{ $empresa->razon_social }}
                                </span>
                            </div>

                            <div class="leading-none mt-1">
                                <span class="text-[0.6875rem] text-[#8c9097] dark:text-white/50">
                                    {{ $empresa->nombre_comercial ?: 'Sin nombre comercial' }}
                                </span>
                            </div>
                        </td>

                        <td>
                            @if ((int) $empresa->estado === 1)
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

                        <td>{{ $nombreContacto }}</td>

                        <td>{{ $contacto?->telefono ?: '—' }}</td>

                        <td>{{ $contacto?->email ?: '—' }}</td>

                        <td>
                            <div class="flex items-center gap-2">
                                <button
                                    class="ti-btn btn-wave ti-btn-icon ti-btn-sm ti-btn-info-full waves-effect waves-light"
                                    @click="openModal({{ $empresa->id }})"
                                    title="Editar"
                                >
                                    <i class="ri-edit-line"></i>
                                </button>

                                @if ((int) $empresa->estado === 1)
                                    <button
                                        class="ti-btn btn-wave ti-btn-icon ti-btn-sm ti-btn-danger-full waves-effect waves-light"
                                        @click="confirmarDesactivar({{ $empresa->id }}, @js($empresa->razon_social))"
                                        title="Desactivar"
                                    >
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-[#8c9097]">
                            No se encontraron empresas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $empresas->links() }}
    </div>
</div>