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
    $inspeccionFinalizadaInicial = in_array($estado, ['observado', 'aprobado', 'rechazado', 'anulado'], true);
    $numeroInspeccion = $inspeccion?->id;
    $certificadoGenerado = (bool) ($inspeccion?->certificado_generado);
    $ultimoCertificado = $inspeccion?->certificados?->sortByDesc('fecha_vencimiento')->first();
    $vigenciaCertificadoVencida = filled($ultimoCertificado?->fecha_vencimiento)
        ? \Illuminate\Support\Carbon::parse($ultimoCertificado->fecha_vencimiento)->isPast()
        : false;
    $puedeEditarInspeccion = filled($inspeccion) && (!$certificadoGenerado || $vigenciaCertificadoVencida);
@endphp

<div x-data="{ step: @entangle('uiStep').live, started: @js($inspeccionIniciada), companyModal: @entangle('companyModal').live, companyStep: @entangle('companyStep').live, equipmentModal: @entangle('equipmentModal').live, inspectionDetailModal: @entangle('inspectionDetailModal').live, inspectionFilePreviewModal: @entangle('inspectionFilePreviewModal').live, customQuestionModal: false, observationHistoryModal: false, observationHistoryRows: [], observationHistoryResponseId: null, observedParamsModal: false, observedParamsRows: [], hasObservations: @js($tieneObservaciones), inspectionFinalized: @js($inspeccionFinalizadaInicial), remediationDueDate: '', certificateGenerated: @js((bool) ($inspeccion?->certificado_generado) && !$tieneObservaciones) }" x-on:inspection-reset.window="started = false; step = 1; hasObservations = false; inspectionFinalized = false; remediationDueDate = ''; certificateGenerated = false" x-on:inspection-state.window="started = !!($event.detail.started ?? started); inspectionFinalized = !!($event.detail.inspectionFinalized ?? inspectionFinalized); if (($event.detail.step ?? null) !== null) step = $event.detail.step;" x-on:observation-form-ready.window="window.InspeccionesObs?.openCreate($wire, $event.detail || {})" x-on:observation-list-ready.window="observationHistoryRows = (($event.detail && $event.detail.observations) ? $event.detail.observations : []); observationHistoryResponseId = ($event.detail && $event.detail.responseId ? $event.detail.responseId : null); observationHistoryModal = true" x-on:observed-parameters-ready.window="observedParamsRows = (($event.detail && $event.detail.items) ? $event.detail.items : []); observedParamsModal = true" x-on:observation-saved.window="window.InspeccionesObs?.close()" x-on:custom-question-ready.window="customQuestionModal = true" x-on:custom-question-saved.window="customQuestionModal = false" class="insp-ui mt-5 space-y-5">
    @include('livewire.inspecciones.partials.ui-theme')
    <template x-teleport="body">
        <div wire:loading.delay
             wire:target="selectEmpresa,clearSelectedEmpresa,openCompanyModal,saveCompany,selectEquipment,clearSelectedEquipment,openEquipmentModal,saveEquipment,startInspection,startObservedInspection,continueInspection,viewInspection,enableInspectionEdition,saveSubgroup,flushPendingResponses,prepareCustomQuestionModal,saveCustomQuestion,prepareObservationModal,openObservationList,saveObservation,saveObservationFromModal,deleteObservationFromModal,attachInspectionFile,toggleInspectionFileCertificate,openInspectionFilePreview,deleteInspectionFile,finalizeInspection,generateInspectionCertificate,openDetailReportPreview,openObservedParametersSummary"
             class="fixed inset-x-0 top-0 z-[20001] pointer-events-none">
            <div class="insp-loading-bar w-full animate-pulse"></div>
        </div>
        <div wire:loading.delay.shortest
             wire:target="selectEmpresa,clearSelectedEmpresa,openCompanyModal,saveCompany,selectEquipment,clearSelectedEquipment,openEquipmentModal,saveEquipment,startInspection,startObservedInspection,continueInspection,viewInspection,enableInspectionEdition,saveSubgroup,flushPendingResponses,prepareCustomQuestionModal,saveCustomQuestion,prepareObservationModal,openObservationList,saveObservation,saveObservationFromModal,deleteObservationFromModal,attachInspectionFile,toggleInspectionFileCertificate,openInspectionFilePreview,deleteInspectionFile,finalizeInspection,generateInspectionCertificate,openDetailReportPreview,openObservedParametersSummary"
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
        </div>
        <div class="mt-3 md:mt-0">
            <a href="{{ route('inspecciones.index') }}" class="ti-btn ti-btn-light"><i class="ri-arrow-left-line me-1"></i>Volver a la bandeja</a>
        </div>
    </div>

    <div class="insp-wizard">
        <button type="button" wire:click="setUiStep(1)"
                class="insp-wizard-item"
                :class="step === 1 ? 'is-active' : ''">
            <div class="insp-wizard-step">Paso 1</div>
            <div class="insp-wizard-title">Datos Generales</div>
        </button>
        <button type="button" wire:click="setUiStep(2)"
                class="insp-wizard-item"
                :class="(step === 2 ? 'is-active ' : '') + (!started ? 'is-locked' : '')"
                :disabled="!started">
            <div class="insp-wizard-step">Paso 2</div>
            <div class="insp-wizard-title">Inspección</div>
        </button>
        <button type="button" wire:click="setUiStep(3)"
                class="insp-wizard-item"
                :class="(step === 3 ? 'is-active ' : '') + (!started ? 'is-locked' : '')"
                :disabled="!started">
            <div class="insp-wizard-step">Paso 3</div>
            <div class="insp-wizard-title">Generación de Certificado</div>
        </button>
    </div>

    <div class="mt-4 hidden w-full min-h-[260px] items-center justify-center rounded-2xl border border-defaultborder bg-white/90 p-5 shadow-sm"
         wire:loading.class.remove="hidden"
         wire:loading.class="flex"
         wire:target="setUiStep,startInspection,startObservedInspection,continueInspection,viewInspection,enableInspectionEdition">
        <x-loaders.dots />
    </div>

    <div wire:loading.class="hidden" wire:target="setUiStep,startInspection,startObservedInspection,continueInspection,viewInspection,enableInspectionEdition">
        @switch($uiStep)
            @case(1)
                @include('livewire.inspecciones.steps.step-1')
                @break

            @case(2)
                @include('livewire.inspecciones.steps.step-2')
                @break

            @case(3)
                @include('livewire.inspecciones.steps.step-3')
                @break
        @endswitch
    </div>
