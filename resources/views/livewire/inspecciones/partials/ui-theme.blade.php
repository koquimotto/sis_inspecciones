<style>
    .insp-ui {
        --insp-bg: #f4f6fb;
        --insp-surface: #ffffff;
        --insp-border: #dbe3f0;
        --insp-text: #1f2937;
        --insp-muted: #6b7280;
        --insp-primary: #4f46e5;
        --insp-primary-soft: #ede9fe;
        --insp-success: #059669;
        --insp-success-soft: #d1fae5;
        --insp-info: #0284c7;
        --insp-info-soft: #e0f2fe;
        --insp-warning: #d97706;
        --insp-warning-soft: #fef3c7;
        --insp-danger: #dc2626;
        --insp-danger-soft: #fee2e2;
    }

    .insp-ui .box {
        border: 1px solid var(--insp-border);
        border-radius: 1rem;
        background: var(--insp-surface);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.05);
        transition: box-shadow .2s ease, transform .2s ease;
    }

    .insp-ui .box:hover {
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
    }

    .insp-ui .box-header {
        border-bottom: 1px solid #e5eaf3;
        background: linear-gradient(180deg, #ffffff 0%, #fbfcff 100%);
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .insp-ui .box-title {
        color: #111827;
        font-weight: 700;
        letter-spacing: .01em;
    }

    .insp-ui .form-control,
    .insp-ui .form-select {
        border-color: #d4dce9 !important;
        background: #fff;
        transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
    }

    .insp-ui .form-control:focus,
    .insp-ui .form-select:focus,
    .insp-ui .form-check-input:focus {
        border-color: #6366f1 !important;
        box-shadow: 0 0 0 .2rem rgba(99, 102, 241, .16) !important;
    }

    .insp-ui .ti-btn,
    .insp-ui button {
        transition: transform .15s ease, box-shadow .2s ease, filter .2s ease;
    }

    .insp-ui .ti-btn:hover,
    .insp-ui button:hover {
        filter: brightness(1.02);
    }

    .insp-ui .ti-btn:active,
    .insp-ui button:active {
        transform: translateY(1px);
    }

    .insp-ui .insp-steps button {
        min-height: 92px;
        border-radius: 1rem;
    }

    .insp-ui .insp-wizard {
        display: inline-flex;
        gap: 0;
        width: min(100%, 760px);
        overflow: hidden;
        border-radius: 10px;
        background: transparent;
    }

    .insp-ui .insp-wizard-item {
        position: relative;
        flex: 1 1 0;
        min-width: 0;
        border: 0;
        text-align: left;
        padding: .75rem 1.1rem .75rem 1.5rem;
        color: #f8fafc;
        --wiz-bg: #b9a8ef;
        background: var(--wiz-bg);
        transition: filter .2s ease, color .2s ease, background .2s ease;
        clip-path: polygon(0 0, calc(100% - 18px) 0, 100% 50%, calc(100% - 18px) 100%, 0 100%, 14px 50%);
        z-index: 1;
    }

    .insp-ui .insp-wizard-item:first-child {
        clip-path: polygon(0 0, calc(100% - 18px) 0, 100% 50%, calc(100% - 18px) 100%, 0 100%);
    }

    .insp-ui .insp-wizard-item:not(:first-child) {
        margin-left: -10px;
        padding-left: 1.8rem;
    }

    .insp-ui .insp-wizard-item::before {
        display: none;
    }

    .insp-ui .insp-wizard-item:last-child::before {
        display: none;
    }

    .insp-ui .insp-wizard-item:hover {
        filter: brightness(1.01);
    }

    .insp-ui .insp-wizard-item.is-active {
        --wiz-bg: #7c3aed;
        color: #fff;
        background: var(--wiz-bg);
        z-index: 2;
    }

    .insp-ui .insp-wizard-item.is-locked {
        opacity: .78;
        cursor: not-allowed;
    }

    .insp-ui .insp-wizard-step {
        font-size: .85rem;
        font-weight: 700;
        line-height: 1.1;
    }

    .insp-ui .insp-wizard-title {
        margin-top: .15rem;
        font-size: .74rem;
        font-weight: 500;
        opacity: .96;
        line-height: 1.15;
    }

    .insp-ui .insp-muted {
        color: var(--insp-muted);
    }

    .insp-ui .insp-soft-panel {
        border: 1px solid #e4e9f2;
        border-radius: 14px;
        background: #f8faff;
    }

    .insp-ui .insp-upload-panel {
        border: 1px solid #dbe3f0;
        border-top: 4px solid #6366f1;
        border-radius: 18px;
        box-shadow: 0 10px 26px rgba(79, 70, 229, .08);
        background: #ffffff;
    }

    .insp-ui .insp-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, #d9e2f0 15%, #d9e2f0 85%, transparent 100%);
    }

    .insp-ui .insp-tab-strip {
        display: flex;
        align-items: stretch;
        gap: 0;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        overflow-x: auto;
        overflow-y: hidden;
        background: #fff;
    }

    .insp-ui .insp-tab {
        border: 0;
        border-right: 1px solid #d1d5db;
        background: #fff;
        color: #4b5563;
        min-height: 38px;
        padding: .6rem .9rem;
        font-size: .76rem;
        line-height: 1.2;
        white-space: nowrap;
        flex: 1 1 0;
        min-width: 0;
        text-align: left;
    }

    .insp-ui .insp-tab:last-child {
        border-right: 0;
    }

    .insp-ui .insp-tab span {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .insp-ui .insp-tab.is-active {
        background: #7c3aed;
        color: #fff;
    }

    .insp-ui .insp-subtab-row {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        box-sizing: border-box;
    }

    .insp-ui .insp-subtab-scroll {
        display: flex;
        gap: 0;
        flex: 1 1 auto;
        min-width: 0;
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        border: 1px solid #c4b5fd;
        border-radius: 8px;
        background: #ede9fe;
        box-sizing: border-box;
    }

    .insp-ui .insp-subtab {
        border: 0;
        border-right: 1px solid #c4b5fd;
        background: transparent;
        color: #4c1d95;
        min-height: 36px;
        padding: .55rem .85rem;
        font-size: .74rem;
        line-height: 1.2;
        text-align: left;
        white-space: nowrap;
        flex: 0 0 auto;
        min-width: 120px;
        max-width: 180px;
        display: inline-flex;
        align-items: center;
        justify-content: space-between;
        gap: .4rem;
    }

    .insp-ui .insp-subtab:last-child {
        border-right: 0;
    }

    .insp-ui .insp-subtab span {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .insp-ui .insp-subtab.is-active {
        background: #8b5cf6;
        color: #fff;
    }

    .insp-ui .insp-subtab-alert {
        width: 18px;
        height: 18px;
        border-radius: 999px;
        background: #f59e0b;
        color: #fff;
        font-size: .75rem;
        font-weight: 800;
        line-height: 18px;
        text-align: center;
        flex: 0 0 18px;
    }

    .insp-ui .insp-row-has-observation {
        background: linear-gradient(90deg, rgba(220, 38, 38, 0.06) 0%, rgba(220, 38, 38, 0) 38%);
    }

    .insp-ui .insp-subtab-add {
        border: 0;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #7c3aed;
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 32px;
    }

    .insp-ui .insp-subtab-add:disabled {
        opacity: .55;
        cursor: not-allowed;
    }

    .insp-ui .table thead th {
        color: #374151;
        font-size: .78rem;
        letter-spacing: .06em;
        text-transform: uppercase;
        font-weight: 700;
        background: #f8fafc;
    }

    .insp-ui .table tbody tr {
        transition: background-color .18s ease;
    }

    .insp-ui .table-hover tbody tr:hover {
        background-color: #f7f9ff;
    }

    .insp-ui .insp-chip {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        border-radius: 999px;
        padding: .18rem .55rem;
        font-size: .72rem;
        font-weight: 600;
    }

    .insp-ui .insp-chip--info { background: var(--insp-info-soft); color: var(--insp-info); }
    .insp-ui .insp-chip--success { background: var(--insp-success-soft); color: var(--insp-success); }
    .insp-ui .insp-chip--warning { background: var(--insp-warning-soft); color: var(--insp-warning); }
    .insp-ui .insp-chip--danger { background: var(--insp-danger-soft); color: var(--insp-danger); }

    .insp-ui .insp-loading-bar {
        height: 5px;
        background: linear-gradient(90deg, #4f46e5 0%, #0ea5e9 55%, #10b981 100%);
        box-shadow: 0 1px 4px rgba(79, 70, 229, .35);
    }

    .insp-ui .insp-loading-pill {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .45rem .8rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, .95);
        border: 1px solid #dbe3f0;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .12);
        color: #475569;
        font-size: .82rem;
        font-weight: 600;
    }

    .insp-ui .insp-spinner {
        width: 14px;
        height: 14px;
        border-radius: 999px;
        border: 2px solid #c7d2fe;
        border-top-color: #4f46e5;
        animation: insp-spin .7s linear infinite;
    }

    @keyframes insp-spin {
        to { transform: rotate(360deg); }
    }

    .insp-ui .insp-skeleton {
        background: linear-gradient(90deg, #eef2ff 25%, #f8fafc 45%, #eef2ff 65%);
        background-size: 200% 100%;
        animation: insp-shimmer 1.2s linear infinite;
        border-radius: .65rem;
        min-height: 14px;
    }

    @keyframes insp-shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }

    @media (max-width: 768px) {
        .insp-ui .insp-steps button {
            min-height: 78px;
        }

        .insp-ui .insp-wizard {
            flex-direction: column;
            width: 100%;
        }

        .insp-ui .insp-wizard-item {
            min-width: 100%;
            padding-left: 1rem !important;
            clip-path: none;
            margin-left: 0 !important;
        }

        .insp-ui .insp-wizard-item::after,
        .insp-ui .insp-wizard-item::before {
            display: none;
        }
    }
</style>
