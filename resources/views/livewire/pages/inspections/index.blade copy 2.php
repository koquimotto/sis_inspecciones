@extends('layouts.master')
@section('title', 'Nueva inspección - EL CUMBE EIRL')

@section('styles')
    <style>
        .wizard-create-page {
            width: 100%;
        }

        .wizard-create-container {
            width: 100%;
            max-width: none;
            margin: 0;
        }

        .wiz-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }

        .wiz-card-header {
            padding: 14px 18px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }

        .wiz-card-body {
            padding: 18px;
        }

        .wiz-page-title {
            font-size: 1.60rem;
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
        }

        .wiz-page-subtitle {
            margin-top: 8px;
            font-size: 0.90rem;
            line-height: 1.55;
            color: #64748b;
        }

        .wiz-section-title {
            font-size: 1.02rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .wiz-section-text {
            margin-top: 4px;
            font-size: 0.79rem;
            color: #64748b;
        }

        .wiz-label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.76rem;
            font-weight: 700;
            color: #334155;
            letter-spacing: .01em;
        }

        .wiz-hint {
            margin-top: 5px;
            font-size: 0.72rem;
            color: #64748b;
        }

        .wiz-input,
        .wiz-select,
        .wiz-textarea {
            width: 100%;
            background: #fff;
            border: 1px solid #dbe3ee;
            border-radius: 4px;
            color: #0f172a;
            transition: .18s ease;
            font-size: 0.88rem;
        }

        .wiz-input,
        .wiz-select {
            height: 42px;
            padding: 0 12px;
        }

        .wiz-textarea {
            min-height: 96px;
            resize: vertical;
            padding: 10px 12px;
        }

        .wiz-input:focus,
        .wiz-select:focus,
        .wiz-textarea:focus {
            outline: none;
            border-color: rgb(var(--primary));
            box-shadow: 0 0 0 3px rgba(var(--primary), .10);
        }

        .wiz-btn {
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

        .wiz-btn-light {
            background: #fff;
            color: #334155;
            border-color: #dbe3ee;
        }

        .wiz-btn-light:hover {
            background: #f8fafc;
        }

        .wiz-btn-primary {
            background: rgb(var(--primary));
            color: #fff;
        }

        .wiz-btn-primary:hover {
            filter: brightness(.98);
        }

        .wiz-btn-success {
            background: #059669;
            color: #fff;
        }

        .wiz-btn-success:hover {
            background: #047857;
        }

        .wiz-btn-danger {
            background: #fff;
            color: #dc2626;
            border-color: #fecaca;
        }

        .wiz-btn-danger:hover {
            background: #fff5f5;
        }

        .wizard-top-steps {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 10px;
        }

        .wizard-step {
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 4px;
            padding: 12px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            min-height: 68px;
        }

        .wizard-step.active {
            border-color: rgba(var(--primary), .35);
            background: rgba(var(--primary), .04);
        }

        .wizard-step.done {
            border-color: #bbf7d0;
            background: #ecfdf5;
        }

        .wizard-step-badge {
            width: 30px;
            height: 30px;
            border: 1px solid #dbe3ee;
            background: #f8fafc;
            color: #475569;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.76rem;
            font-weight: 800;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .wizard-step.active .wizard-step-badge {
            background: rgb(var(--primary));
            color: #fff;
            border-color: rgb(var(--primary));
        }

        .wizard-step.done .wizard-step-badge {
            background: #059669;
            color: #fff;
            border-color: #059669;
        }

        .wizard-step-title {
            font-size: 0.78rem;
            font-weight: 800;
            color: #0f172a;
        }

        .wizard-step-subtitle {
            margin-top: 2px;
            font-size: 0.70rem;
            color: #64748b;
            line-height: 1.3;
        }

        .wizard-layout {
            display: grid;
            grid-template-columns: minmax(0, 2.3fr) minmax(320px, .9fr);
            gap: 16px;
        }

        .mini-box {
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 4px;
            padding: 13px 14px;
        }

        .mini-box-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: #64748b;
        }

        .mini-box-value {
            margin-top: 7px;
            font-size: 1.28rem;
            font-weight: 800;
            line-height: 1;
            color: #0f172a;
        }

        .priority-option {
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

        .equipment-pick {
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 4px;
            padding: 14px;
        }

        .chip-soft {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.72rem;
            font-weight: 700;
            border-radius: 3px;
            background: #f8fafc;
            color: #475569;
            border: 1px solid #e2e8f0;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 9px;
            border-radius: 3px;
            font-size: 0.72rem;
            font-weight: 700;
        }

        .status-ok {
            background: #ecfdf5;
            color: #047857;
        }

        .status-warn {
            background: #fff7ed;
            color: #c2410c;
        }

        .check-item {
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 4px;
            padding: 15px;
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
            width: 84px;
            height: 64px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid #dbe3ee;
        }

        .result-option {
            border: 1px solid;
            border-radius: 4px;
            padding: 15px;
            min-height: 96px;
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
            padding: 20px 14px;
            text-align: center;
        }

        .summary-panel {
            position: sticky;
            top: 84px;
        }

        .summary-list {
            display: grid;
            gap: 10px;
        }

        .summary-item {
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 4px;
            padding: 11px 12px;
        }

        .summary-item-label {
            font-size: 0.71rem;
            font-weight: 700;
            color: #64748b;
        }

        .summary-item-value {
            margin-top: 6px;
            font-size: 0.82rem;
            font-weight: 800;
            color: #0f172a;
        }

        .wizard-nav-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #eef2f7;
            padding-top: 14px;
            margin-top: 16px;
        }

        @media (max-width: 1399px) {
            .wizard-top-steps {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .wizard-layout {
                grid-template-columns: 1fr;
            }

            .summary-panel {
                position: relative;
                top: auto;
            }
        }

        @media (max-width: 767px) {
            .wizard-top-steps {
                grid-template-columns: 1fr;
            }

            .wiz-card-header,
            .wiz-card-body {
                padding: 14px;
            }

            .wiz-page-title {
                font-size: 1.35rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="wizard-create-page">
        <div class="wizard-create-container">
            {{-- CABECERA --}}
            <div class="wiz-card mb-4">
                <div class="wiz-card-body">
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
                                    <h1 class="wiz-page-title">Crear inspección</h1>
                                    <p class="wiz-page-subtitle max-w-4xl">
                                        Completa el proceso guiado para registrar la inspección, asignar equipos,
                                        evaluar el checklist, determinar el resultado y dejar lista la emisión del certificado.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 xl:justify-end">
                            <button class="wiz-btn wiz-btn-light">
                                <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                Cancelar
                            </button>

                            <button class="wiz-btn wiz-btn-light">
                                <iconify-icon icon="solar:document-add-outline" width="16"></iconify-icon>
                                Guardar borrador
                            </button>

                            <button class="wiz-btn wiz-btn-success">
                                <iconify-icon icon="solar:diskette-outline" width="16"></iconify-icon>
                                Finalizar registro
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PASOS --}}
            <div class="wiz-card mb-4">
                <div class="wiz-card-body">
                    <div class="wizard-top-steps">
                        <div class="wizard-step done">
                            <div class="wizard-step-badge">
                                <iconify-icon icon="solar:check-read-outline" width="16"></iconify-icon>
                            </div>
                            <div>
                                <div class="wizard-step-title">Paso 1</div>
                                <div class="wizard-step-subtitle">Datos iniciales</div>
                            </div>
                        </div>

                        <div class="wizard-step done">
                            <div class="wizard-step-badge">
                                <iconify-icon icon="solar:check-read-outline" width="16"></iconify-icon>
                            </div>
                            <div>
                                <div class="wizard-step-title">Paso 2</div>
                                <div class="wizard-step-subtitle">Empresa y servicio</div>
                            </div>
                        </div>

                        <div class="wizard-step active">
                            <div class="wizard-step-badge">3</div>
                            <div>
                                <div class="wizard-step-title">Paso 3</div>
                                <div class="wizard-step-subtitle">Equipos y checklist</div>
                            </div>
                        </div>

                        <div class="wizard-step">
                            <div class="wizard-step-badge">4</div>
                            <div>
                                <div class="wizard-step-title">Paso 4</div>
                                <div class="wizard-step-subtitle">Resultado</div>
                            </div>
                        </div>

                        <div class="wizard-step">
                            <div class="wizard-step-badge">5</div>
                            <div>
                                <div class="wizard-step-title">Paso 5</div>
                                <div class="wizard-step-subtitle">Plazo y observaciones</div>
                            </div>
                        </div>

                        <div class="wizard-step">
                            <div class="wizard-step-badge">6</div>
                            <div>
                                <div class="wizard-step-title">Paso 6</div>
                                <div class="wizard-step-subtitle">Certificado y confirmación</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wizard-layout">
                {{-- CONTENIDO PRINCIPAL --}}
                <div class="space-y-4">
                    {{-- PASO 1 --}}
                    <section class="wiz-card">
                        <div class="wiz-card-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-violet-100 text-violet-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:file-text-bold-duotone" width="18"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="wiz-section-title">Paso 1. Datos iniciales de la inspección</h2>
                                    <p class="wiz-section-text">Información base para comenzar el registro.</p>
                                </div>
                            </div>
                        </div>

                        <div class="wiz-card-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="wiz-label">Título de la inspección *</label>
                                    <input type="text" class="wiz-input" value="Inspección de equipos críticos - área de molienda">
                                    <div class="wiz-hint">Nombre principal del registro.</div>
                                </div>

                                <div>
                                    <label class="wiz-label">Tipo de inspección *</label>
                                    <select class="wiz-select">
                                        <option>Preventiva</option>
                                        <option>Programada</option>
                                        <option>Correctiva</option>
                                        <option>Extraordinaria</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="wiz-label">Fecha de inspección *</label>
                                    <input type="date" class="wiz-input" value="2026-04-09">
                                </div>

                                <div>
                                    <label class="wiz-label">Hora de inicio *</label>
                                    <input type="time" class="wiz-input" value="08:30">
                                </div>

                                <div class="md:col-span-2">
                                    <label class="wiz-label">Objetivo / alcance</label>
                                    <textarea class="wiz-textarea">Verificar condiciones operativas, estado físico, cumplimiento del checklist técnico y detección de hallazgos en equipos críticos del área de molienda.</textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mt-4">
                                <div class="priority-option priority-low">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:shield-check-bold-duotone" width="18" class="text-emerald-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.80rem] font-extrabold text-emerald-700">Prioridad baja</div>
                                            <div class="text-[0.72rem] text-emerald-700/80 mt-1">Seguimiento rutinario</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="priority-option priority-medium">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:danger-triangle-bold-duotone" width="18" class="text-amber-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.80rem] font-extrabold text-amber-700">Prioridad media</div>
                                            <div class="text-[0.72rem] text-amber-700/80 mt-1">Revisión técnica prioritaria</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="priority-option priority-high">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:shield-warning-bold-duotone" width="18" class="text-rose-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.80rem] font-extrabold text-rose-700">Prioridad alta</div>
                                            <div class="text-[0.72rem] text-rose-700/80 mt-1">Atención inmediata</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="wizard-nav-footer">
                                <div class="text-[0.74rem] text-slate-500">
                                    Paso 1 de 6
                                </div>
                                <div class="flex gap-2">
                                    <button class="wiz-btn wiz-btn-primary">
                                        Siguiente
                                        <iconify-icon icon="solar:arrow-right-outline" width="16"></iconify-icon>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>

                    {{-- PASO 2 --}}
                    <section class="wiz-card">
                        <div class="wiz-card-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:buildings-3-bold-duotone" width="18"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="wiz-section-title">Paso 2. Empresa, servicio y responsables</h2>
                                    <p class="wiz-section-text">Vincula la inspección con la empresa y servicio correspondiente.</p>
                                </div>
                            </div>
                        </div>

                        <div class="wiz-card-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="wiz-label">Empresa *</label>
                                    <select class="wiz-select">
                                        <option>Minera Los Andes S.A.</option>
                                        <option>COMINSA</option>
                                        <option>EL CUMBE E.I.R.L.</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="wiz-label">Servicio / contrato *</label>
                                    <select class="wiz-select">
                                        <option>Mantenimiento de planta</option>
                                        <option>Inspección de seguridad</option>
                                        <option>Supervisión técnica</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="wiz-label">Inspector responsable *</label>
                                    <select class="wiz-select">
                                        <option>María García</option>
                                        <option>Luis Paredes</option>
                                        <option>Roberto Pérez</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="wiz-label">Supervisor / contacto</label>
                                    <select class="wiz-select">
                                        <option>Jefatura de mantenimiento</option>
                                        <option>Supervisor de planta</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="wiz-label">Ubicación / área</label>
                                    <input type="text" class="wiz-input" value="Planta concentradora - área de molienda">
                                </div>

                                <div>
                                    <label class="wiz-label">Código o referencia interna</label>
                                    <input type="text" class="wiz-input" value="INS-2026-000125">
                                </div>
                            </div>

                            <div class="wizard-nav-footer">
                                <button class="wiz-btn wiz-btn-light">
                                    <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                    Anterior
                                </button>

                                <div class="text-[0.74rem] text-slate-500">
                                    Paso 2 de 6
                                </div>

                                <button class="wiz-btn wiz-btn-primary">
                                    Siguiente
                                    <iconify-icon icon="solar:arrow-right-outline" width="16"></iconify-icon>
                                </button>
                            </div>
                        </div>
                    </section>

                    {{-- PASO 3 --}}
                    <section class="wiz-card">
                        <div class="wiz-card-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:settings-bold-duotone" width="18"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="wiz-section-title">Paso 3. Equipos y checklist</h2>
                                    <p class="wiz-section-text">Selecciona uno o más equipos y registra la evaluación técnica.</p>
                                </div>
                            </div>

                            <button class="wiz-btn wiz-btn-light">
                                <iconify-icon icon="solar:magnifer-outline" width="16"></iconify-icon>
                                Buscar equipos
                            </button>
                        </div>

                        <div class="wiz-card-body">
                            <div class="grid grid-cols-2 xl:grid-cols-4 gap-3 mb-4">
                                <div class="mini-box">
                                    <div class="mini-box-label">Equipos seleccionados</div>
                                    <div class="mini-box-value">3</div>
                                </div>

                                <div class="mini-box">
                                    <div class="mini-box-label">Checklist</div>
                                    <div class="mini-box-value">12</div>
                                </div>

                                <div class="mini-box">
                                    <div class="mini-box-label">Cumple</div>
                                    <div class="mini-box-value text-emerald-600">8</div>
                                </div>

                                <div class="mini-box">
                                    <div class="mini-box-label">No cumple</div>
                                    <div class="mini-box-value text-rose-600">3</div>
                                </div>
                            </div>

                            <div class="space-y-3 mb-4">
                                <div class="equipment-pick">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <input type="checkbox" checked class="ti-form-checkbox mt-1">
                                            <div class="min-w-0">
                                                <div class="text-[0.88rem] font-extrabold text-slate-900">Molino SAG 2</div>
                                                <div class="text-[0.75rem] text-slate-500 mt-1">
                                                    Código: ML-002 · Área: Planta molienda · Marca: Metso · Modelo: SAG-900
                                                </div>
                                            </div>
                                        </div>
                                        <span class="status-pill status-ok">
                                            <iconify-icon icon="solar:check-circle-bold-duotone" width="14"></iconify-icon>
                                            Operativo
                                        </span>
                                    </div>
                                </div>

                                <div class="equipment-pick">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <input type="checkbox" checked class="ti-form-checkbox mt-1">
                                            <div class="min-w-0">
                                                <div class="text-[0.88rem] font-extrabold text-slate-900">Espesador 1</div>
                                                <div class="text-[0.75rem] text-slate-500 mt-1">
                                                    Código: ES-001 · Área: Concentrado · Marca: Outotec · Modelo: THK-120
                                                </div>
                                            </div>
                                        </div>
                                        <span class="status-pill status-ok">
                                            <iconify-icon icon="solar:check-circle-bold-duotone" width="14"></iconify-icon>
                                            Operativo
                                        </span>
                                    </div>
                                </div>

                                <div class="equipment-pick">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-start gap-3 min-w-0">
                                            <input type="checkbox" checked class="ti-form-checkbox mt-1">
                                            <div class="min-w-0">
                                                <div class="text-[0.88rem] font-extrabold text-slate-900">Bomba de pulpa 01</div>
                                                <div class="text-[0.75rem] text-slate-500 mt-1">
                                                    Código: BP-001 · Área: Transporte de pulpa · Marca: Warman · Modelo: 6/4 AH
                                                </div>
                                            </div>
                                        </div>
                                        <span class="status-pill status-warn">
                                            <iconify-icon icon="solar:danger-triangle-bold-duotone" width="14"></iconify-icon>
                                            Atención requerida
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="check-item">
                                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                                        <div>
                                            <div class="text-[0.69rem] uppercase tracking-[0.14em] font-extrabold text-primary mb-2">
                                                1. Condiciones generales
                                            </div>
                                            <div class="text-[0.92rem] font-extrabold text-slate-900">Estado general del equipo</div>
                                            <div class="text-[0.75rem] text-slate-500 mt-1">
                                                Verificar limpieza, corrosión, daños visibles, integridad del bastidor y condición superficial.
                                            </div>
                                        </div>

                                        <div class="check-actions">
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
                                            <label class="wiz-label">Observación del ítem</label>
                                            <textarea class="wiz-textarea">El equipo presenta buen estado general, sin deformaciones ni corrosión significativa.</textarea>
                                        </div>

                                        <div class="lg:col-span-5">
                                            <label class="wiz-label">Evidencias fotográficas</label>
                                            <div class="flex flex-wrap gap-2">
                                                <img class="evidence-thumb" src="https://images.unsplash.com/photo-1581092921461-7d65ca45d354?auto=format&fit=crop&w=400&q=80" alt="">
                                                <img class="evidence-thumb" src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=400&q=80" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="check-item">
                                    <div class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
                                        <div>
                                            <div class="text-[0.69rem] uppercase tracking-[0.14em] font-extrabold text-primary mb-2">
                                                2. Sistema de protección
                                            </div>
                                            <div class="text-[0.92rem] font-extrabold text-slate-900">Guardas y protecciones instaladas</div>
                                            <div class="text-[0.75rem] text-slate-500 mt-1">
                                                Validar presencia, ajuste, integridad física y correcto aseguramiento.
                                            </div>
                                        </div>

                                        <div class="check-actions">
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
                                            <label class="wiz-label">Observación del ítem</label>
                                            <textarea class="wiz-textarea">Se detecta guarda lateral con fijación incompleta. Requiere ajuste y reposición de pernos.</textarea>
                                        </div>

                                        <div class="lg:col-span-5">
                                            <label class="wiz-label">Evidencias fotográficas</label>
                                            <div class="flex flex-wrap gap-2">
                                                <img class="evidence-thumb" src="https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=400&q=80" alt="">
                                                <img class="evidence-thumb" src="https://images.unsplash.com/photo-1516321165247-4aa89a48be28?auto=format&fit=crop&w=400&q=80" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="wizard-nav-footer">
                                <button class="wiz-btn wiz-btn-light">
                                    <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                    Anterior
                                </button>

                                <div class="text-[0.74rem] text-slate-500">
                                    Paso 3 de 6
                                </div>

                                <button class="wiz-btn wiz-btn-primary">
                                    Siguiente
                                    <iconify-icon icon="solar:arrow-right-outline" width="16"></iconify-icon>
                                </button>
                            </div>
                        </div>
                    </section>

                    {{-- PASO 4 --}}
                    <section class="wiz-card">
                        <div class="wiz-card-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:shield-warning-bold-duotone" width="18"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="wiz-section-title">Paso 4. Resultado de la inspección</h2>
                                    <p class="wiz-section-text">Define el estado final del proceso de evaluación.</p>
                                </div>
                            </div>
                        </div>

                        <div class="wiz-card-body">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                <div class="result-option result-approved">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:verified-check-bold-duotone" width="18" class="text-emerald-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.84rem] font-extrabold text-emerald-700">Aprobada</div>
                                            <div class="text-[0.73rem] text-emerald-700/80 mt-2">
                                                Sin hallazgos relevantes.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="result-option result-observed">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:danger-triangle-bold-duotone" width="18" class="text-amber-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.84rem] font-extrabold text-amber-700">Observada</div>
                                            <div class="text-[0.73rem] text-amber-700/80 mt-2">
                                                Con levantamiento pendiente.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="result-option result-rejected">
                                    <div class="flex items-start gap-3">
                                        <iconify-icon icon="solar:close-circle-bold-duotone" width="18" class="text-rose-600 mt-0.5"></iconify-icon>
                                        <div>
                                            <div class="text-[0.84rem] font-extrabold text-rose-700">No aprobada</div>
                                            <div class="text-[0.73rem] text-rose-700/80 mt-2">
                                                Riesgo alto o incumplimiento crítico.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label class="wiz-label">Conclusión técnica *</label>
                                <textarea class="wiz-textarea" style="min-height: 138px;">La inspección evidencia que los equipos evaluados mantienen una condición operativa aceptable; sin embargo, se identificaron hallazgos puntuales que deben corregirse dentro del plazo establecido.</textarea>
                            </div>

                            <div class="wizard-nav-footer">
                                <button class="wiz-btn wiz-btn-light">
                                    <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                    Anterior
                                </button>

                                <div class="text-[0.74rem] text-slate-500">
                                    Paso 4 de 6
                                </div>

                                <button class="wiz-btn wiz-btn-primary">
                                    Siguiente
                                    <iconify-icon icon="solar:arrow-right-outline" width="16"></iconify-icon>
                                </button>
                            </div>
                        </div>
                    </section>

                    {{-- PASO 5 --}}
                    <section class="wiz-card">
                        <div class="wiz-card-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:calendar-mark-bold-duotone" width="18"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="wiz-section-title">Paso 5. Levantamiento de observaciones</h2>
                                    <p class="wiz-section-text">Define el plazo, responsables y detalles de corrección.</p>
                                </div>
                            </div>
                        </div>

                        <div class="wiz-card-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="wiz-label">Fecha límite de levantamiento *</label>
                                    <input type="date" class="wiz-input" value="2026-04-25">
                                </div>

                                <div>
                                    <label class="wiz-label">Días hábiles *</label>
                                    <input type="number" class="wiz-input" value="10">
                                </div>

                                <div>
                                    <label class="wiz-label">Responsable de levantamiento</label>
                                    <select class="wiz-select">
                                        <option>Jefatura de mantenimiento</option>
                                        <option>Supervisor de planta</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="wiz-label">Estado inicial de seguimiento</label>
                                    <select class="wiz-select">
                                        <option>Pendiente</option>
                                        <option>En proceso</option>
                                        <option>Subsanado</option>
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="wiz-label">Observaciones a levantar</label>
                                    <textarea class="wiz-textarea">1. Ajuste de guarda lateral en bomba de pulpa 01.
