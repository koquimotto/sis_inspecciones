<div class="eq-step space-y-5" x-data="{ modalEquipo: false }">
    <style>
        .eq-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.75fr) minmax(320px, .9fr);
            gap: 18px;
        }

        .eq-panel {
            background: #ffffff;
            border: 1px solid #dbe3ee;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .eq-panel-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .eq-panel-body {
            padding: 18px;
        }

        .eq-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.01em;
        }

        .eq-sub {
            margin-top: 3px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.45;
        }

        .eq-label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.72rem;
            font-weight: 800;
            color: #334155;
        }

        .eq-required {
            color: #dc2626;
            margin-left: 2px;
        }

        .eq-input,
        .eq-select,
        .eq-textarea {
            width: 100%;
            background: #fff;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            font-size: 0.82rem;
            transition: .18s ease;
        }

        .eq-input,
        .eq-select {
            height: 42px;
            padding: 0 12px;
        }

        .eq-textarea {
            min-height: 96px;
            padding: 10px 12px;
            resize: vertical;
        }

        .eq-input:focus,
        .eq-select:focus,
        .eq-textarea:focus {
            outline: none;
            border-color: rgb(var(--primary));
            box-shadow: 0 0 0 3px rgba(var(--primary), .12);
        }

        .eq-btn {
            height: 42px;
            padding: 0 13px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 0.78rem;
            font-weight: 800;
            border: 1px solid transparent;
            transition: .18s ease;
            white-space: nowrap;
        }

        .eq-btn-primary {
            background: rgb(var(--primary));
            color: #fff;
            border-color: rgb(var(--primary));
        }

        .eq-btn-primary:hover {
            filter: brightness(.98);
        }

        .eq-btn-light {
            background: #fff;
            color: #334155;
            border-color: #cbd5e1;
        }

        .eq-btn-light:hover {
            background: #f8fafc;
        }

        .eq-btn-success {
            background: #059669;
            color: #fff;
            border-color: #059669;
        }

        .eq-btn-success:hover {
            background: #047857;
            border-color: #047857;
        }

        .eq-toolbar {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) repeat(3, minmax(0, .55fr)) auto;
            gap: 10px;
        }

        .eq-stat-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .eq-stat {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 14px;
        }

        .eq-stat-label {
            font-size: 0.69rem;
            font-weight: 700;
            color: #64748b;
        }

        .eq-stat-value {
            margin-top: 7px;
            font-size: 1rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.1;
            letter-spacing: -.02em;
        }

        .eq-stat-note {
            margin-top: 6px;
            font-size: 0.69rem;
            color: #64748b;
        }

        .eq-list {
            display: grid;
            gap: 12px;
        }

        .eq-card {
            border: 1px solid #dbe3ee;
            background: #fff;
            padding: 14px;
        }

        .eq-card.selected {
            border-color: #93c5fd;
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
        }

        .eq-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .eq-card-left {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            min-width: 0;
        }
        
        .eq-card.eq-active {
            border: 1px solid #93c5fd;
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
            box-shadow: inset 0 0 0 1px rgba(59,130,246,.15);
        }

        .eq-check {
            margin-top: 3px;
            flex-shrink: 0;
        }
        
        .eq-radio {
            margin-top: 4px;
            width: 16px;
            height: 16px;
            accent-color: rgb(var(--primary));
        }

        .eq-name {
            font-size: 0.86rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.3;
        }

        .eq-meta {
            margin-top: 4px;
            font-size: 0.72rem;
            color: #64748b;
            line-height: 1.5;
        }

        .eq-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .eq-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid #dbe3ee;
            background: #f8fafc;
            color: #475569;
        }

        .eq-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid;
            white-space: nowrap;
        }

        .eq-status-ok {
            background: #ecfdf5;
            color: #047857;
            border-color: #bbf7d0;
        }

        .eq-status-warn {
            background: #fff7ed;
            color: #c2410c;
            border-color: #fed7aa;
        }

        .eq-status-off {
            background: #f8fafc;
            color: #475569;
            border-color: #cbd5e1;
        }

        .eq-inline-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .eq-summary-grid {
            display: grid;
            gap: 10px;
        }

        .eq-summary-item {
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 11px 12px;
        }

        .eq-summary-label {
            font-size: 0.69rem;
            font-weight: 700;
            color: #64748b;
        }

        .eq-summary-value {
            margin-top: 5px;
            font-size: 0.80rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.4;
        }

        .eq-mini-list {
            display: grid;
            gap: 10px;
        }

        .eq-mini-card {
            border: 1px solid #e2e8f0;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 12px;
        }

        .eq-mini-title {
            font-size: 0.77rem;
            font-weight: 900;
            color: #0f172a;
        }

        .eq-mini-meta {
            margin-top: 4px;
            font-size: 0.70rem;
            color: #64748b;
            line-height: 1.45;
        }

        .eq-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #eef2f7;
            padding-top: 16px;
        }

        .eq-note {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 16px;
        }

        .eq-note-title {
            font-size: 0.82rem;
            font-weight: 900;
            color: #0f172a;
        }

        .eq-note-list {
            margin-top: 10px;
            display: grid;
            gap: 10px;
            font-size: 0.75rem;
            line-height: 1.55;
            color: #64748b;
        }

        .eq-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            z-index: 60;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .eq-modal {
            width: 100%;
            max-width: 760px;
            background: #fff;
            border: 1px solid #cbd5e1;
            box-shadow: 0 24px 48px rgba(15, 23, 42, .22);
        }

        .eq-modal-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .eq-modal-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: #0f172a;
        }

        .eq-modal-text {
            margin-top: 3px;
            font-size: 0.73rem;
            color: #64748b;
        }

        .eq-modal-body {
            padding: 18px;
        }

        .eq-modal-foot {
            padding: 16px 18px;
            border-top: 1px solid #eef2f7;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        
        .eq-panel {
            position: relative;
            background: #ffffff;
            border: 1px solid #dbe3ee;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }
        
        .eq-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #cbd5e1;
        }
        
        .eq-panel.eq-panel-active::before {
            background: #2563eb;
        }
        
        .eq-panel.eq-panel-progress::before {
            background: #0ea5e9;
        }
        
        .eq-panel.eq-panel-observed::before {
            background: #f59e0b;
        }
        
        .eq-panel-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }
        
        .eq-panel.eq-panel-active .eq-panel-head {
            background: linear-gradient(180deg, #eff6ff 0%, #f8fbff 100%);
        }
        
        .eq-panel.eq-panel-progress .eq-panel-head {
            background: linear-gradient(180deg, #f0f9ff 0%, #f8fcff 100%);
        }
        
        .eq-panel.eq-panel-observed .eq-panel-head {
            background: linear-gradient(180deg, #fffbeb 0%, #fffdf7 100%);
        }
        
        .eq-panel.eq-panel-active .eq-title {
            color: #1d4ed8;
        }
        
        .eq-panel.eq-panel-progress .eq-title {
            color: #0369a1;
        }
        
        .eq-panel.eq-panel-observed .eq-title {
            color: #b45309;
        }
        
        .eq-mini-card {
            border: 1px solid #e2e8f0;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 12px;
        }
        
        .eq-panel.eq-panel-active .eq-mini-card {
            border-color: #bfdbfe;
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
        }
        
        .eq-panel.eq-panel-progress .eq-mini-card {
            border-color: #bae6fd;
            background: linear-gradient(180deg, #f6fdff 0%, #eef9ff 100%);
        }
        
        .eq-panel.eq-panel-observed .eq-mini-card {
            border-color: #fde68a;
            background: linear-gradient(180deg, #fffdf7 0%, #fffbeb 100%);
        }
        
        .eq-mini-meta.text-blue-600 {
            color: #2563eb !important;
            font-weight: 700;
        }
        
        .eq-mini-meta.text-amber-600 {
            color: #d97706 !important;
            font-weight: 700;
        }
        
        .eq-alert {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 14px;
            padding: 16px;
            border: 1px solid;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }
        
        .eq-alert-info {
            background: linear-gradient(180deg, #fffdf7 0%, #fffbeb 100%);
            border-color: #fde68a;
        }
        
        .eq-alert-icon {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fef3c7;
            border: 1px solid #fcd34d;
            color: #b45309;
            flex-shrink: 0;
        }
        
        .eq-alert-content {
            min-width: 0;
        }
        
        .eq-alert-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #92400e;
            letter-spacing: -0.01em;
        }
        
        .eq-alert-text {
            margin-top: 4px;
            font-size: 0.74rem;
            color: #a16207;
            line-height: 1.5;
        }
        
        .eq-alert-list {
            margin-top: 12px;
            display: grid;
            gap: 10px;
        }
        
        .eq-alert-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 0.75rem;
            line-height: 1.5;
            color: #78350f;
        }
        
        .eq-alert-item iconify-icon {
            color: #d97706;
            flex-shrink: 0;
            margin-top: 2px;
        }
        
        .eq-panel-head-pro {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }
        
        .eq-panel-active-pro {
            position: relative;
            background: #ffffff;
            border: 1px solid #bfdbfe;
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.08);
            overflow: hidden;
        }
        
        .eq-panel-active-pro::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #2563eb;
        }
        
        .eq-panel-observed-pro {
            position: relative;
            background: #ffffff;
            border: 1px solid #fde68a;
            box-shadow: 0 8px 22px rgba(217, 119, 6, 0.08);
            overflow: hidden;
        }
        
        .eq-panel-observed-pro::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #d97706;
        }
        
        .eq-side-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid;
        }
        
        .eq-side-icon-active {
            background: #eff6ff;
            border-color: #bfdbfe;
            color: #2563eb;
        }
        
        .eq-side-icon-observed {
            background: #fff7ed;
            border-color: #fed7aa;
            color: #d97706;
        }
        
        .eq-side-icon-rule {
            background: #f8fafc;
            border-color: #cbd5e1;
            color: #334155;
        }
        
        .eq-mini-card-active {
            border: 1px solid #bfdbfe;
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
            padding: 14px;
        }
        
        .eq-mini-card-observed {
            border: 1px solid #fde68a;
            background: linear-gradient(180deg, #fffdf7 0%, #fffbeb 100%);
            padding: 14px;
        }
        
        .eq-side-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .eq-side-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid;
        }
        
        .eq-side-tag-blue {
            background: #dbeafe;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }
        
        .eq-side-tag-slate {
            background: #f8fafc;
            color: #475569;
            border-color: #cbd5e1;
        }
        
        .eq-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid;
            white-space: nowrap;
        }
        
        .eq-status-chip-active {
            background: #dbeafe;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }
        
        .eq-status-chip-observed {
            background: #fff7ed;
            color: #b45309;
            border-color: #fcd34d;
        }
        
        .eq-rule-panel {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }
        
        .eq-rule-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }
        
        .eq-rule-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -0.01em;
        }
        
        .eq-rule-text {
            margin-top: 4px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.5;
        }
        
        .eq-rule-body {
            padding: 16px 18px;
        }
        
        .eq-rule-list {
            display: grid;
            gap: 12px;
        }
        
        .eq-rule-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 0.75rem;
            line-height: 1.55;
            color: #475569;
        }
        
        .eq-rule-item iconify-icon {
            color: #2563eb;
            flex-shrink: 0;
            margin-top: 2px;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (max-width: 1399px) {
            .eq-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1199px) {
            .eq-toolbar {
                grid-template-columns: 1fr 1fr;
            }

            .eq-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .eq-toolbar,
            .eq-stat-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="eq-layout">
        {{-- Principal --}}
        <div class="space-y-5">
            <div class="eq-panel">
                <div class="eq-panel-head">
                    <div class="eq-title">Equipos a inspeccionar</div>
                    <div class="eq-sub">
                        Selecciona uno o más equipos de la empresa elegida. Si no existe el equipo, regístralo desde el modal.
                    </div>
                </div>

                <div class="eq-panel-body space-y-5">
                    <div class="eq-toolbar">
                        <div>
                            <label class="eq-label">Buscar equipo <span class="eq-required">*</span></label>
                            <input type="text" class="eq-input" placeholder="Buscar por código, nombre, placa, serie o modelo">
                        </div>

                        <div>
                            <label class="eq-label">Tipo</label>
                            <select class="eq-select">
                                <option>Todos</option>
                                <option>Volquete</option>
                                <option>Excavadora</option>
                                <option>Cargador frontal</option>
                                <option>Camión</option>
                            </select>
                        </div>

                        <div>
                            <label class="eq-label">Estado</label>
                            <select class="eq-select">
                                <option>Todos</option>
                                <option>Operativo</option>
                                <option>Revisión pendiente</option>
                                <option>Fuera de servicio</option>
                            </select>
                        </div>

                        <div>
                            <label class="eq-label">Código</label>
                            <input type="text" class="eq-input" placeholder="Ej. EQ-001">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="button" class="eq-btn eq-btn-primary">
                                <iconify-icon icon="solar:magnifer-outline" width="16"></iconify-icon>
                                Buscar
                            </button>

                            <button type="button" class="eq-btn eq-btn-success" @click="modalEquipo = true">
                                <iconify-icon icon="solar:add-circle-outline" width="16"></iconify-icon>
                                Nuevo equipo
                            </button>
                        </div>
                    </div>

                    <div class="eq-stat-grid">
                        <div class="eq-stat">
                            <div class="eq-stat-label">Equipos disponibles</div>
                            <div class="eq-stat-value">8</div>
                            <div class="eq-stat-note">Según empresa seleccionada</div>
                        </div>

                        <div class="eq-stat">
                            <div class="eq-stat-label">Equipo activo</div>
                            <div class="eq-stat-value">1</div>
                            <div class="eq-stat-note">Unidad en proceso</div>
                        </div>

                        <div class="eq-stat">
                            <div class="eq-stat-label">Operativos</div>
                            <div class="eq-stat-value text-emerald-600">2</div>
                            <div class="eq-stat-note">Estado actual</div>
                        </div>

                        <div class="eq-stat">
                            <div class="eq-stat-label">Pendientes</div>
                            <div class="eq-stat-value text-amber-600">1</div>
                            <div class="eq-stat-note">Requieren revisión</div>
                        </div>
                    </div>

                    <div class="eq-list">
                        <div class="text-[0.65rem] font-bold text-blue-600 mb-2">
                            EQUIPO ACTIVO
                        </div>
                        <div class="eq-card eq-active">
                            <div class="eq-card-top">
                                <div class="eq-card-left">
                                    <input type="radio" name="equipo_activo" checked class="eq-radio">

                                    <div class="min-w-0">
                                        <div class="eq-name">Volquete Volvo FMX 440</div>
                                        <div class="eq-meta">
                                            Código: EQ-001 · Placa: ABC-123 · Modelo: FMX 440 · Marca: Volvo
                                        </div>

                                        <div class="eq-tags">
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:bus-outline" width="13"></iconify-icon>
                                                Volquete
                                            </span>
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:map-point-outline" width="13"></iconify-icon>
                                                Patio principal
                                            </span>
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:document-outline" width="13"></iconify-icon>
                                                EQ-001
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <span class="eq-status eq-status-ok">
                                    <iconify-icon icon="solar:check-circle-bold" width="14"></iconify-icon>
                                    Operativo
                                </span>
                            </div>
                        </div>

                        <div class="eq-card">
                            <div class="eq-card-top">
                                <div class="eq-card-left">
                                    <input type="radio" name="equipo_activo" class="eq-radio">

                                    <div class="min-w-0">
                                        <div class="eq-name">Excavadora CAT 320 GC</div>
                                        <div class="eq-meta">
                                            Código: EQ-002 · Serie: CAT320GC01 · Modelo: 320 GC · Marca: Caterpillar
                                        </div>

                                        <div class="eq-tags">
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:settings-outline" width="13"></iconify-icon>
                                                Excavadora
                                            </span>
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:map-point-outline" width="13"></iconify-icon>
                                                Frente norte
                                            </span>
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:document-outline" width="13"></iconify-icon>
                                                EQ-002
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <span class="eq-status eq-status-warn">
                                    <iconify-icon icon="solar:danger-triangle-bold" width="14"></iconify-icon>
                                    Revisión pendiente
                                </span>
                            </div>
                        </div>

                        <div class="eq-card">
                            <div class="eq-card-top">
                                <div class="eq-card-left">
                                    <input type="radio" class="eq-radio">

                                    <div class="min-w-0">
                                        <div class="eq-name">Cargador frontal Komatsu WA380</div>
                                        <div class="eq-meta">
                                            Código: EQ-003 · Serie: KM-WA380-21 · Modelo: WA380 · Marca: Komatsu
                                        </div>

                                        <div class="eq-tags">
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:settings-outline" width="13"></iconify-icon>
                                                Cargador
                                            </span>
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:map-point-outline" width="13"></iconify-icon>
                                                Zona de carga
                                            </span>
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:document-outline" width="13"></iconify-icon>
                                                EQ-003
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <span class="eq-status eq-status-ok">
                                    <iconify-icon icon="solar:check-circle-bold" width="14"></iconify-icon>
                                    Operativo
                                </span>
                            </div>
                        </div>

                        <div class="eq-card">
                            <div class="eq-card-top">
                                <div class="eq-card-left">
                                    <input type="radio" class="eq-radio">

                                    <div class="min-w-0">
                                        <div class="eq-name">Camión cisterna Isuzu FVR</div>
                                        <div class="eq-meta">
                                            Código: EQ-004 · Placa: CDE-456 · Modelo: FVR · Marca: Isuzu
                                        </div>

                                        <div class="eq-tags">
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:bus-outline" width="13"></iconify-icon>
                                                Camión
                                            </span>
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:map-point-outline" width="13"></iconify-icon>
                                                Área de abastecimiento
                                            </span>
                                            <span class="eq-tag">
                                                <iconify-icon icon="solar:document-outline" width="13"></iconify-icon>
                                                EQ-004
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <span class="eq-status eq-status-off">
                                    <iconify-icon icon="solar:clock-circle-outline" width="14"></iconify-icon>
                                    Fuera de servicio
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="eq-footer">
                        <div class="text-[0.74rem] text-slate-500">
                            Paso 2 de 5 · Selección de equipos para la inspección
                        </div>

                        <div class="flex gap-2">
                            <button type="button" class="eq-btn eq-btn-light">
                                <iconify-icon icon="solar:arrow-left-outline" width="16"></iconify-icon>
                                Anterior
                            </button>

                            <button type="button" class="eq-btn eq-btn-primary">
                                Siguiente: Checklist
                                <iconify-icon icon="solar:arrow-right-outline" width="16"></iconify-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lateral --}}
        <div class="space-y-5">
            {{-- EQUIPO ACTIVO --}}
            <div class="eq-panel eq-panel-active-pro">
                <div class="eq-panel-head eq-panel-head-pro">
                    <div class="flex items-start gap-3">
                        <div class="eq-side-icon eq-side-icon-active">
                            <iconify-icon icon="solar:shield-check-bold-duotone" width="20"></iconify-icon>
                        </div>
        
                        <div>
                            <div class="eq-title">Equipo activo</div>
                            <div class="eq-sub">Unidad seleccionada para esta inspección.</div>
                        </div>
                    </div>
                </div>
        
                <div class="eq-panel-body">
                    <div class="eq-mini-card eq-mini-card-active">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="eq-mini-title">Excavadora CAT 320 GC</div>
                                <div class="eq-mini-meta">
                                    EQ-002 · Caterpillar · Modelo 320 GC
                                </div>
        
                                <div class="eq-side-tags mt-3">
                                    <span class="eq-side-tag eq-side-tag-blue">
                                        <iconify-icon icon="solar:document-text-outline" width="13"></iconify-icon>
                                        Código EQ-002
                                    </span>
        
                                    <span class="eq-side-tag eq-side-tag-slate">
                                        <iconify-icon icon="solar:map-point-outline" width="13"></iconify-icon>
                                        Frente norte
                                    </span>
                                </div>
                            </div>
        
                            <span class="eq-status-chip eq-status-chip-active">
                                <iconify-icon icon="solar:play-circle-bold" width="14"></iconify-icon>
                                Activo
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        
            {{-- EQUIPOS OBSERVADOS --}}
            <div class="eq-panel eq-panel-observed-pro">
                <div class="eq-panel-head eq-panel-head-pro">
                    <div class="flex items-start gap-3">
                        <div class="eq-side-icon eq-side-icon-observed">
                            <iconify-icon icon="solar:danger-triangle-bold-duotone" width="20"></iconify-icon>
                        </div>
        
                        <div>
                            <div class="eq-title">Equipos observados</div>
                            <div class="eq-sub">Unidades pendientes de levantamiento.</div>
                        </div>
                    </div>
                </div>
        
                <div class="eq-panel-body space-y-3">
                    <div class="eq-mini-card eq-mini-card-observed">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="eq-mini-title">Cargador Komatsu WA380</div>
                                <div class="eq-mini-meta">
                                    EQ-003 · Komatsu · WA380
                                </div>
                            </div>
        
                            <span class="eq-status-chip eq-status-chip-observed">
                                <iconify-icon icon="solar:clipboard-remove-bold" width="14"></iconify-icon>
                                Observado
                            </span>
                        </div>
                    </div>
        
                    <div class="eq-mini-card eq-mini-card-observed">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="eq-mini-title">Volquete Volvo FMX 440</div>
                                <div class="eq-mini-meta">
                                    EQ-001 · Volvo · FMX 440
                                </div>
                            </div>
        
                            <span class="eq-status-chip eq-status-chip-observed">
                                <iconify-icon icon="solar:clipboard-remove-bold" width="14"></iconify-icon>
                                Observado
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        
            {{-- REGLAS DEL PASO --}}
            <div class="eq-rule-panel">
                <div class="eq-rule-head">
                    <div class="flex items-start gap-3">
                        <div class="eq-side-icon eq-side-icon-rule">
                            <iconify-icon icon="solar:info-circle-bold-duotone" width="20"></iconify-icon>
                        </div>
        
                        <div>
                            <div class="eq-rule-title">Reglas del paso</div>
                            <div class="eq-rule-text">
                                Validaciones importantes antes de continuar al checklist.
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="eq-rule-body">
                    <div class="eq-rule-list">
                        <div class="eq-rule-item">
                            <iconify-icon icon="solar:check-read-bold" width="16"></iconify-icon>
                            <span>Selecciona un solo equipo activo para continuar.</span>
                        </div>
        
                        <div class="eq-rule-item">
                            <iconify-icon icon="solar:add-circle-bold" width="16"></iconify-icon>
                            <span>Si el equipo no existe, regístralo desde el modal sin salir del flujo.</span>
                        </div>
        
                        <div class="eq-rule-item">
                            <iconify-icon icon="solar:buildings-3-bold" width="16"></iconify-icon>
                            <span>La unidad debe pertenecer a la empresa y servicio definidos en el paso anterior.</span>
                        </div>
        
                        <div class="eq-rule-item">
                            <iconify-icon icon="solar:checklist-minimalistic-bold" width="16"></iconify-icon>
                            <span>El checklist se cargará según el equipo seleccionado.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal nuevo equipo --}}
    <div x-show="modalEquipo" x-cloak class="eq-modal-backdrop">
        <div class="eq-modal">
            <div class="eq-modal-head">
                <div>
                    <div class="eq-modal-title">Registrar nuevo equipo</div>
                    <div class="eq-modal-text">
                        Completa los datos mínimos del equipo para asociarlo a la empresa y usarlo en la inspección.
                    </div>
                </div>

                <button type="button" class="eq-btn eq-btn-light !h-[36px]" @click="modalEquipo = false">
                    <iconify-icon icon="solar:close-circle-outline" width="15"></iconify-icon>
                    Cerrar
                </button>
            </div>

            <div class="eq-modal-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="eq-label">Código <span class="eq-required">*</span></label>
                        <input type="text" class="eq-input" placeholder="Ej. EQ-005">
                    </div>

                    <div>
                        <label class="eq-label">Nombre del equipo <span class="eq-required">*</span></label>
                        <input type="text" class="eq-input" placeholder="Ej. Excavadora CAT 320">
                    </div>

                    <div>
                        <label class="eq-label">Tipo <span class="eq-required">*</span></label>
                        <select class="eq-select">
                            <option>Seleccione</option>
                            <option>Volquete</option>
                            <option>Excavadora</option>
                            <option>Cargador frontal</option>
                            <option>Camión</option>
                        </select>
                    </div>

                    <div>
                        <label class="eq-label">Marca</label>
                        <input type="text" class="eq-input" placeholder="Ej. Caterpillar">
                    </div>

                    <div>
                        <label class="eq-label">Modelo</label>
                        <input type="text" class="eq-input" placeholder="Ej. 320 GC">
                    </div>

                    <div>
                        <label class="eq-label">Placa / serie</label>
                        <input type="text" class="eq-input" placeholder="Placa o número de serie">
                    </div>

                    <div>
                        <label class="eq-label">Estado inicial</label>
                        <select class="eq-select">
                            <option>Operativo</option>
                            <option>Revisión pendiente</option>
                            <option>Fuera de servicio</option>
                        </select>
                    </div>

                    <div>
                        <label class="eq-label">Ubicación</label>
                        <input type="text" class="eq-input" placeholder="Ej. Patio principal">
                    </div>

                    <div class="md:col-span-2">
                        <label class="eq-label">Observación</label>
                        <textarea class="eq-textarea" placeholder="Comentario inicial del equipo..."></textarea>
                    </div>
                </div>
            </div>

            <div class="eq-modal-foot">
                <button type="button" class="eq-btn eq-btn-light" @click="modalEquipo = false">
                    Cancelar
                </button>

                <button type="button" class="eq-btn eq-btn-success">
                    <iconify-icon icon="solar:diskette-outline" width="16"></iconify-icon>
                    Guardar equipo
                </button>
            </div>
        </div>
    </div>
</div>