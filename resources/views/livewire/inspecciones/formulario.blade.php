@php
    $empresaEquipo = $inspeccion?->empresaEquipo;
    $empresa = $empresaEquipo?->empresa;
    $servicio = $empresaEquipo?->servicio;
    $contacto = $empresa?->contactoPrincipal?->persona?->nombre_completo;
    $codigo = $inspeccion?->codigo_formateado ?: '26-0001';
    $estado = $inspeccion?->estado_inspeccion ?: 'borrador';
    $fechaInspeccion = optional($inspeccion?->fecha_ingreso)->format('d/m/Y') ?: now()->format('d/m/Y');
    $inspeccionIniciada = filled($inspeccion) && $estado !== 'borrador';
    $totalObservaciones = 8;
    $tieneObservaciones = $totalObservaciones > 0;
    $esBorrador = $estado === 'borrador';
    $fueObservadaAntes = in_array($estado, ['observado', 'subsanacion'], true);
    $inspeccionFinalizadaInicial = in_array($estado, ['observado', 'subsanacion', 'aprobado', 'rechazado', 'anulado'], true);
    $numeroInspeccion = $inspeccion?->id;
    $certificadoGenerado = (bool) ($inspeccion?->certificado_generado);
    $ultimoCertificado = $inspeccion?->certificados?->sortByDesc('fecha_vencimiento')->first();
    $vigenciaCertificadoVencida = filled($ultimoCertificado?->fecha_vencimiento)
        ? \Illuminate\Support\Carbon::parse($ultimoCertificado->fecha_vencimiento)->isPast()
        : false;
    $puedeEditarInspeccion = filled($inspeccion) && (!$certificadoGenerado || $vigenciaCertificadoVencida);
@endphp