<template x-teleport="body">
    <div x-show="observedParamsModal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="observedParamsModal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full rounded-2xl bg-white shadow-xl dark:bg-[#0b1220] md:w-1/2 lg:w-5/12">
                <div class="flex items-center justify-between border-b border-defaultborder px-6 py-4">
                    <h3 class="text-[15px] font-semibold">Parámetros observados</h3>
                    <button type="button" class="text-slate-500" @click="observedParamsModal = false">
                        <i class="ri-close-line text-[1.35rem] leading-none"></i>
                    </button>
                </div>
                <div class="min-h-[25vh] max-h-[62vh] overflow-y-auto px-6 py-5 space-y-3">
                    <template x-if="!observedParamsRows.length">
                        <div class="text-[0.9rem] text-[#8c9097]">No hay observaciones registradas.</div>
                    </template>
                    <template x-for="(row, idx) in observedParamsRows" :key="idx">
                        <div class="rounded-xl border border-defaultborder bg-slate-50/60 p-3">
                            <div class="mb-2 text-[0.9rem] font-semibold text-[#334155]" x-text="row.parametro"></div>
                            <div class="space-y-2">
                                <template x-for="(obs, oIdx) in (row.observaciones || [])" :key="oIdx">
                                    <div class="rounded-lg border border-[#f3e8cf] bg-[#fffdf8] px-3 py-2">
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="text-[0.78rem] font-semibold text-[#d97706]" x-text="`${obs.momento ?? 'Ambos'} · ${obs.fecha ?? '-'}`"></div>
                                            <button type="button"
                                                    class="inline-flex h-6 w-6 items-center justify-center rounded-md bg-danger/10 text-danger hover:bg-danger/20"
                                                    title="Eliminar observación"
                                                    x-on:click="window.InspeccionesObs?.confirmDelete($wire, obs.id, true)">
                                                <i class="ri-delete-bin-line text-[0.8rem]"></i>
                                            </button>
                                        </div>
                                        <div class="mt-1 text-[0.88rem] text-[#475569]" x-text="obs.descripcion ?? ''"></div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>

<template x-teleport="body">
    <div x-show="observationHistoryModal" x-cloak class="fixed inset-0 z-[9999]">
        <div class="absolute inset-0 bg-slate-950/60" @click="observationHistoryModal = false"></div>
        <div class="relative flex min-h-full items-start justify-center p-4 pt-10 pb-8">
            <div class="w-full rounded-2xl bg-white shadow-xl dark:bg-[#0b1220] md:w-[40%] md:max-w-[40%]">
                <div class="flex items-center justify-between border-b border-defaultborder px-6 py-4">
                    <h3 class="text-[15px] font-semibold">Observaciones registradas</h3>
                    <button type="button" class="text-slate-500" @click="observationHistoryModal = false">
                        <i class="ri-close-line text-[1.35rem] leading-none"></i>
                    </button>
                </div>
                <div class="min-h-[25vh] max-h-[60vh] overflow-y-auto px-6 py-5 space-y-3">
                    <template x-if="!observationHistoryRows.length">
                        <div class="text-[0.9rem] text-[#8c9097]">No hay observaciones registradas para esta respuesta.</div>
                    </template>

                    <template x-for="item in observationHistoryRows" :key="item.id">
                        <div class="rounded-xl border border-[#f3e8cf] bg-[#fffdf8] p-3">
                            <div class="flex items-start justify-between gap-2">
                                <div class="text-[13px] font-semibold text-[#d97706]" x-text="`${item.momento ?? 'Ambos'} · ${item.fecha ?? '-'}`"></div>
                                <button type="button"
                                        class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-danger/10 text-danger hover:bg-danger/20"
                                        title="Eliminar observación"
                                        x-on:click="window.InspeccionesObs?.confirmDelete($wire, item.id)">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                            <div class="mt-1 text-[14px] leading-[1.4] text-[#52525b]" x-text="item.descripcion ?? ''"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
    </template>

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

    @once
        <script>
            window.InspeccionesObs = window.InspeccionesObs || {
                close() {
                    if (window.Swal && Swal.isVisible()) {
                        Swal.close();
                    }
                },
                async confirmDelete(wire, observationId, refreshObservedParams = false) {
                    if (!wire || !observationId) return;
                    const confirmation = await Swal.fire({
                        title: 'Eliminar observación',
                        text: '¿Deseas eliminar esta observación?',
                        icon: 'warning',
                        showCancelButton: true,
                        showCloseButton: true,
                        confirmButtonText: 'Eliminar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: false,
                        customClass: {
                            actions: '!justify-end !w-full !px-6 !pb-4',
                            closeButton: '!text-slate-500 !text-[22px] !font-normal'
                        }
                    });
                    if (!confirmation.isConfirmed) return;

                    await wire.deleteObservationFromModal(observationId, !refreshObservedParams);
                    if (refreshObservedParams) {
                        await wire.openObservedParametersSummary();
                    }
                },
                async confirmFinalize(wire) {
                    if (!wire) return;
                    const confirmation = await Swal.fire({
                        title: 'Finalizar inspección',
                        text: '¿Deseas finalizar la inspección?',
                        icon: 'question',
                        showCancelButton: true,
                        showCloseButton: true,
                        confirmButtonText: 'Sí, finalizar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: false,
                        customClass: {
                            actions: '!justify-end !w-full !px-6 !pb-4',
                            closeButton: '!text-slate-500 !text-[22px] !font-normal'
                        }
                    });
                    if (!confirmation.isConfirmed) return;
                    await wire.finalizeInspection();
                },
                openCreate(wire, detail) {
                    const currentScrollY = window.scrollY || window.pageYOffset || 0;
                    const defaults = (detail && detail.defaults) ? detail.defaults : {};
                    const defaultMomento = defaults.momento ?? 'ambos';
                    const defaultDescripcion = defaults.descripcion ?? '';

                    Swal.fire({
                        title: 'Registrar observación',
                        html: `
                            <div style="display:grid;gap:12px;text-align:left;">
                                <div>
                                    <label style="display:block;font-size:12px;font-weight:600;color:#52525b;margin-bottom:6px;">Momento</label>
                                    <select id="insp-obs-momento" class="swal2-input" style="margin:0;width:100%;height:42px;">
                                        <option value="ingreso">Ingreso</option>
                                        <option value="salida">Salida</option>
                                        <option value="ambos">Ambos</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="display:block;font-size:12px;font-weight:600;color:#52525b;margin-bottom:6px;">Detalle de observación</label>
                                    <textarea id="insp-obs-descripcion" class="swal2-textarea" placeholder="Describe la observación a subsanar" style="margin:0;width:100%;height:120px;resize:vertical;"></textarea>
                                </div>
                            </div>
                        `,
                        position: 'top',
                        width: 620,
                        showCancelButton: true,
                        showCloseButton: true,
                        confirmButtonText: 'Guardar observación',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: false,
                        focusConfirm: false,
                        allowOutsideClick: () => !Swal.isLoading(),
                        heightAuto: false,
                        scrollbarPadding: false,
                        willOpen: () => {
                            window.scrollTo({ top: currentScrollY, behavior: 'auto' });
                        },
                        didOpen: () => {
                            window.scrollTo({ top: currentScrollY, behavior: 'auto' });
                            const momento = document.getElementById('insp-obs-momento');
                            const descripcion = document.getElementById('insp-obs-descripcion');
                            if (momento) momento.value = defaultMomento;
                            if (descripcion) descripcion.value = defaultDescripcion;
                        },
                        customClass: {
                            popup: '!rounded-2xl !text-left',
                            title: '!text-[15px] !font-semibold',
                            actions: '!justify-end !w-full !px-6 !pb-4',
                            closeButton: '!text-slate-500 !text-[22px] !font-normal'
                        },
                        preConfirm: async () => {
                            const momentoEl = document.getElementById('insp-obs-momento');
                            const descripcionEl = document.getElementById('insp-obs-descripcion');
                            const momento = (momentoEl?.value || '').trim();
                            const descripcion = (descripcionEl?.value || '').trim();

                            if (!momento || !['ingreso', 'salida', 'ambos'].includes(momento)) {
                                Swal.showValidationMessage('Selecciona el momento de la observación.');
                                return false;
                            }

                            if (!descripcion) {
                                Swal.showValidationMessage('Describe la observación antes de guardar.');
                                return false;
                            }

                            try {
                                await wire.saveObservationFromModal({ momento, descripcion });
                                return true;
                            } catch (error) {
                                Swal.showValidationMessage('No se pudo guardar la observación. Intenta nuevamente.');
                                return false;
                            }
                        }
                    });
                }
            };
        </script>
    @endonce
</div>
