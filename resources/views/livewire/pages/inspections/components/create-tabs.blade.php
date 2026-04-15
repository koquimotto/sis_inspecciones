<div class="insp-tabs-wrap border-b border-defaultborder bg-white px-5 py-4">
    <style>
        .insp-tabs-grid {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
        }

        .insp-tab-btn {
            position: relative;
            width: 100%;
            text-align: left;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            border-radius: 4px;
            padding: 12px 14px;
            min-height: 68px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transition: all .18s ease;
        }

        .insp-tab-btn:hover {
            border-color: #cbd5e1;
            background: #f8fafc;
        }

        .insp-tab-btn.is-active {
            border-color: rgba(var(--primary), .35);
            background: rgba(var(--primary), .05);
            box-shadow: inset 0 0 0 1px rgba(var(--primary), .05);
        }

        .insp-tab-btn.is-done {
            border-color: #bbf7d0;
            background: #ecfdf5;
        }

        .insp-tab-badge {
            width: 30px;
            height: 30px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            border: 1px solid #dbe3ee;
            background: #f8fafc;
            color: #475569;
            font-size: 0.75rem;
            font-weight: 800;
            line-height: 1;
        }

        .insp-tab-btn.is-active .insp-tab-badge {
            background: rgb(var(--primary));
            border-color: rgb(var(--primary));
            color: #fff;
        }

        .insp-tab-btn.is-done .insp-tab-badge {
            background: #059669;
            border-color: #059669;
            color: #fff;
        }

        .insp-tab-meta {
            min-width: 0;
        }

        .insp-tab-title {
            font-size: 0.80rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.2;
            margin-top: 1px;
        }

        .insp-tab-text {
            margin-top: 4px;
            font-size: 0.71rem;
            color: #64748b;
            line-height: 1.35;
        }

        .insp-tabs-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin-bottom: 12px;
        }

        .insp-tabs-title {
            font-size: 0.92rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .insp-tabs-subtitle {
            margin-top: 2px;
            font-size: 0.74rem;
            color: #64748b;
        }

        .insp-tabs-progress {
            min-width: 220px;
            max-width: 260px;
            width: 100%;
        }

        .insp-tabs-progress-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 0.72rem;
            font-weight: 700;
            color: #64748b;
        }

        .insp-tabs-progress-bar {
            width: 100%;
            height: 7px;
            background: #e2e8f0;
            overflow: hidden;
            border-radius: 999px;
        }

        .insp-tabs-progress-fill {
            height: 100%;
            background: rgb(var(--primary));
            transition: width .2s ease;
        }

        @media (max-width: 1199px) {
            .insp-tabs-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 767px) {
            .insp-tabs-top {
                flex-direction: column;
                align-items: stretch;
            }

            .insp-tabs-progress {
                min-width: 100%;
                max-width: 100%;
            }

            .insp-tabs-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="insp-tabs-top">
        <div>
            <div class="insp-tabs-title">Flujo de registro</div>
            <div class="insp-tabs-subtitle">
                Completa la inspección paso a paso sin salir del proceso.
            </div>
        </div>

        <div class="insp-tabs-progress">
            <div class="insp-tabs-progress-top">
                <span>Avance</span>
                <span
                    x-text="({
                        'empresa-servicio': '20%',
                        'equipos': '40%',
                        'checklist': '60%',
                        'resultado': '80%',
                        'confirmacion': '100%'
                    })[activeTab]"
                ></span>
            </div>

            <div class="insp-tabs-progress-bar">
                <div
                    class="insp-tabs-progress-fill"
                    :style="'width:' + ({
                        'empresa-servicio': '20%',
                        'equipos': '40%',
                        'checklist': '60%',
                        'resultado': '80%',
                        'confirmacion': '100%'
                    })[activeTab]"
                ></div>
            </div>
        </div>
    </div>

    <div class="insp-tabs-grid">
        <button
            type="button"
            class="insp-tab-btn"
            :class="{
                'is-active': isTab('empresa-servicio')
            }"
            @click="setTab('empresa-servicio')"
        >
            <div class="insp-tab-badge">1</div>
            <div class="insp-tab-meta">
                <div class="insp-tab-title">Empresa y servicio</div>
                <div class="insp-tab-text">
                    Empresa, contacto principal, servicio y contexto de la inspección.
                </div>
            </div>
        </button>

        <button
            type="button"
            class="insp-tab-btn"
            :class="{
                'is-active': isTab('equipos'),
                'is-done': isTab('checklist') || isTab('resultado') || isTab('confirmacion')
            }"
            @click="setTab('equipos')"
        >
            <div class="insp-tab-badge">
                <template x-if="isTab('checklist') || isTab('resultado') || isTab('confirmacion')">
                    <iconify-icon icon="solar:check-read-outline" width="15"></iconify-icon>
                </template>
                <template x-if="!(isTab('checklist') || isTab('resultado') || isTab('confirmacion'))">
                    <span>2</span>
                </template>
            </div>
            <div class="insp-tab-meta">
                <div class="insp-tab-title">Equipos</div>
                <div class="insp-tab-text">
                    Selección de uno o más equipos o máquinas para la evaluación.
                </div>
            </div>
        </button>

        <button
            type="button"
            class="insp-tab-btn"
            :class="{
                'is-active': isTab('checklist'),
                'is-done': isTab('resultado') || isTab('confirmacion')
            }"
            @click="setTab('checklist')"
        >
            <div class="insp-tab-badge">
                <template x-if="isTab('resultado') || isTab('confirmacion')">
                    <iconify-icon icon="solar:check-read-outline" width="15"></iconify-icon>
                </template>
                <template x-if="!(isTab('resultado') || isTab('confirmacion'))">
                    <span>3</span>
                </template>
            </div>
            <div class="insp-tab-meta">
                <div class="insp-tab-title">Checklist</div>
                <div class="insp-tab-text">
                    Revisión técnica por ítems, observaciones y evidencias fotográficas.
                </div>
            </div>
        </button>

        <button
            type="button"
            class="insp-tab-btn"
            :class="{
                'is-active': isTab('resultado'),
                'is-done': isTab('confirmacion')
            }"
            @click="setTab('resultado')"
        >
            <div class="insp-tab-badge">
                <template x-if="isTab('confirmacion')">
                    <iconify-icon icon="solar:check-read-outline" width="15"></iconify-icon>
                </template>
                <template x-if="!isTab('confirmacion')">
                    <span>4</span>
                </template>
            </div>
            <div class="insp-tab-meta">
                <div class="insp-tab-title">Resultado</div>
                <div class="insp-tab-text">
                    Definición del resultado general y conclusión técnica de la inspección.
                </div>
            </div>
        </button>

        <button
            type="button"
            class="insp-tab-btn"
            :class="{
                'is-active': isTab('confirmacion')
            }"
            @click="setTab('confirmacion')"
        >
            <div class="insp-tab-badge">5</div>
            <div class="insp-tab-meta">
                <div class="insp-tab-title">Confirmación</div>
                <div class="insp-tab-text">
                    Revisión final del registro antes de guardar la inspección.
                </div>
            </div>
        </button>
    </div>
</div>