<div
    class="cf-step space-y-5"
    x-data="confirmacionStep()"
>
    <style>
        .cf-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(320px, .9fr);
            gap: 18px;
        }

        .cf-panel {
            background: #ffffff;
            border: 1px solid #dbe3ee;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .cf-panel-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .cf-panel-body {
            padding: 18px;
        }

        .cf-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.01em;
        }

        .cf-sub {
            margin-top: 3px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.45;
        }

        .cf-top-card {
            border: 1px solid #bfdbfe;
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
            padding: 16px;
        }

        .cf-top-title {
            font-size: 0.95rem;
            font-weight: 900;
            color: #0f172a;
        }

        .cf-top-meta {
            margin-top: 5px;
            font-size: 0.74rem;
            color: #475569;
            line-height: 1.5;
        }

        .cf-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .cf-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid;
        }

        .cf-tag-blue {
            background: #dbeafe;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .cf-tag-slate {
            background: #f8fafc;
            color: #475569;
            border-color: #cbd5e1;
        }

        .cf-tag-amber {
            background: #fff7ed;
            color: #b45309;
            border-color: #fcd34d;
        }

        .cf-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .cf-card {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 14px;
        }

        .cf-card-label {
            font-size: 0.69rem;
            font-weight: 700;
            color: #64748b;
        }

        .cf-card-value {
            margin-top: 7px;
            font-size: 0.86rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.4;
        }

        .cf-block {
            border: 1px solid #dbe3ee;
            background: #fff;
        }

        .cf-block-head {
            padding: 14px 16px;
            border-bottom: 1px solid #eef2f7;
        }

        .cf-block-title {
            font-size: 0.82rem;
            font-weight: 900;
            color: #0f172a;
        }

        .cf-block-text {
            margin-top: 4px;
            font-size: 0.72rem;
            color: #64748b;
            line-height: 1.5;
        }

        .cf-block-body {
            padding: 16px;
        }

        .cf-text-view {
            font-size: 0.79rem;
            color: #334155;
            line-height: 1.7;
            white-space: pre-line;
        }

        .cf-status-box {
            border: 1px solid #fde68a;
            background: linear-gradient(180deg, #fffdf7 0%, #fffbeb 100%);
            padding: 16px;
        }

        .cf-status-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .cf-status-title {
            font-size: 0.82rem;
            font-weight: 900;
            color: #92400e;
        }

        .cf-status-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #a16207;
            line-height: 1.55;
        }

        .cf-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid;
            white-space: nowrap;
        }

        .cf-chip-amber {
            background: #fff7ed;
            color: #b45309;
            border-color: #fcd34d;
        }

        .cf-side-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            flex-shrink: 0;
        }

        .cf-side-icon-blue {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #2563eb;
        }

        .cf-side-icon-amber {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #d97706;
        }

        .cf-side-icon-slate {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #475569;
        }

        .cf-side-panel {
            background: #fff;
            border: 1px solid #dbe3ee;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .cf-side-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .cf-side-body {
            padding: 16px 18px;
        }

        .cf-side-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #0f172a;
        }

        .cf-side-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.5;
        }

        .cf-side-summary {
            display: grid;
            gap: 10px;
        }

        .cf-side-item {
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 11px 12px;
        }

        .cf-side-label {
            font-size: 0.69rem;
            font-weight: 700;
            color: #64748b;
        }

        .cf-side-value {
            margin-top: 5px;
            font-size: 0.80rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.4;
        }

        .cf-rule-panel {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .cf-rule-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .cf-rule-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #0f172a;
        }

        .cf-rule-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.5;
        }

        .cf-rule-body {
            padding: 16px 18px;
        }

        .cf-rule-list {
            display: grid;
            gap: 12px;
        }

        .cf-rule-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.75rem;
            line-height: 1.55;
            color: #475569;
        }

        .cf-rule-item iconify-icon {
            color: #2563eb;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .cf-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #eef2f7;
            padding-top: 16px;
        }

        .cf-btn {
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

        .cf-btn-primary {
            background: rgb(var(--primary));
            color: #fff;
            border-color: rgb(var(--primary));
        }

        .cf-btn-primary:hover {
            filter: brightness(.98);
        }

        .cf-btn-light {
            background: #fff;
            color: #334155;
            border-color: #cbd5e1;
        }

        .cf-btn-light:hover {
            background: #f8fafc;
        }

        .cf-btn-success {
            background: #059669;
            color: #fff;
            border-color: #059669;
        }

        .cf-btn-success:hover {
            background: #047857;
            border-color: #047857;
        }
        
        .cf-cert-box {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 16px;
        }
        
        .cf-cert-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
        }
        
        .cf-cert-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            color: #2563eb;
            flex-shrink: 0;
        }
        
        .cf-cert-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #0f172a;
        }
        
        .cf-cert-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.55;
        }
        
        .cf-cert-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid #bfdbfe;
            background: #dbeafe;
            color: #1d4ed8;
            white-space: nowrap;
        }
        
        .cf-cert-meta-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-top: 16px;
        }
        
        .cf-cert-meta {
            border: 1px solid #dbe3ee;
            background: #fff;
            padding: 12px;
        }
        
        .cf-cert-meta-label {
            font-size: 0.68rem;
            font-weight: 700;
            color: #64748b;
        }
        
        .cf-cert-meta-value {
            margin-top: 5px;
            font-size: 0.78rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.4;
        }
        
        .cf-cert-preview {
            margin-top: 16px;
            border: 1px solid #dbe3ee;
            background: #fff;
        }
        
        .cf-cert-preview-head {
            padding: 14px 16px;
            border-bottom: 1px solid #eef2f7;
        }
        
        .cf-cert-preview-title {
            font-size: 0.80rem;
            font-weight: 900;
            color: #0f172a;
        }
        
        .cf-cert-preview-sub {
            margin-top: 4px;
            font-size: 0.72rem;
            color: #64748b;
        }
        
        .cf-cert-sheet {
            margin: 16px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            min-height: 260px;
            box-shadow: inset 0 0 0 1px #f8fafc;
        }
        
        .cf-cert-sheet-header {
            padding: 18px 18px 12px 18px;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }
        
        .cf-cert-sheet-company {
            font-size: 0.88rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: 0.03em;
        }
        
        .cf-cert-sheet-doc {
            margin-top: 6px;
            font-size: 0.80rem;
            font-weight: 800;
            color: #334155;
            letter-spacing: 0.08em;
        }
        
        .cf-cert-sheet-body {
            padding: 18px;
        }
        
        .cf-cert-line {
            font-size: 0.78rem;
            color: #334155;
            line-height: 1.7;
        }
        
        .cf-cert-paragraph {
            margin-top: 14px;
            font-size: 0.77rem;
            color: #475569;
            line-height: 1.75;
            text-align: justify;
        }
        
        .cf-cert-actions {
            margin-top: 16px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .cf-pdf-viewer {
            padding: 16px;
            background: #f8fafc;
            border-top: 1px solid #eef2f7;
        }
        
        .cf-pdf-frame {
            width: 100%;
            height: 720px;
            border: 1px solid #cbd5e1;
            background: #fff;
            display: block;
        }
        
        .cf-pdf-empty {
            min-height: 320px;
            border: 1px dashed #cbd5e1;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
            text-align: center;
        }
        
        .cf-pdf-empty-icon {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            color: #2563eb;
            margin-bottom: 14px;
        }
        
        .cf-pdf-empty-title {
            font-size: 0.86rem;
            font-weight: 900;
            color: #0f172a;
        }
        
        .cf-pdf-empty-text {
            margin-top: 6px;
            max-width: 420px;
            font-size: 0.74rem;
            color: #64748b;
            line-height: 1.6;
        }
        
        @media (max-width: 1199px) {
            .cf-cert-meta-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        
        @media (max-width: 767px) {
            .cf-cert-top {
                flex-direction: column;
            }
        
            .cf-cert-meta-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1399px) {
            .cf-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 991px) {
            .cf-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="cf-layout">
        {{-- Principal --}}
        <div class="space-y-5">
            <div class="cf-panel">
                <div class="cf-panel-head">
                    <div class="cf-title">Confirmación de la inspección</div>
                    <div class="cf-sub">
                        Revisa el contexto general, el resultado y las observaciones antes de guardar definitivamente el registro.
                    </div>
                </div>

                <div class="cf-panel-body space-y-5">
                    <div class="cf-top-card">
                        <div class="cf-top-title">Excavadora CAT 320 GC</div>
                        <div class="cf-top-meta">
                            Código: EQ-002 · Caterpillar · Modelo 320 GC · Empresa: LUCHO VIP · Servicio: Servicio 1
                        </div>

                        <div class="cf-tags">
                            <span class="cf-tag cf-tag-blue">
                                <iconify-icon icon="solar:shield-check-outline" width="13"></iconify-icon>
                                Equipo activo
                            </span>

                            <span class="cf-tag cf-tag-slate">
                                <iconify-icon icon="solar:calendar-outline" width="13"></iconify-icon>
                                14/04/2026 · 09:30 AM
                            </span>

                            <span class="cf-tag cf-tag-amber">
                                <iconify-icon icon="solar:danger-triangle-outline" width="13"></iconify-icon>
                                Resultado observado
                            </span>
                        </div>
                    </div>

                    <div class="cf-grid">
                        <div class="cf-card">
                            <div class="cf-card-label">Empresa</div>
                            <div class="cf-card-value">LUCHO VIP</div>
                        </div>

                        <div class="cf-card">
                            <div class="cf-card-label">Servicio</div>
                            <div class="cf-card-value">Servicio 1</div>
                        </div>

                        <div class="cf-card">
                            <div class="cf-card-label">Fecha</div>
                            <div class="cf-card-value">14/04/2026</div>
                        </div>

                        <div class="cf-card">
                            <div class="cf-card-label">Hora</div>
                            <div class="cf-card-value">09:30 AM</div>
                        </div>

                        <div class="cf-card">
                            <div class="cf-card-label">Responsable</div>
                            <div class="cf-card-value">María García</div>
                        </div>

                        <div class="cf-card">
                            <div class="cf-card-label">Resultado final</div>
                            <div class="cf-card-value" x-text="labelResultado()"></div>
                        </div>
                    </div>

                    <div class="cf-status-box">
                        <div class="cf-status-top">
                            <div>
                                <div class="cf-status-title">Estado final del registro</div>
                                <div class="cf-status-text">
                                    Esta inspección quedará registrada con resultado <strong x-text="labelResultado()"></strong>. Verifica que la información consolidada sea correcta antes de guardar.
                                </div>
                            </div>

                            <span class="cf-chip cf-chip-amber">
                                <iconify-icon icon="solar:clipboard-check-outline" width="14"></iconify-icon>
                                Confirmación final
                            </span>
                        </div>
                    </div>

                    <div class="cf-block">
                        <div class="cf-block-head">
                            <div class="cf-block-title">Resumen de hallazgos</div>
                            <div class="cf-block-text">Síntesis ejecutiva de las observaciones encontradas en la inspección.</div>
                        </div>
                        <div class="cf-block-body">
                            <div class="cf-text-view">
Se detectaron observaciones relacionadas con el sistema de protección lateral, fijaciones incompletas y elementos que requieren ajuste correctivo antes del cierre.
                            </div>
                        </div>
                    </div>

                    <div class="cf-block">
                        <div class="cf-block-head">
                            <div class="cf-block-title">Conclusión técnica</div>
                            <div class="cf-block-text">Conclusión consolidada del estado del equipo inspeccionado.</div>
                        </div>
                        <div class="cf-block-body">
                            <div class="cf-text-view">
La unidad inspeccionada presenta una condición operativa aceptable; sin embargo, se identificaron no conformidades que deben ser levantadas para asegurar el cumplimiento total de los criterios de inspección.
                            </div>
                        </div>
                    </div>

                    <div class="cf-block">
                        <div class="cf-block-head">
                            <div class="cf-block-title">Recomendación general</div>
                            <div class="cf-block-text">Acciones sugeridas para asegurar el levantamiento adecuado.</div>
                        </div>
                        <div class="cf-block-body">
                            <div class="cf-text-view">
Programar ajuste correctivo inmediato de protecciones laterales, verificación de fijaciones y nueva validación posterior al levantamiento.
                            </div>
                        </div>
                    </div>

                    <template x-if="resultado === 'observado'">
                        <div class="cf-block">
                            <div class="cf-block-head">
                                <div class="cf-block-title">Levantamiento de observaciones</div>
                                <div class="cf-block-text">Información registrada para el seguimiento posterior.</div>
                            </div>
                            <div class="cf-block-body">
                                <div class="cf-grid">
                                    <div class="cf-card">
                                        <div class="cf-card-label">Fecha límite</div>
                                        <div class="cf-card-value">25/04/2026</div>
                                    </div>

                                    <div class="cf-card">
                                        <div class="cf-card-label">Responsable de levantamiento</div>
                                        <div class="cf-card-value">Jefe de mantenimiento</div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="cf-card-label">Observación de seguimiento</div>
                                    <div class="cf-text-view mt-2">
Las observaciones deberán ser levantadas y validadas antes de emitir el cierre definitivo de la inspección.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <div class="cf-block">
                        <div class="cf-block-head">
                            <div class="cf-block-title">Certificado y salida documental</div>
                            <div class="cf-block-text">
                                Previsualiza el certificado de inspección y deja listo el documento PDF para su emisión.
                            </div>
                        </div>
                    
                        <div class="cf-block-body space-y-4">
                            <div class="cf-cert-box">
                                <div class="cf-cert-top">
                                    <div class="flex items-start gap-3">
                                        <div class="cf-cert-icon">
                                            <iconify-icon icon="solar:file-text-bold-duotone" width="20"></iconify-icon>
                                        </div>
                    
                                        <div>
                                            <div class="cf-cert-title">Certificado de inspección</div>
                                            <div class="cf-cert-text">
                                                Documento final asociado al registro actual. Puede previsualizarse antes de generar el PDF definitivo.
                                            </div>
                                        </div>
                                    </div>
                    
                                    <span class="cf-cert-chip">
                                        <iconify-icon icon="solar:eye-bold" width="14"></iconify-icon>
                                        Vista previa disponible
                                    </span>
                                </div>
                    
                                <div class="cf-cert-meta-grid">
                                    <div class="cf-cert-meta">
                                        <div class="cf-cert-meta-label">Documento</div>
                                        <div class="cf-cert-meta-value">Certificado de inspección</div>
                                    </div>
                    
                                    <div class="cf-cert-meta">
                                        <div class="cf-cert-meta-label">Equipo</div>
                                        <div class="cf-cert-meta-value">Excavadora CAT 320 GC</div>
                                    </div>
                    
                                    <div class="cf-cert-meta">
                                        <div class="cf-cert-meta-label">Empresa</div>
                                        <div class="cf-cert-meta-value">LUCHO VIP</div>
                                    </div>
                    
                                    <div class="cf-cert-meta">
                                        <div class="cf-cert-meta-label">Estado actual</div>
                                        <div class="cf-cert-meta-value" x-text="labelResultado()"></div>
                                    </div>
                                </div>
                    
                                <div class="cf-cert-preview">
                                    <div class="cf-cert-preview-head">
                                        <div class="cf-cert-preview-title">Previsualización del PDF</div>
                                        <div class="cf-cert-preview-sub">
                                            Vista real del certificado generado en formato PDF.
                                        </div>
                                    </div>
                                
                                    <div class="cf-pdf-viewer">
                                        @if(!empty($pdfPreviewUrl))
                                            <iframe
                                                src="{{ $pdfPreviewUrl }}#toolbar=1&navpanes=0&scrollbar=1"
                                                class="cf-pdf-frame"
                                            ></iframe>
                                        @else
                                            <div class="cf-pdf-empty">
                                                <div class="cf-pdf-empty-icon">
                                                    <iconify-icon icon="solar:file-text-bold-duotone" width="28"></iconify-icon>
                                                </div>
                                
                                                <div class="cf-pdf-empty-title">Aún no hay PDF para previsualizar</div>
                                                <div class="cf-pdf-empty-text">
                                                    Genera el certificado para mostrar aquí la vista previa real del documento.
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                    
                                <div class="cf-cert-actions">
                                    <button type="button" class="cf-btn cf-btn-light">
                                        <iconify-icon icon="solar:eye-outline" width="16"></iconify-icon>
                                        Previsualizar certificado
                                    </button>
                    
                                    <button type="button" class="cf-btn cf-btn-primary">
                                        <iconify-icon icon="solar:file-download-outline" width="16"></iconify-icon>
                                        Generar PDF
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cf-footer">
                        <div class="text-[0.74rem] text-slate-500">
                            Paso 5 de 5 · Confirmación final del registro
                        </div>
                    
                        <div class="flex gap-2 flex-wrap justify-end">
                            <button type="button" class="cf-btn cf-btn-light">
                                <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                Anterior
                            </button>
                    
                            <button type="button" class="cf-btn cf-btn-light">
                                <iconify-icon icon="solar:document-add-outline" width="16"></iconify-icon>
                                Guardar borrador
                            </button>
                    
                            <button type="button" class="cf-btn cf-btn-primary">
                                <iconify-icon icon="solar:eye-outline" width="16"></iconify-icon>
                                Previsualizar PDF
                            </button>
                    
                            <button type="button" class="cf-btn cf-btn-success">
                                <iconify-icon icon="solar:file-download-outline" width="16"></iconify-icon>
                                Guardar y generar PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lateral --}}
        <div class="space-y-5">
            <div class="cf-side-panel">
                <div class="cf-side-head">
                    <div class="flex items-start gap-3">
                        <div class="cf-side-icon cf-side-icon-blue">
                            <iconify-icon icon="solar:clipboard-check-bold-duotone" width="20"></iconify-icon>
                        </div>

                        <div>
                            <div class="cf-side-title">Resumen ejecutivo</div>
                            <div class="cf-side-text">
                                Validación rápida de la inspección antes del guardado final.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cf-side-body">
                    <div class="cf-side-summary">
                        <div class="cf-side-item">
                            <div class="cf-side-label">Equipo</div>
                            <div class="cf-side-value">Excavadora CAT 320 GC</div>
                        </div>

                        <div class="cf-side-item">
                            <div class="cf-side-label">Ítems evaluados</div>
                            <div class="cf-side-value">12</div>
                        </div>

                        <div class="cf-side-item">
                            <div class="cf-side-label">No conformidades</div>
                            <div class="cf-side-value text-amber-600">3 detectadas</div>
                        </div>

                        <div class="cf-side-item">
                            <div class="cf-side-label">Resultado final</div>
                            <div class="cf-side-value" x-text="labelResultado()"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cf-side-panel">
                <div class="cf-side-head">
                    <div class="flex items-start gap-3">
                        <div class="cf-side-icon cf-side-icon-amber">
                            <iconify-icon icon="solar:danger-triangle-bold-duotone" width="20"></iconify-icon>
                        </div>

                        <div>
                            <div class="cf-side-title">Observaciones relevantes</div>
                            <div class="cf-side-text">
                                Hallazgos críticos o principales del registro actual.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cf-side-body space-y-3">
                    <div class="cf-side-item">
                        <div class="cf-side-label">Ítem 02</div>
                        <div class="cf-side-value">Sistema de protección y seguridad</div>
                    </div>

                    <div class="cf-side-item">
                        <div class="cf-side-label">Ítem 05</div>
                        <div class="cf-side-value">Conexiones y elementos expuestos</div>
                    </div>
                </div>
            </div>

            <div class="cf-rule-panel">
                <div class="cf-rule-head">
                    <div class="flex items-start gap-3">
                        <div class="cf-side-icon cf-side-icon-slate">
                            <iconify-icon icon="solar:info-circle-bold-duotone" width="20"></iconify-icon>
                        </div>

                        <div>
                            <div class="cf-rule-title">Reglas del paso</div>
                            <div class="cf-rule-text">
                                Validaciones finales antes de completar el wizard.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cf-rule-body">
                    <div class="cf-rule-list">
                        <div class="cf-rule-item">
                            <iconify-icon icon="solar:check-read-bold" width="16"></iconify-icon>
                            <span>Verifica que empresa, equipo, fecha, responsable y resultado final sean correctos.</span>
                        </div>

                        <div class="cf-rule-item">
                            <iconify-icon icon="solar:danger-triangle-bold" width="16"></iconify-icon>
                            <span>Si la inspección queda observada, confirma que exista fecha límite de levantamiento.</span>
                        </div>

                        <div class="cf-rule-item">
                            <iconify-icon icon="solar:document-text-bold" width="16"></iconify-icon>
                            <span>La conclusión técnica y la recomendación deben reflejar fielmente el checklist evaluado.</span>
                        </div>

                        <div class="cf-rule-item">
                            <iconify-icon icon="solar:diskette-bold" width="16"></iconify-icon>
                            <span>Al guardar, el sistema registrará definitivamente la inspección y su estado.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmacionStep() {
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