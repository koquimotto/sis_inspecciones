<div class="es-step space-y-5" x-data="{ modalEmpresa: false, modalServicio: false }">
    <style>
        .es-vehicle-card {
            border: 1px solid #e2e8f0;
            background: #ffffff;
            padding: 12px;
        }
        
        .es-vehicle-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }
        
        .es-vehicle-title {
            font-size: 0.80rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.3;
        }
        
        .es-vehicle-meta {
            margin-top: 4px;
            font-size: 0.70rem;
            color: #64748b;
        }
        
        .es-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 8px;
            font-size: 0.68rem;
            font-weight: 800;
            border: 1px solid;
            white-space: nowrap;
        }
        
        .es-status-ok {
            background: #ecfdf5;
            color: #047857;
            border-color: #bbf7d0;
        }
        
        .es-status-warn {
            background: #fff7ed;
            color: #c2410c;
            border-color: #fed7aa;
        }
        
        .es-kpi-mini {
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 12px;
        }
        
        .es-kpi-mini-label {
            font-size: 0.68rem;
            font-weight: 700;
            color: #64748b;
        }
        
        .es-kpi-mini-value {
            margin-top: 6px;
            font-size: 0.95rem;
            font-weight: 900;
            color: #0f172a;
        }
        .es-layout {
            display: grid;
            grid-template-columns: minmax(0, 1.7fr) minmax(320px, .9fr);
            gap: 18px;
        }

        .es-panel {
            background: #ffffff;
            border: 1px solid #dbe3ee;
            box-shadow: 0 6px 18px rgba(15, 23, 42, 0.05);
        }

        .es-panel-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
        }

        .es-panel-body {
            padding: 18px;
        }

        .es-page-head {
            background: linear-gradient(180deg, #f8fbff 0%, #f1f5f9 100%);
            border: 1px solid #dbe3ee;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
        }

        .es-page-head-body {
            padding: 20px 22px;
        }

        .es-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            font-size: 0.70rem;
            font-weight: 800;
            color: #1d4ed8;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .es-main-title {
            margin-top: 14px;
            font-size: 1.55rem;
            line-height: 1.02;
            font-weight: 900;
            letter-spacing: -.04em;
            color: #0f172a;
        }

        .es-main-text {
            margin-top: 10px;
            max-width: 860px;
            font-size: 0.83rem;
            line-height: 1.7;
            color: #475569;
        }

        .es-head-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-top: 18px;
        }

        .es-head-stat {
            background: #fff;
            border: 1px solid #dbe3ee;
            padding: 14px;
        }

        .es-head-stat-label {
            font-size: 0.70rem;
            font-weight: 700;
            color: #64748b;
        }

        .es-head-stat-value {
            margin-top: 7px;
            font-size: 1.02rem;
            line-height: 1.05;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.02em;
        }

        .es-head-stat-note {
            margin-top: 6px;
            font-size: 0.69rem;
            color: #64748b;
        }

        .es-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: #0f172a;
            letter-spacing: -.01em;
        }

        .es-sub {
            margin-top: 3px;
            font-size: 0.73rem;
            color: #64748b;
            line-height: 1.45;
        }

        .es-label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.72rem;
            font-weight: 800;
            color: #334155;
        }

        .es-required {
            color: #dc2626;
            margin-left: 2px;
        }

        .es-input,
        .es-select,
        .es-textarea {
            width: 100%;
            background: #fff;
            border: 1px solid #cbd5e1;
            color: #0f172a;
            font-size: 0.82rem;
            transition: .18s ease;
        }

        .es-input,
        .es-select {
            height: 42px;
            padding: 0 12px;
        }

        .es-textarea {
            min-height: 96px;
            padding: 10px 12px;
            resize: vertical;
        }

        .es-input:focus,
        .es-select:focus,
        .es-textarea:focus {
            outline: none;
            border-color: rgb(var(--primary));
            box-shadow: 0 0 0 3px rgba(var(--primary), .12);
        }

        .es-btn {
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

        .es-btn-primary {
            background: rgb(var(--primary));
            color: #fff;
            border-color: rgb(var(--primary));
        }

        .es-btn-primary:hover {
            filter: brightness(.98);
        }

        .es-btn-light {
            background: #fff;
            color: #334155;
            border-color: #cbd5e1;
        }

        .es-btn-light:hover {
            background: #f8fafc;
        }

        .es-btn-success {
            background: #059669;
            color: #fff;
            border-color: #059669;
        }

        .es-btn-success:hover {
            background: #047857;
            border-color: #047857;
        }

        .es-search-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto auto;
            gap: 10px;
        }

        .es-found {
            margin-top: 14px;
            background: linear-gradient(180deg, #f8fbff 0%, #eef6ff 100%);
            border: 1px solid #bfdbfe;
            padding: 16px;
        }

        .es-found-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 14px;
        }

        .es-found-title {
            font-size: 0.96rem;
            font-weight: 900;
            color: #0f172a;
        }

        .es-found-meta {
            margin-top: 5px;
            font-size: 0.74rem;
            color: #475569;
        }

        .es-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 9px;
            font-size: 0.69rem;
            font-weight: 800;
            border: 1px solid;
        }

        .es-pill-blue {
            background: #dbeafe;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        .es-pill-green {
            background: #ecfdf5;
            color: #047857;
            border-color: #bbf7d0;
        }

        .es-box {
            border: 1px solid #e2e8f0;
            background: #fff;
        }

        .es-box-head {
            padding: 14px 16px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: flex-start;
        }

        .es-box-title {
            font-size: 0.84rem;
            font-weight: 900;
            color: #0f172a;
        }

        .es-box-text {
            margin-top: 3px;
            font-size: 0.72rem;
            color: #64748b;
        }

        .es-box-body {
            padding: 16px;
        }

        .es-summary-grid {
            display: grid;
            gap: 10px;
        }

        .es-summary-item {
            border: 1px solid #e2e8f0;
            background: #fff;
            padding: 11px 12px;
        }

        .es-summary-label {
            font-size: 0.69rem;
            font-weight: 700;
            color: #64748b;
        }

        .es-summary-value {
            margin-top: 5px;
            font-size: 0.80rem;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.4;
        }

        .es-aside-note {
            border: 1px solid #dbe3ee;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            padding: 16px;
        }

        .es-aside-note-title {
            font-size: 0.82rem;
            font-weight: 900;
            color: #0f172a;
        }

        .es-aside-note-list {
            margin-top: 10px;
            display: grid;
            gap: 10px;
            font-size: 0.75rem;
            line-height: 1.55;
            color: #64748b;
        }

        .es-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #eef2f7;
            padding-top: 16px;
        }

        .es-modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            z-index: 60;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .es-modal {
            width: 100%;
            max-width: 620px;
            background: #fff;
            border: 1px solid #cbd5e1;
            box-shadow: 0 24px 48px rgba(15, 23, 42, .22);
        }

        .es-modal-head {
            padding: 16px 18px;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .es-modal-title {
            font-size: 0.92rem;
            font-weight: 900;
            color: #0f172a;
        }

        .es-modal-text {
            margin-top: 3px;
            font-size: 0.73rem;
            color: #64748b;
        }

        .es-modal-body {
            padding: 18px;
        }

        .es-modal-foot {
            padding: 16px 18px;
            border-top: 1px solid #eef2f7;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        [x-cloak] {
            display: none !important;
        }

        @media (max-width: 1399px) {
            .es-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 991px) {
            .es-head-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .es-search-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767px) {
            .es-head-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    {{-- Encabezado --}}
    <div class="es-layout">
        {{-- Columna principal --}}
        <div class="space-y-5">
            <div class="es-panel">
                <div class="es-panel-head">
                    <div class="es-title">Búsqueda y selección de empresa</div>
                    <div class="es-sub">
                        El flujo empieza aquí. Busca una empresa existente o regístrala desde modal.
                    </div>
                </div>

                <div class="es-panel-body">
                    <label class="es-label">
                        Empresa <span class="es-required">*</span>
                    </label>

                    <div class="es-search-grid">
                        <input
                            type="text"
                            class="es-input"
                            placeholder="Buscar por RUC, razón social o nombre comercial"
                            value="LUCHO VIP"
                        >

                        <button type="button" class="es-btn es-btn-primary">
                            <iconify-icon icon="solar:magnifer-outline" width="16"></iconify-icon>
                            Buscar
                        </button>

                        <button type="button" class="es-btn es-btn-success" @click="modalEmpresa = true">
                            <iconify-icon icon="solar:add-circle-outline" width="16"></iconify-icon>
                            Nueva empresa
                        </button>
                    </div>

                    <div class="es-found">
                        <div class="es-found-top">
                            <div>
                                <div class="es-found-title">LUCHO VIP</div>
                                <div class="es-found-meta">
                                    RUC: 10704957608 · Nombre comercial: LUCHO GRILL
                                </div>
                            </div>

                            <span class="es-pill es-pill-blue">
                                <iconify-icon icon="solar:check-circle-bold" width="14"></iconify-icon>
                                Empresa seleccionada
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="es-panel">
                <div class="es-panel-head">
                    <div class="es-title">Configuración operativa</div>
                    <div class="es-sub">
                        Contacto principal, servicio asociado y contexto base de la inspección.
                    </div>
                </div>

                <div class="es-panel-body space-y-5">
                    <div class="es-box">
                        <div class="es-box-head">
                            <div>
                                <div class="es-box-title">Contacto y servicio</div>
                                <div class="es-box-text">Datos obligatorios para continuar con equipos.</div>
                            </div>

                            <button type="button" class="es-btn es-btn-light !h-[38px]" @click="modalServicio = true">
                                <iconify-icon icon="solar:add-circle-outline" width="15"></iconify-icon>
                                Nuevo servicio
                            </button>
                        </div>

                        <div class="es-box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="es-label">
                                        Contacto principal <span class="es-required">*</span>
                                    </label>
                                    <select class="es-select">
                                        <option>Administrador - admin@sis-cursos.test</option>
                                        <option>Juan Pérez - juanp69@gmail.com</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="es-label">
                                        Servicio <span class="es-required">*</span>
                                    </label>
                                    <select class="es-select">
                                        <option>Servicio 1</option>
                                        <option>Servicio 2</option>
                                        <option>Servicio 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="es-box">
                        <div class="es-box-head">
                            <div>
                                <div class="es-box-title">Contexto de inspección</div>
                                <div class="es-box-text">Datos mínimos para iniciar correctamente el registro.</div>
                            </div>
                        </div>

                        <div class="es-box-body">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="es-label">
                                        Fecha <span class="es-required">*</span>
                                    </label>
                                    <input type="date" class="es-input">
                                </div>
                    
                                <div>
                                    <label class="es-label">
                                        Hora <span class="es-required">*</span>
                                    </label>
                                    <input type="time" class="es-input">
                                </div>
                    
                                <div class="md:col-span-2">
                                    <label class="es-label">
                                        Responsable <span class="es-required">*</span>
                                    </label>
                                    <select class="es-select">
                                        <option>María García</option>
                                        <option>Luis Paredes</option>
                                        <option>Roberto Pérez</option>
                                    </select>
                                </div>
                    
                                <div class="md:col-span-2">
                                    <label class="es-label">Observación inicial</label>
                                    <textarea
                                        class="es-textarea"
                                        placeholder="Describe brevemente el contexto inicial de la inspección..."
                                        style="min-height: 90px;"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>

        {{-- Columna lateral --}}
        <div class="space-y-5">
            <div class="es-panel">
                <div class="es-panel-head">
                    <div class="es-title">Resumen de inspección</div>
                    <div class="es-sub">Contexto consolidado del paso actual.</div>
                </div>
        
                <div class="es-panel-body">
                    <div class="es-summary-grid">
                        <div class="es-summary-item">
                            <div class="es-summary-label">Empresa</div>
                            <div class="es-summary-value">LUCHO VIP</div>
                        </div>
        
                        <div class="es-summary-item">
                            <div class="es-summary-label">RUC</div>
                            <div class="es-summary-value">10704957608</div>
                        </div>
        
                        <div class="es-summary-item">
                            <div class="es-summary-label">Contacto</div>
                            <div class="es-summary-value">Administrador</div>
                        </div>
        
                        <div class="es-summary-item">
                            <div class="es-summary-label">Servicio</div>
                            <div class="es-summary-value">Servicio 1</div>
                        </div>
        
                        <div class="es-summary-item">
                            <div class="es-summary-label">Fecha</div>
                            <div class="es-summary-value">12/04/2026</div>
                        </div>
        
                        <div class="es-summary-item">
                            <div class="es-summary-label">Hora</div>
                            <div class="es-summary-value">09:30 AM</div>
                        </div>
        
                        <div class="es-summary-item">
                            <div class="es-summary-label">Responsable</div>
                            <div class="es-summary-value">María García</div>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="es-panel">
                <div class="es-panel-head">
                    <div class="es-title">Vehículos / equipos de la empresa</div>
                    <div class="es-sub">Unidades disponibles según la empresa seleccionada.</div>
                </div>
        
                <div class="es-panel-body space-y-3">
                    <div class="es-vehicle-card">
                        <div class="es-vehicle-top">
                            <div>
                                <div class="es-vehicle-title">Volquete Volvo FMX 440</div>
                                <div class="es-vehicle-meta">Código: EQ-001 · Placa: ABC-123</div>
                            </div>
                            <span class="es-status es-status-ok">
                                <iconify-icon icon="solar:check-circle-bold" width="14"></iconify-icon>
                                Operativo
                            </span>
                        </div>
                    </div>
        
                    <div class="es-vehicle-card">
                        <div class="es-vehicle-top">
                            <div>
                                <div class="es-vehicle-title">Excavadora CAT 320 GC</div>
                                <div class="es-vehicle-meta">Código: EQ-002 · Serie: CAT320GC01</div>
                            </div>
                            <span class="es-status es-status-warn">
                                <iconify-icon icon="solar:danger-triangle-bold" width="14"></iconify-icon>
                                Revisión pendiente
                            </span>
                        </div>
                    </div>
        
                    <div class="es-vehicle-card">
                        <div class="es-vehicle-top">
                            <div>
                                <div class="es-vehicle-title">Cargador frontal Komatsu WA380</div>
                                <div class="es-vehicle-meta">Código: EQ-003 · Serie: KM-WA380-21</div>
                            </div>
                            <span class="es-status es-status-ok">
                                <iconify-icon icon="solar:check-circle-bold" width="14"></iconify-icon>
                                Operativo
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="es-panel">
                <div class="es-panel-head">
                    <div class="es-title">Indicadores rápidos</div>
                    <div class="es-sub">Vista ejecutiva de la empresa seleccionada.</div>
                </div>
        
                <div class="es-panel-body">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="es-kpi-mini">
                            <div class="es-kpi-mini-label">Total equipos</div>
                            <div class="es-kpi-mini-value">3</div>
                        </div>
        
                        <div class="es-kpi-mini">
                            <div class="es-kpi-mini-label">Operativos</div>
                            <div class="es-kpi-mini-value text-emerald-600">2</div>
                        </div>
        
                        <div class="es-kpi-mini">
                            <div class="es-kpi-mini-label">Pendientes</div>
                            <div class="es-kpi-mini-value text-amber-600">1</div>
                        </div>
        
                        <div class="es-kpi-mini">
                            <div class="es-kpi-mini-label">Servicio activo</div>
                            <div class="es-kpi-mini-value">1</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="es-footer">
        <div class="text-[0.74rem] text-slate-500">
            Paso 1 de 5 · Empresa, contacto y servicio
        </div>

        <div class="flex gap-2">
            <button type="button" class="es-btn es-btn-light">
                <iconify-icon icon="solar:document-add-outline" width="16"></iconify-icon>
                Guardar borrador
            </button>

            <button type="button" class="es-btn es-btn-primary">
                Siguiente: Equipos
                <iconify-icon icon="solar:arrow-right-outline" width="16"></iconify-icon>
            </button>
        </div>
    </div>

    {{-- Modal empresa --}}
    <div x-show="modalEmpresa" x-cloak class="es-modal-backdrop">
        <div class="es-modal">
            <div class="es-modal-head">
                <div>
                    <div class="es-modal-title">Registrar nueva empresa</div>
                    <div class="es-modal-text">
                        Campos mínimos para continuar el flujo sin perder contexto.
                    </div>
                </div>

                <button type="button" class="es-btn es-btn-light !h-[36px]" @click="modalEmpresa = false">
                    <iconify-icon icon="solar:close-circle-outline" width="15"></iconify-icon>
                    Cerrar
                </button>
            </div>

            <div class="es-modal-body space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="es-label">
                            RUC <span class="es-required">*</span>
                        </label>
                        <input type="text" class="es-input">
                    </div>

                    <div>
                        <label class="es-label">
                            Razón social <span class="es-required">*</span>
                        </label>
                        <input type="text" class="es-input">
                    </div>

                    <div>
                        <label class="es-label">Nombre comercial</label>
                        <input type="text" class="es-input">
                    </div>

                    <div>
                        <label class="es-label">Teléfono</label>
                        <input type="text" class="es-input">
                    </div>
                </div>

                <div class="es-box">
                    <div class="es-box-head">
                        <div>
                            <div class="es-box-title">Contacto principal</div>
                            <div class="es-box-text">Se registra junto con la empresa.</div>
                        </div>
                    </div>

                    <div class="es-box-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="es-label">
                                    Nombre del contacto <span class="es-required">*</span>
                                </label>
                                <input type="text" class="es-input">
                            </div>

                            <div>
                                <label class="es-label">Email del contacto</label>
                                <input type="email" class="es-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="es-modal-foot">
                <button type="button" class="es-btn es-btn-light" @click="modalEmpresa = false">
                    Cancelar
                </button>

                <button type="button" class="es-btn es-btn-success">
                    <iconify-icon icon="solar:diskette-outline" width="16"></iconify-icon>
                    Guardar empresa
                </button>
            </div>
        </div>
    </div>

    {{-- Modal servicio --}}
    <div x-show="modalServicio" x-cloak class="es-modal-backdrop">
        <div class="es-modal" style="max-width: 520px;">
            <div class="es-modal-head">
                <div>
                    <div class="es-modal-title">Registrar nuevo servicio</div>
                    <div class="es-modal-text">
                        El nuevo servicio quedará asociado a la empresa seleccionada.
                    </div>
                </div>

                <button type="button" class="es-btn es-btn-light !h-[36px]" @click="modalServicio = false">
                    <iconify-icon icon="solar:close-circle-outline" width="15"></iconify-icon>
                    Cerrar
                </button>
            </div>

            <div class="es-modal-body">
                <div>
                    <label class="es-label">
                        Nombre del servicio <span class="es-required">*</span>
                    </label>
                    <input type="text" class="es-input">
                </div>
            </div>

            <div class="es-modal-foot">
                <button type="button" class="es-btn es-btn-light" @click="modalServicio = false">
                    Cancelar
                </button>

                <button type="button" class="es-btn es-btn-success">
                    <iconify-icon icon="solar:diskette-outline" width="16"></iconify-icon>
                    Guardar servicio
                </button>
            </div>
        </div>
    </div>
</div>