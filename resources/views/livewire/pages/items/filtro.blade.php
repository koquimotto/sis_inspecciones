{{-- resources/views/livewire/items/filtro.blade.php --}}
<div
  class="box-header justify-between"
  x-data="{
    abrirModal() {
      Livewire.dispatch('items-modal:open', { id: 0, title: 'Nuevo ítem' });
    }
  }"
>
  <div class="box-title">
    Gestión de ítems
  </div>

  {{-- ✅ toolbar en una sola línea, respetando Ynex --}}
  <div class="flex items-center gap-2 flex-nowrap overflow-x-auto no-scrollbar">

    {{-- Categoría --}}
    <select class="ti-form-select rounded-sm !h-10 !py-0 !px-3 !text-[0.78rem] flex-none"
            style="width:190px;min-width:190px">
      <option value="">Categoría</option>
      <option>Documentación</option>
      <option>Inspección</option>
      <option>Seguridad</option>
      <option>Mantenimiento</option>
    </select>

    {{-- Subcategoría --}}
    <select class="ti-form-select rounded-sm !h-10 !py-0 !px-3 !text-[0.78rem] flex-none"
            style="width:260px;min-width:260px">
      <option value="">Subcategoría</option>
      <option>Documentos entregados por el proveedor</option>
      <option>Chasis / Suspensión</option>
      <option>Iluminación</option>
      <option>EPP</option>
    </select>
    
        {{-- Estado --}}
    <select class="ti-form-select rounded-sm !h-10 !py-0 !px-3 !text-[0.78rem] flex-none"
            style="width:150px;min-width:150px">
      <option value="">Estado</option>
      <option value="1">Activo</option>
      <option value="0">Inactivo</option>
    </select>

    {{-- Buscar ítem --}}
    <div class="relative flex-none" style="width:240px;min-width:240px">
      <input
        type="text"
        placeholder="Buscar ítem…"
        class="ti-form-input rounded-sm ps-11 !h-10 !py-0 !text-[0.78rem]"
      />
      <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4 text-[#8c9097] dark:text-white/50">
        <iconify-icon icon="mdi:magnify" class="text-[18px]"></iconify-icon>
      </div>
    </div>



    {{-- Nuevo --}}
    <button
      type="button"
      class="ti-btn btn-wave ti-btn-primary-full !h-10 !py-0 !px-3 !text-[0.75rem] !font-semibold flex-none"
      @click="abrirModal()"
      style="min-width:120px"
    >
      <i class="ri-add-line font-semibold align-middle me-1"></i>
      Nuevo ítem
    </button>

  </div>
</div>