<div x-data="{ confirmDelete(type, id, label) { window.dispatchEvent(new CustomEvent('confirmar-eliminar-catalogo-inspeccion', { detail: { type, id, text: `Se eliminara el registro ${label}.` } })); } }" class="insp-ui mt-5 space-y-4">
    @include('livewire.inspecciones.partials.ui-theme')
    <template x-teleport="body">
        <div wire:loading.delay
             wire:target="searchCategoria,searchSubCategoria,searchPregunta,seleccionarCategoria,seleccionarSubCategoria,limpiarFiltrosPregunta,openCategoriaModal,saveCategoria,openSubCategoriaModal,saveSubCategoria,openPreguntaModal,savePregunta,deleteItem"
             class="fixed inset-x-0 top-0 z-[20001] pointer-events-none">
            <div class="insp-loading-bar w-full animate-pulse"></div>
        </div>
        <div wire:loading.delay.shortest
             wire:target="searchCategoria,searchSubCategoria,searchPregunta,seleccionarCategoria,seleccionarSubCategoria,limpiarFiltrosPregunta,openCategoriaModal,saveCategoria,openSubCategoriaModal,saveSubCategoria,openPreguntaModal,savePregunta,deleteItem"
             class="fixed right-4 top-3 z-[20002]">
            <div class="insp-loading-pill">
                <span class="insp-spinner"></span>
                Actualizando...
            </div>
        </div>
    </template>
    <div class="box">
        <div class="justify-between box-header">
            <div>
                <div class="box-title !mb-0">Configuración de preguntas de inspección</div>
            </div>

        </div>
    </div>
    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-12 xl:col-span-6">
            <div class="h-full box">
                <div class="justify-between box-header">
                    <div>
                        <div class="box-title !mb-0">Categorías</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="input-group !w-[220px]"><input type="text" class="form-control"
                                placeholder="Buscar categoría..."
                                wire:model.live.debounce.300ms="searchCategoria" /><button
                                class="ti-btn ti-btn-light !mb-0" type="button"
                                wire:click="$set('searchCategoria', '')"><i class="ri-search-line"></i></button></div>
                        <button type="button" class="text-white ti-btn btn-wave bg-primary"
                            wire:click="openCategoriaModal"><i class="ri-add-line me-1"></i>Nuevo</button>
                    </div>
                </div>
                <div class="box-body max-h-[33rem] overflow-y-auto">
                    <div class="table-responsive">
                        <table class="table min-w-full whitespace-nowrap table-hover">
                            <thead>
                                <tr class="border-b border-defaultborder">
                                    <th class="text-start">Categoria</th>
                                    <th class="text-start">Preguntas</th>
                                    <th class="text-start">Estado</th>
                                    <th class="w-1 text-start"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cuestionarioCategorias as $categoria)
                                    <tr
                                        class="border-b border-defaultborder {{ $selectedCategoriaId === $categoria->id ? 'bg-primary/5' : '' }}">
                                        <td><button type="button" class="text-start"
                                                wire:click="seleccionarCategoria({{ $categoria->id }})"><span
                                                    class="font-semibold">{{ $categoria->descripcion }}</span></button>
                                        </td>
                                        <td>{{ $categoria->preguntas_count }}</td>
                                        <td><span
                                                class="badge {{ (int) $categoria->estado === 1 ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">{{ (int) $categoria->estado === 1 ? 'Activo' : 'Inactivo' }}</span>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2"><button
                                                    class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info-full"
                                                    wire:click="openCategoriaModal({{ $categoria->id }})"><i
                                                        class="ri-edit-line"></i></button><button
                                                    class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger-full"
                                                    @click="confirmDelete('categoria', {{ $categoria->id }}, @js($categoria->descripcion))"><i
                                                        class="ri-delete-bin-line"></i></button></div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-8 text-[#8c9097]">No hay categorias
                                            registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 xl:col-span-6">
            <div class="h-full box">
                <div class="justify-between box-header">
                    <div>
                        <div class="box-title !mb-0">Subcategorías</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="input-group !w-[220px]"><input type="text" class="form-control"
                                placeholder="Buscar subcategoría..."
                                wire:model.live.debounce.300ms="searchSubCategoria" /><button
                                class="ti-btn ti-btn-light !mb-0" type="button"
                                wire:click="$set('searchSubCategoria', '')"><i class="ri-search-line"></i></button>
                        </div><button type="button" class="text-white ti-btn btn-wave bg-success"
                            wire:click="openSubCategoriaModal"><i class="ri-add-line me-1"></i>Nuevo</button>
                    </div>
                </div>
                <div class="box-body max-h-[33rem] overflow-y-auto">
                    <div class="table-responsive">
                        <table class="table min-w-full whitespace-nowrap table-hover">
                            <thead>
                                <tr class="border-b border-defaultborder">
                                    <th class="text-start">Subcategoria</th>
                                    <th class="text-start">Preguntas</th>
                                    <th class="text-start">Estado</th>
                                    <th class="w-1 text-start"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cuestionarioSubCategorias as $subCategoria)
                                    <tr
                                        class="border-b border-defaultborder {{ $selectedSubCategoriaId === $subCategoria->id ? 'bg-success/5' : '' }}">
                                        <td><button type="button" class="text-start"
                                                wire:click="seleccionarSubCategoria({{ $subCategoria->id }})"><span
                                                    class="font-semibold">{{ $subCategoria->descripcion }}</span></button>
                                        </td>
                                        <td>{{ $subCategoria->preguntas_count }}</td>
                                        <td><span
                                                class="badge {{ (int) $subCategoria->estado === 1 ? 'bg-success/10 text-success' : 'bg-danger/10 text-danger' }}">{{ (int) $subCategoria->estado === 1 ? 'Activo' : 'Inactivo' }}</span>
                                        </td>
                                        <td>
                                            <div class="flex items-center gap-2"><button
                                                    class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info-full"
                                                    wire:click="openSubCategoriaModal({{ $subCategoria->id }})"><i
                                                        class="ri-edit-line"></i></button><button
                                                    class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger-full"
                                                    @click="confirmDelete('subcategoria', {{ $subCategoria->id }}, @js($subCategoria->descripcion))"><i
                                                        class="ri-delete-bin-line"></i></button></div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-8 text-[#8c9097]">No hay subcategorías
                                            registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12">
            <div class="box">
                <div class="justify-between box-header">
                    <div>
                        <div class="box-title !mb-0">Preguntas de inspección</div>
                    </div>
                    <div class="flex flex-wrap items-center justify-end gap-2">
                        @if ($selectedCategoriaId || $selectedSubCategoriaId)
                            <button type="button" class="ti-btn ti-btn-light"
                                wire:click="limpiarFiltrosPregunta">Limpiar filtros</button>
                        @endif
                        <div class="input-group !w-[280px]"><input type="text" class="form-control"
                                placeholder="Buscar pregunta o ids..."
                                wire:model.live.debounce.300ms="searchPregunta" /><button
                                class="ti-btn ti-btn-light !mb-0" type="button"
                                wire:click="$set('searchPregunta', '')"><i class="ri-search-line"></i></button></div>
                        <button type="button" class="text-white ti-btn btn-wave bg-secondary"
                            wire:click="openPreguntaModal"><i class="ri-add-line me-1"></i>Nuevo</button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table min-w-full whitespace-nowrap ti-striped-table table-hover">
                            <thead>
                                <tr class="border-b border-defaultborder">
                                    <th class="text-start">Categoria</th>
                                    <th class="text-start">Subcategoria</th>
                                    <th class="text-start">Enunciado</th>
                                    <th class="text-start">Vinculada</th>
                                    <th class="text-start">Ingreso / Salida</th>
                                    
                                    <th class="w-1 text-start"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($preguntas as $pregunta)
                                    <tr class="border-b border-defaultborder">
                                        <td>{{ $pregunta->categoria?->descripcion ?: '—' }}</td>
                                        <td>{{ $pregunta->subCategoria?->descripcion ?: '—' }}</td>
                                        <td class="min-w-[280px]">
                                            <div class="font-semibold">{{ $pregunta->pregunta_enunciado }}</div>
                                            <div class="text-[0.72rem] text-[#8c9097]">Observaciones:
                                                {{ (int) $pregunta->permitir_observaciones === 1 ? 'Permitidas' : 'No permitidas' }}
                                            </div>
                                        </td>
                                        <td>
                                            @php($vinculada = filled($pregunta->equipo_tipo_ids) || filled($pregunta->equipo_categoria_ids) || filled($pregunta->equipo_marca_ids) || filled($pregunta->equipo_modelo_ids))
                                            <span class="insp-chip {{ $vinculada ? 'insp-chip--info' : 'insp-chip--success' }}">
                                                {{ $vinculada ? 'Sí' : 'Libre' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-[0.75rem]">IN:
                                                {{ (int) $pregunta->ingeso_preguntar === 1 ? $responseTypeOptions[$pregunta->ingreso_respuesta_tipo] ?? 'Si' : 'No' }}
                                            </div>
                                            <div class="text-[0.75rem]">OUT:
                                                {{ (int) $pregunta->salida_preguntar === 1 ? $responseTypeOptions[$pregunta->salida_respuesta_tipo] ?? 'Si' : 'No' }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="flex items-center gap-2"><button
                                                    class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info-full"
                                                    wire:click="openPreguntaModal({{ $pregunta->id }})"><i
                                                        class="ri-edit-line"></i></button><button
                                                    class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger-full"
                                                    @click="confirmDelete('pregunta', {{ $pregunta->id }}, @js($pregunta->pregunta_enunciado))"><i
                                                        class="ri-delete-bin-line"></i></button></div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-8 text-[#8c9097]">No hay preguntas
                                            registradas para los filtros actuales.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $preguntas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template x-teleport="body">
    <div x-data="{ modal: @entangle('categoriaModal').live }" x-show="modal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="modal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full max-w-sm rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                <div class="flex items-center justify-between px-6 py-4 border-b border-defaultborder">
                    <h3 class="text-[15px] font-semibold">
                        {{ $editingCategoriaId ? 'Editar categoria' : 'Nueva categoria' }}</h3><button type="button"
                        class="text-slate-500" @click="modal = false"><i class="ri-close-line"></i></button>
                </div>
                <div class="px-6 py-5 space-y-4">
                    <div><label class="form-label">Descripcion</label><input type="text" class="form-control"
                            wire:model.defer="categoriaForm.descripcion" placeholder="Ej: Sistema electrico" />
                        @error('categoriaForm.descripcion')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div><label class="form-label">Estado</label><select class="form-control"
                            wire:model.defer="categoriaForm.estado">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select></div>
                </div>
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-defaultborder"><button type="button"
                        class="ti-btn ti-btn-light" @click="modal = false">Cancelar</button><button type="button"
                        class="text-white ti-btn bg-primary" wire:click="saveCategoria">Guardar</button></div>
            </div>
        </div>
    </div>
    </template>

    <template x-teleport="body">
    <div x-data="{ modal: @entangle('subCategoriaModal').live }" x-show="modal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="modal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full max-w-sm rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                <div class="flex items-center justify-between px-6 py-4 border-b border-defaultborder">
                    <h3 class="text-[15px] font-semibold">
                        {{ $editingSubCategoriaId ? 'Editar subcategoria' : 'Nueva subcategoria' }}</h3><button
                        type="button" class="text-slate-500" @click="modal = false"><i
                            class="ri-close-line"></i></button>
                </div>
                <div class="px-6 py-5 space-y-4">
                    <div><label class="form-label">Descripcion</label><input type="text" class="form-control"
                            wire:model.defer="subCategoriaForm.descripcion" placeholder="Ej: Iluminacion frontal" />
                        @error('subCategoriaForm.descripcion')
                            <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div><label class="form-label">Estado</label><select class="form-control"
                            wire:model.defer="subCategoriaForm.estado">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select></div>
                </div>
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-defaultborder"><button type="button"
                        class="ti-btn ti-btn-light" @click="modal = false">Cancelar</button><button type="button"
                        class="text-white ti-btn bg-success" wire:click="saveSubCategoria">Guardar</button></div>
            </div>
        </div>
    </div>
    </template>
    <template x-teleport="body">
    <div x-data="{ modal: @entangle('preguntaModal').live }" x-show="modal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="modal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full max-w-4xl rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                <div class="flex items-center justify-between px-6 py-4 border-b border-defaultborder">
                    <div>
                        <h3 class="text-[15px] font-semibold">
                            {{ $editingPreguntaId ? 'Editar pregunta' : 'Nueva pregunta' }}</h3>
                        <p class="text-[0.75rem] text-[#8c9097] mb-0">Los filtros se guardan en columnas tipo .1.2.
                            segun catalogo.</p>
                    </div><button type="button" class="text-slate-500" @click="modal = false"><i
                            class="ri-close-line"></i></button>
                </div>
                <div class="px-6 py-5 max-h-[78vh] overflow-y-auto space-y-5">
                    <div class="grid items-start grid-cols-12 gap-5">
                        <div class="col-span-12 space-y-4 lg:col-span-4">
                            <div class="flex items-end gap-x-2">
                                <div>
                                    <label class="form-label">Categoria</label>
                                </div>
                                <div class="flex-grow">
                                    <select class="form-control !py-0"
                                        wire:model.defer="preguntaForm.cuestionario_categoria_id">
                                        <option value="">Seleccione...</option>
                                        @foreach ($cuestionarioCategorias as $categoria)
                                            <option value="{{ $categoria->id }}">{{ $categoria->descripcion }}</option>
                                        @endforeach
                                    </select>
                                    @error('preguntaForm.cuestionario_categoria_id')
                                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex items-end gap-x-2">
                                <div>
                                    <label class="form-label">Subcategoria</label>
                                </div>
                                <div class="flex-grow">
                                    <select class="form-control !py-0"
                                        wire:model.defer="preguntaForm.cuestionario_sub_categoria_id">
                                        <option value="">Seleccione...</option>
                                        @foreach ($cuestionarioSubCategorias as $subCategoria)
                                            <option value="{{ $subCategoria->id }}">{{ $subCategoria->descripcion }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('preguntaForm.cuestionario_sub_categoria_id')
                                        <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex items-end gap-x-2">
                                <div>
                                    <label class="form-label">Permitir observaciones</label>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex flex-wrap items-center gap-4 pt-1 min-h-[38px]">
                                        <label class="inline-flex items-center gap-2 text-sm">
                                            <input type="radio" value="1"
                                                wire:model.defer="preguntaForm.permitir_observaciones">
                                            <span>Si</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-sm">
                                            <input type="radio" value="0"
                                                wire:model.defer="preguntaForm.permitir_observaciones">
                                            <span>No</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-end gap-x-2">
                                <div>
                                    <label class="form-label">Estado</label>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex flex-wrap items-center gap-4 pt-1 min-h-[38px]">
                                        <label class="inline-flex items-center gap-2 text-sm">
                                            <input type="radio" value="1" wire:model.defer="preguntaForm.estado">
                                            <span>Activo</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-sm">
                                            <input type="radio" value="0" wire:model.defer="preguntaForm.estado">
                                            <span>Inactivo</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 lg:col-span-8">
                            <div class="flex"></div>
                            <label class="form-label">Enunciado</label>
                            <textarea class="form-control min-h-[145px]" wire:model.defer="preguntaForm.pregunta_enunciado"
                                placeholder="Describe la pregunta que se realizara durante la inspeccion"></textarea>
                            @error('preguntaForm.pregunta_enunciado')
                                <p class="mt-1 text-xs text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-12 col-span-12 gap-4 lg:col-span-4">
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-6 xl:col-span-3">
                            <div
                                class="rounded-xl border border-defaultborder bg-white dark:bg-[#0f172a] overflow-hidden">
                                <div class="flex items-center gap-2 px-4 py-3 border-b border-defaultborder">
                                    <span class="block h-4 w-[3px] rounded-full bg-primary"></span>
                                    <div class="font-semibold text-[0.92rem]">Tipos</div>
                                </div>
                                <div class="px-4 py-3 space-y-2"
                                    style="height: 7rem; overflow-y: scroll; scrollbar-gutter: stable;">
                                    @foreach ($catalogoTipos as $tipo)
                                        <label class="flex items-center gap-2 text-sm">
                                            <input type="checkbox" value="{{ $tipo->id }}"
                                                wire:model="preguntaTipoIds">
                                            <span>{{ $tipo->tipo }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-6 xl:col-span-3">
                            <div
                                class="rounded-xl border border-defaultborder bg-white dark:bg-[#0f172a] overflow-hidden">
                                <div class="flex items-center gap-2 px-4 py-3 border-b border-defaultborder">
                                    <span class="block h-4 w-[3px] rounded-full bg-info"></span>
                                    <div class="font-semibold text-[0.92rem]">Categorias eq.</div>
                                </div>
                                <div class="px-4 py-3 space-y-2"
                                    style="height: 7rem; overflow-y: scroll; scrollbar-gutter: stable;">
                                    @foreach ($catalogoCategorias as $catalogoCategoria)
                                        <label class="flex items-center gap-2 text-sm">
                                            <input type="checkbox" value="{{ $catalogoCategoria->id }}"
                                                wire:model="preguntaCategoriaIds">
                                            <span>{{ $catalogoCategoria->categoria }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-6 xl:col-span-3">
                            <div
                                class="rounded-xl border border-defaultborder bg-white dark:bg-[#0f172a] overflow-hidden">
                                <div class="flex items-center gap-2 px-4 py-3 border-b border-defaultborder">
                                    <span class="block h-4 w-[3px] rounded-full bg-success"></span>
                                    <div class="font-semibold text-[0.92rem]">Marcas</div>
                                </div>
                                <div class="px-4 py-3 space-y-2"
                                    style="height: 7rem; overflow-y: scroll; scrollbar-gutter: stable;">
                                    @foreach ($catalogoMarcas as $marca)
                                        <label class="flex items-center gap-2 text-sm">
                                            <input type="checkbox" value="{{ $marca->id }}"
                                                wire:model="preguntaMarcaIds">
                                            <span>{{ $marca->marca }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 md:col-span-6 xl:col-span-3">
                            <div
                                class="rounded-xl border border-defaultborder bg-white dark:bg-[#0f172a] overflow-hidden">
                                <div class="flex items-center gap-2 px-4 py-3 border-b border-defaultborder">
                                    <span class="block h-4 w-[3px] rounded-full bg-warning"></span>
                                    <div class="font-semibold text-[0.92rem]">Modelos</div>
                                </div>
                                <div class="px-4 py-3 space-y-2"
                                    style="height: 7rem; overflow-y: scroll; scrollbar-gutter: stable;">
                                    @foreach ($catalogoModelos as $modelo)
                                        <label class="flex items-center gap-2 text-sm">
                                            <input type="checkbox" value="{{ $modelo->id }}"
                                                wire:model="preguntaModeloIds">
                                            <span>{{ $modelo->modelo }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 xl:col-span-6">
                            <div
                                class="rounded-xl border border-defaultborder bg-white dark:bg-[#0f172a] overflow-hidden">
                                <div class="flex items-center gap-2 px-4 py-3 border-b border-defaultborder">
                                    <span class="block h-4 w-[3px] rounded-full bg-primary"></span>
                                    <div class="font-semibold text-[0.92rem]">Ingreso</div>
                                </div>
                                <div class="px-4 py-4">
                                    <div class="grid items-end grid-cols-12 gap-4">
                                        <div class="col-span-12 md:col-span-4">
                                            <label class="form-label">Preguntar</label>
                                            <div class="flex flex-wrap items-center gap-4 pt-1 min-h-[38px]">
                                                <label class="inline-flex items-center gap-2 text-sm">
                                                    <input type="radio" value="1"
                                                        wire:model.live="preguntaForm.ingeso_preguntar">
                                                    <span>Si</span>
                                                </label>
                                                <label class="inline-flex items-center gap-2 text-sm">
                                                    <input type="radio" value="0"
                                                        wire:model.live="preguntaForm.ingeso_preguntar">
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>
                                        @if (($preguntaForm['ingeso_preguntar'] ?? 1) == 1)
                                            <div class="col-span-12 md:col-span-4">
                                                <label class="form-label">Tipo de respuesta</label>
                                                <select class="form-control"
                                                    wire:model.live="preguntaForm.ingreso_respuesta_tipo">
                                                    <option value="">No aplica</option>
                                                    @foreach ($responseTypeOptions as $value => $label)
                                                        <option value="{{ $value }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if (in_array($preguntaForm['ingreso_respuesta_tipo'] ?? '', ['select', 'radio'], true))
                                                <div class="col-span-12 md:col-span-4">
                                                    <label class="form-label">Valores permitidos</label>
                                                    <input type="text" class="form-control"
                                                        wire:model.defer="preguntaForm.ingreso_respuesta_valores"
                                                        placeholder="1=>si,2=>aceptar,3=>rechazar" />
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-span-12 xl:col-span-6">
                            <div
                                class="rounded-xl border border-defaultborder bg-white dark:bg-[#0f172a] overflow-hidden">
                                <div class="flex items-center gap-2 px-4 py-3 border-b border-defaultborder">
                                    <span class="block h-4 w-[3px] rounded-full bg-info"></span>
                                    <div class="font-semibold text-[0.92rem]">Salida</div>
                                </div>
                                <div class="px-4 py-4">
                                    <div class="grid items-end grid-cols-12 gap-4">
                                        <div class="col-span-12 md:col-span-4">
                                            <label class="form-label">Preguntar</label>
                                            <div class="flex flex-wrap items-center gap-4 pt-1 min-h-[38px]">
                                                <label class="inline-flex items-center gap-2 text-sm">
                                                    <input type="radio" value="1"
                                                        wire:model.live="preguntaForm.salida_preguntar">
                                                    <span>Si</span>
                                                </label>
                                                <label class="inline-flex items-center gap-2 text-sm">
                                                    <input type="radio" value="0"
                                                        wire:model.live="preguntaForm.salida_preguntar">
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>
                                        @if (($preguntaForm['salida_preguntar'] ?? 1) == 1)
                                            <div class="col-span-12 md:col-span-4">
                                                <label class="form-label">Tipo de respuesta</label>
                                                <select class="form-control"
                                                    wire:model.live="preguntaForm.salida_respuesta_tipo">
                                                    <option value="">No aplica</option>
                                                    @foreach ($responseTypeOptions as $value => $label)
                                                        <option value="{{ $value }}">{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if (in_array($preguntaForm['salida_respuesta_tipo'] ?? '', ['select', 'radio'], true))
                                                <div class="col-span-12 md:col-span-4">
                                                    <label class="form-label">Valores permitidos</label>
                                                    <input type="text" class="form-control"
                                                        wire:model.defer="preguntaForm.salida_respuesta_valores"
                                                        placeholder="1=>ok,2=>observado" />
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-defaultborder"><button type="button"
                        class="ti-btn ti-btn-light" @click="modal = false">Cancelar</button><button type="button"
                        class="text-white ti-btn bg-secondary" wire:click="savePregunta">Guardar pregunta</button>
                </div>
            </div>
        </div>
    </div>
    </template>
</div>



