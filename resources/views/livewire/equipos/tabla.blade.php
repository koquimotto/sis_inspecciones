<div
  class="box-body"
  x-data="{
    openModal(id){
      Livewire.dispatch('equipos-modal:open',{
        id: id,
        title: 'Editar equipo'
      });
    }
  }"
>
  <div class="table-responsive">
    <table class="table whitespace-nowrap ti-striped-table table-hover min-w-full ti-custom-table-hover">
      <thead>
        <tr class="border-b border-defaultborder">
          <th scope="col" class="text-start w-1">#</th>
          <th scope="col" class="text-start">Equipo</th>
          <th scope="col" class="text-start">Empresa</th>
          <th scope="col" class="text-start">Ubicación</th>
          <th scope="col" class="text-start">Estado</th>
          <th scope="col" class="text-start">Últ. inspección</th>
          <th scope="col" class="text-start w-1"></th>
        </tr>
      </thead>

      <tbody>
        {{-- EJEMPLO (estático por ahora) --}}
        @php
          $equipos = [
            [
              'id' => 1,
              'codigo' => 'EQ-0001',
              'nombre' => 'Extintor PQS 6KG',
              'tipo' => 'Extintor',
              'serie' => 'SN-EX-88421',
              'empresa' => 'EL CUMBE E.I.R.L.',
              'ubicacion' => 'Planta - Almacén Central',
              'estado' => 'Activo',
              'estado_color' => 'success',
              'ultima_inspeccion' => '10/02/2026',
              'vencimiento' => '10/08/2026',
            ],
            [
              'id' => 2,
              'codigo' => 'EQ-0002',
              'nombre' => 'Arnés de seguridad',
              'tipo' => 'EPP',
              'serie' => 'SN-EP-12009',
              'empresa' => 'COMINSA',
              'ubicacion' => 'Obra - Zona Norte',
              'estado' => 'En inspección',
              'estado_color' => 'primary',
              'ultima_inspeccion' => '05/02/2026',
              'vencimiento' => '—',
            ],
            [
              'id' => 3,
              'codigo' => 'EQ-0003',
              'nombre' => 'Montacargas 2.5T',
              'tipo' => 'Maquinaria',
              'serie' => 'SN-MQ-77710',
              'empresa' => 'Zetroon',
              'ubicacion' => 'Sucursal - Patio',
              'estado' => 'Observado',
              'estado_color' => 'orange',
              'ultima_inspeccion' => '28/01/2026',
              'vencimiento' => '—',
            ],
            [
              'id' => 4,
              'codigo' => 'EQ-0004',
              'nombre' => 'Tablero eléctrico principal',
              'tipo' => 'Eléctrico',
              'serie' => 'SN-EL-43112',
              'empresa' => 'EL CUMBE E.I.R.L.',
              'ubicacion' => 'Planta - Sala eléctrica',
              'estado' => 'Inactivo',
              'estado_color' => 'danger',
              'ultima_inspeccion' => '12/12/2025',
              'vencimiento' => '—',
            ],
          ];
        @endphp

        @foreach ($equipos as $eq)
          <tr class="border-b border-defaultborder">
            <th scope="row">{{ $loop->iteration }}</th>

            <td>
              <div class="flex items-center">
                <div class="avatar avatar-sm me-2 avatar-rounded bg-primary/10 text-primary flex items-center justify-center">
                  <i class="ri-tools-line"></i>
                </div>

                <div class="min-w-0">
                  <div class="leading-none flex items-center gap-2">
                    <span class="font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70">
                      {{ $eq['codigo'] }}
                    </span>
                    <span class="badge bg-light text-defaulttextcolor/70">
                      {{ $eq['tipo'] }}
                    </span>
                  </div>

                  <div class="leading-none mt-1">
                    <span class="text-[0.8125rem]">
                      {{ $eq['nombre'] }}
                    </span>
                  </div>

                  <div class="leading-none mt-1">
                    <span class="text-[0.6875rem] text-[#8c9097] dark:text-white/50">
                      Serie: {{ $eq['serie'] }}
                      @if($eq['vencimiento'] !== '—')
                        • Vence: {{ $eq['vencimiento'] }}
                      @endif
                    </span>
                  </div>
                </div>
              </div>
            </td>

            <td>
              <div class="leading-none">
                <span>{{ $eq['empresa'] }}</span>
              </div>
              <div class="leading-none mt-1">
                <span class="text-[0.6875rem] text-[#8c9097] dark:text-white/50">
                  Cliente
                </span>
              </div>
            </td>

            <td>
              <span>{{ $eq['ubicacion'] }}</span>
            </td>

            <td>
              <span class="badge bg-{{ $eq['estado_color'] }}/10 text-{{ $eq['estado_color'] }}">
                <i class="ri-checkbox-circle-line align-middle me-1"></i>
                {{ $eq['estado'] }}
              </span>
            </td>

            <td class="text-[#8c9097] dark:text-white/50">
              {{ $eq['ultima_inspeccion'] }}
            </td>

            <td>
              <button
                class="ti-btn btn-wave ti-btn-icon ti-btn-sm ti-btn-info-full waves-effect waves-light"
                @click="openModal({{ $eq['id'] }})"
                title="Editar"
              >
                <i class="ri-edit-line"></i>
              </button>

              <button
                class="ti-btn btn-wave ti-btn-icon ti-btn-sm ti-btn-danger-full waves-effect waves-light"
                title="Eliminar"
              >
                <i class="ri-delete-bin-line"></i>
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>

    </table>
  </div>
</div>
