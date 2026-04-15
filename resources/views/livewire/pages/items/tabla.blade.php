{{-- resources/views/livewire/items/tabla.blade.php --}}
<div
    class="box-body"
    x-data="{
        openModal(id){
            Livewire.dispatch('items-modal:open', { id: id, title: 'Editar ítem' });
        }
    }"
>
    @php
        // ✅ Datos de ejemplo (solo diseño)
        $demoItems = [
            (object)[
                'id' => 1,
                'nombre' => 'Certificado de operatividad de la pluma',
                'codigo' => 'Ingreso/Salida',
                'categoria_nombre' => 'Documentación',
                'subcategoria_nombre' => 'Documentos entregados por el proveedor',
                'estado' => 1,
            ],
            (object)[
                'id' => 2,
                'nombre' => 'Tabla de cargas de pluma',
                'codigo' => 'Ingreso/Salida',
                'categoria_nombre' => 'Documentación',
                'subcategoria_nombre' => 'Documentos entregados por el proveedor',
                'estado' => 1,
            ],
            (object)[
                'id' => 3,
                'nombre' => 'Luces de trabajo operativas',
                'codigo' => 'Ingreso/Salida',
                'categoria_nombre' => 'Inspección',
                'subcategoria_nombre' => 'Chasis / Suspensión',
                'estado' => 1,
            ],
            (object)[
                'id' => 4,
                'nombre' => 'Verificar estado de para choque posterior',
                'codigo' => 'Ingreso/Salida',
                'categoria_nombre' => 'Inspección',
                'subcategoria_nombre' => 'Chasis / Suspensión',
                'estado' => 0,
            ],
            (object)[
                'id' => 5,
                'nombre' => 'Verificar estado de guardafangos posteriores',
                'codigo' => 'Ingreso/Salida',
                'categoria_nombre' => 'Inspección',
                'subcategoria_nombre' => 'Chasis / Suspensión',
                'estado' => 1,
            ],
            (object)[
                'id' => 6,
                'nombre' => 'Chasis sin fisuras visibles',
                'codigo' => 'Ingreso/Salida',
                'categoria_nombre' => 'Inspección',
                'subcategoria_nombre' => 'Chasis / Suspensión',
                'estado' => 1,
            ],
        ];

        // Si Livewire aún no pasa $items, usamos demo.
        $itemsRender = $items ?? $demoItems;
    @endphp

    <div class="overflow-hidden rounded-2xl border border-defaultborder bg-white shadow-sm ring-1 ring-black/5
                dark:bg-[#0b1220] dark:border-white/10 dark:ring-white/10">
        <div class="table-responsive overflow-x-auto">
            <table class="table whitespace-nowrap ti-striped-table table-hover min-w-full ti-custom-table-hover">
                <thead class="bg-slate-50 text-slate-600 dark:bg-white/5 dark:text-slate-300">
                    <tr class="border-b border-defaultborder dark:border-white/10">
                        <th scope="col" class="text-start w-1 px-4 py-3 font-semibold">#</th>
                        <th scope="col" class="text-start px-4 py-3 font-semibold">Ítem</th>
                        <th scope="col" class="text-start px-4 py-3 font-semibold">Categoría / Subcategoría</th>
                        <th scope="col" class="text-start px-4 py-3 font-semibold">Estado</th>
                        <th scope="col" class="text-end w-1 px-4 py-3 font-semibold">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-white/10">
                    @forelse($itemsRender as $it)
                        @php $ok = (int)($it->estado ?? 1) === 1; @endphp
                        <tr class="border-b border-defaultborder dark:border-white/10 hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors">
                            <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $loop->iteration }}</td>

                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-900 dark:text-slate-100">
                                    {{ $it->nombre ?? '—' }}
                                </div>
                                @if(!empty($it->codigo))
                                    <div class="text-xs text-slate-500 dark:text-slate-400">{{ $it->codigo }}</div>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    {{-- ✅ Categoría: con color según nombre --}}
                                    <span
                                        class="inline-flex items-center rounded-md px-2 py-1 text-xs font-semibold ring-1"
                                        :class="catClass(@js($it->categoria_nombre ?? ''))"
                                    >
                                        <iconify-icon icon="mdi:tag-outline" class="text-[14px] me-1"></iconify-icon>
                                        {{ $it->categoria_nombre ?? '—' }}
                                    </span>

                                    {{-- ✅ Subcategoría: color distinto (constante) --}}
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-semibold ring-1
                                                 bg-indigo-50 text-indigo-800 ring-indigo-200
                                                 dark:bg-indigo-500/10 dark:text-indigo-200 dark:ring-indigo-500/20">
                                        <iconify-icon icon="mdi:tag-multiple-outline" class="text-[14px] me-1"></iconify-icon>
                                        {{ $it->subcategoria_nombre ?? '—' }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-semibold ring-1
                                             {{ $ok
                                                ? 'bg-emerald-50 text-emerald-700 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-200 dark:ring-emerald-500/20'
                                                : 'bg-rose-50 text-rose-700 ring-rose-200 dark:bg-rose-500/10 dark:text-rose-200 dark:ring-rose-500/20'
                                             }}">
                                    <iconify-icon icon="{{ $ok ? 'mdi:check-circle-outline' : 'mdi:close-circle-outline' }}" class="text-[16px]"></iconify-icon>
                                    {{ $ok ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        type="button"
                                        @click="openModal({{ $it->id }})"
                                        class="ti-btn btn-wave ti-btn-sm !m-0 rounded-lg h-9 w-9 p-0 inline-flex items-center justify-center
                                               bg-sky-600 text-white ring-1 ring-sky-700/20 shadow-sm
                                               hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-500/20"
                                        title="Editar"
                                        aria-label="Editar"
                                    >
                                        <iconify-icon icon="mdi:pencil-outline" class="text-[18px]"></iconify-icon>
                                    </button>

                                    <button
                                        type="button"
                                        class="ti-btn btn-wave ti-btn-sm !m-0 rounded-lg h-9 w-9 p-0 inline-flex items-center justify-center
                                               bg-rose-50 text-rose-700 ring-1 ring-rose-200 shadow-sm
                                               hover:bg-rose-100 focus:outline-none focus:ring-4 focus:ring-rose-500/20
                                               dark:bg-rose-500/10 dark:text-rose-200 dark:ring-rose-500/20 dark:hover:bg-rose-500/20"
                                        title="Eliminar"
                                        aria-label="Eliminar"
                                    >
                                        <iconify-icon icon="mdi:trash-can-outline" class="text-[18px]"></iconify-icon>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-slate-500 dark:text-slate-400">
                                No se encontraron ítems.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación (solo diseño) --}}
        <div class="border-t border-slate-100 px-4 py-3 dark:border-white/10">
            <div class="flex items-center justify-between gap-3 text-sm text-slate-600 dark:text-slate-300">
                <div>Mostrando <span class="font-semibold">1</span> a <span class="font-semibold">6</span> de <span class="font-semibold">48</span></div>
                <div class="flex items-center gap-2">
                    <button class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-semibold hover:bg-slate-50
                                   dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">Anterior</button>
                    <button class="rounded-lg bg-slate-900 px-3 py-1.5 text-sm font-semibold text-white
                                   dark:bg-white dark:text-slate-900">1</button>
                    <button class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-semibold hover:bg-slate-50
                                   dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">2</button>
                    <button class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-semibold hover:bg-slate-50
                                   dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">3</button>
                    <button class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-semibold hover:bg-slate-50
                                   dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">Siguiente</button>
                </div>
            </div>
        </div>
    </div>
</div>