@extends('layouts.master')
@section('title', 'Nueva inspección - EL CUMBE EIRL')

@section('styles')
    <style>
        .inspection-page {
            width: 100%;
        }

        .inspection-container {
            width: 100%;
            max-width: none;
            margin: 0;
        }

        .inspection-block {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }

        .inspection-block-header {
            padding: 14px 18px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }

        .inspection-block-body {
            padding: 18px;
        }

        .inspection-title {
            font-size: 1.65rem;
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
        }

        .inspection-subtitle {
            margin-top: 8px;
            font-size: 0.90rem;
            line-height: 1.55;
            color: #64748b;
        }

        .section-title {
            font-size: 1.08rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .section-text {
            margin-top: 4px;
            font-size: 0.80rem;
            color: #64748b;
        }

        .field-label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.76rem;
            font-weight: 700;
            color: #334155;
            letter-spacing: .01em;
        }

        .field-hint {
            margin-top: 5px;
            font-size: 0.72rem;
            color: #64748b;
        }

        .ui-input,
        .ui-select,
        .ui-textarea {
            width: 100%;
            background: #fff;
            border: 1px solid #dbe3ee;
            border-radius: 4px;
            color: #0f172a;
            transition: .18s ease;
            font-size: 0.88rem;
        }

        .ui-input,
        .ui-select {
            height: 42px;
            padding: 0 12px;
        }

        .ui-textarea {
            min-height: 96px;
            resize: vertical;
            padding: 10px 12px;
        }

        .ui-input:focus,
        .ui-select:focus,
        .ui-textarea:focus {
            outline: none;
            border-color: rgb(var(--primary));
            box-shadow: 0 0 0 3px rgba(var(--primary), .10);
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 40px;
            padding: 0 14px;
            font-size: 0.82rem;
            font-weight: 700;
            border-radius: 4px;
            border: 1px solid transparent;
            transition: .18s ease;
        }

        .action-btn-light {
            background: #fff;
            color: #334155;
            border-color: #dbe3ee;
        }

        .action-btn-light:hover {
            background: #f8fafc;
        }

        .action-btn-primary {
            background: rgb(var(--primary));
            color: #fff;
        }

        .action-btn-primary:hover {
            filter: brightness(.98);
        }

        .action-btn-success {
            background: #059669;
            color: #fff;
        }

        .action-btn-success:hover {
            background: #047857;
        }

        .top-kpi {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: #fff;
            padding: 14px 16px;
            min-height: 112px;
        }

        .top-kpi-label {
            font-size: 0.74rem;
            color: #64748b;
            font-weight: 700;
        }

        .top-kpi-value {
            margin-top: 8px;
            font-size: 1.55rem;
            line-height: 1;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
        }

        .top-kpi-note {
            margin-top: 8px;
            font-size: 0.74rem;
            color: #64748b;
        }

        .wizard-wrap {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 12px;
        }

        .wizard-step {
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 4px;
            padding: 14px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            min-height: 74px;
        }

        .wizard-step.is-active {
            border-color: rgba(var(--primary), .35);
            background: rgba(var(--primary), .04);
        }

        .wizard-step.is-done {
            border-color: #bbf7d0;
            background: #ecfdf5;
        }

        .wizard-badge {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            font-size: 0.82rem;
            font-weight: 800;
            flex-shrink: 0;
            border: 1px solid #dbe3ee;
            background: #f8fafc;
            color: #475569;
        }

        .wizard-step.is-active .wizard-badge {
            background: rgb(var(--primary));
            border-color: rgb(var(--primary));
            color: #fff;
        }

        .wizard-step.is-done .wizard-badge {
            background: #059669;
            border-color: #059669;
            color: #fff;
        }

        .wizard-title {
            font-size: 0.80rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 1px;
        }

        .wizard-subtitle {
            font-size: 0.72rem;
            color: #64748b;
            margin-top: 2px;
            line-height: 1.35;
        }

        .mini-stat {
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 4px;
            padding: 13px 14px;
        }

        .mini-stat-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #64748b;
        }

        .mini-stat-value {
            margin-top: 7px;
            font-size: 1.45rem;
            font-weight: 800;
            line-height: 1;
            color: #0f172a;
        }

        .priority-box {
            border: 1px solid;
            border-radius: 4px;
            padding: 12px 14px;
            background: #fff;
        }

        .priority-low {
            border-color: #bbf7d0;
            background: #ecfdf5;
        }

        .priority-medium {
            border-color: #fed7aa;
            background: #fff7ed;
        }

        .priority-high {
            border-color: #fecdd3;
            background: #fff1f2;
        }

        .equipment-item {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: #fff;
            padding: 14px;
        }

        .state-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 9px;
            border-radius: 3px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .state-ok {
            background: #ecfdf5;
            color: #047857;
        }

        .state-warn {
            background: #fff7ed;
            color: #c2410c;
        }

        .state-bad {
            background: #fff1f2;
            color: #be123c;
        }

        .check-item {
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: #fff;
            padding: 16px;
        }

        .check-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .check-action {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            height: 34px;
            padding: 0 12px;
            border-radius: 4px;
            border: 1px solid #dbe3ee;
            background: #fff;
            font-size: 0.74rem;
            font-weight: 700;
            color: #334155;
        }

        .check-action.ok.active {
            background: #ecfdf5;
            border-color: #bbf7d0;
            color: #047857;
        }

        .check-action.bad.active {
            background: #fff1f2;
            border-color: #fecdd3;
            color: #be123c;
        }

        .check-action.na.active {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #475569;
        }

        .evidence-thumb {
            width: 82px;
            height: 64px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid #dbe3ee;
        }

        .result-card {
            border: 1px solid;
            border-radius: 4px;
            padding: 15px;
            min-height: 100px;
        }

        .result-approved {
            border-color: #bbf7d0;
            background: #ecfdf5;
        }

        .result-observed {
            border-color: #fde68a;
            background: #fffbeb;
        }

        .result-rejected {
            border-color: #fecdd3;
            background: #fff1f2;
        }

        .upload-box {
            border: 1px dashed #cbd5e1;
            border-radius: 4px;
            background: #f8fafc;
            padding: 22px 16px;
            text-align: center;
        }

        .file-row {
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            background: #fff;
            padding: 11px 12px;
        }

        .alert-box {
            border: 1px solid;
            border-radius: 4px;
            padding: 14px 16px;
        }

        .alert-danger {
            border-color: #fecdd3;
            background: #fff1f2;
        }

        .alert-warning {
            border-color: #fde68a;
            background: #fffbeb;
        }

        .alert-success {
            border-color: #bbf7d0;
            background: #ecfdf5;
        }

        .sticky-panel {
            position: sticky;
            top: 84px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 2.25fr) minmax(340px, 1fr);
            gap: 18px;
        }

        @media (max-width: 1399px) {
            .wizard-wrap {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .sticky-panel {
                position: relative;
                top: auto;
            }
        }

        @media (max-width: 767px) {
            .wizard-wrap {
                grid-template-columns: 1fr;
            }

            .inspection-block-header,
            .inspection-block-body {
                padding: 14px;
            }

            .inspection-title {
                font-size: 1.35rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="inspection-page">
        <div class="inspection-container">
            {{-- CABECERA --}}
            <div class="inspection-block mb-4">
                <div class="inspection-block-body">
                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 text-[0.72rem] text-slate-500 mb-3">
                                <a href="{{ route('dashboard') }}" class="hover:text-primary">Dashboard</a>
                                <span>/</span>
                                <a href="{{ route('inspecciones.index') }}" class="hover:text-primary">Inspecciones</a>
                                <span>/</span>
                                <span class="font-semibold text-slate-700">Nueva inspección</span>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-11 h-11 bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:clipboard-check-bold-duotone" width="22"></iconify-icon>
                                </div>

                                <div class="min-w-0">
                                    <h1 class="inspection-title">Nueva inspección técnica</h1>
                                    <p class="inspection-subtitle max-w-4xl">
                                        Registra una inspección completa considerando empresa, servicio, equipos inspeccionados,
                                        checklist técnico, observaciones, evidencias fotográficas, resultado final y generación de certificado.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 xl:justify-end">
                            <button class="action-btn action-btn-light">
                                <iconify-icon icon="solar:arrow-left-outline" width="17"></iconify-icon>
                                Volver
                            </button>

                            <button class="action-btn action-btn-light">
                                <iconify-icon icon="solar:document-add-outline" width="17"></iconify-icon>
                                Guardar borrador
                            </button>

                            <button class="action-btn action-btn-primary">
                                <iconify-icon icon="solar:diskette-outline" width="17"></iconify-icon>
                                Guardar inspección
                            </button>

                            <button class="action-btn action-btn-success">
                                <iconify-icon icon="solar:diploma-verified-bold-duotone" width="17"></iconify-icon>
                                Generar certificado
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3 mt-4">
                        <div class="top-kpi">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="top-kpi-label">Código preliminar</div>
                                    <div class="top-kpi-value">INS-2026-000125</div>
                                    <div class="top-kpi-note">Correlativo referencial</div>
                                </div>
                                <div class="w-10 h-10 bg-sky-100 text-sky-600 flex items-center justify-center">
                                    <iconify-icon icon="solar:hashtag-square-bold-duotone" width="18"></iconify-icon>
                                </div>
                            </div>
                        </div>

                        <div class="top-kpi">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="top-kpi-label">Empresa seleccionada</div>
                                    <div class="text-[1.22rem] leading-none font-extrabold text-slate-900 mt-2">Minera Los Andes S.A.</div>
                                    <div class="top-kpi-note">Unidad: Planta concentradora</div>
                                </div>
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                    <iconify-icon icon="solar:buildings-3-bold-duotone" width="18"></iconify-icon>
                                </div>
                            </div>
                        </div>

                        <div class="top-kpi">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="top-kpi-label">Equipos a inspeccionar</div>
                                    <div class="top-kpi-value">3</div>
                                    <div class="top-kpi-note">Molino SAG 2, Espesador 1, Bomba de pulpa</div>
                                </div>
                                <div class="w-10 h-10 bg-violet-100 text-violet-600 flex items-center justify-center">
                                    <iconify-icon icon="solar:settings-bold-duotone" width="18"></iconify-icon>
                                </div>
                            </div>
                        </div>

                        <div class="top-kpi">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="top-kpi-label">Estado proyectado</div>
                                    <div class="text-[1.22rem] leading-none font-extrabold text-slate-900 mt-2">Observada</div>
                                    <div class="top-kpi-note">Con plazo de levantamiento</div>
                                </div>
                                <div class="w-10 h-10 bg-amber-100 text-amber-600 flex items-center justify-center">
                                    <iconify-icon icon="solar:danger-triangle-bold-duotone" width="18"></iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WIZARD --}}
            <div class="inspection-block mb-4">
                <div class="inspection-block-body">
                    <div class="wizard-wrap">
                        <div class="wizard-step is-done">
                            <div class="wizard-badge">
                                <iconify-icon icon="solar:check-read-outline" width="18"></iconify-icon>
                            </div>
                            <div>
                                <div class="wizard-title">General</div>
                                <div class="wizard-subtitle">Empresa y servicio</div>
                            </div>
                        </div>

                        <div class="wizard-step is-done">
                            <div class="wizard-badge">
                                <iconify-icon icon="solar:check-read-outline" width="18"></iconify-icon>
                            </div>
                            <div>
                                <div class="wizard-title">Equipos</div>
                                <div class="wizard-subtitle">Uno o más equipos</div>
                            </div>
                        </div>

                        <div class="wizard-step is-active">
                            <div class="wizard-badge">3</div>
                            <div>
                                <div class="wizard-title">Checklist</div>
                                <div class="wizard-subtitle">Ítems y evidencias</div>
                            </div>
                        </div>

                        <div class="wizard-step">
                            <div class="wizard-badge">4</div>
                            <div>
                                <div class="wizard-title">Resultado</div>
                                <div class="wizard-subtitle">Estado final</div>
                            </div>
                        </div>

                        <div class="wizard-step">
                            <div class="wizard-badge">5</div>
                            <div>
                                <div class="wizard-title">Certificado</div>
                                <div class="wizard-subtitle">Emisión y cierre</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                {{-- COLUMNA PRINCIPAL --}}
                <div class="space-y-4">
                    {{-- 1. GENERAL --}}
                    <section class="inspection-block">
                        <div class="inspection-block-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-violet-100 text-violet-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:file-text-bold-duotone" width="19"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="section-title">1. Información general de la inspección</h2>
                                    <p class="section-text">Datos principales para registrar la inspección.</p>
                                </div>
                            </div>
                        </div>

                        <div class="inspection-block-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="field-label">Empresa *</label>
                                    <select class="ui-select">
                                        <option>Minera Los Andes S.A.</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="field-label">Servicio / contrato *</label>
                                    <select class="ui-select">
                                        <option>Mantenimiento de planta</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="field-label">Inspector responsable *</label>
                                    <select class="ui-select">
                                        <option>María García</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="field-label">Tipo de inspección *</label>
                                    <select class="ui-select">
                                        <option>Preventiva</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="field-label">Fecha de inspección *</label>
                                    <input type="date" class="ui-input" value="2026-04-09">
                                </div>

                                <div>
                                    <label class="field-label">Hora de inicio *</label>
                                    <input type="time" class="ui-input" value="08:30">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="field-label">Título de la inspección *</label>
                                    <input type="text" class="ui-input" value="Inspección de equipos críticos - área de molienda">
                                    <div class="field-hint">Usa un nombre claro y trazable documentalmente.</div>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="field-label">Objetivo / alcance</label>
                                    <textarea class="ui-textarea">Verificar condiciones operativas, estado físico, cumplimiento del checklist técnico y detección de hallazgos en equipos críticos del área de molienda.</textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4">
                                <div class="priority-box priority-low">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:shield-check-bold-duotone" width="20" class="text-emerald-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.82rem] font-extrabold text-emerald-700">Prioridad baja</div>
                                            <div class="text-[0.73rem] text-emerald-700/80 mt-1">Seguimiento rutinario</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="priority-box priority-medium">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:danger-triangle-bold-duotone" width="20" class="text-amber-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.82rem] font-extrabold text-amber-700">Prioridad media</div>
                                            <div class="text-[0.73rem] text-amber-700/80 mt-1">Revisión técnica prioritaria</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="priority-box priority-high">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:shield-warning-bold-duotone" width="20" class="text-rose-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.82rem] font-extrabold text-rose-700">Prioridad alta</div>
                                            <div class="text-[0.73rem] text-rose-700/80 mt-1">Atención inmediata</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 2. EQUIPOS --}}
                    <section class="inspection-block">
                        <div class="inspection-block-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:settings-bold-duotone" width="19"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="section-title">2. Equipos a inspeccionar</h2>
                                    <p class="section-text">La inspección puede incluir uno o más equipos de una misma empresa/servicio.</p>
                                </div>
                            </div>

                            <button class="action-btn action-btn-light">
                                <iconify-icon icon="solar:magnifer-outline" width="16"></iconify-icon>
                                Buscar equipos
                            </button>
                        </div>

                        <div class="inspection-block-body">
                            <div class="grid grid-cols-3 gap-3 mb-4">
                                <div class="mini-stat">
                                    <div class="mini-stat-label">Total seleccionados</div>
                                    <div class="mini-stat-value">3</div>
                                </div>
                                <div class="mini-stat">
                                    <div class="mini-stat-label">Operativos</div>
                                    <div class="mini-stat-value text-emerald-600">2</div>
                                </div>
                                <div class="mini-stat">
                                    <div class="mini-stat-label">Con atención requerida</div>
                                    <div class="mini-stat-value text-amber-600">1</div>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div class="equipment-item">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <input type="checkbox" checked class="ti-form-checkbox mt-1">
                                            <div class="min-w-0">
                                                <div class="text-[0.92rem] font-extrabold text-slate-900">Molino SAG 2</div>
                                                <div class="text-[0.77rem] text-slate-500 mt-1">
                                                    Código: ML-002 · Área: Planta molienda · Marca: Metso · Modelo: SAG-900
                                                </div>
                                            </div>
                                        </div>
                                        <span class="state-pill state-ok">
                                            <iconify-icon icon="solar:check-circle-bold-duotone" width="14"></iconify-icon>
                                            Operativo
                                        </span>
                                    </div>
                                </div>

                                <div class="equipment-item">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <input type="checkbox" checked class="ti-form-checkbox mt-1">
                                            <div class="min-w-0">
                                                <div class="text-[0.92rem] font-extrabold text-slate-900">Espesador 1</div>
                                                <div class="text-[0.77rem] text-slate-500 mt-1">
                                                    Código: ES-001 · Área: Concentrado · Marca: Outotec · Modelo: THK-120
                                                </div>
                                            </div>
                                        </div>
                                        <span class="state-pill state-ok">
                                            <iconify-icon icon="solar:check-circle-bold-duotone" width="14"></iconify-icon>
                                            Operativo
                                        </span>
                                    </div>
                                </div>

                                <div class="equipment-item">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <input type="checkbox" checked class="ti-form-checkbox mt-1">
                                            <div class="min-w-0">
                                                <div class="text-[0.92rem] font-extrabold text-slate-900">Bomba de pulpa 01</div>
                                                <div class="text-[0.77rem] text-slate-500 mt-1">
                                                    Código: BP-001 · Área: Transporte de pulpa · Marca: Warman · Modelo: 6/4 AH
                                                </div>
                                            </div>
                                        </div>
                                        <span class="state-pill state-warn">
                                            <iconify-icon icon="solar:danger-triangle-bold-duotone" width="14"></iconify-icon>
                                            Mantenimiento recomendado
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 3. CHECKLIST --}}
                    <section class="inspection-block">
                        <div class="inspection-block-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:checklist-bold-duotone" width="19"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="section-title">3. Checklist de inspección</h2>
                                    <p class="section-text">Ítems, evidencias y observaciones por equipo.</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                <span class="badge bg-light text-defaulttextcolor/70">Checklist: Mecánico - Equipos rotativos</span>
                                <span class="badge bg-light text-defaulttextcolor/70">Equipo: Bomba de pulpa 01</span>
                            </div>
                        </div>

                        <div class="inspection-block-body">
                            <div class="grid grid-cols-2 xl:grid-cols-4 gap-3 mb-4">
                                <div class="mini-stat">
                                    <div class="mini-stat-label">Cumple</div>
                                    <div class="mini-stat-value text-emerald-600">8</div>
                                </div>
                                <div class="mini-stat">
                                    <div class="mini-stat-label">No cumple</div>
                                    <div class="mini-stat-value text-rose-600">3</div>
                                </div>
                                <div class="mini-stat">
                                    <div class="mini-stat-label">N/A</div>
                                    <div class="mini-stat-value text-slate-700">1</div>
                                </div>
                                <div class="mini-stat">
                                    <div class="mini-stat-label">Avance</div>
                                    <div class="mini-stat-value text-primary">100%</div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="check-item">
                                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                                        <div class="min-w-0">
                                            <div class="text-[0.70rem] uppercase tracking-[0.14em] font-extrabold text-primary mb-2">
                                                1. Condiciones generales
                                            </div>
                                            <div class="text-[0.95rem] font-extrabold text-slate-900">Estado general del equipo</div>
                                            <div class="text-[0.77rem] text-slate-500 mt-1">
                                                Verificar limpieza, corrosión, daños visibles, integridad del bastidor y condición superficial.
                                            </div>
                                        </div>

                                        <div class="check-actions shrink-0">
                                            <span class="check-action ok active">
                                                <iconify-icon icon="solar:check-circle-bold-duotone" width="14"></iconify-icon>
                                                Cumple
                                            </span>
                                            <span class="check-action bad">
                                                <iconify-icon icon="solar:close-circle-bold-duotone" width="14"></iconify-icon>
                                                No cumple
                                            </span>
                                            <span class="check-action na">
                                                <iconify-icon icon="solar:slash-circle-bold-duotone" width="14"></iconify-icon>
                                                N/A
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mt-4">
                                        <div class="lg:col-span-7">
                                            <label class="field-label">Observación del ítem</label>
                                            <textarea class="ui-textarea">El equipo presenta buen estado general, sin deformaciones ni corrosión significativa. Se observa acumulación ligera de material particulado, sin comprometer la operación.</textarea>
                                        </div>

                                        <div class="lg:col-span-5">
                                            <label class="field-label">Evidencias fotográficas</label>
                                            <div class="flex flex-wrap gap-2">
                                                <img class="evidence-thumb" src="https://images.unsplash.com/photo-1581092921461-7d65ca45d354?auto=format&fit=crop&w=400&q=80" alt="">
                                                <img class="evidence-thumb" src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=400&q=80" alt="">
                                                <div class="w-[82px] h-[64px] border border-dashed border-slate-300 bg-slate-50 flex items-center justify-center text-slate-400">
                                                    <iconify-icon icon="solar:add-circle-outline" width="20"></iconify-icon>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="check-item">
                                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                                        <div class="min-w-0">
                                            <div class="text-[0.70rem] uppercase tracking-[0.14em] font-extrabold text-primary mb-2">
                                                2. Sistema de protección
                                            </div>
                                            <div class="text-[0.95rem] font-extrabold text-slate-900">Guardas y protecciones instaladas</div>
                                            <div class="text-[0.77rem] text-slate-500 mt-1">
                                                Validar presencia, ajuste, integridad física y correcto aseguramiento de guardas de seguridad.
                                            </div>
                                        </div>

                                        <div class="check-actions shrink-0">
                                            <span class="check-action ok">
                                                <iconify-icon icon="solar:check-circle-bold-duotone" width="14"></iconify-icon>
                                                Cumple
                                            </span>
                                            <span class="check-action bad active">
                                                <iconify-icon icon="solar:close-circle-bold-duotone" width="14"></iconify-icon>
                                                No cumple
                                            </span>
                                            <span class="check-action na">
                                                <iconify-icon icon="solar:slash-circle-bold-duotone" width="14"></iconify-icon>
                                                N/A
                                            </span>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 mt-4">
                                        <div class="lg:col-span-7">
                                            <label class="field-label">Observación del ítem</label>
                                            <textarea class="ui-textarea">Se detecta guarda lateral con fijación incompleta. Requiere ajuste y reposición de pernos para asegurar el cumplimiento de seguridad operacional.</textarea>
                                        </div>

                                        <div class="lg:col-span-5">
                                            <label class="field-label">Evidencias fotográficas</label>
                                            <div class="flex flex-wrap gap-2">
                                                <img class="evidence-thumb" src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=400&q=80" alt="">
                                                <img class="evidence-thumb" src="https://images.unsplash.com/photo-1516321165247-4aa89a48be28?auto=format&fit=crop&w=400&q=80" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="check-item">
                                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                                        <div class="min-w-0">
                                            <div class="text-[0.70rem] uppercase tracking-[0.14em] font-extrabold text-primary mb-2">
                                                3. Etiquetado y señalización
                                            </div>
                                            <div class="text-[0.95rem] font-extrabold text-slate-900">Identificación visible del equipo</div>
                                            <div class="text-[0.77rem] text-slate-500 mt-1">
                                                Corroborar código, placa, señalética de advertencia y rótulos operativos visibles.
                                            </div>
                                        </div>

                                        <div class="check-actions shrink-0">
                                            <span class="check-action ok">
                                                <iconify-icon icon="solar:check-circle-bold-duotone" width="14"></iconify-icon>
                                                Cumple
                                            </span>
                                            <span class="check-action bad">
                                                <iconify-icon icon="solar:close-circle-bold-duotone" width="14"></iconify-icon>
                                                No cumple
                                            </span>
                                            <span class="check-action na active">
                                                <iconify-icon icon="solar:slash-circle-bold-duotone" width="14"></iconify-icon>
                                                N/A
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <label class="field-label">Observación del ítem</label>
                                        <textarea class="ui-textarea">No aplica para este componente secundario, ya que la identificación principal se encuentra en el módulo superior del conjunto inspeccionado.</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 4. RESULTADO --}}
                    <section class="inspection-block">
                        <div class="inspection-block-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:shield-warning-bold-duotone" width="19"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="section-title">4. Resultado de la inspección</h2>
                                    <p class="section-text">Define el estado final y el tratamiento de las observaciones encontradas.</p>
                                </div>
                            </div>
                        </div>

                        <div class="inspection-block-body">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">
                                <div class="result-card result-approved">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:verified-check-bold-duotone" width="20" class="text-emerald-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.88rem] font-extrabold text-emerald-700">Aprobada</div>
                                            <div class="text-[0.75rem] text-emerald-700/80 mt-2">
                                                Todos los puntos críticos cumplen o no presentan hallazgos relevantes.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="result-card result-observed">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:danger-triangle-bold-duotone" width="20" class="text-amber-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.88rem] font-extrabold text-amber-700">Observada</div>
                                            <div class="text-[0.75rem] text-amber-700/80 mt-2">
                                                Existen observaciones que deben levantarse dentro de un plazo definido.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="result-card result-rejected">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:close-circle-bold-duotone" width="20" class="text-rose-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.88rem] font-extrabold text-rose-700">No aprobada</div>
                                            <div class="text-[0.75rem] text-rose-700/80 mt-2">
                                                Los hallazgos comprometen la seguridad o continuidad operativa.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                                <div class="lg:col-span-6">
                                    <label class="field-label">Conclusión técnica *</label>
                                    <textarea class="ui-textarea" style="min-height: 150px;">La inspección evidencia que los equipos evaluados mantienen una condición operativa aceptable; sin embargo, se identificaron hallazgos puntuales relacionados con elementos de protección y ajustes mecánicos que deben corregirse dentro del plazo establecido.</textarea>
                                </div>

                                <div class="lg:col-span-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="field-label">Fecha límite de levantamiento *</label>
                                            <input type="date" class="ui-input" value="2026-04-25">
                                        </div>

                                        <div>
                                            <label class="field-label">Días hábiles *</label>
                                            <input type="number" class="ui-input" value="10">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="field-label">Responsable de levantamiento</label>
                                            <select class="ui-select">
                                                <option>Jefatura de mantenimiento</option>
                                            </select>
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="field-label">Observaciones a levantar</label>
                                            <textarea class="ui-textarea">1. Ajuste de guarda lateral en bomba de pulpa 01.