<div x-data="{ step: @entangle('uiStep').live, started: @js($inspeccionIniciada), companyModal: @entangle('companyModal').live, companyStep: @entangle('companyStep').live, equipmentModal: @entangle('equipmentModal').live, inspectionDetailModal: @entangle('inspectionDetailModal').live, inspectionFilePreviewModal: @entangle('inspectionFilePreviewModal').live, customQuestionModal: false, observeModal: false, viewObservationModal: false, hasObservations: @js($tieneObservaciones), inspectionFinalized: @js($inspeccionFinalizadaInicial), remediationDueDate: '', certificateGenerated: @js((bool) ($inspeccion?->certificado_generado) && !$tieneObservaciones), openQuestionGroup: @entangle('uiOpenQuestionGroup').live, scrollTimer: null }" x-on:inspection-reset.window="started = false; step = 1; hasObservations = false; inspectionFinalized = false; remediationDueDate = ''; certificateGenerated = false" x-on:inspection-state.window="started = !!($event.detail.started ?? started); inspectionFinalized = !!($event.detail.inspectionFinalized ?? inspectionFinalized); if (($event.detail.step ?? null) !== null) step = $event.detail.step;" x-on:observation-form-ready.window="observeModal = true; viewObservationModal = false" x-on:observation-list-ready.window="viewObservationModal = true; observeModal = false" x-on:custom-question-ready.window="customQuestionModal = true" x-on:custom-question-saved.window="customQuestionModal = false; if($event.detail.groupKey){ openQuestionGroup = $event.detail.groupKey }" class="insp-ui mt-5 space-y-5">
    @include('livewire.inspecciones.partials.ui-theme')
    <template x-teleport="body">
        <div wire:loading.delay
             wire:target="selectEmpresa,clearSelectedEmpresa,openCompanyModal,saveCompany,selectEquipment,clearSelectedEquipment,openEquipmentModal,saveEquipment,startInspection,startObservedInspection,enableInspectionEdition,saveSubgroup,flushPendingResponses,prepareCustomQuestionModal,saveCustomQuestion,prepareObservationModal,openObservationList,saveObservation,attachInspectionFile,openInspectionFilePreview,deleteInspectionFile"
             class="fixed inset-x-0 top-0 z-[20001] pointer-events-none">
            <div class="insp-loading-bar w-full animate-pulse"></div>
        </div>
        <div wire:loading.delay.shortest
             wire:target="selectEmpresa,clearSelectedEmpresa,openCompanyModal,saveCompany,selectEquipment,clearSelectedEquipment,openEquipmentModal,saveEquipment,startInspection,startObservedInspection,enableInspectionEdition,saveSubgroup,flushPendingResponses,prepareCustomQuestionModal,saveCustomQuestion,prepareObservationModal,openObservationList,saveObservation,attachInspectionFile,openInspectionFilePreview,deleteInspectionFile"
             class="fixed right-4 top-3 z-[20002]">
            <div class="insp-loading-pill">
                <span class="insp-spinner"></span>
                Cargando...
            </div>
        </div>
    </template>
    <div class="md:flex block items-center justify-between page-header-breadcrumb">
        <div>
            <p class="font-semibold text-[1.125rem] text-defaulttextcolor !mb-0">{{ $inspeccion ? 'Actualizar inspección' : 'Nueva inspección' }}</p>
            <p class="font-normal text-[#8c9097] text-[0.813rem] mb-0">Prototipo visual del flujo de registro de inspección por secciones.</p>
        </div>
        <div class="mt-3 md:mt-0">
            <a href="{{ route('inspecciones.index') }}" class="ti-btn ti-btn-light"><i class="ri-arrow-left-line me-1"></i>Volver a la bandeja</a>
        </div>
    </div>

    <div class="insp-wizard">
        <button type="button" wire:click="flushPendingResponses" @click="step = 1"
                class="insp-wizard-item"
                :class="step === 1 ? 'is-active' : ''">
            <div class="insp-wizard-step">Paso 1</div>
            <div class="insp-wizard-title">Datos Generales</div>
        </button>
        <button type="button" @click="if (started) step = 2"
                class="insp-wizard-item"
                :class="(step === 2 ? 'is-active ' : '') + (!started ? 'is-locked' : '')"
                :disabled="!started">
            <div class="insp-wizard-step">Paso 2</div>
            <div class="insp-wizard-title">Inspección</div>
        </button>
        <button type="button" wire:click="flushPendingResponses" @click="if (started) step = 3"
                class="insp-wizard-item"
                :class="(step === 3 ? 'is-active ' : '') + (!started ? 'is-locked' : '')"
                :disabled="!started">
            <div class="insp-wizard-step">Paso 3</div>
            <div class="insp-wizard-title">Generación de Certificado</div>
        </button>
    </div>

    <div x-show="step === 1" x-transition.opacity.duration.250ms x-cloak class="space-y-4 transition-opacity duration-200">
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
                        <div class="mt-2 text-xl font-semibold">{{ strtoupper($quickSummary['estado']) }}</div>
                        @if (!empty($quickSummary['inspeccion_numero']))
                            <div class="mt-1 text-[0.8rem] text-primary">Inspección #{{ $quickSummary['inspeccion_numero'] }}</div>
                        @endif
                        <div class="mt-2 text-[0.88rem] text-[#8c9097]">{{ $quickSummary['descripcion'] }}</div>
                    </div>
                    <div class="rounded-xl bg-success/5 p-4">
                        <div class="text-[0.75rem] uppercase tracking-[0.16em] text-success">Accion principal</div>
                        @if ($quickSummary['show_start'])
                            <button type="button" class="ti-btn mt-3 w-full bg-success text-white" wire:click="startInspection">
                                <i class="ri-play-circle-line me-1"></i>Iniciar inspección
                            </button>
                        @endif
                        @if ($quickSummary['show_start_observed'])
                            <button type="button" class="ti-btn mt-3 w-full bg-warning text-white" wire:click="startObservedInspection">
                                <i class="ri-refresh-line me-1"></i>Iniciar inspección de observaciones
                            </button>
                        @endif
                        @if ($quickSummary['show_edit'])
                            <button type="button" class="ti-btn mt-3 w-full ti-btn-light" wire:click="enableInspectionEdition">
                                <i class="ri-edit-line me-1"></i>Editar
                            </button>
                        @endif
                        @if (!$quickSummary['show_start'] && !$quickSummary['show_start_observed'] && !$quickSummary['show_edit'])
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
                        <div class="rounded-xl border border-dashed border-defaultborder p-4 text-[0.9rem] text-[#8c9097]">No hay inspecciones registradas para este equipo.</div>
                    @endforelse
                </div></div>
            </div>
        </div>
    </div>

    <div x-show="step === 2" x-transition.opacity.duration.250ms x-cloak class="space-y-4 transition-opacity duration-200">
        <div class="box">
            <div class="box-body space-y-4">
                <fieldset :disabled="inspectionFinalized" :class="inspectionFinalized ? 'opacity-80' : ''" class="space-y-4">
                    <div class="grid grid-cols-12 gap-3">
                        <div class="col-span-12 md:col-span-6 rounded-xl border border-defaultborder bg-white px-4 py-3 shadow-sm">
                            <div class="flex items-center gap-3">
                                <span class="text-[0.78rem] font-semibold uppercase tracking-[0.12em]" style="color:#7c3aed;">INSPECCIÓN</span>
                                <span class="badge bg-primary/10 text-primary">{{ count($responsesInput) }} preguntas</span>
                            </div>
                        </div>
                        {{--  <div class="col-span-12 md:col-span-3 rounded-xl px-4 py-3" style="background-color:#f3e8ff;border:1px solid #d8b4fe;">
                            <span class="text-[0.78rem] font-semibold uppercase tracking-[0.12em]" style="color:#6d28d9;">Ingreso</span>
                        </div>
                        <div class="col-span-12 md:col-span-3 rounded-xl px-4 py-3" style="background-color:#dcfce7;border:1px solid #86efac;">
                            <span class="text-[0.78rem] font-semibold uppercase tracking-[0.12em]" style="color:#059669;">Salida</span>
                        </div> --}}
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl border border-defaultborder bg-white px-4 py-3 shadow-sm">
                        <div>
                            <div class="font-semibold text-[0.95rem] text-defaulttextcolor">Preguntas e inspección</div>
                            {{-- <div class="text-[0.78rem] text-[#8c9097]">Una sola categoría y subcategoría se muestran a la vez.</div> --}}
                        </div>
                    </div>

                    @forelse ($questionnaireGroups as $group)
                        <div class="rounded-2xl border border-defaultborder overflow-hidden bg-white shadow-sm">
                            <div role="button" tabindex="0"
                                 class="w-full text-left px-4 py-4 transition cursor-pointer"
                                 @click="
                                    const key = '{{ $group['key'] }}';
                                    openQuestionGroup = openQuestionGroup === key ? null : key;
                                    if (openQuestionGroup === key) {
                                        clearTimeout(scrollTimer);
                                        scrollTimer = setTimeout(() => {
                                            if ($el && $el.isConnected && openQuestionGroup === key) {
                                                const y = $el.getBoundingClientRect().top + window.scrollY - 96;
                                                window.scrollTo({ top: Math.max(y, 0), behavior: 'smooth' });
                                            }
                                        }, 240);
                                    }
                                 "
                                 @keydown.enter.prevent="
                                    const key = '{{ $group['key'] }}';
                                    openQuestionGroup = openQuestionGroup === key ? null : key;
                                    if (openQuestionGroup === key) {
                                        clearTimeout(scrollTimer);
                                        scrollTimer = setTimeout(() => {
                                            if ($el && $el.isConnected && openQuestionGroup === key) {
                                                const y = $el.getBoundingClientRect().top + window.scrollY - 96;
                                                window.scrollTo({ top: Math.max(y, 0), behavior: 'smooth' });
                                            }
                                        }, 240);
                                    }
                                 "
                                 :style="openQuestionGroup === '{{ $group['key'] }}' ? 'background-color:#e9d5ff;' : 'background-color:#f8fafc;'">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <div class="font-semibold" style="color:#4c1d95;">Categoría: {{ $group['categoria'] }}</div>
                                        <div class="mt-1 inline-flex items-center gap-2">
                                            <span class="inline-flex items-center rounded-full px-3 py-1 text-[0.72rem] font-medium" style="background-color:#c4b5fd;color:#3b0764;">
                                                Subcategoría: {{ $group['subcategoria'] }}
                                            </span>
                                            <button type="button"
                                                    class="ti-btn ti-btn-icon ti-btn-sm bg-primary text-white"
                                                    title="Agregar pregunta adicional"
                                                    wire:click="prepareCustomQuestionModal({{ $group['categoria_id'] }}, {{ $group['subcategoria_id'] }}, '{{ $group['key'] }}')"
                                                    @click.stop>
                                                <i class="ri-add-line"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="badge bg-primary/10 text-primary">{{ count($group['responses']) }} preguntas</span>
                                        <i class="ri-arrow-down-s-line text-[1.25rem] text-[#8c9097] transition-transform"
                                           :class="openQuestionGroup === '{{ $group['key'] }}' ? 'rotate-180' : ''"></i>
                                    </div>
                                </div>
                            </div>

                            <div x-show="openQuestionGroup === '{{ $group['key'] }}'" x-transition.opacity.duration.200ms class="border-t border-defaultborder overflow-x-auto">
                                <div class="min-w-[980px]">
                                <div class="grid grid-cols-12 bg-slate-50/80 border-b border-defaultborder">
                                    <div class="col-span-5 px-4 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#6b7280]">Pregunta</div>
                                    <div class="col-span-2 px-4 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#6d28d9]">Ingreso</div>
                                    <div class="col-span-2 px-4 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#059669]">Salida</div>
                                    <div class="col-span-2 px-4 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#6b7280]">N. observaciones</div>
                                    <div class="col-span-1 px-3 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#6b7280] text-right">Acc.</div>
                                </div>
                                <div class="divide-y divide-defaultborder">
                                    @foreach ($group['responses'] as $row)
                                        <div class="grid grid-cols-12">
                                            <div class="col-span-5 border-s-4 border-slate-200 bg-white px-4 py-5">
                                                <div class="font-medium">{{ $row['enunciado'] }}</div>
                                            </div>
                                            <div class="col-span-2 px-4 py-5" style="background-color:#e9d5ff;">
                                                @if ($row['ingreso_preguntar'])
                                                    @if ($row['ingreso_tipo'] === 'select')
                                                        <select class="form-control bg-white" wire:model.live="responsesInput.{{ $row['id'] }}.ingreso">
                                                            <option value="">Seleccione...</option>
                                                            @foreach ($row['ingreso_valores'] as $opt)
                                                                <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif ($row['ingreso_tipo'] === 'radio')
                                                        <div class="flex flex-wrap items-center gap-3 pt-2">
                                                            @forelse ($row['ingreso_valores'] as $opt)
                                                                <label class="inline-flex items-center gap-2 text-[0.86rem] text-defaulttextcolor">
                                                                    <input type="radio"
                                                                           class="form-check-input"
                                                                           value="{{ $opt['value'] }}"
                                                                           wire:model.live="responsesInput.{{ $row['id'] }}.ingreso">
                                                                    <span>{{ $opt['label'] }}</span>
                                                                </label>
                                                            @empty
                                                                <span class="text-[0.8rem] text-[#8c9097]">Sin opciones configuradas</span>
                                                            @endforelse
                                                        </div>
                                                    @else
                                                        <input type="text" class="form-control bg-white" placeholder="Respuesta ingreso" wire:model.live="responsesInput.{{ $row['id'] }}.ingreso">
                                                    @endif
                                                @else
                                                    <span class="text-[0.8rem] text-[#8c9097]">No aplica</span>
                                                @endif
                                            </div>
                                            <div class="col-span-2 px-4 py-5" style="background-color:#bbf7d0;">
                                                @if ($row['salida_preguntar'])
                                                    @if ($row['salida_tipo'] === 'select')
                                                        <select class="form-control bg-white" wire:model.live="responsesInput.{{ $row['id'] }}.salida">
                                                            <option value="">Seleccione...</option>
                                                            @foreach ($row['salida_valores'] as $opt)
                                                                <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif ($row['salida_tipo'] === 'radio')
                                                        <div class="flex flex-wrap items-center gap-3 pt-2">
                                                            @forelse ($row['salida_valores'] as $opt)
                                                                <label class="inline-flex items-center gap-2 text-[0.86rem] text-defaulttextcolor">
                                                                    <input type="radio"
                                                                           class="form-check-input"
                                                                           value="{{ $opt['value'] }}"
                                                                           wire:model.live="responsesInput.{{ $row['id'] }}.salida">
                                                                    <span>{{ $opt['label'] }}</span>
                                                                </label>
                                                            @empty
                                                                <span class="text-[0.8rem] text-[#8c9097]">Sin opciones configuradas</span>
                                                            @endforelse
                                                        </div>
                                                    @else
                                                        <input type="text" class="form-control bg-white" placeholder="Respuesta salida" wire:model.live="responsesInput.{{ $row['id'] }}.salida">
                                                    @endif
                                                @else
                                                    <span class="text-[0.8rem] text-[#8c9097]">No aplica</span>
                                                @endif
                                            </div>
                                            <div class="col-span-2 px-4 py-5">
                                                <div class="flex items-center gap-2">
                                                    <span class="inline-flex min-w-10 items-center justify-center rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">
                                                        {{ $row['observaciones_count'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-span-1 px-3 py-5">
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info-full"
                                                            wire:click="openObservationList({{ $row['id'] }})"
                                                            title="Ver observaciones">
                                                        <i class="ri-eye-line"></i>
                                                    </button>
                                                    <button type="button" class="ti-btn ti-btn-icon ti-btn-sm bg-warning text-white"
                                                            wire:click="prepareObservationModal({{ $row['id'] }})"
                                                            title="Registrar observación">
                                                        <i class="ri-add-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-xl border border-dashed border-defaultborder p-4 text-[0.9rem] text-[#8c9097]">
                            No hay preguntas configuradas para el equipo seleccionado o la inspección aún no fue iniciada.
                        </div>
                    @endforelse

                    <div class="insp-upload-panel p-4 md:p-5 space-y-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <div class="font-semibold uppercase tracking-[0.12em] text-[#4b5563] text-[0.82rem]">Subir archivos</div>
                                <div class="text-[0.78rem] text-[#8c9097]">Imágenes y PDF vinculados a la inspección.</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 lg:col-span-7">
                                <label class="flex min-h-[180px] cursor-pointer items-center justify-center rounded-2xl border border-dashed border-defaultborder bg-slate-50/70 px-4 text-center transition hover:border-primary/40 hover:bg-primary/5">
                                    <input type="file" class="hidden" wire:model="inspectionUploadFile" accept=".jpg,.jpeg,.png,.webp,.pdf">
                                    <div class="space-y-2">
                                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm text-primary">
                                            <i class="ri-upload-cloud-2-line text-[1.2rem]"></i>
                                        </div>
                                        <div class="text-[1rem] font-medium text-[#475569]">Arrastra el archivo aquí</div>
                                        <div class="text-[#8c9097] text-[0.82rem]">o elige un archivo desde tu equipo</div>
                                        <span class="ti-btn ti-btn-light">Seleccionar archivo</span>
                                        <div class="text-[0.74rem] text-[#8c9097]">Permitido: JPG, PNG, WEBP y PDF. Máx. 10MB.</div>
                                        @if ($inspectionUploadFile)
                                            <div class="text-[0.82rem] text-primary font-medium">Archivo seleccionado: {{ $inspectionUploadFile->getClientOriginalName() }}</div>
                                        @endif
                                    </div>
                                </label>
                                @error('inspectionUploadFile') <p class="mt-2 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 lg:col-span-5 space-y-3 rounded-2xl border border-defaultborder bg-slate-50/60 p-4">
                                <div>
                                    <label class="form-label">Nombre del archivo</label>
                                    <input type="text" class="form-control" wire:model.defer="inspectionFileForm.descripcion" placeholder="Ej: SOAT vigente">
                                    @error('inspectionFileForm.descripcion') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="rounded-xl border border-defaultborder bg-white p-3">
                                    <label class="inline-flex items-center gap-2 text-[0.9rem]">
                                        <input type="checkbox" class="form-check-input" wire:model.defer="inspectionFileForm.mostrar_certificado">
                                        <span>Mostrar archivo en el certificado</span>
                                    </label>
                                </div>
                                <button type="button" class="ti-btn w-full bg-primary text-white" wire:click="attachInspectionFile">
                                    <i class="ri-upload-cloud-2-line me-1"></i>Adjuntar archivo a la inspección
                                </button>
                            </div>
                        </div>

                        <div class="pt-4">
                            <div class="insp-divider mb-4"></div>
                            <div class="mb-3 flex items-center gap-3">
                                <div class="h-5 w-[3px] rounded-full bg-primary"></div>
                                <div class="text-lg font-semibold">Archivos cargados</div>
                            </div>
                            <div class="space-y-2">
                                @forelse ($inspectionFiles as $file)
                                    <div class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-3">
                                        <div class="flex flex-wrap items-center justify-between gap-3">
                                            <div>
                                                <div class="font-medium">{{ $file['descripcion'] }}</div>
                                                <div class="text-[0.8rem] text-[#8c9097]">
                                                    {{ strtoupper($file['tipo']) }} · {{ $file['fecha'] }} · {{ $file['mostrar_certificado'] ? 'Mostrar en certificado' : 'No mostrar en certificado' }}
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button type="button" class="ti-btn ti-btn-sm ti-btn-info-full" wire:click="openInspectionFilePreview({{ $file['id'] }})" @click="inspectionFilePreviewModal = true">
                                                    <i class="ri-eye-line me-1"></i>Visualizar
                                                </button>
                                                <button type="button" class="ti-btn ti-btn-sm ti-btn-danger-full" x-on:click="if(confirm('¿Deseas eliminar este archivo?')) { $wire.deleteInspectionFile({{ $file['id'] }}) }">
                                                    <i class="ri-delete-bin-line me-1"></i>Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-xl border border-dashed border-defaultborder p-4 text-[0.88rem] text-[#8c9097]">
                                        Aún no se adjuntaron archivos a esta inspección.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>

    <div x-show="step === 3" x-transition.opacity.duration.250ms x-cloak class="space-y-4 transition-opacity duration-200">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 xl:col-span-5">
                <div class="box h-full">
                    <div class="box-header"><div class="box-title !mb-0">Generación de certificado</div></div>
                    <div class="box-body space-y-4">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-4"><div class="rounded-2xl bg-danger/5 p-4"><div class="text-[0.75rem] uppercase tracking-[0.16em] text-danger">Observaciones</div><div class="mt-2 text-3xl font-semibold">{{ $totalObservaciones }}</div></div></div>
                            <div class="col-span-12 md:col-span-4"><div class="rounded-2xl bg-success/5 p-4"><div class="text-[0.75rem] uppercase tracking-[0.16em] text-success">Estado</div><div class="mt-2 text-xl font-semibold" x-text="inspectionFinalized ? (hasObservations ? 'Con observaciones' : 'Apto para emitir') : 'Inspección en proceso'"></div></div></div>
                            <div class="col-span-12 md:col-span-4"><div class="rounded-2xl bg-info/5 p-4"><div class="text-[0.75rem] uppercase tracking-[0.16em] text-info">Certificado</div><div class="mt-2 text-xl font-semibold" x-text="certificateGenerated ? 'Emitido' : 'No emitido'"></div></div></div>
                        </div>
                        <div class="rounded-2xl border border-defaultborder p-4">
                            <div class="grid grid-cols-12 gap-3 items-end">
                                <div class="col-span-12 md:col-span-7">
                                    <label class="form-label">Fecha plazo para subsanar observaciones</label>
                                    <input type="date" class="form-control" x-model="remediationDueDate" :disabled="inspectionFinalized">
                                </div>
                                <div class="col-span-12 md:col-span-5">
                                    <template x-if="!inspectionFinalized">
                                        <button type="button" class="ti-btn w-full bg-primary text-white" @click="inspectionFinalized = true">
                                            <i class="ri-checkbox-circle-line me-1"></i>Finalizar inspección
                                        </button>
                                    </template>
                                    <template x-if="inspectionFinalized">
                                        <button type="button" class="ti-btn w-full bg-success text-white disabled:opacity-60 disabled:cursor-not-allowed" :disabled="hasObservations" @click="if(!hasObservations){ certificateGenerated = true }" :title="hasObservations ? 'No se puede generar certificado mientras existan observaciones' : 'Generar certificado'">
                                            <i class="ri-award-line me-1"></i>Generar certificado
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-[0.92rem] text-[#8c9097]">La vista previa ocupa mas ancho y los botones principales se concentran debajo del documento para un cierre mas claro.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 xl:col-span-7">
                <div class="box h-full">
                    <div class="box-header"><div class="box-title !mb-0">Vista previa</div></div>
                    <div class="box-body space-y-4">
                        <div class="rounded-2xl border border-dashed border-defaultborder p-8 text-center min-h-[360px] flex flex-col justify-center">
                            <div class="text-[0.75rem] uppercase tracking-[0.18em] text-[#8c9097]">Documento</div>
                            <div class="mt-3 text-lg font-semibold">Certificado de inspección</div>
                            <div class="mt-2 text-[0.9rem] text-[#8c9097]">Aqui luego se podra mostrar un resumen previo del certificado antes de emitirlo.</div>
                        </div>
                        <div class="flex flex-wrap items-center justify-end gap-3 border-t border-defaultborder pt-4">
                            <template x-if="certificateGenerated">
                                <div class="flex flex-wrap items-center gap-3">
                                    <button type="button" class="ti-btn bg-primary text-white"><i class="ri-eye-line me-1"></i>Ver</button>
                                    <button type="button" class="ti-btn bg-danger text-white" @click="certificateGenerated = false"><i class="ri-close-circle-line me-1"></i>Anular certificado</button>
                                </div>
                            </template>
                        </div>
                        <p x-show="inspectionFinalized && hasObservations && !certificateGenerated" class="text-[0.82rem] text-danger mb-0">
                            No se puede generar certificado mientras existan observaciones pendientes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <template x-teleport="body">
    <div x-show="inspectionFilePreviewModal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="inspectionFilePreviewModal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full max-w-4xl rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                <div class="flex items-center justify-between border-b border-defaultborder px-6 py-4">
                    <div>
                        <h3 class="text-[15px] font-semibold">Archivo adjunto</h3>
                        <p class="mb-0 text-[0.78rem] text-[#8c9097]">{{ $inspectionFilePreview['descripcion'] ?? 'Sin descripción' }}</p>
                    </div>
                    <button type="button" class="text-slate-500" @click="inspectionFilePreviewModal = false"><i class="ri-close-line text-[1.35rem] leading-none"></i></button>
                </div>
                <div class="max-h-[75vh] overflow-auto px-6 py-5">
                    @if (($inspectionFilePreview['tipo'] ?? '') === 'pdf')
                        <iframe src="{{ $inspectionFilePreview['url'] ?? '' }}" class="h-[70vh] w-full rounded-xl border border-defaultborder"></iframe>
                    @elseif (($inspectionFilePreview['tipo'] ?? '') === 'imagen')
                        <img src="{{ $inspectionFilePreview['url'] ?? '' }}" alt="Archivo de inspección" class="mx-auto max-h-[70vh] rounded-xl border border-defaultborder">
                    @else
                        <div class="rounded-xl border border-dashed border-defaultborder p-4 text-[0.9rem] text-[#8c9097]">
                            No se pudo visualizar el archivo seleccionado.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </template>

    <template x-teleport="body">
        <div x-show="customQuestionModal" x-cloak class="fixed inset-0 z-[9999]">
            <div class="absolute inset-0 bg-slate-950/60" @click="customQuestionModal = false"></div>
            <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
                <div class="w-full max-w-xl rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                    <div class="flex items-center justify-between border-b border-defaultborder px-6 py-4"><h3 class="text-[15px] font-semibold">Nueva pregunta personalizada</h3><button type="button" class="text-slate-500" @click="customQuestionModal = false"><i class="ri-close-line text-[1.35rem] leading-none"></i></button></div>
                    <div class="px-6 py-5 space-y-4">
                        <div>
                            <label class="form-label">Enunciado</label>
                            <textarea class="form-control" rows="3" placeholder="Escribe la pregunta personalizada" wire:model.defer="customQuestionForm.enunciado"></textarea>
                            @error('customQuestionForm.enunciado') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Respuesta ingreso</label>
                                <input type="text" class="form-control" placeholder="Dato o respuesta de ingreso" wire:model.defer="customQuestionForm.ingreso_respuesta">
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Respuesta salida</label>
                                <input type="text" class="form-control" placeholder="Dato o respuesta de salida" wire:model.defer="customQuestionForm.salida_respuesta">
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 border-t border-defaultborder px-6 py-4">
                        <button type="button" class="ti-btn ti-btn-light" @click="customQuestionModal = false">Cancelar</button>
                        <button type="button" class="ti-btn bg-primary text-white" wire:click="saveCustomQuestion">Guardar pregunta</button>
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template x-teleport="body">
    <div x-show="viewObservationModal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="viewObservationModal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full max-w-xl rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                <div class="flex items-center justify-between border-b border-defaultborder px-6 py-4"><h3 class="text-[15px] font-semibold">Observaciones registradas</h3><button type="button" class="text-slate-500" @click="viewObservationModal = false"><i class="ri-close-line text-[1.35rem] leading-none"></i></button></div>
                <div class="px-6 py-5 space-y-3">
                    @forelse ($activeResponseObservations as $obs)
                        <div class="rounded-xl bg-warning/5 p-4">
                            <div class="font-medium text-warning">{{ $obs['tipo_observacion'] }} · {{ $obs['fecha'] }}</div>
                            <div class="mt-2 text-[0.9rem] text-[#8c9097]">{{ $obs['descripcion'] }}</div>
                        </div>
                    @empty
                        <div class="text-[0.9rem] text-[#8c9097]">No hay observaciones registradas para esta respuesta.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    </template>

    <template x-teleport="body">
    <div x-show="observeModal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="observeModal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full max-w-xl rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                <div class="flex items-center justify-between border-b border-defaultborder px-6 py-4"><h3 class="text-[15px] font-semibold">Registrar observación</h3><button type="button" class="text-slate-500" @click="observeModal = false"><i class="ri-close-line text-[1.35rem] leading-none"></i></button></div>
                <div class="px-6 py-5 space-y-4">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-6">
                            <label class="form-label">Momento</label>
                            <select class="form-control" wire:model.defer="observationForm.tipo_observacion">
                                <option value="Ingreso">Ingreso</option>
                                <option value="Salida">Salida</option>
                                <option value="Ambos">Ambos</option>
                            </select>
                            @error('observationForm.tipo_observacion') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Detalle de observación</label>
                        <textarea class="form-control" rows="4" placeholder="Describe la observación a subsanar" wire:model.defer="observationForm.descripcion"></textarea>
                        @error('observationForm.descripcion') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-defaultborder px-6 py-4">
                    <button type="button" class="ti-btn ti-btn-light" @click="observeModal = false">Cancelar</button>
                    <button type="button" class="ti-btn bg-warning text-white" wire:click="saveObservation">Guardar observación</button>
                </div>
            </div>
        </div>
    </div>
    </template>
    <template x-teleport="body">
    <div x-show="companyModal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="companyModal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full max-w-4xl rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                <div class="flex items-center justify-between border-b border-defaultborder px-6 py-4">
                    <div><h3 class="text-[15px] font-semibold">Registrar empresa</h3></div>
                    <button type="button" class="text-slate-500" @click="companyModal = false">
                        <i class="ri-close-line text-[1.35rem] leading-none"></i>
                    </button>
                </div>

                <div class="border-b border-defaultborder px-6 pt-2">
                    <div class="grid grid-cols-3">
                        <button type="button" wire:click="goToCompanyStep(1)" :class="companyStep === 1 ? 'text-primary border-b-[3px] border-primary bg-primary/5' : 'text-[#6b7280] border-b-[3px] border-transparent hover:bg-slate-50'" class="inline-flex items-center justify-center gap-2 px-4 py-3 transition">
                            <i class="ri-building-4-line text-[1.1rem]"></i>
                            <span class="text-[0.85rem] font-medium">Empresa</span>
                        </button>
                        <button type="button" wire:click="goToCompanyStep(2)" :class="companyStep === 2 ? 'text-primary border-b-[3px] border-primary bg-primary/5' : 'text-[#6b7280] border-b-[3px] border-transparent hover:bg-slate-50'" class="inline-flex items-center justify-center gap-2 px-4 py-3 transition">
                            <i class="ri-service-line text-[1.1rem]"></i>
                            <span class="text-[0.85rem] font-medium">Servicios</span>
                        </button>
                        <button type="button" wire:click="goToCompanyStep(3)" :class="companyStep === 3 ? 'text-primary border-b-[3px] border-primary bg-primary/5' : 'text-[#6b7280] border-b-[3px] border-transparent hover:bg-slate-50'" class="inline-flex items-center justify-center gap-2 px-4 py-3 transition">
                            <i class="ri-contacts-line text-[1.1rem]"></i>
                            <span class="text-[0.85rem] font-medium">Contacto</span>
                        </button>
                    </div>
                </div>

                <div class="max-h-[70vh] overflow-y-auto px-6 py-5">
                    <div x-show="companyStep === 1" x-cloak class="grid grid-cols-12 gap-4">
                        <div class="col-span-12 md:col-span-4">
                            <label class="form-label">Tipo <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                            <select class="form-control" wire:model.defer="empresaForm.tipo">
                                <option value="empresa">Empresa</option>
                                <option value="unidad_minera">Unidad minera</option>
                            </select>
                            @error('empresaForm.tipo') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-12 md:col-span-4">
                            <label class="form-label">RUC <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                            <input type="text" class="form-control" placeholder="Numero de RUC" wire:model.defer="empresaForm.ruc" wire:blur="validateCompanyRucOnBlur">
                            @error('empresaForm.ruc') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            @if ($companyLockedByRuc)
                                <p class="mt-1 text-xs text-danger">Empresa bloqueada para edicion en este modal porque ya tiene equipos registrados.</p>
                            @endif
                        </div>
                        <div class="col-span-12 md:col-span-4">
                            <label class="form-label">Teléfono</label>
                            <input type="text" class="form-control" placeholder="Telefono principal" wire:model.defer="empresaForm.telefono">
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label class="form-label">Razón social <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                            <input type="text" class="form-control" placeholder="Nombre legal" wire:model.defer="empresaForm.razon_social">
                            @error('empresaForm.razon_social') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label class="form-label">Nombre comercial <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                            <input type="text" class="form-control" placeholder="Nombre comercial" wire:model.defer="empresaForm.nombre_comercial">
                            @error('empresaForm.nombre_comercial') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="correo@empresa.com" wire:model.defer="empresaForm.email">
                            @error('empresaForm.email') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-12 md:col-span-6">
                            <label class="form-label">Dirección</label>
                            <input type="text" class="form-control" placeholder="Dirección principal" wire:model.defer="empresaForm.direccion">
                        </div>
                    </div>

                    <div x-show="companyStep === 2" x-cloak class="space-y-4">
                        <div class="rounded-xl bg-light p-4 text-[0.9rem] text-[#8c9097]">
                            Escribe el servicio. Si no existe, al presionar Enter se agregara automaticamente al catalogo y a la empresa.
                        </div>
                        <div class="relative">
                            <label class="form-label">Agregar servicio <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                            <input type="text" class="form-control" placeholder="Ej: Mantenimiento, transporte, izaje" wire:model.live.debounce.300ms="serviceSearch" wire:keydown.enter.prevent="addServiceFromInput">
                            @if (!empty($serviceSuggestions))
                                <div class="absolute z-20 mt-1 w-full rounded-xl border border-defaultborder bg-white shadow-lg">
                                    @foreach ($serviceSuggestions as $suggestion)
                                        <button type="button" class="w-full border-b border-defaultborder px-3 py-2 text-start text-sm last:border-b-0 hover:bg-slate-50" wire:click="selectService({{ $suggestion['id'] }})">
                                            {{ $suggestion['descripcion'] }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                            @error('serviceSearch') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @forelse ($companyServices as $service)
                                <span class="badge bg-primary/10 text-primary inline-flex items-center gap-2 text-[0.95rem] px-3 py-2">
                                    {{ $service['descripcion'] }}
                                    <button type="button" class="text-[1rem] leading-none" wire:click="removeService({{ $service['id'] }})">
                                        <i class="ri-close-line"></i>
                                    </button>
                                </span>
                            @empty
                                <span class="text-[0.85rem] text-[#8c9097]">Aún no agregaste servicios.</span>
                            @endforelse
                        </div>
                    </div>

                    <div x-show="companyStep === 3" x-cloak class="space-y-4">
                        <div class="rounded-xl border border-defaultborder p-4">
                            <div class="grid grid-cols-12 gap-4 items-end">
                                <div class="col-span-12 md:col-span-3">
                                    <label class="form-label">Tipo documento <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                    <select class="form-control" wire:model.defer="contactForm.tipo_documento">
                                        <option value="DNI">DNI</option>
                                        <option value="CE">CE</option>
                                        <option value="PAS">PAS</option>
                                    </select>
                                </div>
                                <div class="col-span-12 md:col-span-5">
                                    <label class="form-label">Numero <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                    <input type="text" class="form-control" placeholder="Numero de documento" wire:model.defer="contactForm.numero_documento" wire:keydown.enter.prevent="searchPersonaByDocumento" title="Presiona Enter para buscar. Si no existe, podras registrarlo manualmente.">
                                    @error('contactForm.numero_documento') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="col-span-12 md:col-span-4">
                                    <button type="button" class="ti-btn w-full bg-primary text-white" wire:click="searchPersonaByDocumento" title="Busca en catalogo de personas. Si no se encuentra, habilita registro manual."><i class="ri-search-line me-1"></i>Buscar persona</button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Nombres <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <input type="text" class="form-control" placeholder="Nombres" wire:model.defer="contactForm.nombres" @disabled(!$allowManualContact) style="{{ !$allowManualContact ? 'background-color:#eef1f5;cursor:not-allowed;' : '' }}">
                                @error('contactForm.nombres') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Apellido paterno <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <input type="text" class="form-control" placeholder="Apellido paterno" wire:model.defer="contactForm.apellido_paterno" @disabled(!$allowManualContact) style="{{ !$allowManualContact ? 'background-color:#eef1f5;cursor:not-allowed;' : '' }}">
                                @error('contactForm.apellido_paterno') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Apellido materno <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <input type="text" class="form-control" placeholder="Apellido materno" wire:model.defer="contactForm.apellido_materno" @disabled(!$allowManualContact) style="{{ !$allowManualContact ? 'background-color:#eef1f5;cursor:not-allowed;' : '' }}">
                                @error('contactForm.apellido_materno') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="correo@contacto.com" wire:model.defer="contactForm.email" @disabled(!$allowManualContact) style="{{ !$allowManualContact ? 'background-color:#eef1f5;cursor:not-allowed;' : '' }}">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" placeholder="Teléfono del contacto" wire:model.defer="contactForm.telefono" @disabled(!$allowManualContact) style="{{ !$allowManualContact ? 'background-color:#eef1f5;cursor:not-allowed;' : '' }}">
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label opacity-0">Accion</label>
                                <button type="button" class="ti-btn bg-success text-white w-full" wire:click="addCompanyContact">
                                    <i class="ri-user-add-line me-1"></i>Agregar contacto
                                </button>
                            </div>
                        </div>

                        <div class="rounded-xl border border-defaultborder p-3 space-y-2">
                            @forelse ($companyContacts as $index => $contact)
                                <div class="flex items-center justify-between rounded-lg bg-light px-3 py-2">
                                    <div>
                                        <div class="font-medium">
                                            {{ $contact['nombres'] }} {{ $contact['apellido_paterno'] }} {{ $contact['apellido_materno'] }}
                                            @if ($contact['principal'])
                                                <span class="badge bg-primary/10 text-primary ms-2">Principal</span>
                                            @endif
                                        </div>
                                        <div class="text-[0.75rem] text-[#8c9097]">{{ $contact['tipo_documento'] }}: {{ $contact['numero_documento'] }}</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if (!$contact['principal'])
                                            <button type="button" class="ti-btn ti-btn-sm ti-btn-light" wire:click="setPrimaryContact({{ $index }})">Hacer principal</button>
                                        @endif
                                        <button type="button" class="ti-btn ti-btn-sm ti-btn-danger-full" wire:click="removeCompanyContact({{ $index }})">Quitar</button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-[0.85rem] text-[#8c9097]">Aún no agregaste contactos.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-2 border-t border-defaultborder px-6 py-4">
                    <button type="button" class="ti-btn ti-btn-light" @click="companyModal = false">Cancelar</button>
                    <button type="button" class="ti-btn bg-primary text-white" wire:click="saveCompany">Guardar empresa</button>
                </div>
            </div>
        </div>
    </div>
    </template>

    <template x-teleport="body">
    <div x-show="inspectionDetailModal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="inspectionDetailModal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full max-w-5xl rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                <div class="flex items-center justify-between border-b border-defaultborder px-6 py-4">
                    <div>
                        <h3 class="text-[15px] font-semibold">Detalle de inspección</h3>
                        <p class="mb-0 text-[0.78rem] text-[#8c9097]">
                            {{ $inspectionDetailView['codigo'] ?? 'Sin código' }} · Estado: {{ $inspectionDetailView['estado'] ?? '-' }}
                        </p>
                    </div>
                    <button type="button" class="text-slate-500" @click="inspectionDetailModal = false"><i class="ri-close-line text-[1.35rem] leading-none"></i></button>
                </div>
                <div class="max-h-[70vh] overflow-y-auto px-6 py-5">
                    <div class="mb-3 text-[0.82rem] text-[#8c9097]">Fecha de ingreso: {{ $inspectionDetailView['fecha_ingreso'] ?? '-' }}</div>
                    <div class="overflow-auto rounded-xl border border-defaultborder">
                        <table class="ti-custom-table ti-custom-table-head whitespace-nowrap min-w-full">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Estado detalle</th>
                                    <th>Fecha</th>
                                    <th>Limite subsanacion</th>
                                    <th>Certificado</th>
                                    <th>Vencimiento certificado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (($inspectionDetailView['detalles'] ?? []) as $detalle)
                                    <tr>
                                        <td>{{ $detalle['numero'] }}</td>
                                        <td>{{ $detalle['estado'] }}</td>
                                        <td>{{ $detalle['fecha'] }}</td>
                                        <td>{{ $detalle['limite_subsanacion'] }}</td>
                                        <td>{{ $detalle['certificado_numero'] }}</td>
                                        <td>{{ $detalle['certificado_vencimiento'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-[#8c9097]">Sin detalles registrados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-defaultborder px-6 py-4">
                    <button type="button" class="ti-btn ti-btn-light" @click="inspectionDetailModal = false">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    </template>

    <template x-teleport="body">
    <div x-show="equipmentModal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="equipmentModal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full max-w-4xl rounded-2xl bg-white shadow-xl dark:bg-[#0b1220]">
                <div class="flex items-center justify-between border-b border-defaultborder px-6 py-4">
                    <h3 class="text-[15px] font-semibold">Registro manual del equipo</h3>
                    <button type="button" class="text-slate-500" @click="equipmentModal = false"><i class="ri-close-line text-[1.35rem] leading-none"></i></button>
                </div>
                <div class="max-h-[70vh] overflow-y-auto px-6 py-5 space-y-6">
                    <div>
                        <div class="mb-3 text-[0.78rem] font-semibold uppercase tracking-[0.14em] text-[#8c9097]">Datos generales</div>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-8 relative">
                                <label class="form-label">Descripcion</label>
                                <div class="flex items-center gap-2">
                                    <input type="text" class="form-control" placeholder="Describe el equipo para buscar en catalogo" wire:model.live.debounce.300ms="equipmentForm.descripcion_catalogo">
                                    <button type="button" class="ti-btn ti-btn-light"><i class="ri-search-line"></i></button>
                                </div>
                                @if (!empty($equipmentDescriptionSuggestions))
                                    <div class="absolute z-20 mt-1 w-full rounded-xl border border-defaultborder bg-white shadow-lg">
                                        @foreach ($equipmentDescriptionSuggestions as $suggestion)
                                            <button type="button" class="w-full border-b border-defaultborder px-3 py-2 text-start text-sm last:border-b-0 hover:bg-slate-50" wire:click="selectEquipmentCatalog({{ $suggestion['id'] }})">
                                                <div class="font-medium">{{ $suggestion['descripcion'] }}</div>
                                                <div class="text-[0.72rem] text-[#8c9097]">{{ collect([$suggestion['tipo'], $suggestion['categoria'], $suggestion['marca'], $suggestion['modelo'], $suggestion['anio']])->filter()->join(' · ') }}</div>
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Anio</label>
                                <input type="text" class="form-control" placeholder="2026" wire:model.defer="equipmentForm.anio">
                                @error('equipmentForm.anio') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-3 relative">
                                <label class="form-label">Tipo <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <input type="text" class="form-control" placeholder="Escribe y presiona Enter" wire:model.live.debounce.300ms="tipoSearch" wire:keydown.enter.prevent="addOrSelectTipoFromInput" wire:blur="syncTipoFromBlur">
                                @if (!empty($tipoSuggestions))
                                    <div class="absolute z-20 mt-1 w-full rounded-xl border border-defaultborder bg-white shadow-lg">
                                        @foreach ($tipoSuggestions as $item)
                                            <button type="button" class="w-full border-b border-defaultborder px-3 py-2 text-start text-sm last:border-b-0 hover:bg-slate-50" wire:click="selectTipo({{ $item['id'] }})">{{ $item['nombre'] }}</button>
                                        @endforeach
                                    </div>
                                @endif
                                @error('equipmentForm.tipo_id') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-3 relative">
                                <label class="form-label">Categoria <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <input type="text" class="form-control" placeholder="Escribe y presiona Enter" wire:model.live.debounce.300ms="categoriaSearch" wire:keydown.enter.prevent="addOrSelectCategoriaFromInput" wire:blur="syncCategoriaFromBlur">
                                @if (!empty($categoriaSuggestions))
                                    <div class="absolute z-20 mt-1 w-full rounded-xl border border-defaultborder bg-white shadow-lg">
                                        @foreach ($categoriaSuggestions as $item)
                                            <button type="button" class="w-full border-b border-defaultborder px-3 py-2 text-start text-sm last:border-b-0 hover:bg-slate-50" wire:click="selectCategoria({{ $item['id'] }})">{{ $item['nombre'] }}</button>
                                        @endforeach
                                    </div>
                                @endif
                                @error('equipmentForm.categoria_id') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-3 relative">
                                <label class="form-label">Marca <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <input type="text" class="form-control" placeholder="Escribe y presiona Enter" wire:model.live.debounce.300ms="marcaSearch" wire:keydown.enter.prevent="addOrSelectMarcaFromInput" wire:blur="syncMarcaFromBlur">
                                @if (!empty($marcaSuggestions))
                                    <div class="absolute z-20 mt-1 w-full rounded-xl border border-defaultborder bg-white shadow-lg">
                                        @foreach ($marcaSuggestions as $item)
                                            <button type="button" class="w-full border-b border-defaultborder px-3 py-2 text-start text-sm last:border-b-0 hover:bg-slate-50" wire:click="selectMarca({{ $item['id'] }})">{{ $item['nombre'] }}</button>
                                        @endforeach
                                    </div>
                                @endif
                                @error('equipmentForm.marca_id') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-3 relative">
                                <label class="form-label">Modelo <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <input type="text" class="form-control" placeholder="Escribe y presiona Enter" wire:model.live.debounce.300ms="modeloSearch" wire:keydown.enter.prevent="addOrSelectModeloFromInput" wire:blur="syncModeloFromBlur">
                                @if (!empty($modeloSuggestions))
                                    <div class="absolute z-20 mt-1 w-full rounded-xl border border-defaultborder bg-white shadow-lg">
                                        @foreach ($modeloSuggestions as $item)
                                            <button type="button" class="w-full border-b border-defaultborder px-3 py-2 text-start text-sm last:border-b-0 hover:bg-slate-50" wire:click="selectModelo({{ $item['id'] }})">{{ $item['nombre'] }}</button>
                                        @endforeach
                                    </div>
                                @endif
                                @error('equipmentForm.modelo_id') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="mb-3 text-[0.78rem] font-semibold uppercase tracking-[0.14em] text-[#8c9097]">Datos especificos del equipo</div>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Descripcion para la empresa <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <input type="text" class="form-control" placeholder="Descripcion operativa" wire:model.defer="equipmentForm.descripcion_empresa">
                                @error('equipmentForm.descripcion_empresa') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label class="form-label">Servicio</label>
                                <select class="form-control" wire:model.defer="equipmentForm.servicio_id">
                                    <option value="">Selecciona servicio</option>
                                    @foreach ($empresaServiceOptions as $serviceOption)
                                        <option value="{{ $serviceOption['id'] }}">{{ $serviceOption['descripcion'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-12 md:col-span-4">
                                <label class="form-label">Tipo identificador <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <select class="form-control" wire:model.live="equipmentForm.serie_tipo">
                                    <option value="placa">Placa</option>
                                    <option value="codigo">Código</option>
                                    <option value="serie">Serie</option>
                                </select>
                                @error('equipmentForm.serie_tipo') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 md:col-span-8">
                                <label class="form-label">Identificador ({{ $equipmentForm['serie_tipo'] ?: 'codigo' }}) <span title="Campo obligatorio" style="color:#dc2626;">*</span></label>
                                <input type="text" class="form-control" placeholder="Ingresa identificador unico" wire:model.defer="equipmentForm.serie_codigo">
                                @error('equipmentForm.serie_codigo') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 border-t border-defaultborder px-6 py-4">
                    <button type="button" class="ti-btn ti-btn-light" @click="equipmentModal = false">Cancelar</button>
                    <button type="button" class="ti-btn bg-success text-white" wire:click="saveEquipment">Guardar equipo</button>
                </div>
            </div>
        </div>
    </div>
    </template>
</div>
