<div 
    class="box-header justify-between" 
    x-data="{
                abrirModal() {
                    Livewire.dispatch('usuarios-modal:open', {
                        id      : 0,
                        title   : 'Nuevo Usuario'
                    });
                } 
            }">
    <div class="box-title">
        Gestión de Usuarios
    </div>

    <div class="flex">
        <button
          type="button"
          class="ti-btn btn-wave !py-1 !px-2 !text-[0.75rem] !text-white !font-medium bg-primary"
            @click="abrirModal()"
        >
          <i class="ri-add-line font-semibold align-middle me-1"></i>
          Nuevo usuario
        </button>
    </div>
</div>