2. Verificación de pernería y puntos de aseguramiento.
3. Reposición de señalética faltante en área adyacente.</textarea>
                                </div>
                            </div>

                            <div class="wizard-nav-footer">
                                <button class="wiz-btn wiz-btn-light">
                                    <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                    Anterior
                                </button>

                                <div class="text-[0.74rem] text-slate-500">
                                    Paso 5 de 6
                                </div>

                                <button class="wiz-btn wiz-btn-primary">
                                    Siguiente
                                    <iconify-icon icon="solar:arrow-right-outline" width="16"></iconify-icon>
                                </button>
                            </div>
                        </div>
                    </section>

                    {{-- PASO 6 --}}
                    <section class="wiz-card">
                        <div class="wiz-card-header">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <iconify-icon icon="solar:diploma-verified-bold-duotone" width="18"></iconify-icon>
                                </div>
                                <div>
                                    <h2 class="wiz-section-title">Paso 6. Certificado y confirmación</h2>
                                    <p class="wiz-section-text">Deja lista la información para emitir el certificado final.</p>
                                </div>
                            </div>
                        </div>

                        <div class="wiz-card-body">
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                                <div class="lg:col-span-7">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="wiz-label">Código de certificado</label>
                                            <input type="text" class="wiz-input" value="CERT-INS-2026-000125">
                                        </div>

                                        <div>
                                            <label class="wiz-label">Fecha de emisión</label>
                                            <input type="date" class="wiz-input" value="2026-04-09">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label class="wiz-label">Texto complementario</label>
                                            <textarea class="wiz-textarea">Se certifica que la presente inspección fue ejecutada conforme al procedimiento interno de control técnico, dejando constancia del resultado obtenido y de las observaciones consignadas.</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="lg:col-span-5">
                                    <div class="mini-box h-full">
                                        <div class="text-[0.88rem] font-extrabold text-slate-900 mb-3">Contenido del certificado</div>
                                        <div class="space-y-3">
                                            <label class="flex items-center gap-3 text-[0.80rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Datos de la empresa
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.80rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Servicio inspeccionado
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.80rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Equipos incluidos
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.80rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Resultado final
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.80rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Vigencia / plazo
                                            </label>
                                            <label class="flex items-center gap-3 text-[0.80rem] font-medium text-slate-700">
                                                <input type="checkbox" checked class="ti-form-checkbox">
                                                Firma y QR de validación
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 upload-box">
                                <div class="w-11 h-11 bg-primary/10 text-primary flex items-center justify-center mx-auto">
                                    <iconify-icon icon="solar:cloud-upload-bold-duotone" width="20"></iconify-icon>
                                </div>
                                <div class="mt-3 text-[0.84rem] font-extrabold text-slate-900">
                                    Adjuntos generales de la inspección
                                </div>
                                <div class="mt-1 text-[0.72rem] text-slate-500">
                                    PDF, DOCX, XLSX, JPG, PNG · Máximo 10 MB por archivo
                                </div>
                            </div>

                            <div class="wizard-nav-footer">
                                <button class="wiz-btn wiz-btn-light">
                                    <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                    Anterior
                                </button>

                                <div class="flex gap-2">
                                    <button class="wiz-btn wiz-btn-light">
                                        <iconify-icon icon="solar:document-add-outline" width="16"></iconify-icon>
                                        Guardar borrador
                                    </button>

                                    <button class="wiz-btn wiz-btn-success">
                                        <iconify-icon icon="solar:check-circle-bold-duotone" width="16"></iconify-icon>
                                        Crear inspección
                                    </button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- RESUMEN LATERAL --}}
                <div>
                    <div class="summary-panel space-y-4">
                        <section class="wiz-card">
                            <div class="wiz-card-header">
                                <div>
                                    <div class="wiz-section-title">Resumen del proceso</div>
                                    <div class="wiz-section-text">Vista rápida del registro en creación.</div>
                                </div>
                                <span class="badge bg-primary/10 text-primary">Wizard</span>
                            </div>

                            <div class="wiz-card-body">
                                <div class="summary-list">
                                    <div class="summary-item">
                                        <div class="summary-item-label">Código preliminar</div>
                                        <div class="summary-item-value">INS-2026-000125</div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="summary-item-label">Empresa</div>
                                        <div class="summary-item-value">Minera Los Andes S.A.</div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="summary-item-label">Servicio</div>
                                        <div class="summary-item-value">Mantenimiento de planta</div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="summary-item-label">Inspector</div>
                                        <div class="summary-item-value">María García</div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="summary-item-label">Equipos</div>
                                        <div class="summary-item-value">3 seleccionados</div>
                                    </div>

                                    <div class="summary-item">
                                        <div class="summary-item-label">Resultado proyectado</div>
                                        <div class="summary-item-value text-amber-600">Observada</div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="flex items-center justify-between text-[0.74rem] font-semibold text-slate-600 mb-2">
                                        <span>Avance del registro</span>
                                        <span class="text-primary">58%</span>
                                    </div>
                                    <div class="w-full h-[8px] bg-slate-100 overflow-hidden rounded-none">
                                        <div class="h-full bg-primary" style="width:58%"></div>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="wiz-card">
                            <div class="wiz-card-header">
                                <div>
                                    <div class="wiz-section-title">Indicadores rápidos</div>
                                    <div class="wiz-section-text">Apoyo visual durante la captura.</div>
                                </div>
                            </div>

                            <div class="wiz-card-body">
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="mini-box">
                                        <div class="mini-box-label">Cumple</div>
                                        <div class="mini-box-value text-emerald-600">8</div>
                                    </div>
                                    <div class="mini-box">
                                        <div class="mini-box-label">No cumple</div>
                                        <div class="mini-box-value text-rose-600">3</div>
                                    </div>
                                </div>

                                <div id="chartChecklistWizard" class="w-full h-[220px]"></div>
                            </div>
                        </section>

                        <section class="wiz-card">
                            <div class="wiz-card-header">
                                <div>
                                    <div class="wiz-section-title">Notas operativas</div>
                                    <div class="wiz-section-text">Recordatorios antes de finalizar.</div>
                                </div>
                            </div>

                            <div class="wiz-card-body space-y-3">
                                <div class="mini-box">
                                    <div class="summary-item-value text-[0.80rem]">
                                        Verifica que todos los equipos seleccionados pertenezcan a la empresa y servicio elegidos.
                                    </div>
                                </div>

                                <div class="mini-box">
                                    <div class="summary-item-value text-[0.80rem]">
                                        Si la inspección queda observada, registra obligatoriamente plazo y responsable.
                                    </div>
                                </div>

                                <div class="mini-box">
                                    <div class="summary-item-value text-[0.80rem]">
                                        Adjunta evidencias suficientes para sustentar hallazgos y certificado.
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

            Highcharts.chart('chartChecklistWizard', {
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
                        innerSize: '66%',
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            distance: 10,
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
        });
    </script>
@endsection