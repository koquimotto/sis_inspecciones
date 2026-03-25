<div
  class="box-header justify-between"
  x-data="{
    abrirModal() {
      Livewire.dispatch('empresas-modal:open', {
        id: 0,
        title: 'Nueva Empresa'
      });
    }
  }"
>
  <div>
    <div class="box-title !mb-0">Gestión de Empresas</div>
    <p class="text-[0.78rem] text-[#8c9097] dark:text-white/50 mb-0">
      Registro y administración de clientes/contratistas.
    </p>
  </div>

  <div class="flex items-center gap-2">
    <div class="input-group !w-[320px]">
      <input type="text" class="form-control" placeholder="Buscar: RUC, razón social, contacto..." />
      <button class="ti-btn ti-btn-light !mb-0" type="button">
        <i class="ri-search-line"></i>
      </button>
    </div>

    <select class="form-control form-control-lg !w-[180px] !rounded-md" aria-label="Estado">
      <option value="" selected>Estado: Todos</option>
      <option>Activo</option>
      <option>Inactivo</option>
    </select>

    <button
      type="button"
      class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] !text-white !font-medium bg-primary"
      @click="abrirModal()"
    >
      <i class="ri-add-line font-semibold align-middle me-1"></i>
      Nueva empresa
    </button>
  </div>
</div>