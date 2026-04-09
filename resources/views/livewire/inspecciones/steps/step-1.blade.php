<div class="space-y-4 transition-opacity duration-200">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 xl:col-span-8">
                <div class="box"><div class="box-header"><div class="box-title !mb-0">Datos generales de la inspección</div></div><div class="box-body space-y-5">
                    @if (!$esBorrador)
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Código de inspección</label>
                                <input type="text" readonly value="{{ $codigo }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Número de inspección</label>
                                <input type="text" readonly value="{{ $numeroInspeccion ?: 'Sin número' }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                        </div>
                    @endif
                    <fieldset :disabled="inspectionFinalized" :class="inspectionFinalized ? 'opacity-80' : ''" class="space-y-5">
                    <div class="rounded-2xl border border-defaultborder p-4">
                        <div class="mb-4 border-b border-primary/30 pb-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="font-semibold whitespace-nowrap">Empresa y datos de contacto</div>
                                <div class="flex flex-1 flex-wrap items-center gap-2 min-w-[260px]">
                                    <div class="flex-1 min-w-[220px] relative">
                                        <input type="text" class="form-control" placeholder="Busca empresa" wire:model.live.debounce.300ms="empresaSearch">
                                        @if (!empty($empresaSuggestions))
                                            <div class="absolute z-20 mt-1 w-full rounded-xl border border-defaultborder bg-white shadow-lg">
                                                @foreach ($empresaSuggestions as $suggestion)
                                                    <button type="button" class="w-full border-b border-defaultborder px-3 py-2 text-start text-sm last:border-b-0 hover:bg-slate-50" wire:click="selectEmpresa({{ $suggestion['id'] }})">
                                                        <div class="font-medium">{{ $suggestion['razon_social'] }}</div>
                                                        <div class="text-[0.72rem] text-[#8c9097]">
                                                            {{ $suggestion['nombre_comercial'] ?: 'Sin nombre comercial' }} · {{ $suggestion['ruc'] ?: 'Sin RUC' }}
                                                        </div>
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="ti-btn ti-btn-light !mb-0"><i class="ri-search-line"></i></button>
                                    @if ($selectedEmpresaId)
                                        <button type="button" class="ti-btn bg-danger text-white" wire:click="clearSelectedEmpresa"><i class="ri-eraser-line me-1"></i>Limpiar datos de la empresa</button>
                                    @else
                                        <button type="button" class="ti-btn bg-primary text-white" wire:click="openCompanyModal"><i class="ri-add-line me-1"></i>Nuevo</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Nombre comercial</label>
                                <input type="text" readonly value="{{ $empresaResumen['nombre_comercial'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Razón social</label>
                                <input type="text" readonly value="{{ $empresaResumen['razon_social'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">RUC</label>
                                <input type="text" readonly value="{{ $empresaResumen['ruc'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Unidad minera</label>
                                <input type="text" readonly value="{{ $empresaResumen['unidad_minera'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Servicios</label>
                                <input type="text" readonly value="{{ $empresaResumen['servicios'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Teléfono empresa</label>
                                <input type="text" readonly value="{{ $empresaResumen['telefono_empresa'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Dirección</label>
                                <input type="text" readonly value="{{ $empresaResumen['direccion'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Contacto principal</label>
                                <input type="text" readonly value="{{ $empresaResumen['contacto_principal'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Teléfono del contacto</label>
                                <input type="text" readonly value="{{ $empresaResumen['telefono_contacto'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                        </div>
                    </div>
                    <div class="rounded-2xl border border-defaultborder p-4">
                        <div class="mb-4 border-b border-primary/30 pb-3">
                            <div class="flex flex-wrap items-center gap-3">
                                <div class="font-semibold whitespace-nowrap">Vehículo / equipo</div>
                                <div class="flex flex-1 flex-wrap items-center gap-2 min-w-[260px]">
                                    <div class="flex-1 min-w-[220px] relative">
                                        <input type="text" class="form-control" placeholder="Busca equipo" wire:model.live.debounce.300ms="equipmentSearch" @disabled(!$selectedEmpresaId) style="{{ !$selectedEmpresaId ? 'cursor:not-allowed;background-color:#eef1f5;' : '' }}">
                                        @if (!empty($equipmentSuggestions))
                                            <div class="absolute z-20 mt-1 w-full rounded-xl border border-defaultborder bg-white shadow-lg">
                                                @foreach ($equipmentSuggestions as $suggestion)
                                                    <button type="button" class="w-full border-b border-defaultborder px-3 py-2 text-start text-sm last:border-b-0 hover:bg-slate-50" wire:click="selectEquipment({{ $suggestion['id'] }})">
                                                        <div class="font-medium">{{ $suggestion['descripcion'] }}</div>
                                                        <div class="text-[0.72rem] text-[#8c9097]">{{ $suggestion['detalle'] ?: 'Sin detalle' }}</div>
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="ti-btn ti-btn-light !mb-0" @disabled(!$selectedEmpresaId) style="{{ !$selectedEmpresaId ? 'cursor:not-allowed;opacity:.65;' : '' }}"><i class="ri-search-line"></i></button>
                                    @if ($selectedEmpresaEquipoId)
                                        <button type="button" class="ti-btn bg-danger text-white" wire:click="clearSelectedEquipment"><i class="ri-eraser-line me-1"></i>Limpiar datos del vehiculo</button>
                                    @else
                                        <button type="button" class="ti-btn bg-success text-white" wire:click="openEquipmentModal" @disabled(!$selectedEmpresaId) style="{{ !$selectedEmpresaId ? 'cursor:not-allowed;opacity:.65;' : '' }}"><i class="ri-add-line me-1"></i>Registrar vehiculo</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (!$selectedEmpresaId)
                            <div class="mb-3 text-[0.82rem] text-warning">Selecciona una empresa para habilitar la busqueda y el registro de equipo.</div>
                        @endif
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Descripcion</label>
                                <input type="text" readonly value="{{ $equipoResumen['descripcion'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Anio</label>
                                <input type="text" readonly value="{{ $equipoResumen['anio'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Tipo identificador</label>
                                <input type="text" readonly value="{{ $equipoResumen['serie_tipo'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Identificador</label>
                                <input type="text" readonly value="{{ $equipoResumen['serie_codigo'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Servicio</label>
                                <input type="text" readonly value="{{ $equipoResumen['servicio'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Tipo</label>
                                <input type="text" readonly value="{{ $equipoResumen['tipo'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Categoria</label>
                                <input type="text" readonly value="{{ $equipoResumen['categoria'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Marca</label>
                                <input type="text" readonly value="{{ $equipoResumen['marca'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                            <div class="col-span-12 md:col-span-3">
                                <label class="form-label">Modelo</label>
                                <input type="text" readonly value="{{ $equipoResumen['modelo'] }}" class="form-control cursor-not-allowed" style="background-color: #eef1f5;">
                            </div>
                        </div>
                    </div>
                    </fieldset>
                </div></div>
            </div>
            <div class="col-span-12 xl:col-span-4 space-y-4">
                <div class="box"><div class="box-header"><div class="box-title !mb-0">Resumen rápido</div></div><div class="box-body space-y-4">
                    <div class="rounded-xl bg-primary/5 p-4">
                        <div class="text-[0.75rem] uppercase tracking-[0.16em] text-primary">Estado</div>
                        <div class="mt-2 text-xl font-semibold">{{ strtoupper(str_replace('_', ' ', $quickSummary['estado'])) }}</div>
                        @if (!empty($quickSummary['inspeccion_numero']))
                            <div class="mt-1 text-[0.8rem] text-primary">Inspección #{{ $quickSummary['inspeccion_numero'] }}</div>
                        @endif
                        <div class="mt-2 text-[0.88rem] text-[#8c9097]">{{ $quickSummary['descripcion'] }}</div>
                    </div>
                    <div class="rounded-xl bg-success/5 p-4">
                        <div class="text-[0.75rem] uppercase tracking-[0.16em] text-success">Accion principal</div>
                        @if ($quickSummary['show_create'])
                            <button type="button" class="ti-btn mt-3 w-full bg-success text-white" wire:click="startInspection">
                                <i class="ri-add-circle-line me-1"></i>Crear inspección
                            </button>
                        @endif
                        @if ($quickSummary['show_start_observed'])
                            <button type="button" class="ti-btn mt-3 w-full bg-warning text-white" wire:click="startObservedInspection">
                                <i class="ri-refresh-line me-1"></i>Inspeccionar observaciones
                            </button>
                        @endif
                        @if ($quickSummary['show_continue'])
                            <button type="button" class="ti-btn mt-3 w-full bg-info text-white" wire:click="continueInspection">
                                <i class="ri-play-circle-line me-1"></i>Continuar inspección
                            </button>
                        @endif
                        @if ($quickSummary['show_view'])
                            <button type="button" class="ti-btn mt-3 w-full bg-secondary text-white" wire:click="viewInspection">
                                <i class="ri-eye-line me-1"></i>Ver inspección
                            </button>
                        @endif
                        @if (!$quickSummary['show_create'] && !$quickSummary['show_start_observed'] && !$quickSummary['show_continue'] && !$quickSummary['show_view'])
                            <div class="mt-3 text-[0.82rem] text-[#8c9097]">No hay acciones disponibles hasta seleccionar un equipo.</div>
                        @endif
                    </div>
                </div></div>
                <div class="box"><div class="box-header"><div class="box-title !mb-0">Historial de inspecciones</div></div><div class="box-body space-y-3">
                    @forelse ($inspectionHistory as $item)
                        <div class="rounded-xl border border-defaultborder p-4">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <div class="font-semibold">{{ $item['codigo'] }}</div>
                                    <div class="text-[0.78rem] text-[#8c9097]">{{ $item['fecha'] }} · {{ $item['estado'] }}</div>
                                    <div class="text-[0.76rem] text-[#8c9097]">Vencimiento: {{ $item['vencimiento'] }}</div>
                                </div>
                                <button type="button" class="ti-btn ti-btn-sm ti-btn-light" wire:click="openInspectionDetail({{ $item['id'] }})" title="Ver inspección y detalles">
                                    <i class="ri-eye-line"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        @if (empty($selectedEmpresaEquipoId))
                            <div class="rounded-xl border border-dashed border-defaultborder p-4 text-[0.9rem] text-[#8c9097]">No se ha seleccionado ningun equipo/vehiculo. Selecciona un vehiculo para visualizar el historial.</div>
                        @else
                            <div class="rounded-xl border border-dashed border-defaultborder p-4 text-[0.9rem] text-[#8c9097]">No hay inspecciones registradas para este equipo.</div>
                        @endif
                    @endforelse
                </div></div>
            </div>
        </div>
    </div>

