@extends('layouts.master')
@section('title', 'Resumen - EL CUMBE EIRL')

@section('styles')
@endsection

@section('content')

<!-- Start::page-header -->
<div class="md:flex block items-center justify-between my-[1.5rem] page-header-breadcrumb">
    <div>
        <p class="font-semibold text-[1.125rem] text-defaulttextcolor dark:text-defaulttextcolor/70 !mb-0">Resumen</p>
        <p class="font-normal text-[#8c9097] dark:text-white/50 text-[0.813rem]">
            Indicadores rápidos del sistema.
        </p>
    </div>

    <div class="flex items-center gap-2 md:mt-0 mt-2">
        {{-- Filtros rápidos --}}
        <select class="form-control form-control-lg !w-[170px] !rounded-md" aria-label="Rango">
            <option selected>Esta semana</option>
            <option>Hoy</option>
            <option>Este mes</option>
            <option>Este año</option>
        </select>

        <select class="form-control form-control-lg !w-[200px] !rounded-md" aria-label="Empresa">
            <option selected>Todas las empresas</option>
            <option>EL CUMBE E.I.R.L.</option>
            <option>Empresa XYZ SAC</option>
        </select>

        <button type="button"
            class="ti-btn bg-primary text-white btn-wave !font-medium !text-[0.85rem] !rounded-[0.35rem] !py-[0.51rem] !px-[0.86rem] shadow-none">
            <i class="ri-filter-3-fill inline-block"></i> Filtrar
        </button>

        <button type="button"
            class="ti-btn ti-btn-outline-secondary btn-wave !font-medium !text-[0.85rem] !rounded-[0.35rem] !py-[0.51rem] !px-[0.86rem] shadow-none">
            <i class="ri-upload-cloud-line inline-block"></i> Exportar
        </button>
    </div>
</div>
<!-- End::page-header -->

