<div class="space-y-4 transition-opacity duration-200">
        <div class="box">
            <div class="box-body space-y-4">
                <fieldset :disabled="inspectionFinalized" :class="inspectionFinalized ? 'opacity-80' : ''" class="space-y-4">
                    @php
                        $selectedCategory = collect($questionnaireCategories)->firstWhere('id', $uiActiveQuestionCategoryId);
                        $selectedSubcategory = $selectedCategory
                            ? collect($selectedCategory['subcategorias'] ?? [])->firstWhere('id', $uiActiveQuestionSubcategoryId)
                            : null;
                        $activeGroup = collect($questionnaireGroups)->first(function ($group) use ($uiActiveQuestionCategoryId, $uiActiveQuestionSubcategoryId) {
                            return (int) ($group['categoria_id'] ?? 0) === (int) $uiActiveQuestionCategoryId
                                && (int) ($group['subcategoria_id'] ?? 0) === (int) $uiActiveQuestionSubcategoryId;
                        });
                    @endphp

                    <div class="rounded-xl border border-defaultborder bg-white px-4 py-3 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="text-[0.78rem] font-semibold uppercase tracking-[0.12em]" style="color:#7c3aed;">INSPECCIÓN</span>
                            <span class="badge bg-primary/10 text-primary">{{ count($responsesInput) }} preguntas</span>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-defaultborder bg-white shadow-sm">
                        <div class="border-b border-defaultborder px-4 py-3">
                            <div class="insp-tab-strip">
                                @forelse ($questionnaireCategories as $categoria)
                                    <button type="button"
                                            class="insp-tab {{ $uiInspectionTab === 'questions' && (int) $uiActiveQuestionCategoryId === (int) $categoria['id'] ? 'is-active' : '' }}"
                                            wire:click="selectQuestionCategory({{ $categoria['id'] }})"
                                            title="{{ $categoria['nombre'] }}">
                                        <span>{{ $categoria['nombre'] }}</span>
                                    </button>
                                @empty
                                    <span class="text-[0.85rem] text-[#8c9097]">No hay categorías configuradas.</span>
                                @endforelse
                                <button type="button"
                                        class="insp-tab {{ $uiInspectionTab === 'files' ? 'is-active' : '' }}"
                                        wire:click="selectInspectionFilesTab"
                                        title="Archivos">
                                    <span>Archivos</span>
                                </button>
                            </div>
                        </div>

                        @if ($uiInspectionTab === 'questions')
                            <div class="border-b border-defaultborder px-4 py-3" style="background:#f3e8ff;">
                                <div class="insp-subtab-row">
                                    <div class="insp-subtab-scroll">
                                        @forelse (($selectedCategory['subcategorias'] ?? []) as $subcategoria)
                                            <button type="button"
                                                    class="insp-subtab {{ (int) $uiActiveQuestionSubcategoryId === (int) $subcategoria['id'] ? 'is-active' : '' }}"
                                                    wire:click="selectQuestionSubcategory({{ $subcategoria['id'] }})"
                                                    title="{{ $subcategoria['nombre'] }}">
                                                <span>{{ $subcategoria['nombre'] }}</span>
                                                @if (!empty($subcategoria['has_observaciones']))
                                                    <span class="insp-subtab-alert animate-pulse" title="Subcategoría con observaciones">!</span>
                                                @endif
                                            </button>
                                        @empty
                                            <span class="text-[0.84rem] text-[#6b7280]">Esta categoría no tiene subcategorías.</span>
                                        @endforelse
                                    </div>
                                    <button type="button"
                                            class="insp-subtab-add"
                                            title="Agregar pregunta personalizada"
                                            @disabled(!$selectedSubcategory || !$activeGroup)
                                            wire:click="prepareCustomQuestionModal({{ (int) ($uiActiveQuestionCategoryId ?? 0) }}, {{ (int) ($uiActiveQuestionSubcategoryId ?? 0) }}, '{{ $activeGroup['key'] ?? '' }}')">
                                        <i class="ri-add-line"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="p-0">
                                @if ($activeGroup && !empty($activeGroup['responses']))
                                    <div class="grid grid-cols-12 bg-slate-50/80 border-b border-defaultborder">
                                        <div class="col-span-12 lg:col-span-4 px-4 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#6b7280]">Pregunta</div>
                                        <div class="col-span-12 lg:col-span-3 px-4 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#6d28d9]">Ingreso</div>
                                        <div class="col-span-12 lg:col-span-3 px-4 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#059669]">Salida</div>
                                        <div class="col-span-6 lg:col-span-1 px-4 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#6b7280]">Observaciones</div>
                                        <div class="col-span-6 lg:col-span-1 px-4 py-3 text-[0.74rem] font-semibold uppercase tracking-[0.12em] text-[#6b7280] text-right">Acc.</div>
                                    </div>
                                    <div class="divide-y divide-defaultborder">
                                        @foreach ($activeGroup['responses'] as $row)
                                            <div class="grid grid-cols-12 {{ (int) $row['observaciones_count'] > 0 ? 'insp-row-has-observation' : '' }}">
                                                <div class="col-span-12 lg:col-span-4 border-s-4 {{ (int) $row['observaciones_count'] > 0 ? 'border-s-danger bg-danger/5' : 'border-s-slate-200 bg-white' }} px-4 py-5">
                                                    <div class="font-medium {{ (int) $row['observaciones_count'] > 0 ? 'text-danger' : '' }}">{{ $row['enunciado'] }}</div>
                                                </div>
                                                <div class="col-span-12 lg:col-span-3 px-4 py-5" style="background-color:#e9d5ff;">
                                                    @if ($row['ingreso_preguntar'])
                                                        @if ($row['ingreso_tipo'] === 'select')
                                                            <select class="form-control bg-white" wire:model.live="responsesInput.{{ $row['id'] }}.ingreso">
                                                                <option value="">Seleccione...</option>
                                                                @foreach ($row['ingreso_valores'] as $opt)
                                                                    <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        @elseif ($row['ingreso_tipo'] === 'radio')
                                                            <div class="flex flex-wrap items-center gap-3 pt-2">
                                                                @forelse ($row['ingreso_valores'] as $opt)
                                                                    <label class="inline-flex items-center gap-2 text-[0.86rem] text-defaulttextcolor">
                                                                        <input type="radio" class="form-check-input" value="{{ $opt['value'] }}" wire:model.live="responsesInput.{{ $row['id'] }}.ingreso">
                                                                        <span>{{ $opt['label'] }}</span>
                                                                    </label>
                                                                @empty
                                                                    <span class="text-[0.8rem] text-[#8c9097]">Sin opciones configuradas</span>
                                                                @endforelse
                                                            </div>
                                                        @else
                                                            <input type="text" class="form-control bg-white" placeholder="Respuesta ingreso" wire:model.live="responsesInput.{{ $row['id'] }}.ingreso">
                                                        @endif
                                                    @else
                                                        <span class="text-[0.8rem] text-[#8c9097]">No aplica</span>
                                                    @endif
                                                </div>
                                                <div class="col-span-12 lg:col-span-3 px-4 py-5" style="background-color:#bbf7d0;">
                                                    @if ($row['salida_preguntar'])
                                                        @if ($row['salida_tipo'] === 'select')
                                                            <select class="form-control bg-white" wire:model.live="responsesInput.{{ $row['id'] }}.salida">
                                                                <option value="">Seleccione...</option>
                                                                @foreach ($row['salida_valores'] as $opt)
                                                                    <option value="{{ $opt['value'] }}">{{ $opt['label'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        @elseif ($row['salida_tipo'] === 'radio')
                                                            <div class="flex flex-wrap items-center gap-3 pt-2">
                                                                @forelse ($row['salida_valores'] as $opt)
                                                                    <label class="inline-flex items-center gap-2 text-[0.86rem] text-defaulttextcolor">
                                                                        <input type="radio" class="form-check-input" value="{{ $opt['value'] }}" wire:model.live="responsesInput.{{ $row['id'] }}.salida">
                                                                        <span>{{ $opt['label'] }}</span>
                                                                    </label>
                                                                @empty
                                                                    <span class="text-[0.8rem] text-[#8c9097]">Sin opciones configuradas</span>
                                                                @endforelse
                                                            </div>
                                                        @else
                                                            <input type="text" class="form-control bg-white" placeholder="Respuesta salida" wire:model.live="responsesInput.{{ $row['id'] }}.salida">
                                                        @endif
                                                    @else
                                                        <span class="text-[0.8rem] text-[#8c9097]">No aplica</span>
                                                    @endif
                                                </div>
                                                <div class="col-span-6 lg:col-span-1 px-4 py-5">
                                                    <span class="inline-flex min-w-10 items-center justify-center rounded-full px-3 py-1 text-sm font-semibold {{ (int) $row['observaciones_count'] > 0 ? 'bg-danger/10 text-danger' : 'bg-slate-100 text-slate-700' }}">
                                                        {{ $row['observaciones_count'] }}
                                                    </span>
                                                </div>
                                                <div class="col-span-6 lg:col-span-1 px-4 py-5">
                                                    <div class="flex justify-end gap-2">
                                                        <button type="button" class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info-full" wire:click="openObservationList({{ $row['id'] }})" title="Ver observaciones">
                                                            <i class="ri-eye-line"></i>
                                                        </button>
                                                        <button type="button" class="ti-btn ti-btn-icon ti-btn-sm bg-warning text-white" wire:click="prepareObservationModal({{ $row['id'] }})" title="Registrar observación">
                                                            <i class="ri-add-line"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="p-4 text-[0.9rem] text-[#8c9097]">
                                        No hay preguntas configuradas para la subcategoría seleccionada.
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if ($uiInspectionTab === 'files')
                    <div class="insp-upload-panel p-4 md:p-5 space-y-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <div class="font-semibold uppercase tracking-[0.12em] text-[#4b5563] text-[0.82rem]">Subir archivos</div>
                                <div class="text-[0.78rem] text-[#8c9097]">Imágenes y PDF vinculados a la inspección.</div>
                            </div>
                        </div>
                        <div class="grid grid-cols-12 gap-4">
                            <div class="col-span-12 lg:col-span-7">
                                <label class="flex min-h-[180px] cursor-pointer items-center justify-center rounded-2xl border border-dashed border-defaultborder bg-slate-50/70 px-4 text-center transition hover:border-primary/40 hover:bg-primary/5">
                                    <input type="file" class="hidden" wire:model="inspectionUploadFile" accept=".jpg,.jpeg,.png,.webp,.pdf">
                                    <div class="space-y-2">
                                        <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm text-primary">
                                            <i class="ri-upload-cloud-2-line text-[1.2rem]"></i>
                                        </div>
                                        <div class="text-[1rem] font-medium text-[#475569]">Arrastra el archivo aquí</div>
                                        <div class="text-[#8c9097] text-[0.82rem]">o elige un archivo desde tu equipo</div>
                                        <span class="ti-btn ti-btn-light">Seleccionar archivo</span>
                                        <div class="text-[0.74rem] text-[#8c9097]">Permitido: JPG, PNG, WEBP y PDF. Máx. 10MB.</div>
                                        @if ($inspectionUploadFile)
                                            <div class="text-[0.82rem] text-primary font-medium">Archivo seleccionado: {{ $inspectionUploadFile->getClientOriginalName() }}</div>
                                        @endif
                                    </div>
                                </label>
                                @error('inspectionUploadFile') <p class="mt-2 text-xs text-danger">{{ $message }}</p> @enderror
                            </div>
                            <div class="col-span-12 lg:col-span-5 space-y-3 rounded-2xl border border-defaultborder bg-slate-50/60 p-4">
                                <div>
                                    <label class="form-label">Nombre del archivo</label>
                                    <input type="text" class="form-control" wire:model.defer="inspectionFileForm.descripcion" placeholder="Ej: SOAT vigente">
                                    @error('inspectionFileForm.descripcion') <p class="mt-1 text-xs text-danger">{{ $message }}</p> @enderror
                                </div>
                                <div class="rounded-xl border border-defaultborder bg-white p-3">
                                    <label class="inline-flex items-center gap-2 text-[0.9rem]">
                                        <input type="checkbox" class="form-check-input" wire:model.defer="inspectionFileForm.mostrar_certificado">
                                        <span>Mostrar archivo en el certificado</span>
                                    </label>
                                </div>
                                <button type="button" class="ti-btn w-full bg-primary text-white" wire:click="attachInspectionFile">
                                    <i class="ri-upload-cloud-2-line me-1"></i>Adjuntar archivo a la inspección
                                </button>
                            </div>
                        </div>

                        <div class="pt-4">
                            <div class="insp-divider mb-4"></div>
                            <div class="mb-3 flex items-center gap-3">
                                <div class="h-5 w-[3px] rounded-full bg-primary"></div>
                                <div class="text-lg font-semibold">Archivos cargados</div>
                            </div>
                            @if (!empty($inspectionFiles))
                                <div class="mb-2 grid grid-cols-12 gap-3 px-4 text-[0.72rem] font-semibold uppercase tracking-[0.12em] text-[#6b7280]">
                                    <div class="col-span-12 lg:col-span-7">Archivo</div>
                                    <div class="col-span-12 lg:col-span-3">Mostrar en certificado</div>
                                    <div class="col-span-12 lg:col-span-2 text-right">Acciones</div>
                                </div>
                            @endif
                            <div class="space-y-2">
                                @forelse ($inspectionFiles as $file)
                                    <div class="rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-3">
                                        <div class="grid grid-cols-12 items-center gap-3">
                                            <div class="col-span-12 lg:col-span-7">
                                                <div class="font-medium">{{ $file['descripcion'] }}</div>
                                                <div class="text-[0.8rem] text-[#8c9097]">
                                                    {{ strtoupper($file['tipo']) }} · {{ $file['fecha'] }}
                                                </div>
                                            </div>
                                            <div class="col-span-12 lg:col-span-3">
                                                <label class="inline-flex items-center gap-2 text-[0.86rem] text-[#475569]">
                                                    <input type="checkbox"
                                                           class="form-check-input"
                                                           @checked($file['mostrar_certificado'])
                                                           wire:change="toggleInspectionFileCertificate({{ $file['id'] }}, $event.target.checked)">
                                                    <span>Mostrar en certificado</span>
                                                </label>
                                            </div>
                                            <div class="col-span-12 lg:col-span-2">
                                                <div class="flex items-center justify-start gap-2 lg:justify-end">
                                                    <button type="button"
                                                            class="ti-btn ti-btn-icon ti-btn-sm ti-btn-info-full"
                                                            wire:click="openInspectionFilePreview({{ $file['id'] }})"
                                                            @click="inspectionFilePreviewModal = true"
                                                            title="Visualizar archivo">
                                                        <i class="ri-eye-line"></i>
                                                    </button>
                                                    <button type="button"
                                                            class="ti-btn ti-btn-icon ti-btn-sm ti-btn-danger-full"
                                                            x-on:click="if(confirm('¿Deseas eliminar este archivo?')) { $wire.deleteInspectionFile({{ $file['id'] }}) }"
                                                            title="Eliminar archivo">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="rounded-xl border border-dashed border-defaultborder p-4 text-[0.88rem] text-[#8c9097]">
                                        Aún no se adjuntaron archivos a esta inspección.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @endif
                </fieldset>
            </div>
        </div>
    </div>

