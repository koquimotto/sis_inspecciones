<div
  class="box-body"
  x-data="{
    openModal(id){
      Livewire.dispatch('personas-modal:open',{
        id: id,
        title: 'Editar persona'
      });
    }
  }"
>
  <div class="table-responsive">
    <table class="table whitespace-nowrap ti-striped-table table-hover min-w-full ti-custom-table-hover">
      <thead>
        <tr class="border-b border-defaultborder">
          <th scope="col" class="text-start w-1">#</th>
          <th scope="col" class="text-start">Persona</th>
          <th scope="col" class="text-start">Rol</th>
          <th scope="col" class="text-start">Empresa</th>
          <th scope="col" class="text-start">Teléfono</th>
          <th scope="col" class="text-start">Correo</th>
          <th scope="col" class="text-start">Estado</th>
          <th scope="col" class="text-start">F. registro</th>
          <th scope="col" class="text-start w-1"></th>
        </tr>
      </thead>

      <tbody>
        @php
          $personas = [
            [
              'id' => 1,
              'dni' => '70112233',
              'nombres' => 'José Luis Paredes',
              'cargo' => 'Inspector',
              'empresa' => 'EL CUMBE E.I.R.L.',
              'telefono' => '+51 987 111 000',
              'correo' => 'jose.paredes@elcumbe.pe',
              'estado' => 'Activo',
              'estado_color' => 'success',
              'created_at' => '09/02/2026',
            ],
            [
              'id' => 2,
              'dni' => '40998877',
              'nombres' => 'Carla Gómez Ruiz',
              'cargo' => 'Responsable técnico',
              'empresa' => 'COMINSA S.A.C.',
              'telefono' => '+51 950 333 444',
              'correo' => 'carla.gomez@cominsa.pe',
              'estado' => 'Activo',
              'estado_color' => 'success',
              'created_at' => '02/02/2026',
            ],
            [
              'id' => 3,
              'dni' => '08887766',
              'nombres' => 'Miguel Salazar',
              'cargo' => 'Representante',
              'empresa' => 'ZETROON TECHNOLOGY S.A.C.',
              'telefono' => '+51 999 222 333',
              'correo' => 'miguel.salazar@zetroon.pe',
              'estado' => 'Inactivo',
              'estado_color' => 'danger',
              'created_at' => '18/01/2026',
            ],
          ];
        @endphp

        @foreach ($personas as $p)
          <tr class="border-b border-defaultborder">
            <th scope="row">{{ $loop->iteration }}</th>

            <td>
              <div class="flex items-center">
                <div class="avatar avatar-sm me-2 avatar-rounded">
                  <img src="https://laravelui.spruko.com/tailwind/ynex/build/assets/images/faces/15.jpg" alt="img">
                </div>

                <div class="min-w-0">
                  <div class="leading-none">
                    <span class="font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70">
                      {{ $p['nombres'] }}
                    </span>
                  </div>
                  <div class="leading-none mt-1">
                    <span class="text-[0.6875rem] text-[#8c9097] dark:text-white/50">
                      DNI: {{ $p['dni'] }}
                    </span>
                  </div>
                </div>
              </div>
            </td>

            <td>
              <span class="badge bg-primary/10 text-primary">
                <i class="ri-briefcase-2-line align-middle me-1"></i>
                {{ $p['cargo'] }}
              </span>
            </td>

            <td>{{ $p['empresa'] }}</td>
            <td>{{ $p['telefono'] }}</td>
            <td class="text-[#8c9097] dark:text-white/50">{{ $p['correo'] }}</td>

            <td>
              <span class="badge bg-{{ $p['estado_color'] }}/10 text-{{ $p['estado_color'] }}">
                <i class="ri-check-fill align-middle me-1"></i>{{ $p['estado'] }}
              </span>
            </td>

            <td class="text-[#8c9097] dark:text-white/50">{{ $p['created_at'] }}</td>

            <td>
              <button
                class="ti-btn btn-wave ti-btn-icon ti-btn-sm ti-btn-info-full waves-effect waves-light"
                @click="openModal({{ $p['id'] }})"
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