<div
  class="box-header justify-between"
  x-data="{
    abrirModal() {
      Livewire.dispatch('{{ $config['events']['open_modal'] }}', {
        id: 0,
        title: 'Nuevo {{ ucfirst($config['singular']) }}'
      });
    }
  }"
>
  <div>
    <div class="box-title !mb-0">Gestion de {{ $config['title'] }}</div>
    <p class="text-[0.78rem] text-[#8c9097] dark:text-white/50 mb-0">
      {{ $config['description'] }}
    </p>
  </div>

  <div class="flex items-center gap-2">
    <div class="input-group !w-[320px]">
      <input
        type="text"
        class="form-control"
        placeholder="Buscar registro..."
        wire:model.live.debounce.300ms="search"
      />
      <button class="ti-btn ti-btn-light !mb-0" type="button" wire:click="limpiar">
        <i class="ri-search-line"></i>
      </button>
    </div>

    <button
      type="button"
      class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] !text-white !font-medium bg-primary"
      @click="abrirModal()"
    >
      <i class="ri-add-line font-semibold align-middle me-1"></i>
      Nuevo {{ $config['singular'] }}
    </button>
  </div>
</div>