{{-- Indicadores (cards) --}}
{{-- KPI CARDS (elegante Ynex + acentos de color más grandes) --}}
<div class="grid grid-cols-12 gap-x-6 gap-y-6">

    {{-- 1) INSPECCIONES HOY (AZUL) --}}
    <div class="xl:col-span-3 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12">
        <div class="box !border-0 !overflow-hidden">
            <div class="box-body !p-0">
                <div class="p-4 bg-white dark:bg-bodybg">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            {{-- color accent más grande --}}
                            <span
                                class="h-11 w-11 rounded-xl bg-primary/10 text-primary flex items-center justify-center ring-1 ring-primary/15">
                                <i class="ri-file-list-3-line text-[1.2rem]"></i>
                            </span>

                            <div class="min-w-0">
                                <p class="mb-0 text-[0.82rem] text-defaulttextcolor/70 dark:text-white/50 truncate">Inspecciones hoy</p>
                                <div class="flex items-end gap-2">
                                    <span class="text-[1.7rem] font-semibold leading-none text-defaulttextcolor dark:text-defaulttextcolor/70">5</span>
                                    <span class="text-[0.72rem] text-[#8c9097] dark:text-white/50 mb-0.5">hoy</span>
                                </div>
                            </div>
                        </div>

                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[0.72rem] font-semibold">
                            <i class="ri-arrow-up-line"></i> +23
                        </span>
                    </div>
                </div>

                {{-- footer suave con color --}}
                <div class="px-4 py-3 bg-primary/10 dark:bg-white/5 flex items-center justify-between">
                    <span class="text-[0.78rem] text-[#47484b] dark:text-white/50">vs. última semana</span>
                    <a href="javascript:void(0);" class="text-[0.78rem] text-primary font-medium">
                        Ver detalle <i class="ti ti-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 2) OBSERVADAS (NARANJA) --}}
    <div class="xl:col-span-3 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12">
        <div class="box !border-0 !overflow-hidden">
            <div class="box-body !p-0">
                <div class="p-4 bg-white dark:bg-bodybg">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span
                                class="h-11 w-11 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center ring-1 ring-orange-500/15">
                                <i class="ri-error-warning-line text-[1.2rem]"></i>
                            </span>

                            <div class="min-w-0">
                                <p class="mb-0 text-[0.82rem] text-[#8c9097] dark:text-white/50 truncate">Observadas</p>
                                <div class="flex items-end gap-2">
                                    <span class="text-[1.7rem] font-semibold leading-none text-defaulttextcolor dark:text-defaulttextcolor/70">2</span>
                                    <span class="text-[0.72rem] text-[#8c9097] dark:text-white/50 mb-0.5">pendientes</span>
                                </div>
                            </div>
                        </div>

                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-orange-50 text-orange-600 text-[0.72rem] font-semibold">
                            <i class="ri-arrow-up-line"></i> +2
                        </span>
                    </div>
                </div>

                <div class="px-4 py-3 bg-orange-500/10 dark:bg-white/5 flex items-center justify-between">
                    <span class="text-[0.78rem] text-defaulttextcolor/70 dark:text-white/50">vs. última semana</span>
                    <a href="javascript:void(0);" class="text-[0.78rem] text-orange-600 font-medium">
                        Ver observaciones <i class="ti ti-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 3) CERTIFICADOS VIGENTES (VERDE) --}}
    <div class="xl:col-span-3 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12">
        <div class="box !border-0 !overflow-hidden">
            <div class="box-body !p-0">
                <div class="p-4 bg-white dark:bg-bodybg">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span
                                class="h-11 w-11 rounded-xl bg-emerald-500/10 text-emerald-600 flex items-center justify-center ring-1 ring-emerald-500/15">
                                <i class="ri-award-line text-[1.2rem]"></i>
                            </span>

                            <div class="min-w-0">
                                <p class="mb-0 text-[0.82rem] text-[#8c9097] dark:text-white/50 truncate">Certificados vigentes</p>
                                <div class="flex items-end gap-2">
                                    <span class="text-[1.7rem] font-semibold leading-none text-defaulttextcolor dark:text-defaulttextcolor/70">12</span>
                                    <span class="text-[0.72rem] text-[#8c9097] dark:text-white/50 mb-0.5">vigentes</span>
                                </div>
                            </div>
                        </div>

                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[0.72rem] font-semibold">
                            <i class="ri-arrow-up-line"></i> +9
                        </span>
                    </div>
                </div>

                <div class="px-4 py-3 bg-emerald-500/10 dark:bg-white/5 flex items-center justify-between">
                    <span class="text-[0.78rem] text-defaulttextcolor/70 dark:text-white/50">vs. última semana</span>
                    <a href="javascript:void(0);" class="text-[0.78rem] text-emerald-600 font-medium">
                        Ver certificados <i class="ti ti-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- 4) EQUIPOS REGISTRADOS (MORADO) --}}
    <div class="xl:col-span-3 lg:col-span-6 md:col-span-6 sm:col-span-6 col-span-12">
        <div class="box !border-0 !overflow-hidden">
            <div class="box-body !p-0">
                <div class="p-4 bg-white dark:bg-bodybg">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <span
                                class="h-11 w-11 rounded-xl bg-purple-500/10 text-purple-600 flex items-center justify-center ring-1 ring-purple-500/15">
                                <i class="ri-truck-line text-[1.2rem]"></i>
                            </span>

                            <div class="min-w-0">
                                <p class="mb-0 text-[0.82rem] text-[#8c9097] dark:text-white/50 truncate">Equipos registrados</p>
                                <div class="flex items-end gap-2">
                                    <span class="text-[1.7rem] font-semibold leading-none text-defaulttextcolor dark:text-defaulttextcolor/70">48</span>
                                    <span class="text-[0.72rem] text-[#8c9097] dark:text-white/50 mb-0.5">equipos</span>
                                </div>
                            </div>
                        </div>

                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-purple-50 text-purple-600 text-[0.72rem] font-semibold">
                            <i class="ri-arrow-up-line"></i> +5
                        </span>
                    </div>
                </div>

                <div class="px-4 py-3 bg-purple-500/10 dark:bg-white/5 flex items-center justify-between">
                    <span class="text-[0.78rem] text-defaulttextcolor/70 dark:text-white/50">vs. última semana</span>
                    <a href="javascript:void(0);" class="text-[0.78rem] text-purple-600 font-medium">
                        Ver equipos <i class="ti ti-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>



