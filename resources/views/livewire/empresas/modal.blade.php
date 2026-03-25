{{-- resources/views/livewire/empresas/modal.blade.php --}}
<div
  x-data="{
    modal: @entangle('modal').live,
    tab: 'empresa', // empresa | contacto

    // Pro: progreso simple por sección
    get stepText(){
      return this.tab === 'empresa' ? '1/2 Empresa' : '2/2 Contacto';
    },
  }"
  x-on:keydown.escape.window="if(modal) modal=false"
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
      @click="modal=false"
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
        {{-- Header --}}
        <div class="sticky top-0 z-20 border-b border-slate-200/70 bg-white/85 backdrop-blur
                    dark:border-white/10 dark:bg-[#0b1220]/75">
          <div class="px-6 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
              <div class="h-11 w-11 rounded-2xl bg-indigo-600/10 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300
                          ring-1 ring-indigo-600/10 dark:ring-indigo-400/10 flex items-center justify-center">
                <iconify-icon icon="mdi:office-building-plus-outline" class="text-[24px]"></iconify-icon>
              </div>

              <div class="min-w-0">
                <div class="flex items-center gap-3">
                  <h2 class="text-[15px] font-semibold text-slate-900 dark:text-slate-100 truncate">
                    {{ $editingId ? 'Editar Empresa' : 'Registrar Empresa' }}
                  </h2>

                  {{-- Step pill --}}
                  <span
                    class="hidden sm:inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700
                           dark:border-white/10 dark:bg-white/5 dark:text-slate-200"
                  >
                    <iconify-icon icon="mdi:progress-check" class="text-[16px] text-slate-500 dark:text-slate-300"></iconify-icon>
                    <span x-text="stepText"></span>
                  </span>
                </div>

                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                  Registro completo • Empresa/Unidad minera + Contacto principal (buscable por documento)
                </p>
              </div>
            </div>

            <div class="flex items-center gap-2">
              {{-- Hint compacto --}}
              <div class="hidden md:flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2
                          dark:border-white/10 dark:bg-white/5">
                <iconify-icon icon="mdi:information-outline" class="text-[16px] text-slate-500 dark:text-slate-300"></iconify-icon>
                <span class="text-xs font-semibold text-slate-700 dark:text-slate-200">
                  Busca el contacto por documento y al guardar se crea todo.
                </span>
              </div>

              <button
                type="button"
                class="inline-flex h-10 w-10 items-center justify-center rounded-2xl
                       text-slate-500 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/5"
                @click="modal=false"
                aria-label="Cerrar"
              >
                <iconify-icon icon="mdi:close-circle-outline" class="text-[22px]"></iconify-icon>
              </button>
            </div>
          </div>

          {{-- Tabs + Progreso visual --}}
          <div class="px-6 pb-4">
            <div class="flex flex-wrap items-center gap-2">
              <button
                type="button"
                @click="tab='empresa'"
                class="inline-flex items-center gap-2 rounded-2xl px-4 py-2 text-sm font-semibold transition"
                :class="tab==='empresa'
                  ? 'bg-indigo-600 text-white shadow-sm'
                  : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10'"
              >
                <iconify-icon icon="mdi:domain" class="text-[18px]"></iconify-icon>
                Empresa
              </button>

              <button
                type="button"
                @click="tab='contacto'"
                class="inline-flex items-center gap-2 rounded-2xl px-4 py-2 text-sm font-semibold transition"
                :class="tab==='contacto'
                  ? 'bg-indigo-600 text-white shadow-sm'
                  : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10'"
              >
                <iconify-icon icon="mdi:account-tie-outline" class="text-[18px]"></iconify-icon>
                Contacto
              </button>

              <div class="ms-auto flex items-center gap-2">
                {{-- Mini progress bar --}}
                <div class="hidden sm:block w-40 h-2 rounded-full bg-slate-200/70 dark:bg-white/10 overflow-hidden">
                  <div
                    class="h-2 rounded-full bg-indigo-600 transition-all"
                    :style="tab==='empresa' ? 'width:50%' : 'width:100%'"
                  ></div>
                </div>

                {{-- CTA navegar --}}
                <button
                  type="button"
                  class="rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700
                         hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10"
                  x-show="tab==='empresa'"
                  @click="tab='contacto'"
                >
                  Siguiente
                  <iconify-icon icon="mdi:arrow-right" class="text-[16px] ms-1"></iconify-icon>
                </button>

                <button
                  type="button"
                  class="rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700
                         hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10"
                  x-show="tab==='contacto'"
                  @click="tab='empresa'"
                >
                  <iconify-icon icon="mdi:arrow-left" class="text-[16px] me-1"></iconify-icon>
                  Volver
                </button>
              </div>
            </div>

            {{-- Indicaciones (compactas, sin cargar) --}}
            <div class="mt-3 grid grid-cols-12 gap-3">
              <div class="col-span-12 md:col-span-6 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-700
                          dark:border-white/10 dark:bg-white/5 dark:text-slate-200">
                <div class="flex items-start gap-2">
                  <iconify-icon icon="mdi:check-decagram-outline" class="text-[18px] mt-0.5 text-slate-400"></iconify-icon>
                  <div>
                    <span class="font-semibold">Guardado único:</span> al guardar se crea/actualiza empresa y se vincula el contacto.
                  </div>
                </div>
              </div>

              <div class="col-span-12 md:col-span-6 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-xs text-slate-700
                          dark:border-white/10 dark:bg-white/5 dark:text-slate-200">
                <div class="flex items-start gap-2">
                  <iconify-icon icon="mdi:account-search-outline" class="text-[18px] mt-0.5 text-slate-400"></iconify-icon>
                  <div>
                    <span class="font-semibold">Contacto:</span> busca por documento. Si no existe, completa datos mínimos (se creará).
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Body --}}
        <div class="px-6 pb-6 pt-5 overflow-y-auto" style="max-height: calc(100vh - 18.5rem);">
          {{-- TAB: EMPRESA --}}
          <div x-show="tab==='empresa'" x-transition.opacity class="space-y-4">
            {{-- Card: Datos de empresa --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10 overflow-hidden">
              <div class="px-5 py-4 border-b border-slate-200/70 dark:border-white/10">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                      <iconify-icon icon="mdi:office-building-outline" class="text-[18px] text-indigo-600 dark:text-indigo-300"></iconify-icon>
                      Datos de la empresa
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                      Identificación y relación con unidad minera (si aplica).
                    </p>
                  </div>

                  {{-- Chip estado (pro) --}}
                  <div class="hidden sm:flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700
                              dark:border-white/10 dark:bg-white/5 dark:text-slate-200">
                    <iconify-icon icon="mdi:domain" class="text-[16px] text-slate-500 dark:text-slate-300"></iconify-icon>
                    Registro empresarial
                  </div>
                </div>
              </div>

              <div class="p-5">
                <div class="grid grid-cols-12 gap-4">
                  {{-- Tipo --}}
                  <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Tipo <span class="text-rose-500">*</span>
                    </label>
                    <select
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="state.tipo"
                    >
                      <option value="">Seleccione...</option>
                      <option value="EMPRESA">EMPRESA</option>
                      <option value="UNIDAD_MINERA">UNIDAD MINERA</option>
                    </select>
                    @error('state.tipo') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Unidad minera padre --}}
                  <div class="col-span-12 md:col-span-8">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Unidad minera (padre)
                      <span class="text-slate-400 font-normal">(opcional)</span>
                    </label>
                    <select
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="state.unidad_minera_id"
                    >
                      <option value="">Sin unidad minera</option>
                      @foreach(($unidadMineraOptions ?? []) as $opt)
                        <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                      @endforeach
                    </select>
                    @error('state.unidad_minera_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- RUC --}}
                  <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      RUC <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                      <input
                        type="text"
                        inputmode="numeric"
                        maxlength="11"
                        class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        placeholder="Ej: 20123456789"
                        wire:model.defer="state.ruc"
                      />
                      <iconify-icon icon="mdi:identifier" class="absolute right-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400"></iconify-icon>
                    </div>
                    @error('state.ruc') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Razón social --}}
                  <div class="col-span-12 md:col-span-8">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Razón social <span class="text-rose-500">*</span>
                    </label>
                    <input
                      type="text"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      placeholder="Ej: EL CUMBE E.I.R.L."
                      wire:model.defer="state.razon_social"
                    />
                    @error('state.razon_social') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Nombre comercial --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Nombre comercial
                    </label>
                    <input
                      type="text"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      placeholder="Ej: El Cumbe"
                      wire:model.defer="state.nombre_comercial"
                    />
                    @error('state.nombre_comercial') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Email --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Email institucional
                    </label>
                    <div class="relative">
                      <input
                        type="email"
                        class="w-full rounded-2xl border border-slate-200 bg-white pl-3 pr-10 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        placeholder="contacto@empresa.com"
                        wire:model.defer="state.email"
                      />
                      <iconify-icon icon="mdi:email-outline" class="absolute right-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400"></iconify-icon>
                    </div>
                    @error('state.email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Teléfono --}}
                  <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Teléfono institucional
                    </label>
                    <div class="relative">
                      <input
                        type="text"
                        class="w-full rounded-2xl border border-slate-200 bg-white pl-3 pr-10 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        placeholder="Ej: 076-123456 / 987654321"
                        wire:model.defer="state.telefono"
                      />
                      <iconify-icon icon="mdi:phone-outline" class="absolute right-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400"></iconify-icon>
                    </div>
                    @error('state.telefono') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- País --}}
                  <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      País <span class="text-rose-500">*</span>
                    </label>
                    <select
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="state.pais_id"
                    >
                      <option value="">Seleccione...</option>
                      @foreach(($paisOptions ?? []) as $opt)
                        <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                      @endforeach
                    </select>
                    @error('state.pais_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Región --}}
                  <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Región/Departamento <span class="text-rose-500">*</span>
                    </label>
                    <select
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="state.region_id"
                    >
                      <option value="">Seleccione...</option>
                      @foreach(($regionOptions ?? []) as $opt)
                        <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                      @endforeach
                    </select>
                    @error('state.region_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Ciudad --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Ciudad/Provincia/Distrito
                    </label>
                    <input
                      type="text"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      placeholder="Ej: Cajamarca / Cajamarca / Baños del Inca"
                      wire:model.defer="state.ciudad"
                    />
                    @error('state.ciudad') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Dirección --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Dirección
                    </label>
                    <input
                      type="text"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      placeholder="Av. / Jr. / Mz. / Lt."
                      wire:model.defer="state.direccion"
                    />
                    @error('state.direccion') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Estado --}}
                  <div class="col-span-12">
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
                        <input type="radio" class="rounded text-indigo-600" value="0" wire:model.defer="state.estado">
                        <span class="text-slate-700 dark:text-slate-200 font-semibold">Inactivo</span>
                      </label>
                    </div>
                    @error('state.estado') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- TAB: CONTACTO --}}
          <div x-show="tab==='contacto'" x-transition.opacity class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10 overflow-hidden">
              <div class="px-5 py-4 border-b border-slate-200/70 dark:border-white/10">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                      <iconify-icon icon="mdi:account-tie-outline" class="text-[18px] text-indigo-600 dark:text-indigo-300"></iconify-icon>
                      Contacto principal
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                      Busca por documento. Si no existe, completa datos mínimos para crearlo al guardar.
                    </p>
                  </div>

                  <div class="hidden sm:flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700
                              dark:border-white/10 dark:bg-white/5 dark:text-slate-200">
                    <iconify-icon icon="mdi:account-search-outline" class="text-[16px] text-slate-500 dark:text-slate-300"></iconify-icon>
                    Búsqueda inteligente
                  </div>
                </div>
              </div>

              <div class="p-5">
                <div class="grid grid-cols-12 gap-4">
                  {{-- Tipo doc --}}
                  <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Tipo doc. <span class="text-rose-500">*</span>
                    </label>
                    <select
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="contacto.tipo_documento"
                    >
                      <option value="DNI">DNI</option>
                      <option value="CE">CE</option>
                      <option value="PAS">PAS</option>
                    </select>
                    @error('contacto.tipo_documento') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Nro doc + buscar --}}
                  <div class="col-span-12 md:col-span-8">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      N° documento <span class="text-rose-500">*</span>
                    </label>

                    <div class="relative">
                      <input
                        type="text"
                        class="w-full rounded-2xl border border-slate-200 bg-white pl-3 pr-12 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        placeholder="Ej: 12345678"
                        wire:model.defer="contacto.numero_documento"
                      />

                      <button
                        type="button"
                        class="absolute right-1.5 top-1/2 -translate-y-1/2 inline-flex h-10 w-10 items-center justify-center rounded-2xl
                               bg-indigo-600 text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                        wire:click="buscarContacto"
                        wire:loading.attr="disabled"
                        wire:target="buscarContacto"
                        aria-label="Buscar contacto"
                        title="Buscar contacto"
                      >
                        <iconify-icon icon="mdi:magnify" class="text-[20px]" wire:loading.remove wire:target="buscarContacto"></iconify-icon>
                        <iconify-icon icon="mdi:loading" class="text-[20px] animate-spin" wire:loading wire:target="buscarContacto"></iconify-icon>
                      </button>
                    </div>

                    @error('contacto.numero_documento') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror

                    <div class="mt-2 text-xs">
                      @if(!empty($contacto_id))
                        <div class="inline-flex items-center gap-2 rounded-2xl border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-emerald-700
                                    dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200">
                          <iconify-icon icon="mdi:check-circle-outline" class="text-[16px]"></iconify-icon>
                          Contacto encontrado
                        </div>
                      @else
                        <div class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-3 py-1.5 text-slate-600
                                    dark:border-white/10 dark:bg-white/5 dark:text-slate-300">
                          <iconify-icon icon="mdi:information-outline" class="text-[16px]"></iconify-icon>
                          Se creará al guardar si no existe.
                        </div>
                      @endif
                    </div>
                  </div>

                  {{-- Nombres --}}
                  <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Nombres <span class="text-rose-500">*</span>
                    </label>
                    <input
                      type="text"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="contacto.nombres"
                      placeholder="Ej: Juan Carlos"
                    />
                    @error('contacto.nombres') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Apellido paterno --}}
                  <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Apellido paterno <span class="text-rose-500">*</span>
                    </label>
                    <input
                      type="text"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="contacto.apellido_paterno"
                      placeholder="Ej: Pérez"
                    />
                    @error('contacto.apellido_paterno') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Apellido materno --}}
                  <div class="col-span-12 md:col-span-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Apellido materno <span class="text-rose-500">*</span>
                    </label>
                    <input
                      type="text"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="contacto.apellido_materno"
                      placeholder="Ej: Gómez"
                    />
                    @error('contacto.apellido_materno') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Cargo --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Cargo
                    </label>
                    <input
                      type="text"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="contacto.cargo"
                      placeholder="Ej: Administrador / Supervisor"
                    />
                    @error('contacto.cargo') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Email --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Email
                    </label>
                    <div class="relative">
                      <input
                        type="email"
                        class="w-full rounded-2xl border border-slate-200 bg-white pl-3 pr-10 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        wire:model.defer="contacto.email"
                        placeholder="contacto@correo.com"
                      />
                      <iconify-icon icon="mdi:email-outline" class="absolute right-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400"></iconify-icon>
                    </div>
                    @error('contacto.email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Teléfono --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Teléfono
                    </label>
                    <div class="relative">
                      <input
                        type="text"
                        class="w-full rounded-2xl border border-slate-200 bg-white pl-3 pr-10 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        wire:model.defer="contacto.telefono"
                        placeholder="Ej: 987654321"
                      />
                      <iconify-icon icon="mdi:phone-outline" class="absolute right-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400"></iconify-icon>
                    </div>
                    @error('contacto.telefono') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Estado --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                      Estado
                    </label>
                    <div class="flex flex-wrap gap-2">
                      <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm
                                     hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                        <input type="radio" class="rounded text-indigo-600" value="1" wire:model.defer="contacto.estado">
                        <span class="text-slate-700 dark:text-slate-200 font-semibold">Activo</span>
                      </label>
                      <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm
                                     hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                        <input type="radio" class="rounded text-indigo-600" value="0" wire:model.defer="contacto.estado">
                        <span class="text-slate-700 dark:text-slate-200 font-semibold">Inactivo</span>
                      </label>
                    </div>
                    @error('contacto.estado') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>
                </div>

                {{-- CTA volver/guardar rápido --}}
                <div class="mt-5 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2">
                  <button
                    type="button"
                    class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700
                           hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10"
                    @click="tab='empresa'"
                  >
                    <iconify-icon icon="mdi:arrow-left" class="text-[18px] me-1"></iconify-icon>
                    Volver a Empresa
                  </button>

                  <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
                    <iconify-icon icon="mdi:lock-outline" class="text-[16px]"></iconify-icon>
                    Empresa + contacto se guardan juntos.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Footer --}}
        <div class="sticky bottom-0 z-20 border-t border-slate-200/70 bg-white/85 backdrop-blur px-6 py-4
                    dark:border-white/10 dark:bg-[#0b1220]/75">
          <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
              <iconify-icon icon="mdi:lock-outline" class="text-[16px]"></iconify-icon>
              Guardado único: Empresa + Contacto
            </div>

            <div class="flex items-center justify-end gap-2">
              <button
                type="button"
                class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700
                       hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10"
                @click="modal=false"
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
          wire:target="save,buscarContacto"
          class="absolute inset-0 z-[30] bg-white/60 backdrop-blur-sm dark:bg-slate-950/40"
        >
          <div class="h-full w-full flex items-center justify-center">
            <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-xl dark:bg-[#0b1220] dark:border-white/10">
              <div class="flex items-center gap-3">
                <iconify-icon icon="mdi:loading" class="text-[22px] animate-spin text-indigo-600 dark:text-indigo-300"></iconify-icon>
                <div>
                  <div class="text-sm font-semibold text-slate-800 dark:text-slate-100">Procesando</div>
                  <div class="text-xs text-slate-500 dark:text-slate-400">Espere un momento…</div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>