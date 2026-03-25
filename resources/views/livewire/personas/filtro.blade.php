<div
  class="box-header justify-between"
  x-data="{
    abrirModal() {
      Livewire.dispatch('personas-modal:open', {
        id: 0,
        title: 'Nueva Persona'
      });
    }
  }"
>
  <div>
    <div class="box-title !mb-0">Gestión de Personas</div>
    <p class="text-[0.78rem] text-[#8c9097] dark:text-white/50 mb-0">
      Registro de inspectores, responsables técnicos, contactos y representantes.
    </p>
  </div>

  <div class="flex items-center gap-2">
    <div class="input-group !w-[320px]">
      <input type="text" class="form-control" placeholder="Buscar: DNI, nombres, cargo, empresa..." />
      <button class="ti-btn ti-btn-light !mb-0" type="button">
        <i class="ri-search-line"></i>
      </button>
    </div>

    <select class="form-control form-control-lg !w-[190px] !rounded-md" aria-label="Rol">
      <option value="" selected>Rol: Todos</option>
      <option>Inspector</option>
      <option>Responsable técnico</option>
      <option>Representante</option>
      <option>Contacto</option>
    </select>

    <button
      type="button"
      class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] !text-white !font-medium bg-primary"
      @click="abrirModal()"
    >
      <i class="ri-add-line font-semibold align-middle me-1"></i>
      Nueva persona
    </button>
  </div>
</div>