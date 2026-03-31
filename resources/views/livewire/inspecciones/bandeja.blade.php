<div x-data="{ advancedFilters: false }" class="mt-5 space-y-5">
    <div class="md:flex block items-center justify-between page-header-breadcrumb">
        <div>
            <p class="font-semibold text-[1.125rem] text-defaulttextcolor !mb-0">Inspecciones</p>
            <p class="font-normal text-[#8c9097] text-[0.813rem] mb-0">
                Consulta el estado de las inspecciones y accede al registro del equipo inspeccionado.
            </p>
        </div>
        <div class="mt-3 md:mt-0">
            <a href="{{ route('inspecciones.create') }}"
                class="ti-btn btn-wave bg-primary text-white !font-medium !rounded-[0.35rem] !py-[0.6rem] !px-4 shadow-none">
                <i class="ri-add-line me-1"></i>Nueva inspeccion
            </a>
        </div>
    </div>

    <div class="grid grid-cols-12 gap-4">
        @foreach ($cards as $card)
            <div class="col-span-12 sm:col-span-6 xl:col-span-3">
                <div class="overflow-hidden rounded-2xl text-white shadow-sm" style="{{ $card['style'] }}">
                    <div class="p-5">
                        <div class="text-[0.78rem] uppercase tracking-[0.18em] text-white/80">{{ $card['label'] }}</div>
                        <div class="mt-3 text-3xl font-semibold leading-none">{{ number_format($card['count']) }}</div>
                        <div class="mt-2 text-sm text-white/80">{{ $card['hint'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="box overflow-hidden">
        <div class="box-header">
            <div>
                <div class="box-title !mb-0">Bandeja de inspecciones</div>
                <p class="text-[0.78rem] text-[#8c9097] mb-0">Filtra por estado, empresa, equipo, servicio, fecha y texto libre.</p>
            </div>
        </div>
        <div class="box-body space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div class="flex flex-1 flex-wrap items-center gap-2">
                    <div class="min-w-[260px] flex-1">
                        <input type="text" class="form-control" wire:model.defer="texto"
                            placeholder="Buscar por equipo o serie/codigo">
                    </div>
                    <button type="button" class="ti-btn ti-btn-light" @click="advancedFilters = !advancedFilters">
                        <i class="ri-equalizer-line me-1"></i>Filtro avanzado
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" class="ti-btn ti-btn-light" wire:click="limpiarFiltros">
                        Limpiar
                    </button>
                    <button type="button" class="ti-btn bg-primary text-white" wire:click="buscar">
                        Buscar
                    </button>
                </div>
            </div>

            <div x-show="advancedFilters" x-collapse class="rounded-xl border border-defaultborder p-3">
                <div class="grid grid-cols-12 gap-3">
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">
                        <div class="flex items-center gap-2">
                            <label class="form-label !mb-0 min-w-[60px]">Estado</label>
                            <select class="form-control" wire:model.live="estadoFiltro">
                                <option value="">Todos</option>
                                @foreach ($estadoOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">
                        <div class="flex items-center gap-2">
                            <label class="form-label !mb-0 min-w-[70px]">Empresa</label>
                            <select class="form-control" wire:model.live="empresaFiltro">
                                <option value="">Todas</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->razon_social ?: $empresa->nombre_comercial }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">
                        <div class="flex items-center gap-2">
                            <label class="form-label !mb-0 min-w-[62px]">Equipo</label>
                            <select class="form-control" wire:model.live="equipoFiltro">
                                <option value="">Todos</option>
                                @foreach ($equipos as $equipo)
                                    <option value="{{ $equipo->id }}">{{ $equipo->descripcion ?: $equipo->serie_codigo }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">
                        <div class="flex items-center gap-2">
                            <label class="form-label !mb-0 min-w-[68px]">Servicio</label>
                            <select class="form-control" wire:model.live="servicioFiltro">
                                <option value="">Todos</option>
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">
                        <div class="flex items-center gap-2">
                            <label class="form-label !mb-0 min-w-[54px]">Desde</label>
                            <input type="date" class="form-control" wire:model.live="fechaDesde">
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-6 xl:col-span-4">
                        <div class="flex items-center gap-2">
                            <label class="form-label !mb-0 min-w-[54px]">Hasta</label>
                            <input type="date" class="form-control" wire:model.live="fechaHasta">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box overflow-hidden">
        <div class="box-body !p-0">
            <div class="table-responsive">
                <table class="table min-w-full whitespace-nowrap table-hover">
                    <thead>
                        <tr class="border-b border-defaultborder">
                            <th class="text-start">Codigo</th>
                            <th class="text-start">Empresa</th>
                            <th class="text-start">Servicio</th>
                            <th class="text-start">Equipo</th>
                            <th class="text-start">Estado</th>
                            <th class="text-start">Contacto</th>
                            <th class="text-start">Fecha inspeccion</th>
                            <th class="text-start">Plazo subsanar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $estadoBadge = [
                                'borrador' => 'bg-light text-defaulttextcolor',
                                'en_inspeccion' => 'bg-primary/10 text-primary',
                                'observado' => 'bg-warning/10 text-warning',
                                'subsanacion' => 'bg-info/10 text-info',
                                'aprobado' => 'bg-success/10 text-success',
                                'rechazado' => 'bg-danger/10 text-danger',
                                'anulado' => 'bg-dark/10 text-dark',
                            ];
                            $estadoLabel = [
                                'borrador' => 'Borrador',
                                'en_inspeccion' => 'En inspeccion',
                                'observado' => 'Pendiente de subsanar',
                                'subsanacion' => 'En subsanacion',
                                'aprobado' => 'Aprobado',
                                'rechazado' => 'No subsanada',
                                'anulado' => 'Anulado',
                            ];
                        @endphp

                        @forelse ($inspecciones as $inspeccion)
                            @php
                                $empresa = $inspeccion->empresaEquipo?->empresa;
                                $servicio = $inspeccion->empresaEquipo?->servicio;
                                $empresaEquipo = $inspeccion->empresaEquipo;
                                $contacto = $empresa?->contactoPrincipal;
                                $contactoNombre = $contacto?->persona?->nombre_completo ?: ($contacto?->telefono ?: 'Sin contacto');
                                $plazo = $inspeccion->ultimoDetalle?->correcion_vigencia_fecha;
                                $equipoTexto = $empresaEquipo?->descripcion ?: ($empresaEquipo?->equipo?->descripcion ?: 'Sin descripcion');
                            @endphp
                            <tr class="cursor-pointer border-b border-defaultborder hover:bg-primary/5"
                                onclick="window.location='{{ route('inspecciones.edit', $inspeccion) }}'">
                                <td class="font-semibold">{{ $inspeccion->codigo_formateado ?: 'Sin codigo' }}</td>
                                <td>
                                    <div>{{ $empresa?->razon_social ?: 'Sin empresa' }}</div>
                                    @if ($empresa?->nombre_comercial)
                                        <div class="text-[0.75rem] text-[#8c9097]">{{ $empresa->nombre_comercial }}</div>
                                    @endif
                                </td>
                                <td>{{ $servicio?->descripcion ?: 'Sin servicio' }}</td>
                                <td>
                                    <div>{{ $equipoTexto }}</div>
                                    @if ($empresaEquipo?->serie_codigo)
                                        <div class="text-[0.75rem] text-[#8c9097]">{{ $empresaEquipo->serie_tipo }}: {{ $empresaEquipo->serie_codigo }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $estadoBadge[$inspeccion->estado_inspeccion] ?? 'bg-light text-defaulttextcolor' }}">
                                        {{ $estadoLabel[$inspeccion->estado_inspeccion] ?? $inspeccion->estado_inspeccion }}
                                    </span>
                                    @if ($inspeccion->certificado_generado)
                                        <div class="mt-1 text-[0.72rem] text-success">Certificado emitido</div>
                                    @endif
                                </td>
                                <td>{{ $contactoNombre }}</td>
                                <td>{{ optional($inspeccion->fecha_ingreso)->format('d/m/Y') ?: 'Sin fecha' }}</td>
                                <td>{{ optional($plazo)->format('d/m/Y') ?: 'Sin plazo' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="py-10 text-center text-[#8c9097]">
                                    No se encontraron inspecciones con los filtros actuales.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($inspecciones->hasPages())
            <div class="border-t border-defaultborder px-4 py-3">
                {{ $inspecciones->links() }}
            </div>
        @endif
    </div>
</div>
