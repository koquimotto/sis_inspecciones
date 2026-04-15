@extends('layouts.master')
@section('title', 'Nueva inspección - EL CUMBE EIRL')

@section('styles')
    <style>
        .insp-create-wrap {
            width: 100%;
        }

        .insp-create-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
        }

        .insp-create-header {
            padding: 18px 20px 14px 20px;
            border-bottom: 1px solid #eef2f7;
        }

        .insp-create-title {
            font-size: 1.35rem;
            line-height: 1.1;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: #0f172a;
        }

        .insp-create-text {
            margin-top: 6px;
            font-size: 0.84rem;
            color: #64748b;
        }

        .insp-create-body {
            padding: 0;
        }

        .insp-tab-content {
            padding: 18px 20px 20px 20px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    <div
        class="insp-create-wrap"
        x-data="{
            activeTab: 'empresa-servicio',
            setTab(tab) {
                this.activeTab = tab;
            },
            isTab(tab) {
                return this.activeTab === tab;
            }
        }"
    >
        <div class="insp-create-card">
            <div class="insp-create-header">
                <div class="insp-create-title">Nueva inspección</div>
                <div class="insp-create-text">
                    Registro guiado de inspección técnica.
                </div>
            </div>

            @include('livewire.pages.inspections.components.create-tabs')

            <div class="insp-create-body">
                <div class="insp-tab-content" x-show="isTab('empresa-servicio')" x-cloak>
                    @include('livewire.pages.inspections.components.steps.empresa-servicio')
                </div>

                <div class="insp-tab-content" x-show="isTab('equipos')" x-cloak>
                    @include('livewire.pages.inspections.components.steps.equipos')
                </div>

                <div class="insp-tab-content" x-show="isTab('checklist')" x-cloak>
                    @include('livewire.pages.inspections.components.steps.checklist')
                </div>

                <div class="insp-tab-content" x-show="isTab('resultado')" x-cloak>
                    @include('livewire.pages.inspections.components.steps.resultado')
                </div>

                <div class="insp-tab-content" x-show="isTab('confirmacion')" x-cloak>
                    @include('livewire.pages.inspections.components.steps.confirmacion')
                </div>
            </div>
        </div>
    </div>
@endsection