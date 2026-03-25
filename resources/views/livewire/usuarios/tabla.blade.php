{{-- resources/views/livewire/usuarios/tabla.blade.php --}}
<div
  class="box-body"
  x-data="{
    openModal(id){
      Livewire.dispatch('usuarios-modal:open',{
        id    : id,
        title : 'Editar usuario'
      });
    }
  }"
>
  <div class="overflow-hidden rounded-2xl border border-defaultborder bg-white shadow-sm ring-1 ring-black/5 dark:bg-[#0b1220] dark:border-white/10 dark:ring-white/10">
    <div class="table-responsive overflow-x-auto">
      <table class="table whitespace-nowrap ti-striped-table table-hover min-w-full ti-custom-table-hover">
        <thead class="bg-slate-50 text-slate-600 dark:bg-white/5 dark:text-slate-300">
          <tr class="border-b border-defaultborder dark:border-white/10">
            <th scope="col" class="text-start w-1 px-4 py-3 font-semibold">#</th>
            <th scope="col" class="text-start px-4 py-3 font-semibold">Usuarios</th>
            <th scope="col" class="text-start px-4 py-3 font-semibold">Estado</th>
            <th scope="col" class="text-start px-4 py-3 font-semibold">F. creación</th>
            <th scope="col" class="text-end w-1 px-4 py-3 font-semibold">Acciones</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-100 dark:divide-white/10">
          @forelse ($usuarios as $u)
            <tr class="border-b border-defaultborder dark:border-white/10 hover:bg-slate-50/70 dark:hover:bg-white/5 transition-colors">
              <th scope="row" class="px-4 py-3 text-slate-500 dark:text-slate-400">
                {{ $loop->iteration + ($usuarios->firstItem() - 1) }}
              </th>

              <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                  <div class="avatar avatar-sm me-2 avatar-rounded">
                    <img src="https://laravelui.spruko.com/tailwind/ynex/build/assets/images/faces/15.jpg" alt="img">
                  </div>

                  <div class="min-w-0">
                    <div class="leading-none font-semibold text-slate-900 dark:text-slate-100 truncate">
                      {{ $u->name }}
                    </div>
                    <div class="leading-none text-[0.75rem] text-[#8c9097] dark:text-white/50 truncate mt-1">
                      {{ $u->email }}
                    </div>
                  </div>
                </div>
              </td>

              <td class="px-4 py-3">
                @php $ok = (int)$u->estado === 1; @endphp
                <span class="inline-flex items-center gap-1 rounded-md px-2 py-1 text-xs font-semibold ring-1
                             {{ $ok
                                ? 'bg-emerald-50 text-emerald-700 ring-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-200 dark:ring-emerald-500/20'
                                : 'bg-rose-50 text-rose-700 ring-rose-200 dark:bg-rose-500/10 dark:text-rose-200 dark:ring-rose-500/20'
                             }}">
                  <iconify-icon icon="{{ $ok ? 'mdi:check-circle-outline' : 'mdi:close-circle-outline' }}" width="16"></iconify-icon>
                  {{ $ok ? 'Activo' : 'Inactivo' }}
                </span>
              </td>

              <td class="px-4 py-3 text-slate-700 dark:text-slate-200">
                {{ optional($u->created_at)->format('d/m/Y') }}
              </td>

              <td class="px-4 py-3">
                <div class="flex items-center justify-end gap-2">
                  {{-- EDITAR (solo icono) --}}
                  <button
                    type="button"
                    @click="openModal({{ $u->id }})"
                    class="ti-btn btn-wave ti-btn-sm !m-0 rounded-lg
                           h-9 w-9 p-0 inline-flex items-center justify-center
                           bg-sky-600 text-white ring-1 ring-sky-700/20 shadow-sm
                           hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-500/20
                           dark:bg-sky-500/90 dark:hover:bg-sky-500"
                    title="Editar"
                    aria-label="Editar"
                  >
                    <iconify-icon icon="mdi:pencil-outline" width="18"></iconify-icon>
                  </button>

                  {{-- ELIMINAR (solo icono) --}}
                  <button
                    type="button"
                    wire:click="$dispatch('usuarios-delete:confirm', { id: {{ $u->id }} })"
                    class="ti-btn btn-wave ti-btn-sm !m-0 rounded-lg
                           h-9 w-9 p-0 inline-flex items-center justify-center
                           bg-rose-50 text-rose-700 ring-1 ring-rose-200 shadow-sm
                           hover:bg-rose-100 focus:outline-none focus:ring-4 focus:ring-rose-500/20
                           dark:bg-rose-500/10 dark:text-rose-200 dark:ring-rose-500/20 dark:hover:bg-rose-500/20"
                    title="Eliminar"
                    aria-label="Eliminar"
                  >
                    <iconify-icon icon="mdi:trash-can-outline" width="18"></iconify-icon>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-4 py-10 text-center text-[#8c9097] dark:text-white/50">
                No se encontraron usuarios.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(method_exists($usuarios,'links'))
      <div class="border-t border-slate-100 px-4 py-3 dark:border-white/10">
        {{ $usuarios->links() }}
      </div>
    @endif
  </div>
</div>