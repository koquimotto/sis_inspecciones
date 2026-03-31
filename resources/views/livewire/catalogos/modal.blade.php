<div x-data="{ modal: @entangle('modal').live }" x-on:keydown.escape.window="if(modal) modal=false">
  <div x-show="modal" x-cloak class="fixed inset-0 z-[9999]" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-[2px]" x-transition.opacity @click="modal=false"></div>

    <div class="relative min-h-full flex items-center justify-center p-4 -translate-y-6">
      <div
        @click.stop
        x-transition
        class="w-full {{ $config['modal_width'] ?? 'max-w-xl' }} overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/10 dark:bg-[#0b1220] dark:ring-white/10"
      >
        <div class="border-b border-slate-200/70 bg-white/85 px-6 py-4 backdrop-blur dark:border-white/10 dark:bg-[#0b1220]/75">
          <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
              <div class="h-11 w-11 rounded-2xl bg-indigo-600/10 text-indigo-600 ring-1 ring-indigo-600/10 flex items-center justify-center dark:bg-indigo-500/15 dark:text-indigo-300 dark:ring-indigo-400/10">
                <iconify-icon icon="mdi:shape-plus-outline" class="text-[24px]"></iconify-icon>
              </div>

              <div>
                <h2 class="text-[15px] font-semibold text-slate-900 dark:text-slate-100">{{ $titleModal }}</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                  Configura {{ strtolower($config['title']) }} para el proceso de inspeccion.
                </p>
              </div>
            </div>

            <button
              type="button"
              class="inline-flex h-10 w-10 items-center justify-center rounded-2xl text-slate-500 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-white/5"
              @click="modal=false"
              aria-label="Cerrar"
            >
              <iconify-icon icon="mdi:close-circle-outline" class="text-[22px]"></iconify-icon>
            </button>
          </div>
        </div>

        <div class="px-6 py-5 space-y-4">
          <div class="grid grid-cols-12 gap-4">
            @foreach ($config['fields'] as $field)
              <div class="col-span-12 {{ count($config['fields']) > 1 ? 'md:col-span-6' : '' }}">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">
                  {{ $field['label'] }}
                  @if ($field['required'])
                    <span class="text-rose-500">*</span>
                  @endif
                </label>
                <input
                  type="{{ $field['type'] }}"
                  class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-800 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 dark:bg-white/5 dark:text-slate-100 dark:border-white/10"
                  placeholder="{{ $field['placeholder'] ?? '' }}"
                  wire:model.defer="state.{{ $field['name'] }}"
                />
                @error('state.' . $field['name']) <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
              </div>
            @endforeach

            <div class="col-span-12">
              <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                Estado
              </label>
              <div class="flex flex-wrap gap-2">
                <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                  <input type="radio" class="rounded text-indigo-600" value="1" wire:model.defer="state.estado">
                  <span class="text-slate-700 dark:text-slate-200 font-semibold">Activo</span>
                </label>

                <label class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm hover:bg-slate-50 dark:bg-white/5 dark:border-white/10 dark:hover:bg-white/10">
                  <input type="radio" class="rounded text-indigo-600" value="0" wire:model.defer="state.estado">
                  <span class="text-slate-700 dark:text-slate-200 font-semibold">Inactivo</span>
                </label>
              </div>
              @error('state.estado') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>

        <div class="border-t border-slate-200/70 bg-white/85 px-6 py-4 backdrop-blur dark:border-white/10 dark:bg-[#0b1220]/75">
          <div class="flex items-center justify-end gap-2">
            <button
              type="button"
              class="rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 dark:bg-white/5 dark:text-slate-200 dark:border-white/10 dark:hover:bg-white/10"
              @click="modal=false"
            >
              Cancelar
            </button>

            <button
              type="button"
              class="inline-flex items-center justify-center gap-2 rounded-2xl bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/30"
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
    </div>
  </div>
</div>