{{-- ACTIVIDADES RECIENTES + CERTIFICADOS EMITIDOS (con chart) --}}
<div class="grid grid-cols-12 gap-x-6 gap-y-6">

    {{-- ACTIVIDADES RECIENTES --}}
    <div class="xl:col-span-5 col-span-12">
        <div class="box !border-0 !overflow-hidden">
            <div class="box-header justify-between !border-b !border-primary/10 dark:!border-defaultborder/10">
                <div>
                    <div class="box-title !mb-0">Actividades recientes</div>
                    <p class="text-[0.78rem] text-[#8c9097] dark:text-white/50 mb-0">Últimas inspecciones/acciones registradas.</p>
                </div>

                <div class="flex items-center gap-2">
                    {{-- filtro rápido --}}
                    <div class="hs-dropdown ti-dropdown">
                        <a href="javascript:void(0);"
                           class="ti-btn ti-btn-outline-primary btn-wave !py-1 !px-2.5 !text-[0.75rem] !m-0 !font-medium"
                           aria-expanded="false">
                            Todos <i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                        </a>
                        <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                            <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block" href="javascript:void(0);">Inspecciones</a></li>
                            <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block" href="javascript:void(0);">Observaciones</a></li>
                            <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block" href="javascript:void(0);">Certificados</a></li>
                        </ul>
                    </div>

                    <a href="javascript:void(0);" class="ti-btn ti-btn-light btn-wave !py-1 !px-2.5 !text-[0.75rem] !m-0">
                        Ver todo <i class="ri-arrow-right-s-line ms-1"></i>
                    </a>
                </div>
            </div>

            <div class="box-body !p-0">
                <div class="table-responsive">
                    <table class="table whitespace-nowrap min-w-full !mb-0">
                        <thead class="bg-primary/5 dark:bg-white/5">
                            <tr>
                                <th scope="col" class="text-start !py-3">Código</th>
                                <th scope="col" class="text-start !py-3">Empresa</th>
                                <th scope="col" class="text-start !py-3">Equipo</th>
                                <th scope="col" class="text-start !py-3">Estado</th>
                                <th scope="col" class="text-start !py-3">Hace</th>
                            </tr>
                        </thead>

                        <tbody>
                            {{-- fila --}}
                            <tr class="border-t border-primary/10 dark:border-defaultborder/10 hover:bg-primary/5 dark:hover:bg-white/5">
                                <td class="!py-3">
                                    <span class="font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70">INS-2026-000025</span>
                                </td>
                                <td class="!py-3">Empresa XYZ SAC</td>
                                <td class="!py-3">ABC-123</td>
                                <td class="!py-3">
                                    <span class="badge bg-orange-500/10 !text-orange-600 !px-2.5 !py-1 !rounded-full">Observado</span>
                                </td>
                                <td class="!py-3 text-[#8c9097] dark:text-white/50">12 min</td>
                            </tr>

                            <tr class="border-t border-primary/10 dark:border-defaultborder/10 hover:bg-primary/5 dark:hover:bg-white/5">
                                <td class="!py-3">
                                    <span class="font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70">INS-2026-000024</span>
                                </td>
                                <td class="!py-3">SERVICIOS PERÚ S.A.C.</td>
                                <td class="!py-3">XYZ-987</td>
                                <td class="!py-3">
                                    <span class="badge bg-emerald-500/10 !text-emerald-600 !px-2.5 !py-1 !rounded-full">Aprobado</span>
                                </td>
                                <td class="!py-3 text-[#8c9097] dark:text-white/50">1 hora</td>
                            </tr>

                            <tr class="border-t border-primary/10 dark:border-defaultborder/10 hover:bg-primary/5 dark:hover:bg-white/5">
                                <td class="!py-3">
                                    <span class="font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70">INS-2026-000023</span>
                                </td>
                                <td class="!py-3">MINERA OPCIÓN I S.A.</td>
                                <td class="!py-3">DEF-456</td>
                                <td class="!py-3">
                                    <span class="badge bg-primary/10 !text-primary !px-2.5 !py-1 !rounded-full">Subsanación</span>
                                </td>
                                <td class="!py-3 text-[#8c9097] dark:text-white/50">3 horas</td>
                            </tr>

                            <tr class="border-t border-primary/10 dark:border-defaultborder/10 hover:bg-primary/5 dark:hover:bg-white/5">
                                <td class="!py-3">
                                    <span class="font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70">INS-2026-000022</span>
                                </td>
                                <td class="!py-3">Empresa XYZ SAC</td>
                                <td class="!py-3">GHI-111</td>
                                <td class="!py-3">
                                    <span class="badge bg-emerald-500/10 !text-emerald-600 !px-2.5 !py-1 !rounded-full">Aprobado</span>
                                </td>
                                <td class="!py-3 text-[#8c9097] dark:text-white/50">4 horas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- mini resumen inferior --}}
                <div class="px-4 py-3 border-t border-primary/10 dark:border-defaultborder/10 flex items-center justify-between bg-white dark:bg-bodybg">
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center gap-2 text-[0.8rem] text-[#8c9097] dark:text-white/50">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Aprobadas
                        </span>
                        <span class="inline-flex items-center gap-2 text-[0.8rem] text-[#8c9097] dark:text-white/50">
                            <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span> Observadas
                        </span>
                        <span class="inline-flex items-center gap-2 text-[0.8rem] text-[#8c9097] dark:text-white/50">
                            <span class="h-2.5 w-2.5 rounded-full bg-primary"></span> Subsanación
                        </span>
                    </div>

                    <button type="button" class="ti-btn ti-btn-outline-secondary btn-wave !py-1 !px-2.5 !text-[0.75rem] !m-0">
                        Exportar <i class="ri-download-2-line ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- CERTIFICADOS EMITIDOS + CHART --}}
    <div class="xl:col-span-7 col-span-12">
        <div class="box !border-0 !overflow-hidden">
            <div class="box-header justify-between !border-b !border-primary/10 dark:!border-defaultborder/10">
                <div>
                    <div class="box-title !mb-0">Certificados emitidos</div>
                    <p class="text-[0.78rem] text-[#8c9097] dark:text-white/50 mb-0">Emisión por día (rango seleccionado) + detalle.</p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <input class="ti-form-control form-control-sm !ps-9 !w-[220px]" type="text" placeholder="Buscar por código"
                               aria-label="Buscar por código">

                    </div>

                    <div class="hs-dropdown ti-dropdown">
                        <a href="javascript:void(0);"
                           class="ti-btn ti-btn-outline-primary btn-wave !py-1 !px-2.5 !text-[0.75rem] !m-0 !font-medium"
                           aria-expanded="false">
                            Todos <i class="ri-arrow-down-s-line align-middle ms-1 inline-block"></i>
                        </a>
                        <ul class="hs-dropdown-menu ti-dropdown-menu hidden" role="menu">
                            <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block" href="javascript:void(0);">Todos</a></li>
                            <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block" href="javascript:void(0);">Vigentes</a></li>
                            <li><a class="ti-dropdown-item !py-2 !px-[0.9375rem] !text-[0.8125rem] !font-medium block" href="javascript:void(0);">Anulados</a></li>
                        </ul>
                    </div>

                    <button type="button" class="ti-btn ti-btn-primary btn-wave !py-1 !px-2.5 !text-[0.75rem] !m-0">
                        Exportar <i class="ri-upload-cloud-line ms-1"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                {{-- CHART --}}
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12">
                        <div class="p-4 rounded-xl bg-primary/5 dark:bg-white/5 border border-primary/10 dark:border-defaultborder/10">
                            <div class="flex items-center justify-between mb-3">
                                <div class="font-semibold text-defaulttextcolor dark:text-defaulttextcolor/70">
                                    Emisión de certificados (últimos 7 días)
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center gap-2 text-[0.78rem] text-[#8c9097] dark:text-white/50">
                                        <span class="h-2.5 w-2.5 rounded-full bg-primary"></span> Emitidos
                                    </span>
                                    <span class="inline-flex items-center gap-2 text-[0.78rem] text-[#8c9097] dark:text-white/50">
                                        <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span> Observados
                                    </span>
                                </div>
                            </div>

                            {{-- ApexCharts mount --}}
                            <div id="certificadosChart" class="w-full" style="min-height: 260px;"></div>
                        </div>
                    </div>

                    {{-- TABLA --}}
                    <div class="col-span-12">
                        <div class="table-responsive">
                            <table class="table whitespace-nowrap min-w-full !mb-0">
                                <thead class="bg-primary/5 dark:bg-white/5">
                                    <tr>
                                        <th scope="col" class="text-start !py-3">Código</th>
                                        <th scope="col" class="text-start !py-3">Empresa</th>
                                        <th scope="col" class="text-start !py-3">Equipo</th>
                                        <th scope="col" class="text-start !py-3">Estado</th>
                                        <th scope="col" class="text-start !py-3">Emitido</th>
                                        <th scope="col" class="text-start !py-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-primary/10 dark:border-defaultborder/10 hover:bg-primary/5 dark:hover:bg-white/5">
                                        <td class="!py-3 font-semibold">CERT-2026-000120</td>
                                        <td class="!py-3">EL CUMBE E.I.R.L.</td>
                                        <td class="!py-3">ABC-123</td>
                                        <td class="!py-3">
                                            <span class="badge bg-emerald-500/10 !text-emerald-600 !px-2.5 !py-1 !rounded-full">Vigente</span>
                                        </td>
                                        <td class="!py-3 text-[#8c9097] dark:text-white/50">08/02/2026</td>
                                        <td class="!py-3">
                                            <div class="flex items-center gap-2">
                                                <a href="javascript:void(0);" class="ti-btn ti-btn-light btn-wave !py-1 !px-2 !text-[0.75rem] !m-0">
                                                    Ver <i class="ri-eye-line ms-1"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="ti-btn ti-btn-outline-primary btn-wave !py-1 !px-2 !text-[0.75rem] !m-0">
                                                    PDF <i class="ri-file-pdf-line ms-1"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="border-t border-primary/10 dark:border-defaultborder/10 hover:bg-primary/5 dark:hover:bg-white/5">
                                        <td class="!py-3 font-semibold">CERT-2026-000119</td>
                                        <td class="!py-3">Empresa XYZ SAC</td>
                                        <td class="!py-3">XYZ-987</td>
                                        <td class="!py-3">
                                            <span class="badge bg-orange-500/10 !text-orange-600 !px-2.5 !py-1 !rounded-full">Observado</span>
                                        </td>
                                        <td class="!py-3 text-[#8c9097] dark:text-white/50">08/02/2026</td>
                                        <td class="!py-3">
                                            <div class="flex items-center gap-2">
                                                <a href="javascript:void(0);" class="ti-btn ti-btn-light btn-wave !py-1 !px-2 !text-[0.75rem] !m-0">
                                                    Ver <i class="ri-eye-line ms-1"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="ti-btn ti-btn-outline-secondary btn-wave !py-1 !px-2 !text-[0.75rem] !m-0">
                                                    Motivo <i class="ri-information-line ms-1"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="border-t border-primary/10 dark:border-defaultborder/10 hover:bg-primary/5 dark:hover:bg-white/5">
                                        <td class="!py-3 font-semibold">CERT-2026-000118</td>
                                        <td class="!py-3">SERVICIOS PERÚ S.A.C.</td>
                                        <td class="!py-3">DEF-456</td>
                                        <td class="!py-3">
                                            <span class="badge bg-primary/10 !text-primary !px-2.5 !py-1 !rounded-full">Emitido</span>
                                        </td>
                                        <td class="!py-3 text-[#8c9097] dark:text-white/50">07/02/2026</td>
                                        <td class="!py-3">
                                            <div class="flex items-center gap-2">
                                                <a href="javascript:void(0);" class="ti-btn ti-btn-light btn-wave !py-1 !px-2 !text-[0.75rem] !m-0">
                                                    Ver <i class="ri-eye-line ms-1"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="ti-btn ti-btn-outline-primary btn-wave !py-1 !px-2 !text-[0.75rem] !m-0">
                                                    PDF <i class="ri-file-pdf-line ms-1"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-[0.78rem] text-[#8c9097] dark:text-white/50">Mostrando 3 de 120</span>
                            <a href="javascript:void(0);" class="text-primary text-[0.8rem] font-medium">
                                Ir a certificados <i class="ri-arrow-right-s-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>




@endsection

@section('scripts')

    {{-- Highcharts (demo) - colócalo en @section('scripts') --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
  if (!window.Highcharts) return;

  Highcharts.chart('certificadosChart', {
    chart: {
      type: 'areaspline',
      backgroundColor: 'transparent',
      spacing: [10, 10, 10, 10]
    },
    title: { text: null },
    credits: { enabled: false },
    exporting: { enabled: false },
    legend: {
      enabled: true,
      itemStyle: { fontSize: '12px' }
    },
    xAxis: {
      categories: ['Lun','Mar','Mié','Jue','Vie','Sáb','Dom'],
      tickmarkPlacement: 'on',
      lineColor: 'rgba(0,0,0,0.08)',
      gridLineColor: 'rgba(0,0,0,0.06)',
      labels: { style: { fontSize: '12px' } }
    },
    yAxis: {
      title: { text: null },
      gridLineColor: 'rgba(0,0,0,0.06)',
      labels: { style: { fontSize: '12px' } }
    },
    tooltip: {
      shared: true,
      valueSuffix: ''
    },
    plotOptions: {
      series: {
        marker: { radius: 3 },
        lineWidth: 2,
        fillOpacity: 0.18
      }
    },
    series: [
      {
        name: 'Emitidos',
        data: [4, 6, 5, 8, 7, 10, 9],
        color: '#6d5efc' // violeta elegante (similar Ynex)
      },
      {
        name: 'Observados',
        data: [1, 2, 1, 3, 2, 2, 1],
        color: '#f59e0b' // naranja alerta
      }
    ]
  });
});
</script>

@endsection