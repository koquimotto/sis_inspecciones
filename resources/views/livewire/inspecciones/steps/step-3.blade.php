<div class="space-y-4 transition-opacity duration-200">
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-12 xl:col-span-5">
                <div class="box h-full">
                    <div class="box-header"><div class="box-title !mb-0">Generación de certificado</div></div>
                    <div class="box-body space-y-4">
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 md:col-span-7">
                                <button type="button" class="h-full min-h-[124px] w-full rounded-2xl bg-danger/5 p-4 text-left transition hover:bg-danger/10" wire:click="openObservedParametersSummary">
                                    <div class="text-[0.75rem] uppercase tracking-[0.16em] text-danger">Observaciones</div>
                                    <div class="mt-2 text-3xl font-semibold"
                                         title="Número de parámetros observados">{{ $observedParametersCount }} parámetros</div>
                                    <div class="text-[0.9rem] font-medium">observados</div>
                                </button>
                            </div>
                            <div class="col-span-12 md:col-span-5">
                                <div class="h-full min-h-[124px] rounded-2xl bg-success/5 p-4">
                                    <div class="text-[0.75rem] uppercase tracking-[0.16em] text-success">Estado</div>
                                    <div class="mt-2 text-xl font-semibold">{{ \Illuminate\Support\Str::ucfirst($certificateStatusLabel) }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-defaultborder p-4">
                            @if ($inspectionFinalized)
                                <div class="text-[0.93rem]">
                                    Inspección finalizada {{ $finalizedAtLabel ? 'el ' . $finalizedAtLabel : '' }} ·
                                    <button type="button" class="font-semibold text-info hover:underline" wire:click="openDetailReportPreview">ver informe detallado</button>
                                </div>
                                <div class="mt-3 flex justify-end">
                                    <button type="button" class="ti-btn bg-danger text-white" wire:click="enableInspectionEdition">
                                        <i class="ri-edit-line me-1"></i>Editar
                                    </button>
                                </div>
                            @else
                                @if ($observedParametersCount > 0)
                                    <p class="mb-3 text-[0.92rem] text-[#374151]">
                                        El certificado no se puede generar debido a que hay {{ $observedParametersCount }} parámetros observados.
                                    </p>
                                @else
                                    <p class="mb-3 text-[0.92rem] text-[#374151]">
                                        Para generar el certificado debes finalizar la inspección.
                                    </p>
                                @endif

                                <div class="grid grid-cols-12 gap-3 items-end">
                                    @if ($observedParametersCount > 0)
                                        <div class="col-span-12 md:col-span-7">
                                            <label class="form-label">Fecha plazo para subsanar observaciones</label>
                                            <input type="date" class="form-control" wire:model="remediationDueDate">
                                            @error('remediationDueDate') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                                        </div>
                                        <div class="col-span-12 md:col-span-5">
                                            <button type="button" class="ti-btn w-full bg-primary text-white" x-on:click.prevent="window.InspeccionesObs?.confirmFinalize($wire, { hasCurrentCertificate: @js($canEditInspectionFromCertificate), hasObservations: true })">
                                                <i class="ri-checkbox-circle-line me-1"></i>Finalizar inspección
                                            </button>
                                        </div>
                                    @else
                                        <div class="col-span-12">
                                            <button type="button" class="ti-btn w-full bg-primary text-white" x-on:click.prevent="window.InspeccionesObs?.confirmFinalize($wire, { hasCurrentCertificate: @js($canEditInspectionFromCertificate), hasObservations: false })">
                                                <i class="ri-checkbox-circle-line me-1"></i>Finalizar inspección
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        @if ($canGenerateCertificate)
                            <button type="button" class="ti-btn w-full bg-success text-white" wire:click="generateInspectionCertificate">
                                <i class="ri-award-line me-1"></i>Generar certificado de inspección
                            </button>
                        @elseif ($certificateGenerated)
                            <div class="rounded-xl border border-success/30 bg-success/5 px-4 py-3 text-success">
                                Certificado generado correctamente.
                            </div>
                        @endif

                        @if ($canEditInspectionFromCertificate && !$inspectionFinalized)
                            @if ($observedParametersCount > 0)
                                <p class="mb-0 text-[0.82rem] text-warning">
                                    Al finalizar con observaciones se anulará el certificado actual.
                                </p>
                            @else
                                <p class="mb-0 text-[0.82rem] text-warning">
                                    Al finalizar sin observaciones se deberá generar nuevamente el certificado.
                                </p>
                            @endif
                        @endif
                        <p class="mb-0 text-[0.82rem] text-[#8c9097]">
                            Siempre que se genere un PDF se registrará automáticamente en archivos de inspección.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-span-12 xl:col-span-7">
                <div class="box h-full">
                    <div class="box-header">
                        <div class="box-title !mb-0">
                            Certificado de inspección
                            @if ($certificateGenerated)
                                <span class="text-[0.9rem] font-normal text-success">(generado {{ $finalizedAtLabel ? 'el ' . $finalizedAtLabel : '' }})</span>
                            @else
                                <span class="text-[0.9rem] font-normal text-[#8c9097]">(No emitido)</span>
                            @endif
                        </div>
                    </div>
                    <div class="box-body space-y-4">
                        @if ($certificatePdfUrl)
                            <iframe src="{{ $certificatePdfUrl }}" class="h-[68vh] w-full rounded-xl border border-defaultborder"></iframe>
                        @else
                            <div class="rounded-2xl border border-dashed border-defaultborder bg-slate-200/65 p-8 text-center min-h-[68vh] flex flex-col justify-center">
                                <div class="text-[0.75rem] uppercase tracking-[0.18em] text-[#8c9097]">Documento</div>
                                <div class="mt-3 text-lg font-semibold text-[#334155]">Certificado de inspección</div>
                                <div class="mt-2 text-[0.9rem] text-[#8c9097]">Aquí se mostrará la previsualización cuando se genere el certificado.</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

