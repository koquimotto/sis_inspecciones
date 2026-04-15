<div
    class="rs-step space-y-5"
    x-data="resultadoStep()"
>
    <style>
        .rs-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(320px, .9fr);
            gap: 18px;
        }

        .rs-panel {
            background: #ffffff;
            border: 1px solid #dbe3ee;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .rs-panel-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .rs-panel-body {
            padding: 18px;
        }

        .rs-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.01em;
        }

        .rs-sub {
            margin-top: 3px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.45;
        }

        .rs-top-card {
            border: 1px solid #bfdbfe;
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
            padding: 16px;
        }

        .rs-top-title {
            font-size: 0.95rem;
            font-weight: 900;
            color: #0f172a;
        }

        .rs-top-meta {
            margin-top: 5px;
            font-size: 0.74rem;
            color: #475569;
            line-height: 1.5;
        }

        .rs-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .rs-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid;
        }

        .rs-tag-blue {
            background: #dbeafe;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .rs-tag-slate {
            background: #f8fafc;
            color: #475569;
            border-color: #cbd5e1;
        }

        .rs-suggested {
            border: 1px solid #fde68a;
            background: linear-gradient(180deg, #fffdf7 0%, #fffbeb 100%);
            padding: 14px;
        }

        .rs-suggested-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .rs-suggested-title {
            font-size: 0.80rem;
            font-weight: 900;
            color: #92400e;
        }

        .rs-suggested-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #a16207;
            line-height: 1.5;
        }

        .rs-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid;
            white-space: nowrap;
        }

        .rs-chip-amber {
            background: #fff7ed;
            color: #b45309;
            border-color: #fcd34d;
        }

        .rs-result-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .rs-result-card {
            border: 1px solid #dbe3ee;
            background: #fff;
            padding: 16px;
            cursor: pointer;
            transition: .18s ease;
        }

        .rs-result-card:hover {
            background: #f8fafc;
        }

        .rs-result-card.active-approve {
            border-color: #bbf7d0;
            background: linear-gradient(180deg, #f7fef9 0%, #ecfdf5 100%);
        }

        .rs-result-card.active-observed {
            border-color: #fde68a;
            background: linear-gradient(180deg, #fffdf7 0%, #fffbeb 100%);
        }

        .rs-result-card.active-reject {
            border-color: #fecaca;
            background: linear-gradient(180deg, #fff8f8 0%, #fef2f2 100%);
        }

        .rs-result-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            margin-bottom: 12px;
        }

        .rs-result-icon-approve {
            background: #ecfdf5;
            color: #047857;
            border-color: #bbf7d0;
        }

        .rs-result-icon-observed {
            background: #fff7ed;
            color: #b45309;
            border-color: #fcd34d;
        }

        .rs-result-icon-reject {
            background: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .rs-result-title {
            font-size: 0.80rem;
            font-weight: 900;
            color: #0f172a;
        }

        .rs-result-text {
            margin-top: 5px;
            font-size: 0.72rem;
            color: #64748b;
            line-height: 1.5;
        }

        .rs-label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.72rem;
            font-weight: 800;
            color: #334155;
        }

        .rs-required {
            color: #dc2626;
            margin-left: 2px;
        }

        .rs-input,
        .rs-select,
        .rs-textarea {
            width: 100%;
            background: #fff;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            font-size: 0.82rem;
            transition: .18s ease;
        }

        .rs-input,
        .rs-select {
            height: 42px;
            padding: 0 12px;
        }

        .rs-textarea {
            min-height: 102px;
            padding: 10px 12px;
            resize: vertical;
        }

        .rs-input:focus,
        .rs-select:focus,
        .rs-textarea:focus {
            outline: none;
            border-color: rgb(var(--primary));
            box-shadow: 0 0 0 3px rgba(var(--primary), .12);
        }

        .rs-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .rs-summary-card {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 14px;
        }

        .rs-summary-label {
            font-size: 0.69rem;
            font-weight: 700;
            color: #64748b;
        }

        .rs-summary-value {
            margin-top: 7px;
            font-size: 1rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.1;
        }

        .rs-summary-note {
            margin-top: 6px;
            font-size: 0.69rem;
            color: #64748b;
        }

        .rs-side-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            flex-shrink: 0;
        }

        .rs-side-icon-blue {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #2563eb;
        }

        .rs-side-icon-amber {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #d97706;
        }

        .rs-side-icon-slate {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #475569;
        }

        .rs-side-panel {
            background: #fff;
            border: 1px solid #dbe3ee;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .rs-side-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .rs-side-body {
            padding: 16px 18px;
        }

        .rs-side-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #0f172a;
        }

        .rs-side-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.5;
        }

        .rs-side-summary {
            display: grid;
            gap: 10px;
        }

        .rs-side-item {
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 11px 12px;
        }

        .rs-side-label {
            font-size: 0.69rem;
            font-weight: 700;
            color: #64748b;
        }

        .rs-side-value {
            margin-top: 5px;
            font-size: 0.80rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.4;
        }

        .rs-observed-card {
            border: 1px solid #fde68a;
            background: linear-gradient(180deg, #fffdf7 0%, #fffbeb 100%);
            padding: 14px;
        }

        .rs-observed-title {
            font-size: 0.77rem;
            font-weight: 900;
            color: #0f172a;
        }

        .rs-observed-meta {
            margin-top: 4px;
            font-size: 0.70rem;
            color: #64748b;
            line-height: 1.45;
        }

        .rs-status-chip-observed {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid #fcd34d;
            background: #fff7ed;
            color: #b45309;
            white-space: nowrap;
        }

        .rs-rule-panel {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .rs-rule-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .rs-rule-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #0f172a;
        }

        .rs-rule-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.5;
        }

        .rs-rule-body {
            padding: 16px 18px;
        }

        .rs-rule-list {
            display: grid;
            gap: 12px;
        }

        .rs-rule-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.75rem;
            line-height: 1.55;
            color: #475569;
        }

        .rs-rule-item iconify-icon {
            color: #2563eb;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .rs-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #eef2f7;
            padding-top: 16px;
        }

        .rs-btn {
            height: 40px;
            padding: 0 13px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.77rem;
            font-weight: 800;
            border: 1px solid transparent;
            transition: .18s ease;
            white-space: nowrap;
        }

        .rs-btn-primary {
            background: rgb(var(--primary));
            color: #fff;
            border-color: rgb(var(--primary));
        }

        .rs-btn-primary:hover {
            filter: brightness(.98);
        }

        .rs-btn-light {
            background: #fff;
            color: #334155;
            border-color: #cbd5e1;
        }

        .rs-btn-light:hover {
            background: #f8fafc;
        }

        @media (max-width: 1399px) {
            .rs-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1199px) {
            .rs-result-grid,
            .rs-summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="rs-layout">
        {{-- Principal --}}
        <div class="space-y-5">
            <div class="rs-panel">
                <div class="rs-panel-head">
                    <div class="rs-title">Resultado de la inspección</div>
                    <div class="rs-sub">
                        Consolida el resultado del checklist, define el estado final del equipo y registra la conclusión técnica de la inspección.
                    </div>
                </div>

                <div class="rs-panel-body space-y-5">
                    <div class="rs-top-card">
                        <div class="rs-top-title">Excavadora CAT 320 GC</div>
                        <div class="rs-top-meta">
                            Código: EQ-002 · Caterpillar · Modelo 320 GC · Empresa: LUCHO VIP · Servicio: Servicio 1
                        </div>

                        <div class="rs-tags">
                            <span class="rs-tag rs-tag-blue">
                                <iconify-icon icon="solar:shield-check-outline" width="13"></iconify-icon>
                                Equipo activo
                            </span>

                            <span class="rs-tag rs-tag-slate">
                                <iconify-icon icon="solar:checklist-minimalistic-outline" width="13"></iconify-icon>
                                Checklist evaluado
                            </span>
                        </div>
                    </div>

                    <div class="rs-suggested">
                        <div class="rs-suggested-top">
                            <div>
                                <div class="rs-suggested-title">Resultado sugerido por el sistema</div>
                                <div class="rs-suggested-text">
                                    Se detectaron no conformidades en el checklist, por lo que el sistema sugiere marcar el equipo como <strong>Observado</strong>.
                                </div>
                            </div>

                            <span class="rs-chip rs-chip-amber">
                                <iconify-icon icon="solar:danger-triangle-bold" width="14"></iconify-icon>
                                Observado
                            </span>
                        </div>
                    </div>

                    <div>
                        <label class="rs-label">
                            Resultado final <span class="rs-required">*</span>
                        </label>

                        <div class="rs-result-grid">
                            <div
                                class="rs-result-card"
                                :class="resultado === 'aprobado' ? 'active-approve' : ''"
                                @click="resultado = 'aprobado'"
                            >
                                <div class="rs-result-icon rs-result-icon-approve">
                                    <iconify-icon icon="solar:verified-check-bold-duotone" width="20"></iconify-icon>
                                </div>

                                <div class="rs-result-title">Aprobado</div>
                                <div class="rs-result-text">
                                    El equipo cumple con los criterios evaluados y no presenta hallazgos que condicionen su operación.
                                </div>
                            </div>

                            <div
                                class="rs-result-card"
                                :class="resultado === 'observado' ? 'active-observed' : ''"
                                @click="resultado = 'observado'"
                            >
                                <div class="rs-result-icon rs-result-icon-observed">
                                    <iconify-icon icon="solar:danger-triangle-bold-duotone" width="20"></iconify-icon>
                                </div>

                                <div class="rs-result-title">Observado</div>
                                <div class="rs-result-text">
                                    Se detectaron observaciones que requieren levantamiento antes del cierre total.
                                </div>
                            </div>

                            <div
                                class="rs-result-card"
                                :class="resultado === 'no_aprobado' ? 'active-reject' : ''"
                                @click="resultado = 'no_aprobado'"
                            >
                                <div class="rs-result-icon rs-result-icon-reject">
                                    <iconify-icon icon="solar:close-circle-bold-duotone" width="20"></iconify-icon>
                                </div>

                                <div class="rs-result-title">No aprobado</div>
                                <div class="rs-result-text">
                                    El equipo presenta condiciones que impiden su conformidad para la inspección actual.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rs-summary-grid">
                        <div class="rs-summary-card">
                            <div class="rs-summary-label">Ítems evaluados</div>
                            <div class="rs-summary-value">12</div>
                            <div class="rs-summary-note">Checklist total aplicado</div>
                        </div>

                        <div class="rs-summary-card">
                            <div class="rs-summary-label">No conformidades</div>
                            <div class="rs-summary-value text-amber-600">3</div>
                            <div class="rs-summary-note">Detectadas en la evaluación</div>
                        </div>

                        <div class="rs-summary-card">
                            <div class="rs-summary-label">Evidencias</div>
                            <div class="rs-summary-value">4</div>
                            <div class="rs-summary-note">Imágenes registradas</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                        <div class="lg:col-span-12">
                            <label class="rs-label">
                                Resumen de hallazgos <span class="rs-required">*</span>
                            </label>
                            <textarea
                                class="rs-textarea"
                                placeholder="Resume los hallazgos más importantes encontrados en la inspección..."
                            >Se detectaron observaciones relacionadas con el sistema de protección lateral, fijaciones incompletas y elementos que requieren ajuste correctivo antes del cierre.</textarea>
                        </div>

                        <div class="lg:col-span-12">
                            <label class="rs-label">
                                Conclusión técnica <span class="rs-required">*</span>
                            </label>
                            <textarea
                                class="rs-textarea"
                                placeholder="Redacta la conclusión técnica general de la inspección..."
                            >La unidad inspeccionada presenta una condición operativa aceptable; sin embargo, se identificaron no conformidades que deben ser levantadas para asegurar el cumplimiento total de los criterios de inspección.</textarea>
                        </div>

                        <div class="lg:col-span-12">
                            <label class="rs-label">Recomendación general</label>
                            <textarea
                                class="rs-textarea"
                                placeholder="Indica recomendaciones generales para el levantamiento o seguimiento..."
                            >Programar ajuste correctivo inmediato de protecciones laterales, verificación de fijaciones y nueva validación posterior al levantamiento.</textarea>
                        </div>

                        <template x-if="resultado === 'observado'">
                            <div class="lg:col-span-12">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="rs-label">
                                            Fecha límite de levantamiento <span class="rs-required">*</span>
                                        </label>
                                        <input type="date" class="rs-input" value="2026-04-25">
                                    </div>

                                    <div>
                                        <label class="rs-label">Responsable de levantamiento</label>
                                        <input type="text" class="rs-input" placeholder="Nombre del responsable">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="rs-label">Observación de seguimiento</label>
                                    <textarea
                                        class="rs-textarea"
                                        placeholder="Indica observaciones adicionales para el levantamiento..."
                                        style="min-height: 88px;"
                                    >Las observaciones deberán ser levantadas y validadas antes de emitir el cierre definitivo de la inspección.</textarea>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="rs-footer">
                        <div class="text-[0.74rem] text-slate-500">
                            Paso 4 de 5 · Consolidación del resultado de la inspección
                        </div>

                        <div class="flex gap-2">
                            <button type="button" class="rs-btn rs-btn-light">
                                <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                Anterior
                            </button>

                            <button type="button" class="rs-btn rs-btn-primary">
                                Siguiente: Confirmación
                                <iconify-icon icon="solar:arrow-right-outline" width="16"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lateral --}}
        <div class="space-y-5">
            <div class="rs-side-panel">
                <div class="rs-side-head">
                    <div class="flex items-start gap-3">
                        <div class="rs-side-icon rs-side-icon-blue">
                            <iconify-icon icon="solar:clipboard-check-bold-duotone" width="20"></iconify-icon>
                        </div>

                        <div>
                            <div class="rs-side-title">Resumen del equipo</div>
                            <div class="rs-side-text">
                                Contexto consolidado para emitir el resultado final.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rs-side-body">
                    <div class="rs-side-summary">
                        <div class="rs-side-item">
                            <div class="rs-side-label">Equipo activo</div>
                            <div class="rs-side-value">Excavadora CAT 320 GC</div>
                        </div>

                        <div class="rs-side-item">
                            <div class="rs-side-label">Empresa</div>
                            <div class="rs-side-value">LUCHO VIP</div>
                        </div>

                        <div class="rs-side-item">
                            <div class="rs-side-label">Servicio</div>
                            <div class="rs-side-value">Servicio 1</div>
                        </div>

                        <div class="rs-side-item">
                            <div class="rs-side-label">Resultado seleccionado</div>
                            <div class="rs-side-value" x-text="labelResultado()"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rs-side-panel">
                <div class="rs-side-head">
                    <div class="flex items-start gap-3">
                        <div class="rs-side-icon rs-side-icon-amber">
                            <iconify-icon icon="solar:danger-triangle-bold-duotone" width="20"></iconify-icon>
                        </div>

                        <div>
                            <div class="rs-side-title">Hallazgos relevantes</div>
                            <div class="rs-side-text">
                                Observaciones que impactan el resultado de la inspección.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rs-side-body space-y-3">
                    <div class="rs-observed-card">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="rs-observed-title">Sistema de protección y seguridad</div>
                                <div class="rs-observed-meta">Guarda lateral con fijación incompleta.</div>
                            </div>

                            <span class="rs-status-chip-observed">
                                <iconify-icon icon="solar:clipboard-remove-bold" width="14"></iconify-icon>
                                Observado
                            </span>
                        </div>
                    </div>

                    <div class="rs-observed-card">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="rs-observed-title">Conexiones y elementos expuestos</div>
                                <div class="rs-observed-meta">Requiere revisión correctiva y nueva verificación.</div>
                            </div>

                            <span class="rs-status-chip-observed">
                                <iconify-icon icon="solar:clipboard-remove-bold" width="14"></iconify-icon>
                                Observado
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rs-rule-panel">
                <div class="rs-rule-head">
                    <div class="flex items-start gap-3">
                        <div class="rs-side-icon rs-side-icon-slate">
                            <iconify-icon icon="solar:info-circle-bold-duotone" width="20"></iconify-icon>
                        </div>

                        <div>
                            <div class="rs-rule-title">Reglas del paso</div>
                            <div class="rs-rule-text">
                                Consideraciones importantes antes de continuar a la confirmación.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rs-rule-body">
                    <div class="rs-rule-list">
                        <div class="rs-rule-item">
                            <iconify-icon icon="solar:check-read-bold" width="16"></iconify-icon>
                            <span>El resultado sugerido se basa en las respuestas y no conformidades del checklist.</span>
                        </div>

                        <div class="rs-rule-item">
                            <iconify-icon icon="solar:danger-triangle-bold" width="16"></iconify-icon>
                            <span>Si el resultado es observado, debe definirse una fecha límite de levantamiento.</span>
                        </div>

                        <div class="rs-rule-item">
                            <iconify-icon icon="solar:document-text-bold" width="16"></iconify-icon>
                            <span>La conclusión técnica debe resumir el estado general del equipo inspeccionado.</span>
                        </div>

                        <div class="rs-rule-item">
                            <iconify-icon icon="solar:shield-check-bold" width="16"></iconify-icon>
                            <span>La confirmación final tomará este resultado como base para el registro de la inspección.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function resultadoStep() {
            return {
                resultado: 'observado',
                labelResultado() {
                    if (this.resultado === 'aprobado') return 'Aprobado';
                    if (this.resultado === 'observado') return 'Observado';
                    return 'No aprobado';
                }
            }
        }
    </script>
</div>