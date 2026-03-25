{{-- resources/views/livewire/usuarios/modal.blade.php --}}
<div
  x-data="{
    modal: @entangle('modal').live,
    tab: 'registro', // registro | roles
    showPass: false,
    showPass2: false,
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
        class="w-full max-w-5xl overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/10
               dark:bg-[#0b1220] dark:ring-white/10"
        style="max-height: calc(100vh - 4rem);"
      >
        {{-- Header --}}
        <div class="sticky top-0 z-10 border-b border-slate-200/70 bg-white/85 backdrop-blur
                    dark:border-white/10 dark:bg-[#0b1220]/75">
          <div class="px-6 py-4 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3 min-w-0">
              <div class="h-11 w-11 rounded-2xl bg-indigo-600/10 text-indigo-600 dark:bg-indigo-500/15 dark:text-indigo-300
                          ring-1 ring-indigo-600/10 dark:ring-indigo-400/10 flex items-center justify-center">
                <iconify-icon icon="mdi:account-plus-outline" class="text-[24px]"></iconify-icon>
              </div>

              <div class="min-w-0">
                <h2 class="text-[15px] font-semibold text-slate-900 dark:text-slate-100 truncate">
                  {{ $editingId ? 'Editar Usuario' : 'Registrar Usuario' }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">
                  Registro rápido por DNI • Guardado único (persona + usuario + roles)
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

          {{-- Tabs --}}
          <div class="px-6 pb-3">
            <div class="flex flex-wrap items-center gap-2">
              <button
                type="button"
                @click="tab='registro'"
                class="inline-flex items-center gap-2 rounded-2xl px-4 py-2 text-sm font-semibold transition"
                :class="tab==='registro'
                  ? 'bg-indigo-600 text-white shadow-sm'
                  : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10'"
              >
                <iconify-icon icon="mdi:card-account-details-outline" class="text-[18px]"></iconify-icon>
                Registro
              </button>

              <button
                type="button"
                @click="tab='roles'"
                class="inline-flex items-center gap-2 rounded-2xl px-4 py-2 text-sm font-semibold transition"
                :class="tab==='roles'
                  ? 'bg-indigo-600 text-white shadow-sm'
                  : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10'"
              >
                <iconify-icon icon="mdi:shield-account-outline" class="text-[18px]"></iconify-icon>
                Roles
              </button>

              {{-- hint pequeño --}}
              <div class="ms-auto hidden md:flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <iconify-icon icon="mdi:information-outline" class="text-[16px]"></iconify-icon>
                Buscar DNI autocompleta y setea username/clave.
              </div>
            </div>
          </div>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 overflow-y-auto" style="max-height: calc(100vh - 15rem);">
        {{-- Alerta visible (sin cambiar de tab) --}}
        @if($errors->has('selectedRoles'))
          <div class="mb-4 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-rose-700
                      dark:border-rose-500/20 dark:bg-rose-500/10 dark:text-rose-200">
            <div class="flex items-start gap-3">
              <iconify-icon icon="mdi:alert-circle-outline" class="text-[20px] mt-0.5"></iconify-icon>
              <div class="min-w-0">
                <div class="text-sm font-semibold">Faltan roles</div>
                <div class="text-xs opacity-90">{{ $errors->first('selectedRoles') }}</div>
        
                <button
                  type="button"
                  class="mt-2 inline-flex items-center gap-2 rounded-2xl border border-rose-200 bg-white px-3 py-2 text-xs font-semibold
                         hover:bg-rose-100 dark:bg-white/5 dark:border-rose-500/20 dark:hover:bg-rose-500/20"
                  @click="tab='roles'"
                >
                  <iconify-icon icon="mdi:shield-account-outline" class="text-[16px]"></iconify-icon>
                  Ir a Roles
                </button>
              </div>
            </div>
          </div>
        @endif
          {{-- TAB: REGISTRO --}}
          <div x-show="tab==='registro'" x-transition.opacity class="space-y-4">
            {{-- Persona + Empresa --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10">
              <div class="px-5 py-4 border-b border-slate-200/70 dark:border-white/10">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                  <iconify-icon icon="mdi:card-account-details-outline" class="text-[18px] text-indigo-600 dark:text-indigo-300"></iconify-icon>
                  Persona y empresa
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                  DNI para buscar o crear persona. Empresa obligatoria.
                </p>
              </div>

              <div class="p-5">
                <div class="grid grid-cols-12 gap-4">
                  {{-- DNI --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      DNI <span class="text-rose-500">*</span>
                    </label>

                    <div class="relative">
                      <input
                        type="text"
                        inputmode="numeric"
                        maxlength="8"
                        class="w-full rounded-2xl border border-slate-200 bg-white pl-3 pr-12 py-2.5 text-sm text-slate-800 shadow-sm
                              focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                              dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        placeholder="Ej: 12345678"
                        wire:model.defer="persona.dni"
                        wire:keydown.enter="buscarDni"
                      />

                      <button
                        type="button"
                        class="absolute right-1.5 top-1/2 -translate-y-1/2 inline-flex h-10 w-10 items-center justify-center rounded-2xl
                              bg-indigo-600 text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
                        wire:click="buscarDni"
                        wire:loading.attr="disabled"
                        wire:target="buscarDni"
                        aria-label="Buscar DNI"
                        title="Buscar DNI"
                      >
                        <iconify-icon icon="mdi:magnify" class="text-[20px]" wire:loading.remove wire:target="buscarDni"></iconify-icon>
                        <iconify-icon icon="mdi:loading" class="text-[20px] animate-spin" wire:loading wire:target="buscarDni"></iconify-icon>
                      </button>
                    </div>

                    @error('persona.dni') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror

                    <div class="mt-2 text-xs">
                      @if(!empty($persona_id))
                        <div class="inline-flex items-center gap-2 rounded-2xl border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-emerald-700
                                    dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200">
                          <iconify-icon icon="mdi:check-circle-outline" class="text-[16px]"></iconify-icon>
                          Persona encontrada
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

                  {{-- Empresa --}}
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Empresa / Unidad Minera <span class="text-rose-500">*</span>
                    </label>
                    <select
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="state.empresa_id"
                    >
                      <option value="">-- Seleccione --</option>
                      @foreach(($empresaOptions ?? []) as $opt)
                        <option value="{{ $opt['id'] }}">{{ $opt['label'] }}</option>
                      @endforeach
                    </select>
                    @error('state.empresa_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  {{-- Datos mínimos (persona) --}}
                  <div class="col-span-12">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:bg-white/5 dark:border-white/10">
                      <div class="flex items-center justify-between gap-3">
                        <div class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                          <iconify-icon icon="mdi:account-outline" class="text-[18px] text-slate-500 dark:text-slate-300"></iconify-icon>
                          Datos mínimos
                          <span class="text-xs font-normal text-slate-500 dark:text-slate-400">(solo si no existe)</span>
                        </div>

                        <button
                          type="button"
                          class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700
                                 hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10"
                          wire:click="limpiarPersona"
                        >
                          <iconify-icon icon="mdi:refresh" class="text-[16px]"></iconify-icon>
                          Limpiar
                        </button>
                      </div>

                      <div class="mt-4 grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-4">
                          <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                            Nombres <span class="text-rose-500">*</span>
                          </label>
                          <input
                            type="text"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                                   dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                            wire:model.defer="persona.nombres"
                            placeholder="Ej: Juan Carlos"
                          />
                          @error('persona.nombres') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-12 md:col-span-4">
                          <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                            Apellido paterno <span class="text-rose-500">*</span>
                          </label>
                          <input
                            type="text"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                                   dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                            wire:model.defer="persona.apellido_paterno"
                            placeholder="Ej: Pérez"
                          />
                          @error('persona.apellido_paterno') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-12 md:col-span-4">
                          <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                            Apellido materno <span class="text-rose-500">*</span>
                          </label>
                          <input
                            type="text"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                                   dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                            wire:model.defer="persona.apellido_materno"
                            placeholder="Ej: Gómez"
                          />
                          @error('persona.apellido_materno') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-12 md:col-span-6">
                          <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                            Email (opcional)
                          </label>
                          <input
                            type="email"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                                   dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                            wire:model.defer="persona.email"
                            placeholder="persona@dominio.com"
                          />
                          @error('persona.email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-12 md:col-span-6">
                          <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                            Teléfono (opcional)
                          </label>
                          <input
                            type="text"
                            class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                                   focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                                   dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                            wire:model.defer="persona.telefono"
                            placeholder="Ej: 987654321"
                          />
                          @error('persona.telefono') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            {{-- Credenciales --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10">
              <div class="px-5 py-4 border-b border-slate-200/70 dark:border-white/10">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                  <iconify-icon icon="mdi:account-key-outline" class="text-[18px] text-indigo-600 dark:text-indigo-300"></iconify-icon>
                  Credenciales
                  <span class="text-xs font-normal text-slate-500 dark:text-slate-400">(por defecto DNI)</span>
                </h3>
              </div>

              <div class="p-5">
                <div class="grid grid-cols-12 gap-4">
                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Username <span class="text-rose-500">*</span>
                    </label>
                    <input
                      type="text"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="state.username"
                      placeholder="Ej: 12345678"
                    />
                    @error('state.username') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Email (usuario)
                    </label>
                    <input
                      type="email"
                      class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm
                             focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                             dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                      wire:model.defer="state.email"
                      placeholder="usuario@dominio.com"
                    />
                    @error('state.email') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Contraseña <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                      <input
                        :type="showPass ? 'text' : 'password'"
                        class="w-full rounded-2xl border border-slate-200 bg-white pl-3 pr-11 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        wire:model.defer="state.password"
                        placeholder="********"
                      />
                      <button
                        type="button"
                        class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex h-9 w-9 items-center justify-center rounded-2xl
                               text-slate-500 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/10"
                        @click="showPass=!showPass"
                        aria-label="Mostrar/Ocultar"
                      >
                        <iconify-icon :icon="showPass ? 'mdi:eye-off-outline' : 'mdi:eye-outline'" class="text-[20px]"></iconify-icon>
                      </button>
                    </div>
                    @error('state.password') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  <div class="col-span-12 md:col-span-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                      Confirmar contraseña <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                      <input
                        :type="showPass2 ? 'text' : 'password'"
                        class="w-full rounded-2xl border border-slate-200 bg-white pl-3 pr-11 py-2.5 text-sm text-slate-800 shadow-sm
                               focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500
                               dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                        wire:model.defer="state.password_confirmation"
                        placeholder="********"
                      />
                      <button
                        type="button"
                        class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex h-9 w-9 items-center justify-center rounded-2xl
                               text-slate-500 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/10"
                        @click="showPass2=!showPass2"
                        aria-label="Mostrar/Ocultar"
                      >
                        <iconify-icon :icon="showPass2 ? 'mdi:eye-off-outline' : 'mdi:eye-outline'" class="text-[20px]"></iconify-icon>
                      </button>
                    </div>
                    @error('state.password_confirmation') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                  </div>

                  <div class="col-span-12">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                      Estado <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-2">
                      <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm
                                     hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                        <input type="radio" class="rounded text-indigo-600" value="1" wire:model.defer="state.estado">
                        <span class="text-slate-700 dark:text-slate-200 font-semibold">Activo</span>
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

          {{-- TAB: ROLES --}}
          <div x-show="tab==='roles'" x-transition.opacity>
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:bg-white/5 dark:border-white/10 overflow-hidden">
              <div class="px-5 py-4 border-b border-slate-200/70 dark:border-white/10">
                <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-100 flex items-center gap-2">
                  <iconify-icon icon="mdi:shield-account-outline" class="text-[18px] text-indigo-600 dark:text-indigo-300"></iconify-icon>
                  Roles del usuario
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                  Selecciona roles activos.
                </p>
              </div>

              <div class="p-5">
                <div class="grid grid-cols-12 gap-3">
                  @forelse(($rolOptions ?? []) as $opt)
                    <label class="col-span-12 md:col-span-6 flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2
                                   hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                      <input
                        type="checkbox"
                        class="rounded text-indigo-600"
                        value="{{ $opt['id'] }}"
                        wire:model.defer="selectedRoles"
                      >
                      <div class="min-w-0">
                        <div class="text-sm font-semibold text-slate-800 dark:text-slate-100 truncate">{{ $opt['label'] }}</div>
                        @if(!empty($opt['hint']))
                          <div class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $opt['hint'] }}</div>
                        @endif
                      </div>
                    </label>
                  @empty
                    <div class="col-span-12 text-sm text-slate-500 dark:text-slate-400">
                      No hay roles registrados.
                    </div>
                  @endforelse
                </div>

                @error('selectedRoles') <p class="mt-2 text-xs text-rose-500">{{ $message }}</p> @enderror
              </div>
            </div>
          </div>
        </div>

        {{-- Footer --}}
        <div class="sticky bottom-0 border-t border-slate-200/70 bg-white/85 backdrop-blur px-6 py-4
                    dark:border-white/10 dark:bg-[#0b1220]/75">
          <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-2">
              <iconify-icon icon="mdi:lock-outline" class="text-[16px]"></iconify-icon>
              Guardado único: Persona + Usuario + Roles
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
                <span wire:loading.remove wire:target="save">Guardar usuario</span>
                <span wire:loading wire:target="save">Guardando...</span>
              </button>
            </div>
          </div>
        </div>

        {{-- Loading overlay --}}
        <div
          wire:loading
          wire:target="save,buscarDni"
          class="absolute inset-0 z-[30] bg-white/60 backdrop-blur-sm dark:bg-slate-950/40"
        >
          <div class="h-full w-full flex items-center justify-center">
            <div class="rounded-2xl border border-slate-200 bg-white px-5 py-4 shadow-xl dark:bg-[#0b1220] dark:border-white/10">
              <div class="flex items-center gap-3">
                <iconify-icon icon="mdi:loading" class="text-[22px] animate-spin text-indigo-600 dark:text-indigo-300"></iconify-icon>
                <div>
                  <div class="text-sm font-semibold text-slate-800 dark:text-slate-100">Buscando</div>
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