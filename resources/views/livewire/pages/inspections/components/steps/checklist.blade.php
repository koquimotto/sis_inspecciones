<div
    class="ck-step space-y-5"
    x-data="checklistStep()"
>
    <style>
        .ck-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.75fr) minmax(320px, .9fr);
            gap: 18px;
        }

        .ck-panel {
            background: #ffffff;
            border: 1px solid #dbe3ee;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .ck-panel-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .ck-panel-body {
            padding: 18px;
        }

        .ck-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.01em;
        }

        .ck-sub {
            margin-top: 3px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.45;
        }

        .ck-top-card {
            border: 1px solid #bfdbfe;
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
            padding: 16px;
        }

        .ck-top-title {
            font-size: 0.95rem;
            font-weight: 900;
            color: #0f172a;
        }

        .ck-top-meta {
            margin-top: 5px;
            font-size: 0.74rem;
            color: #475569;
            line-height: 1.5;
        }

        .ck-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .ck-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid;
        }

        .ck-tag-blue {
            background: #dbeafe;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .ck-tag-slate {
            background: #f8fafc;
            color: #475569;
            border-color: #cbd5e1;
        }

        .ck-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .ck-stat {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 14px;
        }

        .ck-stat-label {
            font-size: 0.69rem;
            font-weight: 700;
            color: #64748b;
        }

        .ck-stat-value {
            margin-top: 7px;
            font-size: 1rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.1;
            letter-spacing: -.02em;
        }

        .ck-stat-note {
            margin-top: 6px;
            font-size: 0.69rem;
            color: #64748b;
        }

        .ck-items {
            display: grid;
            gap: 14px;
        }

        .ck-item {
            border: 1px solid #dbe3ee;
            background: #fff;
            transition: .18s ease;
        }

        .ck-item.is-disabled {
            opacity: .60;
            background: linear-gradient(180deg, #fafafa 0%, #f5f5f5 100%);
        }

        .ck-item-head {
            padding: 14px 16px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .ck-item-code {
            font-size: 0.67rem;
            font-weight: 900;
            color: #2563eb;
            letter-spacing: .10em;
            text-transform: uppercase;
        }

        .ck-item-title {
            margin-top: 4px;
            font-size: 0.86rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.35;
        }

        .ck-item-text {
            margin-top: 5px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.55;
        }

        .ck-item-body {
            padding: 16px;
        }

        /* .ck-item-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: flex-end;
        } */
        
        .ck-item-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .ck-group-label {
            margin-bottom: 7px;
            font-size: 0.69rem;
            font-weight: 800;
            color: #64748b;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .ck-answer-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-end;
        }

        .ck-answer {
            min-width: 132px;
            height: 38px;
            padding: 0 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 0.72rem;
            font-weight: 900;
            border: 1px solid #dbe3ee;
            background: #fff;
            color: #334155;
            transition: .18s ease;
        }

        .ck-answer:hover {
            background: #f8fafc;
        }

        .ck-answer.ok.active {
            background: #ecfdf5;
            color: #047857;
            border-color: #bbf7d0;
        }

        .ck-answer.bad.active {
            background: #fff7ed;
            color: #b45309;
            border-color: #fcd34d;
        }

        .ck-answer.apply.active {
            background: #dbeafe;
            color: #1d4ed8;
            border-color: #93c5fd;
        }

        .ck-answer.not-apply.active {
            background: #e2e8f0;
            color: #334155;
            border-color: #94a3b8;
        }

        .ck-label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.72rem;
            font-weight: 800;
            color: #334155;
        }

        .ck-required {
            color: #dc2626;
            margin-left: 2px;
        }

        .ck-input,
        .ck-textarea {
            width: 100%;
            background: #fff;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            font-size: 0.82rem;
            transition: .18s ease;
        }

        .ck-input {
            height: 42px;
            padding: 0 12px;
        }

        .ck-textarea {
            min-height: 92px;
            padding: 10px 12px;
            resize: vertical;
        }

        .ck-input:focus,
        .ck-textarea:focus {
            outline: none;
            border-color: rgb(var(--primary));
            box-shadow: 0 0 0 3px rgba(var(--primary), .12);
        }

        .ck-evidence-inline {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ck-evidence-thumb {
            width: 78px;
            height: 62px;
            border: 1px solid #cbd5e1;
            background: #fff;
            overflow: hidden;
            flex-shrink: 0;
        }

        .ck-evidence-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .ck-evidence-add {
            width: 78px;
            height: 62px;
            border: 1px dashed #cbd5e1;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            transition: .18s ease;
            flex-shrink: 0;
        }

        .ck-evidence-add:hover {
            border-color: rgb(var(--primary));
            color: rgb(var(--primary));
            background: #f8fbff;
        }

        .ck-add-item-wrap {
            padding-top: 4px;
        }

        .ck-add-item-btn {
            width: 100%;
            height: 46px;
            border: 1px dashed #cbd5e1;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            color: #475569;
            font-size: 0.78rem;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: .18s ease;
        }

        .ck-add-item-btn:hover {
            border-color: rgb(var(--primary));
            color: rgb(var(--primary));
            background: #f8fbff;
        }

        .ck-side-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            flex-shrink: 0;
        }

        .ck-side-icon-blue {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #2563eb;
        }

        .ck-side-icon-amber {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #d97706;
        }

        .ck-side-icon-slate {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #475569;
        }

        .ck-side-panel {
            background: #fff;
            border: 1px solid #dbe3ee;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .ck-side-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .ck-side-body {
            padding: 16px 18px;
        }

        .ck-side-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #0f172a;
        }

        .ck-side-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.5;
        }

        .ck-side-summary {
            display: grid;
            gap: 10px;
        }

        .ck-side-item {
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 11px 12px;
        }

        .ck-side-label {
            font-size: 0.69rem;
            font-weight: 700;
            color: #64748b;
        }

        .ck-side-value {
            margin-top: 5px;
            font-size: 0.80rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.4;
        }

        .ck-progress-box {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 14px;
        }

        .ck-progress-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            font-size: 0.72rem;
            font-weight: 800;
            color: #475569;
        }

        .ck-progress-bar {
            margin-top: 10px;
            height: 8px;
            background: #e2e8f0;
            overflow: hidden;
        }

        .ck-progress-fill {
            height: 100%;
            width: 58%;
            background: #2563eb;
        }

        .ck-mini-card-observed {
            border: 1px solid #fde68a;
            background: linear-gradient(180deg, #fffdf7 0%, #fffbeb 100%);
            padding: 14px;
        }

        .ck-mini-title {
            font-size: 0.77rem;
            font-weight: 900;
            color: #0f172a;
        }

        .ck-mini-meta {
            margin-top: 4px;
            font-size: 0.70rem;
            color: #64748b;
            line-height: 1.45;
        }

        .ck-status-chip-observed {
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

        .ck-rule-panel {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .ck-rule-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .ck-rule-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #0f172a;
        }

        .ck-rule-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.5;
        }

        .ck-rule-body {
            padding: 16px 18px;
        }

        .ck-rule-list {
            display: grid;
            gap: 12px;
        }

        .ck-rule-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.75rem;
            line-height: 1.55;
            color: #475569;
        }

        .ck-rule-item iconify-icon {
            color: #2563eb;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .ck-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #eef2f7;
            padding-top: 16px;
        }

        .ck-btn {
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

        .ck-btn-primary {
            background: rgb(var(--primary));
            color: #fff;
            border-color: rgb(var(--primary));
        }

        .ck-btn-primary:hover {
            filter: brightness(.98);
        }

        .ck-btn-light {
            background: #fff;
            color: #334155;
            border-color: #cbd5e1;
        }

        .ck-btn-light:hover {
            background: #f8fafc;
        }

        .ck-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            z-index: 70;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .ck-modal {
            width: 100%;
            max-width: 560px;
            background: #fff;
            border: 1px solid #cbd5e1;
            box-shadow: 0 24px 48px rgba(15, 23, 42, .22);
        }

        .ck-modal-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .ck-modal-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: #0f172a;
        }

        .ck-modal-text {
            margin-top: 3px;
            font-size: 0.73rem;
            color: #64748b;
        }

        .ck-modal-body {
            padding: 18px;
        }

        .ck-modal-foot {
            padding: 16px 18px;
            border-top: 1px solid #eef2f7;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .ck-item-actions-inline {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            justify-content: flex-end;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (max-width: 1399px) {
            .ck-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1199px) {
            .ck-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .ck-stats {
                grid-template-columns: 1fr;
            }

            .ck-item-head {
                flex-direction: column;
            }

            .ck-item-actions {
                width: 100%;
                align-items: stretch;
            }

            .ck-answer-group {
                justify-content: flex-start;
            }
        }
    </style>

    <div class="ck-layout">
        {{-- Principal --}}
        <div class="space-y-5">
            <div class="ck-panel">
                <div class="ck-panel-head">
                    <div class="ck-title">Checklist de inspección</div>
                    <div class="ck-sub">
                        Evalúa cada ítem del equipo seleccionado y registra observaciones y evidencias cuando corresponda.
                    </div>
                </div>

                <div class="ck-panel-body space-y-5">
                    <div class="ck-top-card">
                        <div class="ck-top-title">Excavadora CAT 320 GC</div>
                        <div class="ck-top-meta">
                            Código: EQ-002 · Caterpillar · Modelo 320 GC · Empresa: LUCHO VIP · Servicio: Servicio 1
                        </div>

                        <div class="ck-tags">
                            <span class="ck-tag ck-tag-blue">
                                <iconify-icon icon="solar:shield-check-outline" width="13"></iconify-icon>
                                Equipo activo
                            </span>

                            <span class="ck-tag ck-tag-slate">
                                <iconify-icon icon="solar:checklist-minimalistic-outline" width="13"></iconify-icon>
                                Checklist técnico
                            </span>
                        </div>
                    </div>

                    <div class="ck-stats">
                        <div class="ck-stat">
                            <div class="ck-stat-label">Ítems</div>
                            <div class="ck-stat-value" x-text="items.length"></div>
                            <div class="ck-stat-note">Total del checklist</div>
                        </div>

                        <div class="ck-stat">
                            <div class="ck-stat-label">Cumple</div>
                            <div class="ck-stat-value text-emerald-600" x-text="countByEstado('cumple')"></div>
                            <div class="ck-stat-note">Respondidos conformes</div>
                        </div>

                        <div class="ck-stat">
                            <div class="ck-stat-label">No cumple</div>
                            <div class="ck-stat-value text-amber-600" x-text="countByEstado('no_cumple')"></div>
                            <div class="ck-stat-note">Con observación</div>
                        </div>

                        <div class="ck-stat">
                            <div class="ck-stat-label">No aplica</div>
                            <div class="ck-stat-value text-slate-600" x-text="countNoAplica()"></div>
                            <div class="ck-stat-note">Ítems deshabilitados</div>
                        </div>
                    </div>

                    <div class="ck-items">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="ck-item" :class="{ 'is-disabled': item.aplica === false }">
                                <div class="ck-item-head">
                                    <div>
                                        <div class="ck-item-code" x-text="'Ítem ' + String(index + 1).padStart(2, '0')"></div>
                                        <div class="ck-item-title" x-text="item.titulo"></div>
                                        <div class="ck-item-text" x-text="item.descripcion"></div>
                                    </div>

                                    <div class="ck-item-actions-inline">
                                        <button
                                            type="button"
                                            class="ck-answer"
                                            :class="item.estado === 'cumple' ? 'ok active' : 'bad active'"
                                            @click="toggleEstado(item)"
                                            :disabled="item.aplica === false"
                                        >
                                            <iconify-icon
                                                :icon="item.estado === 'cumple'
                                                    ? 'solar:check-circle-bold'
                                                    : 'solar:danger-circle-bold'"
                                                width="14"
                                            ></iconify-icon>
                                            <span x-text="item.estado === 'cumple' ? 'Cumple' : 'No cumple'"></span>
                                        </button>
                                    
                                        <button
                                            type="button"
                                            class="ck-answer"
                                            :class="item.aplica ? 'apply active' : 'not-apply active'"
                                            @click="toggleAplica(item)"
                                        >
                                            <iconify-icon
                                                :icon="item.aplica
                                                    ? 'solar:shield-check-bold'
                                                    : 'solar:slash-circle-bold'"
                                                width="14"
                                            ></iconify-icon>
                                            <span x-text="item.aplica ? 'Sí aplica' : 'No aplica'"></span>
                                        </button>
                                    </div>
                                </div>

                                <template x-if="item.aplica === true && item.estado === 'no_cumple'">
                                    <div class="ck-item-body">
                                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-3">
                                            <div class="lg:col-span-8">
                                                <label class="ck-label">
                                                    Observación del ítem <span class="ck-required">*</span>
                                                </label>
                                                <textarea
                                                    class="ck-textarea"
                                                    x-model="item.observacion"
                                                    placeholder="Describe la observación encontrada..."
                                                ></textarea>
                                            </div>

                                            <div class="lg:col-span-4">
                                                <label class="ck-label">
                                                    Evidencias fotográficas <span class="ck-required">*</span>
                                                </label>

                                                <div class="ck-evidence-inline">
                                                    <template x-for="(img, imgIndex) in item.imagenes" :key="imgIndex">
                                                        <div class="ck-evidence-thumb">
                                                            <img :src="img" alt="evidencia">
                                                        </div>
                                                    </template>

                                                    <button type="button" class="ck-evidence-add" title="Agregar evidencia">
                                                        <iconify-icon icon="solar:add-circle-outline" width="18"></iconify-icon>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <div class="ck-add-item-wrap">
                        <button
                            type="button"
                            class="ck-add-item-btn"
                            @click="modalNuevoItem = true"
                        >
                            <iconify-icon icon="solar:add-circle-bold-duotone" width="18"></iconify-icon>
                            Agregar nuevo ítem al checklist
                        </button>
                    </div>

                    <div class="ck-footer">
                        <div class="text-[0.74rem] text-slate-500">
                            Paso 3 de 5 · Evaluación del checklist del equipo seleccionado
                        </div>

                        <div class="flex gap-2">
                            <button type="button" class="ck-btn ck-btn-light">
                                <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                Anterior
                            </button>

                            <button type="button" class="ck-btn ck-btn-primary">
                                Siguiente: Resultado
                                <iconify-icon icon="solar:arrow-right-outline" width="16"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lateral --}}
        <div class="space-y-5">
            <div class="ck-side-panel">
                <div class="ck-side-head">
                    <div class="flex items-start gap-3">
                        <div class="ck-side-icon ck-side-icon-blue">
                            <iconify-icon icon="solar:clipboard-check-bold-duotone" width="20"></iconify-icon>
                        </div>

                        <div>
                            <div class="ck-side-title">Resumen del checklist</div>
                            <div class="ck-side-text">
                                Vista rápida del avance del equipo activo.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ck-side-body">
                    <div class="ck-side-summary">
                        <div class="ck-side-item">
                            <div class="ck-side-label">Equipo activo</div>
                            <div class="ck-side-value">Excavadora CAT 320 GC</div>
                        </div>

                        <div class="ck-side-item">
                            <div class="ck-side-label">Ítems</div>
                            <div class="ck-side-value" x-text="items.length"></div>
                        </div>

                        <div class="ck-side-item">
                            <div class="ck-side-label">No conformidades</div>
                            <div class="ck-side-value text-amber-600" x-text="countByEstado('no_cumple') + ' detectadas'"></div>
                        </div>

                        <div class="ck-side-item">
                            <div class="ck-side-label">Evidencias cargadas</div>
                            <div class="ck-side-value" x-text="countImagenes() + ' imágenes'"></div>
                        </div>
                    </div>

                    <div class="ck-progress-box mt-4">
                        <div class="ck-progress-top">
                            <span>Avance del checklist</span>
                            <span>100%</span>
                        </div>

                        <div class="ck-progress-bar">
                            <div class="ck-progress-fill" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ck-side-panel">
                <div class="ck-side-head">
                    <div class="flex items-start gap-3">
                        <div class="ck-side-icon ck-side-icon-amber">
                            <iconify-icon icon="solar:danger-triangle-bold-duotone" width="20"></iconify-icon>
                        </div>

                        <div>
                            <div class="ck-side-title">Observaciones detectadas</div>
                            <div class="ck-side-text">
                                Hallazgos pendientes dentro del checklist actual.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ck-side-body space-y-3">
                    <template x-for="item in items.filter(i => i.aplica === true && i.estado === 'no_cumple')" :key="'obs-' + item.id">
                        <div class="ck-mini-card-observed">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="ck-mini-title" x-text="item.titulo"></div>
                                    <div class="ck-mini-meta" x-text="item.observacion || 'Pendiente de detalle de observación'"></div>
                                </div>

                                <span class="ck-status-chip-observed">
                                    <iconify-icon icon="solar:clipboard-remove-bold" width="14"></iconify-icon>
                                    Observado
                                </span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="ck-rule-panel">
                <div class="ck-rule-head">
                    <div class="flex items-start gap-3">
                        <div class="ck-side-icon ck-side-icon-slate">
                            <iconify-icon icon="solar:info-circle-bold-duotone" width="20"></iconify-icon>
                        </div>

                        <div>
                            <div class="ck-rule-title">Reglas del paso</div>
                            <div class="ck-rule-text">
                                Consideraciones importantes antes de continuar al resultado.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ck-rule-body">
                    <div class="ck-rule-list">
                        <div class="ck-rule-item">
                            <iconify-icon icon="solar:check-read-bold" width="16"></iconify-icon>
                            <span>Por defecto, cada ítem inicia en “Cumple” y “Sí aplica”.</span>
                        </div>

                        <div class="ck-rule-item">
                            <iconify-icon icon="solar:danger-triangle-bold" width="16"></iconify-icon>
                            <span>Si cambias a “No cumple”, se mostrarán observación e imágenes.</span>
                        </div>

                        <div class="ck-rule-item">
                            <iconify-icon icon="solar:slash-circle-bold" width="16"></iconify-icon>
                            <span>Si el ítem pasa a “No aplica”, queda inhabilitado y no participa en la inspección.</span>
                        </div>

                        <div class="ck-rule-item">
                            <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                            <span>Puedes agregar nuevos ítems al final del checklist desde el botón grande.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal nuevo item --}}
    <div x-show="modalNuevoItem" x-cloak class="ck-modal-backdrop">
        <div class="ck-modal">
            <div class="ck-modal-head">
                <div>
                    <div class="ck-modal-title">Agregar nuevo ítem al checklist</div>
                    <div class="ck-modal-text">
                        Registra un nuevo criterio de evaluación. Se añadirá al final del listado.
                    </div>
                </div>

                <button
                    type="button"
                    class="ck-btn ck-btn-light !h-[36px]"
                    @click="cerrarModalItem()"
                >
                    <iconify-icon icon="solar:close-circle-outline" width="15"></iconify-icon>
                    Cerrar
                </button>
            </div>

            <div class="ck-modal-body">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="ck-label">
                            Título del ítem <span class="ck-required">*</span>
                        </label>
                        <input
                            type="text"
                            class="ck-input"
                            x-model="nuevoItem.titulo"
                            placeholder="Ej. Verificación de pernos de fijación"
                        >
                    </div>

                    <div>
                        <label class="ck-label">
                            Descripción <span class="ck-required">*</span>
                        </label>
                        <textarea
                            class="ck-textarea"
                            x-model="nuevoItem.descripcion"
                            placeholder="Describe brevemente el criterio de evaluación..."
                            style="min-height: 90px;"
                        ></textarea>
                    </div>
                </div>
            </div>

            <div class="ck-modal-foot">
                <button
                    type="button"
                    class="ck-btn ck-btn-light"
                    @click="cerrarModalItem()"
                >
                    Cancelar
                </button>

                <button
                    type="button"
                    class="ck-btn ck-btn-primary"
                    @click="agregarItem()"
                >
                    <iconify-icon icon="solar:diskette-outline" width="16"></iconify-icon>
                    Guardar ítem
                </button>
            </div>
        </div>
    </div>

    <script>
        function checklistStep() {
            return {
                modalNuevoItem: false,
                nuevoItem: {
                    titulo: '',
                    descripcion: '',
                },
                items: [
                    {
                        id: 1,
                        titulo: 'Estado general del equipo',
                        descripcion: 'Verificar limpieza, corrosión, daños visibles, integridad estructural y condición superficial general del equipo.',
                        estado: 'cumple',
                        aplica: true,
                        observacion: '',
                        imagenes: [
                            'https://images.unsplash.com/photo-1581092921461-7d65ca45d354?auto=format&fit=crop&w=400&q=80',
                            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=400&q=80'
                        ]
                    },
                    {
                        id: 2,
                        titulo: 'Sistema de protección y seguridad',
                        descripcion: 'Revisar guardas, protecciones, fijaciones y componentes de seguridad visibles del equipo.',
                        estado: 'no_cumple',
                        aplica: true,
                        observacion: 'Se detecta guarda lateral con fijación incompleta. Requiere ajuste y reposición inmediata de pernos.',
                        imagenes: [
                            'https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?auto=format&fit=crop&w=400&q=80',
                            'https://images.unsplash.com/photo-1516321165247-4aa89a48be28?auto=format&fit=crop&w=400&q=80'
                        ]
                    },
                    {
                        id: 3,
                        titulo: 'Identificación y señalización',
                        descripcion: 'Verificar que la unidad cuente con identificación visible, señalización y datos operativos mínimos.',
                        estado: 'cumple',
                        aplica: false,
                        observacion: '',
                        imagenes: []
                    },
                    {
                        id: 4,
                        titulo: 'Fugas y derrames visibles',
                        descripcion: 'Inspeccionar presencia de fugas de aceite, refrigerante o fluidos en componentes y zona inmediata.',
                        estado: 'cumple',
                        aplica: true,
                        observacion: '',
                        imagenes: []
                    }
                ],

                toggleEstado(item) {
                    if (item.aplica === false) return;
                    item.estado = item.estado === 'cumple' ? 'no_cumple' : 'cumple';
                    if (item.estado === 'cumple') {
                        item.observacion = '';
                    }
                },

                toggleAplica(item) {
                    item.aplica = !item.aplica;

                    if (item.aplica === false) {
                        item.estado = 'cumple';
                        item.observacion = '';
                    }
                },

                countByEstado(estado) {
                    return this.items.filter(item => item.aplica === true && item.estado === estado).length;
                },

                countNoAplica() {
                    return this.items.filter(item => item.aplica === false).length;
                },

                countImagenes() {
                    return this.items
                        .filter(item => item.aplica === true && item.estado === 'no_cumple')
                        .reduce((total, item) => total + item.imagenes.length, 0);
                },

                cerrarModalItem() {
                    this.modalNuevoItem = false;
                    this.nuevoItem = {
                        titulo: '',
                        descripcion: '',
                    };
                },

                agregarItem() {
                    if (!this.nuevoItem.titulo.trim() || !this.nuevoItem.descripcion.trim()) {
                        return;
                    }

                    this.items.push({
                        id: Date.now(),
                        titulo: this.nuevoItem.titulo,
                        descripcion: this.nuevoItem.descripcion,
                        estado: 'cumple',
                        aplica: true,
                        observacion: '',
                        imagenes: []
                    });

                    this.cerrarModalItem();
                }
            }
        }
    </script>
</div>