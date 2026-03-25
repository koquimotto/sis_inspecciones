{{-- resources/views/livewire/equipos/modal.blade.php --}}
<div
  x-data="{
    modal: @entangle('modal').live,
  }"
  x-on:keydown.escape.window="if(modal) modal = false"
>
  <div
    x-show="modal"
    x-cloak
    class="fixed inset-0 z-[9999]"
    role="dialog"
    aria-modal="true"
  >
    {{-- Backdrop --}}
    <div
      class="absolute inset-0 bg-slate-950/60 backdrop-blur-[2px]"
      x-transition.opacity
      @click="modal = false"
    ></div>

    {{-- Wrapper --}}
    <div class="relative min-h-full flex items-start justify-center p-4 pt-8 pb-10">
      <div
        @click.stop
        x-transition
        class="w-full max-w-6xl overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/10
               dark:bg-[#0b1220] dark:ring-white/10"
        style="max-height: calc(100vh - 4rem);"
      >
        {{-- Header (sticky) --}}
        <div class="sticky top-0 z-10 border-b border-slate-200/70 bg-white/85 backdrop-blur
                    dark:border-white/10 dark:bg-[#0b1220]/75">
          <div class="px-6 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
              <div class="h-11 w-11 rounded-2xl bg-indigo-600/10 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300
                          ring-1 ring-indigo-600/10 dark:ring-indigo-400/10 flex items-center justify-center">
                <iconify-icon icon="mdi:tools" class="text-[24px]"></iconify-icon>
              </div>

              <div class="min-w-0">
                <h2 class="text-[15px] font-semibold text-slate-900 dark:text-slate-100 truncate">
                  {{ $editingId ? 'Editar Equipo' : 'Registrar Equipo' }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                  Gestión de equipos/maquinaria • Campos obligatorios marcados con (*)
                </p>
              </div>
            </div>

            <div class="flex items-center gap-2">
              <div class="hidden sm:flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2 py-1
                          dark:border-white/10 dark:bg-white/5">
                <iconify-icon icon="mdi:shield-check-outline" class="text-[16px] text-slate-500 dark:text-slate-300"></iconify-icon>
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-200">
                  {{ $editingId ? 'Edición' : 'Nuevo registro' }}
                </span>
              </div>

              <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-2xl
                       text-slate-500 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/5"
                @click="modal = false"
                aria-label="Cerrar"
              >
                <iconify-icon icon="mdi:close-circle-outline" class="text-[22px]"></iconify-icon>
              </button>
            </div>
          </div>
        </div>

        {{-- Body (scroll real) --}}
        <div class="px-6 py-5 overflow-y-auto" style="max-height: calc(100vh - 11rem);">
          <div class="grid grid-cols-12 gap-4">
            {{-- Izquierda: Form --}}
            <div class="col-span-12 lg:col-span-7">
              <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10">
                <div class="px-5 py-4 border-b border-slate-200/70 dark:border-white/10">
                  <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                    <iconify-icon icon="mdi:file-document-outline" class="text-[18px] text-indigo-600 dark:text-indigo-300"></iconify-icon>
                    Información del equipo
                  </h3>
                  <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Define tipo, categoría y datos de identificación.
                  </p>
                </div>

                <div class="p-5">
                  <div class="grid grid-cols-12 gap-4">
                    {{-- Tipo --}}
                    <div class="col-span-12 md:col-span-6">
                      <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        Tipo <span class="text-rose-500">*</span>
                      </label>
                      <select
                        class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        wire:model.defer="state.tipo_id"
                      >
                        <option value="">Seleccione...</option>
                        @foreach(($tipoOptions ?? []) as $opt)
                          <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                        @endforeach
                      </select>
                      @error('state.tipo_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Categoría --}}
                    <div class="col-span-12 md:col-span-6">
                      <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        Categoría <span class="text-rose-500">*</span>
                      </label>
                      <select
                        class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        wire:model.defer="state.categoria_id"
                      >
                        <option value="">Seleccione...</option>
                        @foreach(($categoriaOptions ?? []) as $opt)
                          <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                        @endforeach
                      </select>
                      @error('state.categoria_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Marca --}}
                    <div class="col-span-12 md:col-span-6">
                      <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        Marca
                      </label>
                      <select
                        class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        wire:model.defer="state.marca_id"
                      >
                        <option value="">Seleccione...</option>
                        @foreach(($marcaOptions ?? []) as $opt)
                          <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                        @endforeach
                      </select>
                      @error('state.marca_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Modelo --}}
                    <div class="col-span-12 md:col-span-6">
                      <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        Modelo
                      </label>
                      <select
                        class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        wire:model.defer="state.modelo_id"
                      >
                        <option value="">Seleccione...</option>
                        @foreach(($modeloOptions ?? []) as $opt)
                          <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                        @endforeach
                      </select>
                      @error('state.modelo_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Serie --}}
                    <div class="col-span-12 md:col-span-6">
                      <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        Serie
                      </label>
                      <input
                        type="text"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        placeholder="Ej: SN-EX-98765"
                        wire:model.defer="state.serie"
                      />
                      @error('state.serie') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Placa --}}
                    <div class="col-span-12 md:col-span-6">
                      <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        Placa
                      </label>
                      <select
                        class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        wire:model.defer="state.placa_id"
                      >
                        <option value="">Seleccione...</option>
                        @foreach(($placaOptions ?? []) as $opt)
                          <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                        @endforeach
                      </select>
                      @error('state.placa_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Año --}}
                    <div class="col-span-12 md:col-span-6">
                      <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        Año
                      </label>
                      <input
                        type="number"
                        min="1900"
                        max="{{ now()->addYear()->year }}"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        placeholder="Ej: 2024"
                        wire:model.defer="state.anio"
                      />
                      @error('state.anio') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-span-12 md:col-span-6">
                      <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                        Estado <span class="text-rose-500">*</span>
                      </label>

                      <div class="flex flex-wrap gap-2">
                        <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm
                                       hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                          <input type="radio" class="rounded text-indigo-600" value="1" wire:model.defer="state.estado">
                          <span class="text-slate-700 dark:text-slate-200 font-semibold">Vigente</span>
                        </label>

                        <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm
                                       hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                          <input type="radio" class="rounded text-indigo-600" value="2" wire:model.defer="state.estado">
                          <span class="text-slate-700 dark:text-slate-200 font-semibold">En inspección</span>
                        </label>

                        <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm
                                       hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                          <input type="radio" class="rounded text-indigo-600" value="0" wire:model.defer="state.estado">
                          <span class="text-slate-700 dark:text-slate-200 font-semibold">Inactivo</span>
                        </label>
                      </div>

                      @error('state.estado') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Observaciones --}}
                    <div class="col-span-12">
                      <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                        Observaciones
                      </label>
                      <textarea
                        rows="3"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        placeholder="Notas internas del equipo..."
                        wire:model.defer="state.observaciones"
                      ></textarea>
                      @error('state.observaciones') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- Derecha: Vínculos + Recomendaciones + Resumen --}}
            <div class="col-span-12 lg:col-span-5">
              <div class="space-y-4">

                {{-- VÍNCULOS --}}
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10 overflow-hidden">
                  <div class="px-5 py-4 border-b border-slate-200/70 dark:border-white/10">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                      <iconify-icon icon="mdi:link-variant" class="text-[18px] text-indigo-600 dark:text-indigo-300"></iconify-icon>
                      Vínculos
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                      Asigna empresas/unidades mineras y servicios aplicables.
                    </p>
                  </div>

                  <div class="p-5 space-y-4">
                    {{-- Empresas --}}
                    <div
                      class="rounded-2xl border border-slate-200 bg-slate-50 dark:bg-white/5 dark:border-white/10 overflow-hidden"
                      x-data="{
                        qE: '',
                        get empresas(){
                          const all = @js($empresaOptions ?? []);
                          const q = this.qE.toLowerCase().trim();
                          if(!q) return all;
                          return all.filter(o => (o.label ?? '').toLowerCase().includes(q));
                        }
                      }"
                    >
                      <div class="px-4 py-3 border-b border-slate-200/70 dark:border-white/10 flex items-center justify-between gap-3">
                        <div class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                          <iconify-icon icon="mdi:office-building-outline" class="text-[18px] text-slate-500 dark:text-slate-300"></iconify-icon>
                          Empresas
                        </div>

                        <div class="w-44">
                          <div class="relative">
                            <iconify-icon icon="mdi:magnify" class="absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400"></iconify-icon>
                            <input
                              type="text"
                              x-model="qE"
                              class="w-full rounded-2xl border border-slate-200 bg-white pl-10 pr-3 py-2 text-sm text-slate-800 shadow-sm
                                     focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                                     dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                              placeholder="Buscar..."
                            />
                          </div>
                        </div>
                      </div>

                      <div class="p-4">
                        <div class="max-h-44 overflow-y-auto pr-1 space-y-2">
                          <template x-for="opt in empresas" :key="opt.id">
                            <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2
                                           hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                              <input
                                type="checkbox"
                                class="rounded text-indigo-600"
                                :value="opt.id"
                                wire:model.defer="selectedEmpresas"
                              >
                              <div class="min-w-0">
                                <div class="text-sm font-semibold text-slate-800 dark:text-slate-100 truncate" x-text="opt.label"></div>
                              </div>
                            </label>
                          </template>

                          <div x-show="empresas.length===0" class="text-sm text-slate-500 dark:text-slate-400">
                            Sin resultados.
                          </div>
                        </div>

                        @error('selectedEmpresas') <p class="mt-2 text-xs text-rose-500">{{ $message }}</p> @enderror
                      </div>
                    </div>

                    {{-- Servicios --}}
                    <div
                      class="rounded-2xl border border-slate-200 bg-slate-50 dark:bg-white/5 dark:border-white/10 overflow-hidden"
                      x-data="{
                        qS: '',
                        get servicios(){
                          const all = @js($servicioOptions ?? []);
                          const q = this.qS.toLowerCase().trim();
                          if(!q) return all;
                          return all.filter(o => (o.label ?? '').toLowerCase().includes(q));
                        }
                      }"
                    >
                      <div class="px-4 py-3 border-b border-slate-200/70 dark:border-white/10 flex items-center justify-between gap-3">
                        <div class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                          <iconify-icon icon="mdi:cog-outline" class="text-[18px] text-slate-500 dark:text-slate-300"></iconify-icon>
                          Servicios
                        </div>

                        <div class="w-44">
                          <div class="relative">
                            <iconify-icon icon="mdi:magnify" class="absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400"></iconify-icon>
                            <input
                              type="text"
                              x-model="qS"
                              class="w-full rounded-2xl border border-slate-200 bg-white pl-10 pr-3 py-2 text-sm text-slate-800 shadow-sm
                                     focus:outline-none focus:ring-2 focus:ring-emerald-500/30 focus:border-emerald-500
                                     dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                              placeholder="Buscar..."
                            />
                          </div>
                        </div>
                      </div>

                      <div class="p-4">
                        <div class="max-h-44 overflow-y-auto pr-1 space-y-2">
                          <template x-for="opt in servicios" :key="opt.id">
                            <label class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2
                                           hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                              <input
                                type="checkbox"
                                class="rounded text-emerald-600"
                                :value="opt.id"
                                wire:model.defer="selectedServicios"
                              >
                              <div class="min-w-0">
                                <div class="text-sm font-semibold text-slate-800 dark:text-slate-100 truncate" x-text="opt.label"></div>
                              </div>
                            </label>
                          </template>

                          <div x-show="servicios.length===0" class="text-sm text-slate-500 dark:text-slate-400">
                            Sin resultados.
                          </div>
                        </div>

                        @error('selectedServicios') <p class="mt-2 text-xs text-rose-500">{{ $message }}</p> @enderror
                      </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-xs text-slate-600
                                dark:border-white/10 dark:bg-white/5 dark:text-slate-300">
                      <span class="font-semibold">Nota:</span> estos vínculos se guardarán en <b>equipo_empresa</b> y <b>equipo_servicio</b>.
                    </div>
                  </div>
                </div>

                {{-- Recomendaciones --}}
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10">
                  <div class="px-5 py-4 border-b border-slate-200/70 dark:border-white/10">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                      <iconify-icon icon="mdi:lightbulb-on-outline" class="text-[18px] text-amber-500"></iconify-icon>
                      Recomendaciones
                    </h3>
                  </div>
                  <div class="p-5 text-sm text-slate-600 dark:text-slate-300 space-y-3">
                    <div class="flex gap-2">
                      <iconify-icon icon="mdi:information-outline" class="text-[18px] mt-0.5 text-slate-400"></iconify-icon>
                      <p>Usa <b>Tipo</b> y <b>Categoría</b> para estandarizar inspecciones y reportes.</p>
                    </div>
                    <div class="flex gap-2">
                      <iconify-icon icon="mdi:tag-outline" class="text-[18px] mt-0.5 text-slate-400"></iconify-icon>
                      <p>Serie/Placa ayudan a evitar registros duplicados.</p>
                    </div>
                    <div class="flex gap-2">
                      <iconify-icon icon="mdi:shield-outline" class="text-[18px] mt-0.5 text-slate-400"></iconify-icon>
                      <p>“En inspección” es un estado operativo temporal.</p>
                    </div>
                  </div>
                </div>

                {{-- Resumen --}}
                <div class="rounded-2xl border border-slate-200 bg-gradient-to-br from-indigo-600/5 to-slate-50 shadow-sm
                            dark:from-indigo-500/10 dark:to-white/5 dark:border-white/10">
                  <div class="p-5">
                    <div class="flex items-center justify-between">
                      <div>
                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400">Resumen</div>
                        <div class="text-sm font-semibold text-slate-800 dark:text-slate-100 mt-1">
                          {{ $editingId ? 'Actualizando equipo' : 'Nuevo equipo' }}
                        </div>
                      </div>
                      <iconify-icon icon="mdi:clipboard-check-outline" class="text-[26px] text-indigo-600 dark:text-indigo-300"></iconify-icon>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-3 text-xs">
                      <div class="rounded-2xl bg-white px-3 py-2 border border-slate-200 dark:bg-white/5 dark:border-white/10">
                        <div class="text-slate-500 dark:text-slate-400">Serie</div>
                        <div class="font-semibold text-slate-800 dark:text-slate-100 truncate">
                          {{ $state['serie'] ?? '—' }}
                        </div>
                      </div>
                      <div class="rounded-2xl bg-white px-3 py-2 border border-slate-200 dark:bg-white/5 dark:border-white/10">
                        <div class="text-slate-500 dark:text-slate-400">Año</div>
                        <div class="font-semibold text-slate-800 dark:text-slate-100">
                          {{ $state['anio'] ?? '—' }}
                        </div>
                      </div>
                    </div>

                    <div class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                      Vínculos se guardan junto con el equipo.
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>

        {{-- Footer (sticky) --}}
        <div class="sticky bottom-0 border-t border-slate-200/70 bg-white/85 backdrop-blur px-6 py-4
                    dark:border-white/10 dark:bg-[#0b1220]/75">
          <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
              <iconify-icon icon="mdi:lock-outline" class="text-[16px]"></iconify-icon>
              Auditoría: usuario y timestamps se registran automáticamente.
            </div>

            <div class="flex items-center justify-end gap-2">
              <button
                type="button"
                class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700
                       hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10"
                @click="modal = false"
              >
                Cancelar
              </button>

              <button
                type="button"
                class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white
                       shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                wire:click="save"
                wire:loading.attr="disabled"
                wire:target="save"
              >
                <iconify-icon icon="mdi:content-save-outline" class="text-[18px]" wire:loading.remove wire:target="save"></iconify-icon>
                <span wire:loading.remove wire:target="save">Guardar</span>
                <span wire:loading wire:target="save">Guardando...</span>
              </button>
            </div>
          </div>
        </div>

        {{-- Loading overlay --}}
        <div
          wire:loading
          wire:target="save"
          class="absolute inset-0 z-[30] bg-white/60 backdrop-blur-sm dark:bg-slate-950/40"
        >
          <div class="h-full w-full flex items-center justify-center">
            <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-xl dark:bg-[#0b1220] dark:border-white/10">
              <div class="flex items-center gap-3">
                <iconify-icon icon="mdi:loading" class="text-[22px] animate-spin text-indigo-600 dark:text-indigo-300"></iconify-icon>
                <div>
                  <div class="text-sm font-semibold text-slate-800 dark:text-slate-100">Procesando</div>
                  <div class="text-xs text-slate-500 dark:text-slate-400">Guardando cambios…</div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>