2. Verificación de pernería y puntos de aseguramiento.
3. Reposición de señalética faltante en área adyacente.</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- 5. CERTIFICADO --}}
                    <section class="inspection-block">
                        <div class="inspection-block-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:diploma-verified-bold-duotone" width="19"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="section-title">5. Emisión de certificado</h2>
                                    <p class="section-text">Configura la información mínima necesaria para generar el certificado final.</p>
                                </div>
                            </div>

                            <button class="action-btn action-btn-success">
                                <iconify-icon icon="solar:file-download-bold-duotone" width="16"></iconify-icon>
                                Generar PDF
                            </button>
                        </div>

                        <div class="inspection-block-body">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                                <div class="lg:col-span-7">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="field-label">Código de certificado</label>
                                            <input type="text" class="ui-input" value="CERT-INS-2026-000125">
                                        </div>

                                        <div>
                                            <label class="field-label">Fecha de emisión</label>
                                            <input type="date" class="ui-input" value="2026-04-09">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="field-label">Texto complementario</label>
                                            <textarea class="ui-textarea">Se certifica que la presente inspección fue ejecutada conforme al procedimiento interno de control técnico, dejando constancia del resultado obtenido y de las observaciones consignadas en el informe correspondiente.</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="lg:col-span-5">
                                    <div class="mini-stat h-full">
                                        <div class="text-[0.90rem] font-extrabold text-slate-900 mb-3">Contenido del certificado</div>
                                        <div class="space-y-3">
                                            <label class="flex items-center gap-3 text-[0.81rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Datos de la empresa
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.81rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Servicio inspeccionado
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.81rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Equipos incluidos
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.81rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Resultado final
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.81rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Vigencia / plazo
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.81rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Firma y QR de validación
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- PANEL DERECHO --}}
                <div>
                    <div class="sticky-panel space-y-4">
                        <section class="inspection-block">
                            <div class="inspection-block-header">
                                <div>
                                    <div class="section-title">Panel de control</div>
                                    <div class="section-text">Resumen rápido de la captura</div>
                                </div>
                                <span class="badge bg-primary/10 text-primary">72%</span>
                            </div>

                            <div class="inspection-block-body">
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="mini-stat">
                                        <div class="mini-stat-label">Empresa</div>
                                        <div class="text-[0.84rem] font-extrabold text-slate-900 mt-2">Minera Los Andes S.A.</div>
                                    </div>

                                    <div class="mini-stat">
                                        <div class="mini-stat-label">Servicio</div>
                                        <div class="text-[0.84rem] font-extrabold text-slate-900 mt-2">Mantenimiento planta</div>
                                    </div>

                                    <div class="mini-stat">
                                        <div class="mini-stat-label">Inspector</div>
                                        <div class="text-[0.84rem] font-extrabold text-slate-900 mt-2">María García</div>
                                    </div>

                                    <div class="mini-stat">
                                        <div class="mini-stat-label">Resultado</div>
                                        <div class="text-[0.84rem] font-extrabold text-amber-600 mt-2">Observada</div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="flex items-center justify-between text-[0.74rem] font-semibold text-slate-600 mb-2">
                                        <span>Progreso del wizard</span>
                                        <span class="text-primary">72%</span>
                                    </div>
                                    <div class="w-full h-[8px] bg-slate-100 overflow-hidden rounded-none">
                                        <div class="h-full bg-primary" style="width:72%"></div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="inspection-block">
                            <div class="inspection-block-header">
                                <div>
                                    <div class="section-title">Distribución del checklist</div>
                                    <div class="section-text">Cumplimiento por estado</div>
                                </div>
                            </div>
                            <div class="inspection-block-body">
                                <div id="chartChecklistStatus" class="w-full h-[260px]"></div>
                            </div>
                        </section>

                        <section class="inspection-block">
                            <div class="inspection-block-header">
                                <div>
                                    <div class="section-title">Observaciones por criticidad</div>
                                    <div class="section-text">Priorización del levantamiento</div>
                                </div>
                            </div>
                            <div class="inspection-block-body">
                                <div id="chartCriticidad" class="w-full h-[230px]"></div>
                            </div>
                        </section>

                        <section class="inspection-block">
                            <div class="inspection-block-header">
                                <div>
                                    <div class="section-title">Adjuntos generales</div>
                                    <div class="section-text">Planos, reportes y evidencias complementarias.</div>
                                </div>
                            </div>

                            <div class="inspection-block-body">
                                <div class="upload-box">
                                    <div class="w-12 h-12 bg-primary/10 text-primary flex items-center justify-center mx-auto">
                                        <iconify-icon icon="solar:cloud-upload-bold-duotone" width="24"></iconify-icon>
                                    </div>
                                    <div class="mt-3 text-[0.86rem] font-extrabold text-slate-900">
                                        Arrastra archivos o haz clic para cargar
                                    </div>
                                    <div class="mt-1 text-[0.73rem] text-slate-500">
                                        PDF, DOCX, XLSX, JPG, PNG · Máximo 10 MB por archivo
                                    </div>
                                </div>

                                <div class="space-y-3 mt-4">
                                    <div class="file-row">
                                        <div class="w-10 h-10 bg-rose-100 text-rose-600 flex items-center justify-center">
                                            <iconify-icon icon="solar:file-text-bold-duotone" width="18"></iconify-icon>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-[0.80rem] font-bold text-slate-900 truncate">procedimiento_inspeccion.pdf</div>
                                            <div class="text-[0.72rem] text-slate-500 mt-1">PDF · 2.4 MB</div>
                                        </div>
                                        <button class="text-slate-400 hover:text-rose-600">
                                            <iconify-icon icon="solar:trash-bin-trash-outline" width="17"></iconify-icon>
                                        </button>
                                    </div>

                                    <div class="file-row">
                                        <div class="w-10 h-10 bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                            <iconify-icon icon="solar:file-bold-duotone" width="18"></iconify-icon>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-[0.80rem] font-bold text-slate-900 truncate">plano_area_molienda.dwg</div>
                                            <div class="text-[0.72rem] text-slate-500 mt-1">DWG · 4.1 MB</div>
                                        </div>
                                        <button class="text-slate-400 hover:text-rose-600">
                                            <iconify-icon icon="solar:trash-bin-trash-outline" width="17"></iconify-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="inspection-block">
                            <div class="inspection-block-header">
                                <div>
                                    <div class="section-title">Hallazgos clave</div>
                                    <div class="section-text">Resumen ejecutivo de puntos relevantes.</div>
                                </div>
                            </div>

                            <div class="inspection-block-body space-y-3">
                                <div class="alert-box alert-danger">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:danger-bold-duotone" width="18" class="text-rose-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.80rem] font-extrabold text-rose-700">Guarda lateral incompleta</div>
                                            <div class="text-[0.72rem] text-rose-700/80 mt-1">
                                                Equipo: Bomba de pulpa 01 · Requiere corrección inmediata.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-box alert-warning">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:danger-triangle-bold-duotone" width="18" class="text-amber-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.80rem] font-extrabold text-amber-700">Señalética deficiente</div>
                                            <div class="text-[0.72rem] text-amber-700/80 mt-1">
                                                Área adyacente a sistema de bombeo.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert-box alert-success">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:check-circle-bold-duotone" width="18" class="text-emerald-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.80rem] font-extrabold text-emerald-700">Integridad estructural adecuada</div>
                                            <div class="text-[0.72rem] text-emerald-700/80 mt-1">
                                                Molino SAG 2 y Espesador 1 sin hallazgos críticos.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Highcharts === 'undefined') return;

            Highcharts.chart('chartChecklistStatus', {
                chart: {
                    type: 'pie',
                    backgroundColor: 'transparent',
                    spacing: [0, 0, 0, 0]
                },
                title: { text: null },
                credits: { enabled: false },
                exporting: { enabled: false },
                tooltip: {
                    pointFormat: '<b>{point.y}</b> ítems ({point.percentage:.1f}%)'
                },
                plotOptions: {
                    pie: {
                        innerSize: '68%',
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            distance: 12,
                            style: {
                                fontSize: '10px',
                                fontWeight: '600',
                                color: '#334155',
                                textOutline: 'none'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Ítems',
                    data: [
                        { name: 'Cumple', y: 8, color: '#10b981' },
                        { name: 'No cumple', y: 3, color: '#f43f5e' },
                        { name: 'N/A', y: 1, color: '#94a3b8' }
                    ]
                }]
            });

            Highcharts.chart('chartCriticidad', {
                chart: {
                    type: 'bar',
                    backgroundColor: 'transparent',
                    spacing: [0, 0, 0, 0]
                },
                title: { text: null },
                credits: { enabled: false },
                exporting: { enabled: false },
                xAxis: {
                    categories: ['Alta', 'Media', 'Baja'],
                    lineColor: '#e2e8f0',
                    tickColor: '#e2e8f0',
                    labels: {
                        style: {
                            color: '#475569',
                            fontSize: '10px',
                            fontWeight: '600'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: { text: null },
                    gridLineColor: '#eef2f7',
                    labels: {
                        style: {
                            color: '#64748b'
                        }
                    }
                },
                legend: { enabled: false },
                tooltip: {
                    pointFormat: '<b>{point.y}</b> observaciones'
                },
                plotOptions: {
                    series: {
                        borderRadius: 0,
                        pointPadding: 0.16,
                        groupPadding: 0.12
                    }
                },
                series: [{
                    data: [
                        { y: 1, color: '#f43f5e' },
                        { y: 2, color: '#f59e0b' },
                        { y: 4, color: '#10b981' }
                    ]
                }]
            });
        });
    </script>
@endsection