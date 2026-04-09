<?php

namespace App\Livewire\Inspecciones;

use App\Models\Categoria;
use App\Models\Certificado;
use App\Models\CuestionarioPregunta;
use App\Models\CuestionarioRespuesta;
use App\Models\CuestionarioRespuestaObservacion;
use App\Models\DetalleInspeccion;
use App\Models\Empresa;
use App\Models\EmpresaContacto;
use App\Models\EmpresaEquipo;
use App\Models\Equipo;
use App\Models\Inspeccion;
use App\Models\InspeccionArchivoEquipo;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Persona;
use App\Models\Servicio;
use App\Models\Tipo;
use App\Models\TipoCertificado;
use App\Services\InspeccionService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class Formulario extends Component
{
    use WithFileUploads;

    public int $uiStep = 1;
    public ?Inspeccion $inspeccion = null;
    public string $empresaSearch = '';
    public array $empresaSuggestions = [];
    public ?int $selectedEmpresaId = null;
    public array $empresaResumen = [];
    public bool $companyModal = false;
    public int $companyStep = 1;
    public ?int $draftEmpresaId = null;
    public array $empresaForm = [];
    public bool $companyLockedByRuc = false;
    public string $serviceSearch = '';
    public array $serviceSuggestions = [];
    public array $companyServices = [];
    public array $contactForm = [];
    public bool $allowManualContact = false;
    public array $companyContacts = [];
    public bool $equipmentModal = false;
    public string $equipmentSearch = '';
    public array $equipmentSuggestions = [];
    public ?int $selectedEmpresaEquipoId = null;
    public array $equipoResumen = [];
    public array $empresaServiceOptions = [];
    public array $equipmentForm = [];
    public array $equipmentDescriptionSuggestions = [];
    public string $tipoSearch = '';
    public array $tipoSuggestions = [];
    public string $categoriaSearch = '';
    public array $categoriaSuggestions = [];
    public string $marcaSearch = '';
    public array $marcaSuggestions = [];
    public string $modeloSearch = '';
    public array $modeloSuggestions = [];
    public array $quickSummary = [];
    public array $inspectionHistory = [];
    public bool $inspectionDetailModal = false;
    public array $inspectionDetailView = [];
    public array $questionnaireGroups = [];
    public array $questionnaireCategories = [];
    public array $responsesInput = [];
    public array $responseMeta = [];
    public array $responseSubgroupMap = [];
    public array $subgroupResponseIds = [];
    public array $pendingSubgroups = [];
    public ?int $currentDetalleInspeccionId = null;
    public ?int $activeObservationResponseId = null;
    public array $observationForm = [];
    public array $activeResponseObservations = [];
    public ?int $currentInspeccionId = null;
    public $inspectionUploadFile = null;
    public array $inspectionFileForm = [];
    public array $inspectionFiles = [];
    public bool $inspectionFilePreviewModal = false;
    public array $inspectionFilePreview = [];
    public ?int $uiActiveQuestionCategoryId = null;
    public ?int $uiActiveQuestionSubcategoryId = null;
    public string $uiInspectionTab = 'questions';
    public array $customQuestionForm = [];
    public ?string $customQuestionGroupKey = null;
    public int $observedParametersCount = 0;
    public string $certificateStatusLabel = 'en proceso';
    public bool $inspectionFinalized = false;
    public bool $certificateGenerated = false;
    public bool $canFinalizeInspection = false;
    public bool $canGenerateCertificate = false;
    public bool $canEditInspectionFromCertificate = false;
    public ?string $finalizedAtLabel = null;
    public ?string $certificatePdfUrl = null;
    public ?string $reportPdfUrl = null;
    public ?string $remediationDueDate = null;

    public function mount(?Inspeccion $inspeccion = null): void
    {
        $this->inspeccion = $inspeccion?->load([
            'empresaEquipo.empresa.contactoPrincipal.persona',
            'empresaEquipo.servicio',
            'empresaEquipo.equipo.tipo',
            'empresaEquipo.equipo.categoria',
            'empresaEquipo.equipo.marca',
            'empresaEquipo.equipo.modelo',
            'empresaEquipo.empresa.servicios',
            'empresaEquipo.empresa.contactos.persona',
            'ultimoDetalle',
        ]);

        $this->empresaResumen = $this->empresaResumenDefaults();
        $this->equipoResumen = $this->equipoResumenDefaults();
        $this->resetCompanyModalData();
        $this->resetEquipmentModalData();

        $empresaActual = $this->inspeccion?->empresaEquipo?->empresa;
        if ($empresaActual) {
            $this->selectedEmpresaId = (int) $empresaActual->id;
            $this->syncEmpresaResumen($empresaActual->load(['servicios', 'contactoPrincipal.persona']));
            $this->loadEmpresaServiceOptions($empresaActual);
        }

        $empresaEquipoActual = $this->inspeccion?->empresaEquipo;
        if ($empresaEquipoActual) {
            $this->selectedEmpresaEquipoId = (int) $empresaEquipoActual->id;
            $this->syncEquipoResumen($empresaEquipoActual->load(['equipo.tipo', 'equipo.categoria', 'equipo.marca', 'equipo.modelo', 'servicio']));
            $this->equipmentSearch = (string) ($empresaEquipoActual->descripcion ?: $empresaEquipoActual->equipo?->descripcion ?: '');
        }

        $this->refreshInspectionContext();
        $this->observationForm = $this->defaultObservationForm();
        $this->inspectionFileForm = $this->defaultInspectionFileForm();
        $this->customQuestionForm = $this->defaultCustomQuestionForm();
    }

    public function render(): View
    {
        return view('livewire.inspecciones.formulario');
    }

    public function setUiStep(int $step): void
    {
        if (!in_array($step, [1, 2, 3], true)) {
            return;
        }

        $started = (bool) ($this->quickSummary['started'] ?? false);
        if ($step > 1 && !$started) {
            return;
        }

        if ($this->uiStep === 2 && $step !== 2) {
            $this->flushPendingResponses();
        }

        $this->uiStep = $step;
        $this->dispatch(
            'inspection-state',
            started: $started,
            inspectionFinalized: (bool) ($this->quickSummary['inspection_finalized'] ?? false),
            step: $this->uiStep
        );
    }

    public function updatedEmpresaSearch(string $value): void
    {
        $term = trim($value);
        if (mb_strlen($term) < 2) {
            $this->empresaSuggestions = [];
            return;
        }

        $this->empresaSuggestions = Empresa::query()
            ->where('estado', 1)
            ->where(function ($query) use ($term) {
                $query->where('razon_social', 'like', "%{$term}%")
                    ->orWhere('nombre_comercial', 'like', "%{$term}%")
                    ->orWhere('ruc', 'like', "%{$term}%");
            })
            ->orderBy('razon_social')
            ->limit(8)
            ->get(['id', 'ruc', 'razon_social', 'nombre_comercial'])
            ->map(fn (Empresa $empresa) => [
                'id' => (int) $empresa->id,
                'ruc' => (string) ($empresa->ruc ?? ''),
                'razon_social' => (string) $empresa->razon_social,
                'nombre_comercial' => (string) ($empresa->nombre_comercial ?? ''),
            ])
            ->all();
    }

    public function selectEmpresa(int $empresaId): void
    {
        $empresa = Empresa::query()
            ->with([
                'servicios:id,descripcion',
                'contactoPrincipal.persona:id,nombres,apellido_paterno,apellido_materno,telefono',
            ])
            ->findOrFail($empresaId);

        $empresaChanged = (int) ($this->selectedEmpresaId ?? 0) !== (int) $empresa->id;
        $this->selectedEmpresaId = (int) $empresa->id;
        $this->empresaSearch = (string) $empresa->razon_social;
        $this->empresaSuggestions = [];
        $this->syncEmpresaResumen($empresa);
        $this->loadEmpresaServiceOptions($empresa);

        if ($empresaChanged) {
            $this->resetEquipmentSelection();
            $this->dispatch('inspection-reset');
        }
    }

    public function clearSelectedEmpresa(): void
    {
        $this->selectedEmpresaId = null;
        $this->empresaSearch = '';
        $this->empresaSuggestions = [];
        $this->empresaResumen = $this->empresaResumenDefaults();
        $this->empresaServiceOptions = [];
        $this->resetEquipmentSelection();
        $this->dispatch('inspection-reset');
    }

    public function openCompanyModal(): void
    {
        $this->resetCompanyModalData();
        $this->companyModal = true;
    }

    public function goToCompanyStep(int $step): void
    {
        if ($this->companyLockedByRuc) {
            $this->dispatch('swal', type: 'warning', title: 'Empresa no editable', text: 'Esta empresa ya tiene equipos registrados y no puede editarse desde este modal.');
            return;
        }

        if ($step <= 1) {
            if ($this->draftEmpresaId) {
                $this->persistDraftProgress();
            }
            $this->companyStep = 1;
            return;
        }

        if (!$this->saveCompanyBaseData()) {
            $this->dispatch('swal', type: 'warning', title: 'Completa los campos obligatorios', text: 'Para continuar es necesario completar la informacion obligatoria de la empresa.');
            return;
        }

        if ($step === 3 && count($this->companyServices) === 0) {
            $this->addError('serviceSearch', 'Debes agrego al menos un servicio para continuar.');
            return;
        }

        $this->persistDraftProgress();
        $this->companyStep = $step;
    }

    public function validateCompanyRucOnBlur(): void
    {
        $ruc = trim((string) ($this->empresaForm['ruc'] ?? ''));
        $this->companyLockedByRuc = false;
        if ($ruc === '' || strlen($ruc) !== 11) {
            return;
        }

        $empresa = Empresa::query()
            ->withCount('empresaEquipos')
            ->with(['servicios:id,descripcion', 'contactos.persona:id,tipo_documento,numero_documento,nombres,apellido_paterno,apellido_materno,email,telefono'])
            ->where('ruc', $ruc)
            ->first();

        if (!$empresa) {
            return;
        }

        if ($this->draftEmpresaId && (int) $empresa->id === (int) $this->draftEmpresaId) {
            return;
        }

        if ((int) $empresa->empresa_equipos_count > 0) {
            $this->companyLockedByRuc = true;
            $this->draftEmpresaId = null;
            $this->companyServices = [];
            $this->companyContacts = [];
            $this->addError('empresaForm.ruc', 'La empresa ya existe y tiene equipos registrados. No se puede editar ni registrar nuevamente desde este modal.');
            $this->dispatch('swal', type: 'warning', title: 'Empresa ya registrada', text: 'El RUC ingresado pertenece a una empresa con equipos registrados. No puedes continuar desde este modal.', requireConfirm: true, confirmText: 'Entendido');
            return;
        }

        $this->hydrateDraftFromExistingEmpresa($empresa);
        $this->resetErrorBag('empresaForm.ruc');
        $this->dispatch('swal', type: 'info', title: 'Empresa encontrada', text: 'Se cargo la informacion existente para que puedas completar/actualizar el registro', requireConfirm: true, confirmText: 'Continuar');
    }

    public function updatedServiceSearch(string $value): void
    {
        $term = trim($value);
        if (mb_strlen($term) < 2) {
            $this->serviceSuggestions = [];
            return;
        }

        $this->serviceSuggestions = Servicio::query()
            ->where('estado', 1)
            ->where('descripcion', 'like', "%{$term}%")
            ->orderBy('descripcion')
            ->limit(8)
            ->get(['id', 'descripcion'])
            ->map(fn (Servicio $servicio) => ['id' => (int) $servicio->id, 'descripcion' => (string) $servicio->descripcion])
            ->all();
    }

    public function selectService(int $serviceId): void
    {
        $servicio = Servicio::query()->findOrFail($serviceId);
        $this->appendService((int) $servicio->id, (string) $servicio->descripcion);
        $this->serviceSearch = '';
        $this->serviceSuggestions = [];
    }

    public function addServiceFromInput(): void
    {
        $term = trim($this->serviceSearch);
        if ($term === '') {
            return;
        }

        $servicio = Servicio::query()->whereRaw('LOWER(descripcion) = ?', [mb_strtolower($term)])->first();
        if (!$servicio) {
            $servicio = Servicio::query()->create(['descripcion' => $term, 'estado' => 1, 'created_by' => $this->actorId(), 'updated_by' => $this->actorId()]);
        }

        $this->appendService((int) $servicio->id, (string) $servicio->descripcion);
        $this->serviceSearch = '';
        $this->serviceSuggestions = [];
        $this->resetErrorBag('serviceSearch');
    }

    public function removeService(int $serviceId): void
    {
        $this->companyServices = collect($this->companyServices)
            ->reject(fn (array $item) => (int) $item['id'] === $serviceId)
            ->values()
            ->all();
    }

    public function searchPersonaByDocumento(): void
    {
        $this->validate([
            'contactForm.tipo_documento' => ['required', Rule::in(['DNI', 'CE', 'PAS'])],
            'contactForm.numero_documento' => ['required', 'string', 'max:20'],
        ], [], [
            'contactForm.tipo_documento' => 'tipo de documento',
            'contactForm.numero_documento' => 'numero de documento',
        ]);

        $persona = Persona::query()->where('numero_documento', trim((string) $this->contactForm['numero_documento']))->first();
        if (!$persona) {
            $this->allowManualContact = true;
            $this->contactForm['persona_id'] = null;
            $this->contactForm['nombres'] = '';
            $this->contactForm['apellido_paterno'] = '';
            $this->contactForm['apellido_materno'] = '';
            $this->contactForm['email'] = '';
            $this->contactForm['telefono'] = '';
            $this->dispatch('swal', type: 'warning', title: 'Persona no encontrada', text: 'No se encontro la persona. Por favor, completa el registromanual.', toast: true, timer: 3200);
            return;
        }

        $this->allowManualContact = false;
        $this->contactForm['persona_id'] = (int) $persona->id;
        $this->contactForm['nombres'] = (string) $persona->nombres;
        $this->contactForm['apellido_paterno'] = (string) $persona->apellido_paterno;
        $this->contactForm['apellido_materno'] = (string) $persona->apellido_materno;
        $this->contactForm['email'] = (string) ($persona->email ?? '');
        $this->contactForm['telefono'] = (string) ($persona->telefono ?? '');
        $this->dispatch('swal', type: 'success', title: 'Persona encontrada', text: 'Se encontro la persona y se completaron sus datos.', toast: true, timer: 2800);
    }

    public function addCompanyContact(): void
    {
        $data = $this->validate([
            'contactForm.tipo_documento' => ['required', Rule::in(['DNI', 'CE', 'PAS'])],
            'contactForm.numero_documento' => ['required', 'string', 'max:20'],
            'contactForm.nombres' => ['required', 'string', 'max:120'],
            'contactForm.apellido_paterno' => ['required', 'string', 'max:120'],
            'contactForm.apellido_materno' => ['required', 'string', 'max:120'],
            'contactForm.email' => ['nullable', 'email', 'max:150'],
            'contactForm.telefono' => ['nullable', 'string', 'max:30'],
        ], [], [
            'contactForm.tipo_documento' => 'tipo de documento',
            'contactForm.numero_documento' => 'numero de documento',
            'contactForm.nombres' => 'nombres',
            'contactForm.apellido_paterno' => 'apellido paterno',
            'contactForm.apellido_materno' => 'apellido materno',
        ]);

        $doc = trim((string) $data['contactForm']['numero_documento']);
        $exists = collect($this->companyContacts)->contains(fn (array $contacto) => (string) $contacto['numero_documento'] === $doc);
        if ($exists) {
            $this->addError('contactForm.numero_documento', 'estadocumento ya fue agregoo en la lista.');
            return;
        }

        $this->companyContacts[] = [
            'persona_id' => !empty($this->contactForm['persona_id']) ? (int) $this->contactForm['persona_id'] : null,
            'tipo_documento' => (string) $data['contactForm']['tipo_documento'],
            'numero_documento' => $doc,
            'nombres' => trim((string) $data['contactForm']['nombres']),
            'apellido_paterno' => trim((string) $data['contactForm']['apellido_paterno']),
            'apellido_materno' => trim((string) $data['contactForm']['apellido_materno']),
            'email' => trim((string) ($data['contactForm']['email'] ?? '')),
            'telefono' => trim((string) ($data['contactForm']['telefono'] ?? '')),
            'principal' => count($this->companyContacts) === 0,
        ];

        $this->contactForm = $this->defaultContactForm();
        $this->allowManualContact = false;
        $this->resetValidation('contactForm');
    }

    public function removeCompanyContact(int $index): void
    {
        if (!isset($this->companyContacts[$index])) {
            return;
        }

        unset($this->companyContacts[$index]);
        $this->companyContacts = array_values($this->companyContacts);
        if (!empty($this->companyContacts) && !collect($this->companyContacts)->contains('principal', true)) {
            $this->companyContacts[0]['principal'] = true;
        }
    }

    public function setPrimaryContact(int $index): void
    {
        foreach ($this->companyContacts as $i => $contacto) {
            $this->companyContacts[$i]['principal'] = $i === $index;
        }
    }

    public function saveCompany(): void
    {
        if ($this->companyLockedByRuc) {
            $this->dispatch('swal', type: 'warning', title: 'Empresa no editable', text: 'Esta empresa ya tiene equipos registrados y no puede editarse desde este modal.');
            return;
        }

        if (!$this->saveCompanyBaseData()) {
            $this->companyStep = 1;
            return;
        }

        if (count($this->companyServices) === 0) {
            $this->addError('serviceSearch', 'Debes agrego al menos un servicio.');
            $this->companyStep = 2;
            return;
        }

        if (count($this->companyContacts) === 0) {
            $this->addError('contactForm.numero_documento', 'Debes agrego al menos un contacto.');
            $this->companyStep = 3;
            return;
        }

        $empresa = DB::transaction(function () {
            $empresa = Empresa::query()->findOrFail($this->draftEmpresaId);
            $this->persistCompanyServices($empresa);
            $this->persistCompanyContacts($empresa);
            return $empresa->fresh(['servicios', 'contactoPrincipal.persona']);
        });

        $this->selectedEmpresaId = (int) $empresa->id;
        $this->syncEmpresaResumen($empresa);
        $this->loadEmpresaServiceOptions($empresa);
        $this->empresaSearch = (string) $empresa->razon_social;
        $this->empresaSuggestions = [];
        $this->companyModal = false;
        $this->dispatch('swal', type: 'success', title: 'Empresa registrada', text: 'La empresa se vinculo correctamente a la inspeccion.');
    }

    public function updatedEquipmentSearch(string $value): void
    {
        $term = trim($value);
        if (!$this->selectedEmpresaId || mb_strlen($term) < 2) {
            $this->equipmentSuggestions = [];
            return;
        }

        $this->equipmentSuggestions = EmpresaEquipo::query()
            ->with(['equipo.tipo:id,tipo', 'equipo.categoria:id,categoria', 'equipo.marca:id,marca', 'equipo.modelo:id,modelo,modelos'])
            ->where('empresa_id', $this->selectedEmpresaId)
            ->where(function ($query) use ($term) {
                $query->where('descripcion', 'like', "%{$term}%")
                    ->orWhere('serie_codigo', 'like', "%{$term}%")
                    ->orWhereHas('equipo', fn ($q) => $q->where('descripcion', 'like', "%{$term}%"));
            })
            ->orderByDesc('id')
            ->limit(10)
            ->get()
            ->map(function (EmpresaEquipo $empresaEquipo) {
                $equipo = $empresaEquipo->equipo;
                return [
                    'id' => (int) $empresaEquipo->id,
                    'descripcion' => (string) ($empresaEquipo->descripcion ?: $equipo?->descripcion ?: 'Sin descripcion'),
                    'detalle' => trim(collect([
                        $equipo?->tipo?->tipo,
                        $equipo?->categoria?->categoria,
                        $equipo?->marca?->marca,
                        $equipo?->modelo?->modelo ?: $equipo?->modelo?->modelos,
                        $empresaEquipo->serie_codigo,
                    ])->filter()->join(' Â· ')),
                ];
            })
            ->all();
    }

    public function selectEquipment(int $empresaEquipoId): void
    {
        if (!$this->selectedEmpresaId) {
            return;
        }

        $empresaEquipo = EmpresaEquipo::query()
            ->with(['equipo.tipo', 'equipo.categoria', 'equipo.marca', 'equipo.modelo', 'servicio'])
            ->where('empresa_id', $this->selectedEmpresaId)
            ->findOrFail($empresaEquipoId);

        $this->selectedEmpresaEquipoId = (int) $empresaEquipo->id;
        $this->syncEquipoResumen($empresaEquipo);
        $this->equipmentSearch = (string) ($empresaEquipo->descripcion ?: $empresaEquipo->equipo?->descripcion ?: '');
        $this->equipmentSuggestions = [];
        $this->refreshInspectionContext();
    }

    public function clearSelectedEquipment(): void
    {
        $this->resetEquipmentSelection();
        $this->dispatch('inspection-reset');
        $this->refreshInspectionContext();
    }

    public function openEquipmentModal(): void
    {
        if (!$this->selectedEmpresaId) {
            $this->dispatch('swal', type: 'warning', title: 'Selecciona una empresa', text: 'Primero debes seleccionar una empresa para registro un equipo.');
            return;
        }

        $this->resetEquipmentModalData();
        $this->refreshEquipmentCompanyDefaultDescription(true);
        $this->equipmentModal = true;
    }

    public function updatedEquipmentFormDescripcionCatalogo(string $value): void
    {
        $term = trim($value);
        if (mb_strlen($term) < 2) {
            $this->equipmentDescriptionSuggestions = [];
            return;
        }

        $this->equipmentDescriptionSuggestions = Equipo::query()
            ->with(['tipo:id,tipo', 'categoria:id,categoria', 'marca:id,marca', 'modelo:id,modelo,modelos'])
            ->where('descripcion', 'like', "%{$term}%")
            ->orderBy('descripcion')
            ->limit(8)
            ->get()
            ->map(fn (Equipo $equipo) => [
                'id' => (int) $equipo->id,
                'descripcion' => (string) ($equipo->descripcion ?: 'Sin descripcion'),
                'anio' => (string) ($equipo->anio ?: ''),
                'tipo' => (string) ($equipo->tipo?->tipo ?? ''),
                'categoria' => (string) ($equipo->categoria?->categoria ?? ''),
                'marca' => (string) ($equipo->marca?->marca ?? ''),
                'modelo' => (string) ($equipo->modelo?->modelo ?: $equipo->modelo?->modelos ?: ''),
            ])
            ->all();
    }

    public function selectEquipmentCatalog(int $equipoId): void
    {
        $equipo = Equipo::query()->with(['tipo', 'categoria', 'marca', 'modelo'])->findOrFail($equipoId);
        $this->equipmentForm['equipo_id'] = (int) $equipo->id;
        $this->equipmentForm['descripcion_catalogo'] = (string) ($equipo->descripcion ?? '');
        $this->equipmentForm['anio'] = $equipo->anio ? (string) $equipo->anio : '';
        $this->equipmentForm['tipo_id'] = $equipo->tipo_id ? (int) $equipo->tipo_id : null;
        $this->equipmentForm['categoria_id'] = $equipo->categoria_id ? (int) $equipo->categoria_id : null;
        $this->equipmentForm['marca_id'] = $equipo->marca_id ? (int) $equipo->marca_id : null;
        $this->equipmentForm['modelo_id'] = $equipo->modelo_id ? (int) $equipo->modelo_id : null;
        $this->tipoSearch = (string) ($equipo->tipo?->tipo ?? '');
        $this->categoriaSearch = (string) ($equipo->categoria?->categoria ?? '');
        $this->marcaSearch = (string) ($equipo->marca?->marca ?? '');
        $this->modeloSearch = (string) ($equipo->modelo?->modelo ?: $equipo->modelo?->modelos ?: '');
        $this->equipmentDescriptionSuggestions = [];
        $this->refreshEquipmentCompanyDefaultDescription(true);
    }

    public function updatedTipoSearch(string $value): void
    {
        $this->tipoSuggestions = $this->queryCatalogSuggestions(Tipo::class, 'tipo', $value);
    }

    public function updatedCategoriaSearch(string $value): void
    {
        $this->categoriaSuggestions = $this->queryCatalogSuggestions(Categoria::class, 'categoria', $value);
    }

    public function updatedMarcaSearch(string $value): void
    {
        $this->marcaSuggestions = $this->queryCatalogSuggestions(Marca::class, 'marca', $value);
    }

    public function updatedModeloSearch(string $value): void
    {
        $term = trim($value);
        if (mb_strlen($term) < 2) {
            $this->modeloSuggestions = [];
            return;
        }

        $this->modeloSuggestions = Modelo::query()
            ->where('estado', 1)
            ->where(function ($query) use ($term) {
                $query->where('modelo', 'like', "%{$term}%")
                    ->orWhere('modelos', 'like', "%{$term}%");
            })
            ->orderBy('modelo')
            ->limit(8)
            ->get(['id', 'modelo', 'modelos'])
            ->map(fn (Modelo $modelo) => ['id' => (int) $modelo->id, 'nombre' => (string) ($modelo->modelo ?: $modelo->modelos ?: '')])
            ->all();
    }

    public function selectTipo(int $id): void
    {
        $tipo = Tipo::query()->findOrFail($id);
        $this->equipmentForm['tipo_id'] = (int) $tipo->id;
        $this->tipoSearch = (string) $tipo->tipo;
        $this->tipoSuggestions = [];
        $this->refreshEquipmentCompanyDefaultDescription(true);
    }

    public function selectCategoria(int $id): void
    {
        $categoria = Categoria::query()->findOrFail($id);
        $this->equipmentForm['categoria_id'] = (int) $categoria->id;
        $this->categoriaSearch = (string) $categoria->categoria;
        $this->categoriaSuggestions = [];
        $this->refreshEquipmentCompanyDefaultDescription(true);
    }

    public function selectMarca(int $id): void
    {
        $marca = Marca::query()->findOrFail($id);
        $this->equipmentForm['marca_id'] = (int) $marca->id;
        $this->marcaSearch = (string) $marca->marca;
        $this->marcaSuggestions = [];
        $this->refreshEquipmentCompanyDefaultDescription(true);
    }

    public function selectModelo(int $id): void
    {
        $modelo = Modelo::query()->findOrFail($id);
        $this->equipmentForm['modelo_id'] = (int) $modelo->id;
        $this->modeloSearch = (string) ($modelo->modelo ?: $modelo->modelos ?: '');
        $this->modeloSuggestions = [];
        $this->refreshEquipmentCompanyDefaultDescription(true);
    }

    public function addOrSelectTipoFromInput(): void
    {
        $term = trim($this->tipoSearch);
        if ($term === '') {
            return;
        }

        $tipo = Tipo::query()->whereRaw('LOWER(tipo) = ?', [mb_strtolower($term)])->first();
        if (!$tipo) {
            $tipo = Tipo::query()->create(['tipo' => $term, 'estado' => 1, 'created_by' => $this->actorId(), 'updated_by' => $this->actorId()]);
        }
        $this->selectTipo((int) $tipo->id);
    }

    public function syncTipoFromBlur(): void
    {
        $this->addOrSelectTipoFromInput();
    }

    public function addOrSelectCategoriaFromInput(): void
    {
        $term = trim($this->categoriaSearch);
        if ($term === '') {
            return;
        }

        $categoria = Categoria::query()->whereRaw('LOWER(categoria) = ?', [mb_strtolower($term)])->first();
        if (!$categoria) {
            $categoria = Categoria::query()->create(['categoria' => $term, 'codigo' => null, 'estado' => 1, 'created_by' => $this->actorId(), 'updated_by' => $this->actorId()]);
        }
        $this->selectCategoria((int) $categoria->id);
    }

    public function syncCategoriaFromBlur(): void
    {
        $this->addOrSelectCategoriaFromInput();
    }

    public function addOrSelectMarcaFromInput(): void
    {
        $term = trim($this->marcaSearch);
        if ($term === '') {
            return;
        }

        $marca = Marca::query()->whereRaw('LOWER(marca) = ?', [mb_strtolower($term)])->first();
        if (!$marca) {
            $marca = Marca::query()->create(['marca' => $term, 'codigo' => null, 'estado' => 1, 'created_by' => $this->actorId(), 'updated_by' => $this->actorId()]);
        }
        $this->selectMarca((int) $marca->id);
    }

    public function syncMarcaFromBlur(): void
    {
        $this->addOrSelectMarcaFromInput();
    }

    public function addOrSelectModeloFromInput(): void
    {
        $term = trim($this->modeloSearch);
        if ($term === '') {
            return;
        }

        $modelo = Modelo::query()
            ->where(function ($query) use ($term) {
                $query->whereRaw('LOWER(modelo) = ?', [mb_strtolower($term)])
                    ->orWhereRaw('LOWER(modelos) = ?', [mb_strtolower($term)]);
            })
            ->first();

        if (!$modelo) {
            $modelo = Modelo::query()->create(['modelo' => $term, 'modelos' => mb_strtoupper($term), 'estado' => 1, 'created_by' => $this->actorId(), 'updated_by' => $this->actorId()]);
        }
        $this->selectModelo((int) $modelo->id);
    }

    public function syncModeloFromBlur(): void
    {
        $this->addOrSelectModeloFromInput();
    }

    public function saveEquipment(): void
    {
        if (!$this->selectedEmpresaId) {
            $this->dispatch('swal', type: 'warning', title: 'Selecciona una empresa', text: 'Primero debes seleccionar una empresa.');
            return;
        }

        // Si el usuario escribio pero no presiono Enter, igual sincronizamos con catalogos.
        $this->addOrSelectTipoFromInput();
        $this->addOrSelectCategoriaFromInput();
        $this->addOrSelectMarcaFromInput();
        $this->addOrSelectModeloFromInput();

        $data = $this->validate([
            'equipmentForm.tipo_id' => ['required', Rule::exists('tipos', 'id')],
            'equipmentForm.categoria_id' => ['required', Rule::exists('categorias', 'id')],
            'equipmentForm.marca_id' => ['required', Rule::exists('marcas', 'id')],
            'equipmentForm.modelo_id' => ['required', Rule::exists('modelos', 'id')],
            'equipmentForm.anio' => ['nullable', 'integer', 'between:1900,2100'],
            'equipmentForm.descripcion_catalogo' => ['nullable', 'string', 'max:255'],
            'equipmentForm.descripcion_empresa' => ['required', 'string', 'max:255'],
            'equipmentForm.serie_tipo' => ['required', 'string', 'max:50'],
            'equipmentForm.serie_codigo' => ['required', 'string', 'max:120'],
            'equipmentForm.servicio_id' => ['nullable', Rule::in(collect($this->empresaServiceOptions)->pluck('id')->all())],
        ], [], [
            'equipmentForm.tipo_id' => 'tipo',
            'equipmentForm.categoria_id' => 'categoria',
            'equipmentForm.marca_id' => 'marca',
            'equipmentForm.modelo_id' => 'modelo',
            'equipmentForm.descripcion_empresa' => 'descripcion para la empresa',
            'equipmentForm.serie_tipo' => 'tipo identificador',
            'equipmentForm.serie_codigo' => 'identificador',
        ]);

        $empresaEquipo = DB::transaction(function () use ($data) {
            $equipoId = $this->equipmentForm['equipo_id'] ? (int) $this->equipmentForm['equipo_id'] : null;
            $equipo = $equipoId ? Equipo::query()->find($equipoId) : null;

            if (!$equipo) {
                $equipo = Equipo::query()->create([
                    'tipo_id' => (int) $data['equipmentForm']['tipo_id'],
                    'categoria_id' => (int) $data['equipmentForm']['categoria_id'],
                    'marca_id' => (int) $data['equipmentForm']['marca_id'],
                    'modelo_id' => (int) $data['equipmentForm']['modelo_id'],
                    'descripcion' => trim((string) ($data['equipmentForm']['descripcion_catalogo'] ?: $this->buildEquipmentBaseDescription())),
                    'anio' => $data['equipmentForm']['anio'] !== '' ? (int) $data['equipmentForm']['anio'] : null,
                    'estado' => 1,
                    'created_by' => $this->actorId(),
                    'updated_by' => $this->actorId(),
                ]);
            }

            $serieTipo = trim((string) $data['equipmentForm']['serie_tipo']);
            $serieCodigo = trim((string) $data['equipmentForm']['serie_codigo']);

            $empresaEquipo = EmpresaEquipo::query()
                ->where('empresa_id', $this->selectedEmpresaId)
                ->where('serie_tipo', $serieTipo)
                ->where('serie_codigo', $serieCodigo)
                ->first();

            $payload = [
                'equipo_id' => (int) $equipo->id,
                'servicio_id' => $data['equipmentForm']['servicio_id'] ? (int) $data['equipmentForm']['servicio_id'] : null,
                'descripcion' => trim((string) $data['equipmentForm']['descripcion_empresa']),
                'serie_tipo' => $serieTipo,
                'serie_codigo' => $serieCodigo,
                'estado' => 1,
                'updated_by' => $this->actorId(),
            ];

            if ($empresaEquipo) {
                $empresaEquipo->update($payload);
            } else {
                $payload['empresa_id'] = (int) $this->selectedEmpresaId;
                $payload['created_by'] = $this->actorId();
                $empresaEquipo = EmpresaEquipo::query()->create($payload);
            }

            return $empresaEquipo->fresh(['equipo.tipo', 'equipo.categoria', 'equipo.marca', 'equipo.modelo', 'servicio']);
        });

        $this->selectedEmpresaEquipoId = (int) $empresaEquipo->id;
        $this->syncEquipoResumen($empresaEquipo);
        $this->equipmentSearch = (string) ($empresaEquipo->descripcion ?: $empresaEquipo->equipo?->descripcion ?: '');
        $this->equipmentSuggestions = [];
        $this->equipmentModal = false;
        $this->refreshInspectionContext();
        $this->dispatch('swal', type: 'success', title: 'Equipo registroo', text: 'El equipo se guardo correctamente para la empresa seleccionada.');
    }

    public function updatedResponsesInput($value, string $name): void
    {
        if (!preg_match('/^(?:responsesInput\.)?(\d+)\.(ingreso|salida)$/', $name, $matches)) {
            return;
        }

        $responseId = (int) $matches[1];
        $this->persistResponse($responseId);
    }

    public function selectQuestionCategory(int $categoriaId): void
    {
        $selectedCategory = collect($this->questionnaireCategories)
            ->first(fn (array $cat) => (int) $cat['id'] === $categoriaId);

        if (!$selectedCategory) {
            return;
        }

        $this->uiInspectionTab = 'questions';
        $this->uiActiveQuestionCategoryId = (int) $selectedCategory['id'];
        $firstSubcategoryId = isset($selectedCategory['subcategorias'][0]['id'])
            ? (int) $selectedCategory['subcategorias'][0]['id']
            : null;
        $this->uiActiveQuestionSubcategoryId = $firstSubcategoryId;
    }

    public function selectQuestionSubcategory(int $subCategoriaId): void
    {
        if (!$this->uiActiveQuestionCategoryId) {
            return;
        }

        $selectedCategory = collect($this->questionnaireCategories)
            ->first(fn (array $cat) => (int) $cat['id'] === (int) $this->uiActiveQuestionCategoryId);
        if (!$selectedCategory) {
            return;
        }

        $exists = collect($selectedCategory['subcategorias'] ?? [])
            ->contains(fn (array $sub) => (int) $sub['id'] === $subCategoriaId);
        if (!$exists) {
            return;
        }

        $this->uiInspectionTab = 'questions';
        $this->uiActiveQuestionSubcategoryId = $subCategoriaId;
    }

    public function selectInspectionFilesTab(): void
    {
        $this->uiInspectionTab = 'files';
    }

    public function selectInspectionQuestionsTab(): void
    {
        $this->uiInspectionTab = 'questions';
    }

    public function startInspection(): void
    {
        if (!$this->selectedEmpresaEquipoId) {
            return;
        }

        DB::transaction(function (): void {
            $now = now();
            $year = (int) $now->format('Y');
            $nextCorrelative = ((int) (Inspeccion::query()->where('anio', $year)->max('correlativo') ?? 0)) + 1;

            $inspeccion = Inspeccion::query()->create([
                'anio' => $year,
                'correlativo' => $nextCorrelative,
                'codigo' => sprintf('%02d-%04d', $year % 100, $nextCorrelative),
                'empresa_equipo_id' => (int) $this->selectedEmpresaEquipoId,
                'fecha_ingreso' => $now->toDateString(),
                'estado_inspeccion' => 'en_inspeccion',
                'certificado_generado' => 0,
                'estado' => 1,
                'created_by' => $this->actorId(),
                'updated_by' => $this->actorId(),
            ]);

            $detalle = $inspeccion->detalleInspecciones()->create([
                'inespeccion_numero' => 1,
                'inspeccion_estado' => 'en_inspeccion',
                'inspeccion_fecha' => $now,
                'severidad' => null,
                'estado' => 1,
                'created_by' => $this->actorId(),
                'updated_by' => $this->actorId(),
            ]);

            $this->seedCuestionarioRespuesta($detalle);
        });

        $this->refreshInspectionContext();
        $this->uiStep = 2;
        $this->dispatch('inspection-state', started: true, inspectionFinalized: false, step: 2);
        $this->dispatch('swal', type: 'success', title: 'Inspeccion iniciada', text: 'La inspeccion se inicio correctamente.');
    }

    public function startObservedInspection(): void
    {
        if (!$this->selectedEmpresaEquipoId) {
            return;
        }

        $inspeccion = Inspeccion::query()
            ->with('detalleInspecciones')
            ->where('empresa_equipo_id', $this->selectedEmpresaEquipoId)
            ->latest('id')
            ->first();

        if (!$inspeccion) {
            return;
        }

        $lastDetail = $inspeccion->detalleInspecciones()->orderByDesc('inespeccion_numero')->first();
        if (!$lastDetail || (string) $lastDetail->inspeccion_estado !== 'observado') {
            return;
        }

        $dueAt = $lastDetail->correcion_vigencia_fecha ? Carbon::parse($lastDetail->correcion_vigencia_fecha)->endOfDay() : null;
        if (!$dueAt || $dueAt->isPast()) {
            $this->dispatch('swal', type: 'warning', title: 'Plazo vencido', text: 'La vigencia para subsanar observaciones vencio. Debes crear una nueva inspeccion.');
            return;
        }

        DB::transaction(function () use ($inspeccion, $lastDetail): void {
            $nextNumber = ((int) ($inspeccion->detalleInspecciones()->max('inespeccion_numero') ?? 0)) + 1;
            $inspeccion->update([
                'estado_inspeccion' => 'subsanacion',
                'fecha_ingreso' => now()->toDateString(),
                'updated_by' => $this->actorId(),
            ]);

            $detalle = $inspeccion->detalleInspecciones()->create([
                'inespeccion_numero' => $nextNumber,
                'inspeccion_estado' => 'subsanacion',
                'inspeccion_fecha' => now(),
                'severidad' => null,
                'estado' => 1,
                'created_by' => $this->actorId(),
                'updated_by' => $this->actorId(),
            ]);

            $this->copyCuestionarioRespuestaFromDetalle($detalle, (int) $lastDetail->id);
        });

        $this->refreshInspectionContext();
        $this->uiStep = 2;
        $this->dispatch('inspection-state', started: true, inspectionFinalized: false, step: 2);
        $this->dispatch('swal', type: 'success', title: 'Reinspeccion iniciada', text: 'Se inicio la inspeccion de observaciones.');
    }

    public function continueInspection(): void
    {
        if (!$this->selectedEmpresaEquipoId || !$this->currentInspeccionId || !$this->currentDetalleInspeccionId) {
            return;
        }

        $this->uiStep = 2;
        $this->dispatch('inspection-state', started: true, inspectionFinalized: false, step: 2);
    }

    public function viewInspection(): void
    {
        if (!$this->selectedEmpresaEquipoId || !$this->currentInspeccionId || !$this->currentDetalleInspeccionId) {
            return;
        }

        $this->uiStep = 2;
        $this->dispatch('inspection-state', started: true, inspectionFinalized: true, step: 2);
    }

    public function enableInspectionEdition(): void
    {
        if (!$this->selectedEmpresaEquipoId || !$this->currentInspeccionId || !$this->currentDetalleInspeccionId) {
            return;
        }

        Inspeccion::query()
            ->whereKey($this->currentInspeccionId)
            ->update([
                'estado_inspeccion' => 'en_inspeccion',
                'updated_by' => $this->actorId(),
            ]);

        DetalleInspeccion::query()
            ->whereKey($this->currentDetalleInspeccionId)
            ->update([
                'inspeccion_estado' => 'en_inspeccion',
                'updated_by' => $this->actorId(),
            ]);

        $this->refreshInspectionContext();
        $this->uiStep = 2;
        $this->dispatch('inspection-state', started: true, inspectionFinalized: false, step: 2);
        $this->dispatch('swal', type: 'info', title: 'Edicion habilitada', text: 'Puedes continuar con la edicion de la inspeccion.', toast: true, timer: 2400);
    }

    public function openInspectionDetail(int $inspeccionId): void
    {
        $inspeccion = Inspeccion::query()
            ->with([
                'detalleInspecciones' => fn ($q) => $q->orderBy('inespeccion_numero'),
                'detalleInspecciones.certificados' => fn ($q) => $q->orderByDesc('fecha_vencimiento'),
            ])
            ->findOrFail($inspeccionId);

        $this->inspectionDetailView = [
            'id' => (int) $inspeccion->id,
            'codigo' => (string) ($inspeccion->codigo_formateado ?: 'Sin codigo'),
            'estado' => (string) $inspeccion->estado_inspeccion,
            'fecha_ingreso' => $inspeccion->fecha_ingreso ? $inspeccion->fecha_ingreso->format('d/m/Y') : '-',
            'detalles' => $inspeccion->detalleInspecciones->map(function ($detalle) {
                $cert = $detalle->certificados->first();
                return [
                    'numero' => (int) $detalle->inespeccion_numero,
                    'estado' => (string) $detalle->inspeccion_estado,
                    'fecha' => $detalle->inspeccion_fecha ? Carbon::parse($detalle->inspeccion_fecha)->format('d/m/Y H:i') : '-',
                    'limite_subsanacion' => $detalle->correcion_vigencia_fecha ? Carbon::parse($detalle->correcion_vigencia_fecha)->format('d/m/Y') : '-',
                    'certificado_numero' => $cert?->numero ?: '-',
                    'certificado_vencimiento' => $cert?->fecha_vencimiento ? Carbon::parse($cert->fecha_vencimiento)->format('d/m/Y') : '-',
                ];
            })->all(),
        ];

        $this->inspectionDetailModal = true;
    }

    public function saveSubgroup(string $subgroupKey): void
    {
        $responseIds = $this->subgroupResponseIds[$subgroupKey] ?? [];
        if ($responseIds === []) {
            return;
        }

        foreach ($responseIds as $responseId) {
            $this->persistResponse((int) $responseId);
        }
    }

    public function flushPendingResponses(): void
    {
        foreach (array_keys($this->responsesInput) as $responseId) {
            $this->persistResponse((int) $responseId);
        }
    }

    public function prepareObservationModal(int $responseId): void
    {
        $this->activeObservationResponseId = $responseId;
        $this->observationForm = $this->defaultObservationForm();
        $this->dispatch('observation-form-ready', defaults: $this->observationForm);
        $this->skipRender();
    }

    public function openObservationList(int $responseId): void
    {
        $this->activeObservationResponseId = $responseId;
        $observations = $this->buildObservationList($responseId);

        $this->dispatch('observation-list-ready', observations: $observations, responseId: $responseId);
        $this->skipRender();
    }

    public function saveObservation(): void
    {
        $this->saveObservationFromModal($this->observationForm);
    }

    public function saveObservationFromModal(array $payload = []): void
    {
        if (!$this->activeObservationResponseId) {
            return;
        }

        $data = Validator::make($payload, [
            'momento' => ['required', Rule::in(['ingreso', 'salida', 'ambos'])],
            'descripcion' => ['required', 'string', 'max:255'],
        ], [], [
            'momento' => 'momento',
            'descripcion' => 'detalle de observacion',
        ])->validate();

        CuestionarioRespuestaObservacion::query()->create([
            'cuestionario_respuesta_id' => $this->activeObservationResponseId,
            'descripcion' => trim((string) $data['descripcion']),
            'momento' => (string) $data['momento'],
            'estado' => 1,
            'created_by' => $this->actorId(),
            'updated_by' => $this->actorId(),
        ]);

        if ($this->currentDetalleInspeccionId) {
            $this->loadQuestionnaireForDetalle($this->currentDetalleInspeccionId);
        }
        $this->refreshCertificateState();

        $this->observationForm = $this->defaultObservationForm();
        $this->dispatch('observation-saved');
        $this->dispatch('swal', type: 'success', title: 'Observacion registrada', text: 'La observacion se guardo correctamente.', toast: true, timer: 2200);
    }

    public function deleteObservationFromModal(int $observationId, bool $dispatchObservationList = true): void
    {
        $observation = CuestionarioRespuestaObservacion::query()
            ->whereKey($observationId)
            ->where('estado', 1)
            ->first();

        if (!$observation) {
            return;
        }

        $responseId = (int) $observation->cuestionario_respuesta_id;
        $observation->update([
            'estado' => 0,
            'updated_by' => $this->actorId(),
            'deleted_by' => $this->actorId(),
        ]);
        $observation->delete();

        if ($this->currentDetalleInspeccionId) {
            $this->loadQuestionnaireForDetalle($this->currentDetalleInspeccionId);
        }

        if ($dispatchObservationList) {
            $this->dispatch(
                'observation-list-ready',
                observations: $this->buildObservationList($responseId),
                responseId: $responseId
            );
        }
        $this->refreshCertificateState();
        $this->dispatch('swal', type: 'success', title: 'Observacion eliminada', text: 'La observacion fue eliminada correctamente.', toast: true, timer: 1800);
    }

    public function prepareCustomQuestionModal(int $categoriaId, int $subCategoriaId, string $groupKey): void
    {
        $this->customQuestionGroupKey = $groupKey;
        $this->customQuestionForm = $this->defaultCustomQuestionForm();
        $this->customQuestionForm['cuestionario_categoria_id'] = $categoriaId;
        $this->customQuestionForm['cuestionario_sub_categoria_id'] = $subCategoriaId;
        $this->dispatch('custom-question-ready');
    }

    public function saveCustomQuestion(): void
    {
        if (!$this->currentDetalleInspeccionId) {
            $this->dispatch('swal', type: 'warning', title: 'Inspeccion no disponible', text: 'Primero debes iniciar una inspeccion para registrar preguntas adicionales.');
            return;
        }

        $data = $this->validate([
            'customQuestionForm.cuestionario_categoria_id' => ['required', 'integer', Rule::exists('cuestionario_categorias', 'id')],
            'customQuestionForm.cuestionario_sub_categoria_id' => ['required', 'integer', Rule::exists('cuestionario_sub_categorias', 'id')],
            'customQuestionForm.enunciado' => ['required', 'string', 'max:255'],
            'customQuestionForm.ingreso_respuesta' => ['nullable', 'string', 'max:255'],
            'customQuestionForm.salida_respuesta' => ['nullable', 'string', 'max:255'],
        ], [], [
            'customQuestionForm.enunciado' => 'enunciado',
        ]);

        CuestionarioRespuesta::query()->create([
            'detalle_inspeccion_id' => (int) $this->currentDetalleInspeccionId,
            'cuestionario_categoria_id' => (int) $data['customQuestionForm']['cuestionario_categoria_id'],
            'cuestionario_sub_categoria_id' => (int) $data['customQuestionForm']['cuestionario_sub_categoria_id'],
            'cuestionario_pregunta_id' => null,
            'cuestionario_pregunta_personalizada' => trim((string) $data['customQuestionForm']['enunciado']),
            'ingreso_respuesta' => $this->normalizeNullableText($data['customQuestionForm']['ingreso_respuesta'] ?? null),
            'salida_respuesta' => $this->normalizeNullableText($data['customQuestionForm']['salida_respuesta'] ?? null),
            'estado' => 1,
            'created_by' => $this->actorId(),
            'updated_by' => $this->actorId(),
        ]);

        $groupKey = (string) ($this->customQuestionGroupKey ?? '');
        $this->loadQuestionnaireForDetalle($this->currentDetalleInspeccionId);
        $this->customQuestionForm = $this->defaultCustomQuestionForm();
        $this->dispatch('custom-question-saved', groupKey: $groupKey);
        $this->dispatch('swal', type: 'success', title: 'Pregunta adicional registrada', text: 'La pregunta se agrego correctamente.', toast: true, timer: 2200);
    }

    public function attachInspectionFile(): void
    {
        if (!$this->currentInspeccionId || !$this->selectedEmpresaEquipoId || !$this->currentDetalleInspeccionId) {
            $this->dispatch('swal', type: 'warning', title: 'Inspeccion no disponible', text: 'Primero debes tener una inspeccion activa para adjuntar archivos.');
            return;
        }

        $data = $this->validate([
            'inspectionUploadFile' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'inspectionFileForm.descripcion' => ['required', 'string', 'max:255'],
            'inspectionFileForm.mostrar_certificado' => ['nullable', 'boolean'],
        ], [], [
            'inspectionUploadFile' => 'archivo',
            'inspectionFileForm.descripcion' => 'nombre del archivo',
        ]);

        $inspeccion = Inspeccion::query()
            ->with(['empresaEquipo'])
            ->find($this->currentInspeccionId);

        if (!$inspeccion) {
            $this->dispatch('swal', type: 'warning', title: 'Inspeccion no encontrada', text: 'No se pudo adjuntar el archivo porque la inspeccion no esta disponible.');
            return;
        }

        $numeroInspeccion = (string) $this->resolveInspectionNumber();
        $targetRelativePath = $this->resolveInspectionStoragePath($inspeccion, $numeroInspeccion, 'archivos_cargados');
        $targetDirectory = public_path($targetRelativePath);
        if (!File::exists($targetDirectory)) {
            File::makeDirectory($targetDirectory, 0755, true);
        }

        $uploaded = $data['inspectionUploadFile'];
        $extension = strtolower((string) $uploaded->getClientOriginalExtension());
        $mimeType = strtolower((string) $uploaded->getMimeType());
        $archivoTipo = str_contains($mimeType, 'pdf') || $extension === 'pdf' ? 'pdf' : 'imagen';
        $baseName = $this->sanitizeStorageFileToken((string) pathinfo((string) $uploaded->getClientOriginalName(), PATHINFO_FILENAME), 'archivo');
        $fileName = now()->format('Ymd_His') . '-' . $baseName . '-' . Str::lower(Str::random(6)) . '.' . $extension;
        $sourcePath = $uploaded->getRealPath();
        if (!$sourcePath || !is_file($sourcePath)) {
            $this->dispatch('swal', type: 'warning', title: 'Archivo no disponible', text: 'No se pudo leer el archivo temporal cargado.');
            return;
        }

        File::copy($sourcePath, $targetDirectory . DIRECTORY_SEPARATOR . $fileName);

        InspeccionArchivoEquipo::query()->create([
            'inspeccion_id' => (int) $inspeccion->id,
            'archivo_descripcion' => $this->sanitizeStorageText((string) $data['inspectionFileForm']['descripcion']),
            'archivo_autogenerado' => 0,
            'archivo_tipo' => $archivoTipo,
            'archivo_ruta' => $targetRelativePath . '/' . $fileName,
            'archivo_origen' => 'original',
            'mostrar_certificado' => (bool) ($data['inspectionFileForm']['mostrar_certificado'] ?? false),
            'estado' => 1,
            'created_by' => $this->actorId(),
            'updated_by' => $this->actorId(),
        ]);

        $this->inspectionUploadFile = null;
        $this->inspectionFileForm = $this->defaultInspectionFileForm();
        $this->loadInspectionFiles($this->currentInspeccionId);
        $this->dispatch('swal', type: 'success', title: 'Archivo adjuntado', text: 'El archivo se registro correctamente en la inspeccion.', toast: true, timer: 2200);
    }

    public function updatedInspectionUploadFile(): void
    {
        if ($this->inspectionUploadFile && trim((string) ($this->inspectionFileForm['descripcion'] ?? '')) === '') {
            $originalName = (string) $this->inspectionUploadFile->getClientOriginalName();
            $this->inspectionFileForm['descripcion'] = (string) pathinfo($originalName, PATHINFO_FILENAME);
        }
    }

    public function openInspectionFilePreview(int $archivoId): void
    {
        $archivo = InspeccionArchivoEquipo::query()
            ->where('inspeccion_id', $this->currentInspeccionId)
            ->where('archivo_origen', 'original')
            ->findOrFail($archivoId);

        $this->inspectionFilePreview = [
            'id' => (int) $archivo->id,
            'descripcion' => (string) $archivo->archivo_descripcion,
            'tipo' => (string) $archivo->archivo_tipo,
            'url' => asset($archivo->archivo_ruta),
            'origen' => (string) $archivo->archivo_origen,
            'mostrar_certificado' => (bool) $archivo->mostrar_certificado,
        ];
        $this->inspectionFilePreviewModal = true;
    }

    public function deleteInspectionFile(int $archivoId): void
    {
        $archivo = InspeccionArchivoEquipo::query()
            ->where('inspeccion_id', $this->currentInspeccionId)
            ->where('archivo_origen', 'original')
            ->findOrFail($archivoId);

        $absolutePath = public_path((string) $archivo->archivo_ruta);
        if (File::exists($absolutePath)) {
            File::delete($absolutePath);
        }

        $archivo->update([
            'updated_by' => $this->actorId(),
            'deleted_by' => $this->actorId(),
        ]);
        $archivo->delete();

        if ((int) ($this->inspectionFilePreview['id'] ?? 0) === (int) $archivoId) {
            $this->inspectionFilePreviewModal = false;
            $this->inspectionFilePreview = [];
        }

        $this->loadInspectionFiles($this->currentInspeccionId);
        $this->dispatch('swal', type: 'success', title: 'Archivo eliminado', text: 'El archivo se elimino correctamente.', toast: true, timer: 2200);
    }

    public function toggleInspectionFileCertificate(int $archivoId, $mostrar): void
    {
        $archivo = InspeccionArchivoEquipo::query()
            ->where('inspeccion_id', $this->currentInspeccionId)
            ->where('archivo_origen', 'original')
            ->find($archivoId);

        if (!$archivo) {
            return;
        }

        $archivo->update([
            'mostrar_certificado' => filter_var($mostrar, FILTER_VALIDATE_BOOL),
            'updated_by' => $this->actorId(),
        ]);

        $this->loadInspectionFiles($this->currentInspeccionId);
    }

    public function finalizeInspection(): void
    {
        if (!$this->currentInspeccionId || !$this->currentDetalleInspeccionId) {
            return;
        }

        $this->refreshCertificateState();
        if ($this->observedParametersCount > 0 && !$this->remediationDueDate) {
            $this->addError('remediationDueDate', 'Debes indicar la fecha plazo para subsanar observaciones.');
            return;
        }

        DB::transaction(function (): void {
            $inspeccion = Inspeccion::query()->findOrFail($this->currentInspeccionId);
            $detalle = DetalleInspeccion::query()->findOrFail($this->currentDetalleInspeccionId);

            if ($inspeccion->certificado_generado) {
                Certificado::query()
                    ->where('inspeccion_id', $inspeccion->id)
                    ->where('anulado', 0)
                    ->update([
                        'anulado' => 1,
                        'motivo_anulacion' => 'Anulado por edicion de inspeccion',
                        'updated_by' => $this->actorId(),
                    ]);

                $inspeccion->update([
                    'certificado_generado' => 0,
                    'updated_by' => $this->actorId(),
                ]);
            }

            $newState = $this->observedParametersCount > 0 ? 'observado' : 'aprobado';
            $detalle->update([
                'inspeccion_estado' => $newState,
                'correcion_vigencia_fecha' => $this->observedParametersCount > 0 ? $this->remediationDueDate : null,
                'inspeccion_fecha' => now(),
                'updated_by' => $this->actorId(),
            ]);

            $inspeccion->update([
                'estado_inspeccion' => $newState,
                'fecha_salida' => now()->toDateString(),
                'updated_by' => $this->actorId(),
            ]);
        });

        $this->ensureDetailReportPdf(true);
        $this->refreshInspectionContext();
        $this->refreshCertificateState();
        $this->dispatch('swal', type: 'success', title: 'Inspeccion finalizada', text: 'La inspeccion se finalizo correctamente.');
    }

    public function generateInspectionCertificate(): void
    {
        if (!$this->currentInspeccionId || !$this->currentDetalleInspeccionId) {
            return;
        }

        $this->refreshCertificateState();
        if ($this->observedParametersCount > 0) {
            $this->dispatch('swal', type: 'warning', title: 'No disponible', text: 'No se puede generar certificado mientras existan parametros observados.');
            return;
        }

        $createdNewCertificate = false;
        DB::transaction(function () use (&$createdNewCertificate): void {
            $inspeccion = Inspeccion::query()->findOrFail($this->currentInspeccionId);
            $detalle = DetalleInspeccion::query()->findOrFail($this->currentDetalleInspeccionId);
            $existingCert = Certificado::query()
                ->where('inspeccion_id', (int) $inspeccion->id)
                ->where('anulado', 0)
                ->latest('id')
                ->first();

            if ($existingCert) {
                if (!(bool) $inspeccion->certificado_generado) {
                    $inspeccion->update([
                        'certificado_generado' => 1,
                        'updated_by' => $this->actorId(),
                    ]);
                }
                return;
            }
            $tipoCertificadoId = $this->resolveTipoCertificadoId();

            $pdfRelative = app(InspeccionService::class)
                ->generateInspectionCertificatePdf($inspeccion, $detalle, (int) $this->observedParametersCount);
            if (!$pdfRelative) {
                throw new \RuntimeException('No se pudo generar el certificado.');
            }
            $numero = $this->nextCertificateNumber();

            Certificado::query()->create([
                'tipo_certificado_id' => $tipoCertificadoId,
                'inspeccion_id' => (int) $inspeccion->id,
                'detalle_inspeccion_id' => (int) $detalle->id,
                'numero' => $numero,
                'fecha_emision' => now()->toDateString(),
                'fecha_vencimiento' => now()->addYear()->toDateString(),
                'pdf_ruta' => $pdfRelative,
                'anulado' => 0,
                'estado' => 1,
                'created_by' => $this->actorId(),
                'updated_by' => $this->actorId(),
            ]);

            $inspeccion->update([
                'certificado_generado' => 1,
                'estado_inspeccion' => 'aprobado',
                'updated_by' => $this->actorId(),
            ]);

            $detalle->update([
                'inspeccion_estado' => 'aprobado',
                'updated_by' => $this->actorId(),
            ]);

            InspeccionArchivoEquipo::query()->create([
                'inspeccion_id' => (int) $inspeccion->id,
                'archivo_descripcion' => $this->sanitizeStorageText('Certificado de inspeccion ' . $numero),
                'archivo_autogenerado' => 1,
                'archivo_tipo' => 'pdf',
                'archivo_ruta' => $pdfRelative,
                'archivo_origen' => 'autogenerado',
                'mostrar_certificado' => 1,
                'estado' => 1,
                'created_by' => $this->actorId(),
                'updated_by' => $this->actorId(),
            ]);
            $createdNewCertificate = true;
        });

        $this->refreshInspectionContext();
        $this->refreshCertificateState();
        if ($createdNewCertificate) {
            $this->dispatch('swal', type: 'success', title: 'Certificado generado', text: 'Se genero y registro el certificado correctamente.');
        } else {
            $this->dispatch('swal', type: 'info', title: 'Certificado existente', text: 'El certificado ya existe en la base de datos y se cargo para su consulta.', toast: true, timer: 2200);
        }
    }

    public function openDetailReportPreview(): void
    {
        $relative = $this->ensureDetailReportPdf();
        if (!$relative) {
            return;
        }

        $this->inspectionFilePreview = [
            'id' => 0,
            'descripcion' => 'Reporte detallado de inspeccion',
            'tipo' => 'pdf',
            'url' => asset($relative),
            'origen' => 'autogenerado',
            'mostrar_certificado' => false,
        ];
        $this->inspectionFilePreviewModal = true;
    }

    public function openObservedParametersSummary(): void
    {
        if (!$this->currentDetalleInspeccionId) {
            return;
        }

        $items = CuestionarioRespuesta::query()
            ->with([
                'pregunta:id,pregunta_enunciado',
                'observacionesAdjuntas' => fn ($q) => $q->latest('id'),
            ])
            ->where('detalle_inspeccion_id', $this->currentDetalleInspeccionId)
            ->whereHas('observacionesAdjuntas')
            ->orderBy('id')
            ->get()
            ->map(function (CuestionarioRespuesta $respuesta): array {
                $parametro = (string) ($respuesta->pregunta?->pregunta_enunciado ?: $respuesta->cuestionario_pregunta_personalizada ?: 'Parametro');
                $observaciones = $respuesta->observacionesAdjuntas->map(function (CuestionarioRespuestaObservacion $obs): array {
                    return [
                        'id' => (int) $obs->id,
                        'momento' => match ((string) $obs->momento) {
                            'ingreso' => 'Ingreso',
                            'salida' => 'Salida',
                            default => 'Ambos',
                        },
                        'descripcion' => (string) $obs->descripcion,
                        'fecha' => $obs->created_at ? $obs->created_at->format('d/m/Y H:i') : '-',
                    ];
                })->values()->all();

                return [
                    'parametro' => $parametro,
                    'observaciones' => $observaciones,
                ];
            })
            ->values()
            ->all();

        $this->dispatch('observed-parameters-ready', items: $items);
        $this->skipRender();
    }

    private function saveCompanyBaseData(): bool
    {
        if ($this->companyLockedByRuc) {
            $this->addError('empresaForm.ruc', 'Esta empresa no puede registrarse nuevamente desde este modal.');
            return false;
        }

        $validator = Validator::make($this->all(), [
            'empresaForm.tipo' => ['required', Rule::in(['unidad_minera', 'empresa'])],
            'empresaForm.ruc' => [
                'required',
                'digits:11',
                Rule::unique('empresas', 'ruc')->ignore($this->draftEmpresaId)->whereNull('deleted_at'),
            ],
            'empresaForm.razon_social' => ['required', 'string', 'max:200'],
            'empresaForm.nombre_comercial' => ['required', 'string', 'max:200'],
            'empresaForm.telefono' => ['nullable', 'string', 'max:30'],
            'empresaForm.email' => ['nullable', 'email', 'max:150'],
            'empresaForm.direccion' => ['nullable', 'string', 'max:250'],
        ], ['empresaForm.ruc.unique' => 'La empresa con este RUC ya se encuentra registrada y no se puede registrar nuevamente.']);

        if ($validator->fails()) {
            $this->setErrorBag($validator->errors());
            if ($validator->errors()->has('empresaForm.ruc')) {
                $this->dispatch('swal', type: 'warning', title: 'Empresa ya registrada', text: 'El RUC ingresado ya pertenece a una empresa registrada y no se puede duplicar.');
            }
            return false;
        }

        $data = $validator->validated();
        $payload = [
            'tipo' => $data['empresaForm']['tipo'],
            'ruc' => trim((string) $data['empresaForm']['ruc']),
            'razon_social' => trim((string) $data['empresaForm']['razon_social']),
            'nombre_comercial' => trim((string) $data['empresaForm']['nombre_comercial']),
            'telefono' => trim((string) ($data['empresaForm']['telefono'] ?? '')) ?: null,
            'email' => trim((string) ($data['empresaForm']['email'] ?? '')) ?: null,
            'direccion' => trim((string) ($data['empresaForm']['direccion'] ?? '')) ?: null,
            'estado' => 1,
            'updated_by' => $this->actorId(),
        ];

        if ($this->draftEmpresaId) {
            Empresa::query()->whereKey($this->draftEmpresaId)->update($payload);
        } else {
            $payload['created_by'] = $this->actorId();
            $empresa = Empresa::query()->create($payload);
            $this->draftEmpresaId = (int) $empresa->id;
        }

        $this->resetErrorBag('empresaForm');
        return true;
    }

    private function persistDraftProgress(): void
    {
        if (!$this->draftEmpresaId) {
            return;
        }
        $empresa = Empresa::query()->find($this->draftEmpresaId);
        if (!$empresa) {
            return;
        }
        if (count($this->companyServices) > 0) {
            $this->persistCompanyServices($empresa);
        }
        if (count($this->companyContacts) > 0) {
            $this->persistCompanyContacts($empresa);
        }
    }

    private function hydrateDraftFromExistingEmpresa(Empresa $empresa): void
    {
        $this->draftEmpresaId = (int) $empresa->id;
        $this->companyLockedByRuc = false;
        $this->empresaForm['tipo'] = (string) $empresa->tipo;
        $this->empresaForm['ruc'] = (string) ($empresa->ruc ?? '');
        $this->empresaForm['razon_social'] = (string) ($empresa->razon_social ?? '');
        $this->empresaForm['nombre_comercial'] = (string) ($empresa->nombre_comercial ?? '');
        $this->empresaForm['telefono'] = (string) ($empresa->telefono ?? '');
        $this->empresaForm['email'] = (string) ($empresa->email ?? '');
        $this->empresaForm['direccion'] = (string) ($empresa->direccion ?? '');
        $this->companyServices = $empresa->servicios->map(fn (Servicio $servicio) => ['id' => (int) $servicio->id, 'descripcion' => (string) $servicio->descripcion])->values()->all();

        $contactos = $empresa->contactos->map(function (EmpresaContacto $contacto) {
            $persona = $contacto->persona;
            if (!$persona) {
                return null;
            }

            return [
                'persona_id' => (int) $persona->id,
                'tipo_documento' => (string) $persona->tipo_documento,
                'numero_documento' => (string) $persona->numero_documento,
                'nombres' => (string) $persona->nombres,
                'apellido_paterno' => (string) $persona->apellido_paterno,
                'apellido_materno' => (string) $persona->apellido_materno,
                'email' => (string) ($contacto->email ?? $persona->email ?? ''),
                'telefono' => (string) ($contacto->telefono ?? $persona->telefono ?? ''),
                'principal' => (bool) $contacto->estado,
            ];
        })->filter()->values()->all();

        if (!empty($contactos) && !collect($contactos)->contains('principal', true)) {
            $contactos[0]['principal'] = true;
        }
        $this->companyContacts = $contactos;
    }

    private function persistCompanyServices(Empresa $empresa): void
    {
        $servicioIds = collect($this->companyServices)->pluck('id')->filter()->map(fn ($id) => (int) $id)->unique()->values()->all();
        $empresa->servicios()->sync($servicioIds);
    }

    private function persistCompanyContacts(Empresa $empresa): void
    {
        EmpresaContacto::query()->where('empresa_id', $empresa->id)->update([
            'updated_by' => $this->actorId(),
            'deleted_by' => $this->actorId(),
        ]);
        EmpresaContacto::query()->where('empresa_id', $empresa->id)->delete();
        foreach ($this->companyContacts as $index => $contacto) {
            $persona = Persona::query()->updateOrCreate(
                ['numero_documento' => trim((string) $contacto['numero_documento'])],
                [
                    'tipo_documento' => (string) $contacto['tipo_documento'],
                    'nombres' => trim((string) $contacto['nombres']),
                    'apellido_paterno' => trim((string) $contacto['apellido_paterno']),
                    'apellido_materno' => trim((string) $contacto['apellido_materno']),
                    'email' => trim((string) ($contacto['email'] ?? '')) ?: null,
                    'telefono' => trim((string) ($contacto['telefono'] ?? '')) ?: null,
                    'estado' => 1,
                    'created_by' => $this->actorId(),
                    'updated_by' => $this->actorId(),
                ]
            );

            EmpresaContacto::query()->create([
                'empresa_id' => $empresa->id,
                'persona_id' => $persona->id,
                'email' => trim((string) ($contacto['email'] ?? '')) ?: null,
                'telefono' => trim((string) ($contacto['telefono'] ?? '')) ?: null,
                'estado' => $index === 0 ? 1 : 0,
                'created_by' => $this->actorId(),
                'updated_by' => $this->actorId(),
            ]);
        }
    }

    private function appendService(int $id, string $descripcion): void
    {
        $exists = collect($this->companyServices)->contains(fn (array $item) => (int) $item['id'] === $id);
        if (!$exists) {
            $this->companyServices[] = ['id' => $id, 'descripcion' => $descripcion];
        }
    }

    private function syncEmpresaResumen(Empresa $empresa): void
    {
        $servicio = $empresa->servicios->first();
        $contactoPrincipal = $empresa->contactoPrincipal;
        $persona = $contactoPrincipal?->persona;

        $this->empresaResumen = [
            'nombre_comercial' => $empresa->nombre_comercial ?: 'Aun no seleccionada',
            'razon_social' => $empresa->razon_social ?: 'Aun no seleccionada',
            'ruc' => $empresa->ruc ?: 'Sin RUC',
            'unidad_minera' => $empresa->unidad_minera_id ? 'Unidad minera vinculada' : 'Sin unidad minera',
            'servicios' => $servicio?->descripcion ?: 'Sin servicio',
            'telefono_empresa' => $empresa->telefono ?: 'Sin telefono',
            'direccion' => $empresa->direccion ?: 'Sin direccion',
            'contacto_principal' => $persona?->nombre_completo ?: 'Sin contacto',
            'telefono_contacto' => $contactoPrincipal?->telefono ?: ($persona?->telefono ?: 'Sin telefono'),
        ];
    }

    private function loadEmpresaServiceOptions(Empresa $empresa): void
    {
        $this->empresaServiceOptions = $empresa->servicios->map(fn (Servicio $servicio) => ['id' => (int) $servicio->id, 'descripcion' => (string) $servicio->descripcion])->values()->all();
        if ($this->equipmentForm['servicio_id'] ?? null) {
            $exists = collect($this->empresaServiceOptions)->contains(fn (array $item) => (int) $item['id'] === (int) $this->equipmentForm['servicio_id']);
            if (!$exists) {
                $this->equipmentForm['servicio_id'] = null;
            }
        }
    }

    private function syncEquipoResumen(EmpresaEquipo $empresaEquipo): void
    {
        $equipo = $empresaEquipo->equipo;
        $this->equipoResumen = [
            'descripcion' => $empresaEquipo->descripcion ?: ($equipo?->descripcion ?: 'Sin descripcion'),
            'anio' => $equipo?->anio ?: 'Sin anio',
            'serie_tipo' => $empresaEquipo->serie_tipo ?: 'Sin tipo identificador',
            'serie_codigo' => $empresaEquipo->serie_codigo ?: 'Sin identificador',
            'servicio' => $empresaEquipo->servicio?->descripcion ?: 'Sin servicio',
            'tipo' => $equipo?->tipo?->tipo ?: 'Sin tipo',
            'categoria' => $equipo?->categoria?->categoria ?: 'Sin categoria',
            'marca' => $equipo?->marca?->marca ?: 'Sin marca',
            'modelo' => $equipo?->modelo?->modelo ?: ($equipo?->modelo?->modelos ?: 'Sin modelo'),
        ];
    }

    private function resetCompanyModalData(): void
    {
        $this->companyStep = 1;
        $this->draftEmpresaId = null;
        $this->companyLockedByRuc = false;
        $this->empresaForm = ['tipo' => 'empresa', 'ruc' => '', 'razon_social' => '', 'nombre_comercial' => '', 'telefono' => '', 'email' => '', 'direccion' => ''];
        $this->serviceSearch = '';
        $this->serviceSuggestions = [];
        $this->companyServices = [];
        $this->contactForm = $this->defaultContactForm();
        $this->allowManualContact = false;
        $this->companyContacts = [];
        $this->resetValidation();
    }

    private function resetEquipmentSelection(): void
    {
        $this->selectedEmpresaEquipoId = null;
        $this->equipmentSearch = '';
        $this->equipmentSuggestions = [];
        $this->equipoResumen = $this->equipoResumenDefaults();
        $this->resetEquipmentModalData();
        $this->inspectionHistory = [];
        $this->quickSummary = $this->quickSummaryDefaults();
        $this->loadQuestionnaireForDetalle(null);
    }

    private function resetEquipmentModalData(): void
    {
        $this->equipmentForm = ['equipo_id' => null, 'descripcion_catalogo' => '', 'anio' => '', 'tipo_id' => null, 'categoria_id' => null, 'marca_id' => null, 'modelo_id' => null, 'descripcion_empresa' => '', 'serie_tipo' => 'placa', 'serie_codigo' => '', 'servicio_id' => null];
        $this->equipmentDescriptionSuggestions = [];
        $this->tipoSearch = '';
        $this->categoriaSearch = '';
        $this->marcaSearch = '';
        $this->modeloSearch = '';
        $this->tipoSuggestions = [];
        $this->categoriaSuggestions = [];
        $this->marcaSuggestions = [];
        $this->modeloSuggestions = [];
        $this->resetErrorBag('equipmentForm');
    }

    private function defaultContactForm(): array
    {
        return ['persona_id' => null, 'tipo_documento' => 'DNI', 'numero_documento' => '', 'nombres' => '', 'apellido_paterno' => '', 'apellido_materno' => '', 'email' => '', 'telefono' => ''];
    }

    private function defaultObservationForm(): array
    {
        return [
            'momento' => 'ambos',
            'descripcion' => '',
        ];
    }

    private function defaultInspectionFileForm(): array
    {
        return [
            'descripcion' => '',
            'mostrar_certificado' => false,
        ];
    }

    private function empresaResumenDefaults(): array
    {
        return ['nombre_comercial' => 'Aun no seleccionada', 'razon_social' => 'Aun no seleccionada', 'ruc' => 'Sin RUC', 'unidad_minera' => 'Sin unidad minera', 'servicios' => 'Sin servicio', 'telefono_empresa' => 'Sin telefono', 'direccion' => 'Sin direccion', 'contacto_principal' => 'Sin contacto', 'telefono_contacto' => 'Sin telefono'];
    }

    private function equipoResumenDefaults(): array
    {
        return ['descripcion' => 'Sin descripcion', 'anio' => 'Sin anio', 'serie_tipo' => 'Sin tipo identificador', 'serie_codigo' => 'Sin identificador', 'servicio' => 'Sin servicio', 'tipo' => 'Sin tipo', 'categoria' => 'Sin categoria', 'marca' => 'Sin marca', 'modelo' => 'Sin modelo'];
    }

    private function queryCatalogSuggestions(string $modelClass, string $field, string $value): array
    {
        $term = trim($value);
        if (mb_strlen($term) < 2) {
            return [];
        }

        return $modelClass::query()
            ->where('estado', 1)
            ->where($field, 'like', "%{$term}%")
            ->orderBy($field)
            ->limit(8)
            ->get(['id', $field])
            ->map(fn ($model) => ['id' => (int) $model->id, 'nombre' => (string) $model->{$field}])
            ->all();
    }

    private function buildEquipmentBaseDescription(): string
    {
        return trim(collect([$this->tipoSearch, $this->categoriaSearch, $this->marcaSearch, $this->modeloSearch, $this->equipmentForm['anio'] ?: null])->filter()->join(' - '));
    }

    private function refreshEquipmentCompanyDefaultDescription(bool $force = false): void
    {
        $base = $this->buildEquipmentBaseDescription();
        $empresaNombre = $this->empresaResumen['nombre_comercial'] !== 'Aun no seleccionada' ? $this->empresaResumen['nombre_comercial'] : $this->empresaResumen['razon_social'];
        $default = trim(collect([$base, $empresaNombre])->filter()->join(' - '));
        if ($default !== '' && ($force || trim((string) ($this->equipmentForm['descripcion_empresa'] ?? '')) === '')) {
            $this->equipmentForm['descripcion_empresa'] = $default;
        }
    }

    private function seedCuestionarioRespuesta(DetalleInspeccion $detalle): void
    {
        $empresaEquipo = EmpresaEquipo::query()->with('equipo')->find($this->selectedEmpresaEquipoId);
        $equipo = $empresaEquipo?->equipo;
        if (!$equipo) {
            return;
        }

        $preguntas = CuestionarioPregunta::query()
            ->where('estado', 1)
            ->where(function ($query) use ($equipo) {
                $query->whereNull('equipo_tipo_ids')
                    ->orWhere('equipo_tipo_ids', '')
                    ->orWhere('equipo_tipo_ids', 'like', '%.' . $equipo->tipo_id . '.%');
            })
            ->where(function ($query) use ($equipo) {
                $query->whereNull('equipo_categoria_ids')
                    ->orWhere('equipo_categoria_ids', '')
                    ->orWhere('equipo_categoria_ids', 'like', '%.' . $equipo->categoria_id . '.%');
            })
            ->where(function ($query) use ($equipo) {
                $query->whereNull('equipo_marca_ids')
                    ->orWhere('equipo_marca_ids', '')
                    ->orWhere('equipo_marca_ids', 'like', '%.' . $equipo->marca_id . '.%');
            })
            ->where(function ($query) use ($equipo) {
                $query->whereNull('equipo_modelo_ids')
                    ->orWhere('equipo_modelo_ids', '')
                    ->orWhere('equipo_modelo_ids', 'like', '%.' . $equipo->modelo_id . '.%');
            })
            ->get();

        foreach ($preguntas as $pregunta) {
            CuestionarioRespuesta::query()->firstOrCreate(
                [
                    'detalle_inspeccion_id' => (int) $detalle->id,
                    'cuestionario_pregunta_id' => (int) $pregunta->id,
                ],
                [
                    'cuestionario_categoria_id' => (int) $pregunta->cuestionario_categoria_id,
                    'cuestionario_sub_categoria_id' => (int) $pregunta->cuestionario_sub_categoria_id,
                    'estado' => 1,
                    'created_by' => $this->actorId(),
                    'updated_by' => $this->actorId(),
                ]
            );
        }
    }

    private function copyCuestionarioRespuestaFromDetalle(DetalleInspeccion $targetDetalle, int $sourceDetalleId): void
    {
        $sourceRows = CuestionarioRespuesta::query()
            ->where('detalle_inspeccion_id', $sourceDetalleId)
            ->orderBy('id')
            ->get();

        if ($sourceRows->isEmpty()) {
            $this->seedCuestionarioRespuesta($targetDetalle);
            return;
        }

        foreach ($sourceRows as $row) {
            CuestionarioRespuesta::query()->create([
                'detalle_inspeccion_id' => (int) $targetDetalle->id,
                'cuestionario_categoria_id' => (int) $row->cuestionario_categoria_id,
                'cuestionario_sub_categoria_id' => (int) $row->cuestionario_sub_categoria_id,
                'cuestionario_pregunta_id' => $row->cuestionario_pregunta_id ? (int) $row->cuestionario_pregunta_id : null,
                'cuestionario_pregunta_personalizada' => $this->normalizeNullableText($row->cuestionario_pregunta_personalizada),
                'ingreso_respuesta' => $this->normalizeNullableText($row->ingreso_respuesta),
                'salida_respuesta' => $this->normalizeNullableText($row->salida_respuesta),
                'estado_respuesta' => $this->normalizeNullableText($row->estado_respuesta),
                'estado' => 1,
                'created_by' => $this->actorId(),
                'updated_by' => $this->actorId(),
            ]);
        }
    }

    private function loadQuestionnaireForDetalle(?int $detalleInspeccionId): void
    {
        $this->questionnaireGroups = [];
        $this->questionnaireCategories = [];
        $this->responsesInput = [];
        $this->responseMeta = [];
        $this->responseSubgroupMap = [];
        $this->subgroupResponseIds = [];
        $this->pendingSubgroups = [];

        if (!$detalleInspeccionId) {
            $this->uiActiveQuestionCategoryId = null;
            $this->uiActiveQuestionSubcategoryId = null;
            $this->uiInspectionTab = 'questions';
            return;
        }

        $respuestas = CuestionarioRespuesta::query()
            ->with([
                'pregunta:id,pregunta_enunciado,ingeso_preguntar,ingreso_respuesta_tipo,ingreso_respuesta_valores,salida_preguntar,salida_respuesta_tipo,salida_respuesta_valores',
                'categoria:id,descripcion',
                'subCategoria:id,descripcion',
            ])
            ->withCount('observacionesAdjuntas')
            ->where('detalle_inspeccion_id', $detalleInspeccionId)
            ->orderBy('cuestionario_categoria_id')
            ->orderBy('cuestionario_sub_categoria_id')
            ->orderBy('id')
            ->get();

        $groups = [];
        $categories = [];
        foreach ($respuestas as $respuesta) {
            $groupKey = $respuesta->cuestionario_categoria_id . '-' . $respuesta->cuestionario_sub_categoria_id;
            if (!isset($groups[$groupKey])) {
                $groups[$groupKey] = [
                    'key' => $groupKey,
                    'categoria_id' => (int) $respuesta->cuestionario_categoria_id,
                    'subcategoria_id' => (int) $respuesta->cuestionario_sub_categoria_id,
                    'categoria' => $respuesta->categoria?->descripcion ?: 'Sin categoria',
                    'subcategoria' => $respuesta->subCategoria?->descripcion ?: 'Sin subcategoria',
                    'responses' => [],
                ];
            }

            $ingresoType = (string) ($respuesta->pregunta?->ingreso_respuesta_tipo ?: 'texto');
            $salidaType = (string) ($respuesta->pregunta?->salida_respuesta_tipo ?: 'texto');
            $item = [
                'id' => (int) $respuesta->id,
                'enunciado' => (string) ($respuesta->pregunta?->pregunta_enunciado ?: $respuesta->cuestionario_pregunta_personalizada ?: 'Pregunta'),
                'ingreso_preguntar' => (bool) $respuesta->pregunta?->ingeso_preguntar,
                'ingreso_tipo' => $ingresoType,
                'ingreso_valores' => $this->parseRespuestaValores((string) ($respuesta->pregunta?->ingreso_respuesta_valores ?? '')),
                'salida_preguntar' => (bool) $respuesta->pregunta?->salida_preguntar,
                'salida_tipo' => $salidaType,
                'salida_valores' => $this->parseRespuestaValores((string) ($respuesta->pregunta?->salida_respuesta_valores ?? '')),
                'observaciones_count' => (int) ($respuesta->observaciones_adjuntas_count ?? 0),
                'categoria_id' => (int) $respuesta->cuestionario_categoria_id,
                'subcategoria_id' => (int) $respuesta->cuestionario_sub_categoria_id,
                'group_key' => $groupKey,
            ];

            $groups[$groupKey]['responses'][] = $item;
            $this->responsesInput[(int) $respuesta->id] = [
                'ingreso' => (string) ($respuesta->ingreso_respuesta ?? ''),
                'salida' => (string) ($respuesta->salida_respuesta ?? ''),
            ];
            $this->responseMeta[(int) $respuesta->id] = $item;
            $this->responseSubgroupMap[(int) $respuesta->id] = $groupKey;
            $this->subgroupResponseIds[$groupKey][] = (int) $respuesta->id;
            $this->pendingSubgroups[$groupKey] = false;

            $categoriaId = (int) $respuesta->cuestionario_categoria_id;
            $subCategoriaId = (int) $respuesta->cuestionario_sub_categoria_id;
            if (!isset($categories[$categoriaId])) {
                $categories[$categoriaId] = [
                    'id' => $categoriaId,
                    'nombre' => $respuesta->categoria?->descripcion ?: 'Sin categoria',
                    'preguntas' => 0,
                    'subcategorias' => [],
                ];
            }
            $categories[$categoriaId]['preguntas']++;
            if (!isset($categories[$categoriaId]['subcategorias'][$subCategoriaId])) {
                $categories[$categoriaId]['subcategorias'][$subCategoriaId] = [
                    'id' => $subCategoriaId,
                    'nombre' => $respuesta->subCategoria?->descripcion ?: 'Sin subcategoria',
                    'key' => $groupKey,
                    'preguntas' => 0,
                    'has_observaciones' => false,
                ];
            }
            $categories[$categoriaId]['subcategorias'][$subCategoriaId]['preguntas']++;
            if ((int) ($respuesta->observaciones_adjuntas_count ?? 0) > 0) {
                $categories[$categoriaId]['subcategorias'][$subCategoriaId]['has_observaciones'] = true;
            }
        }

        $this->questionnaireGroups = array_values($groups);
        $this->questionnaireCategories = array_values(array_map(function (array $cat): array {
            $cat['subcategorias'] = array_values($cat['subcategorias']);
            return $cat;
        }, $categories));

        $availableCategoryIds = array_map(fn (array $cat): int => (int) $cat['id'], $this->questionnaireCategories);
        if ($this->uiActiveQuestionCategoryId === null || !in_array((int) $this->uiActiveQuestionCategoryId, $availableCategoryIds, true)) {
            $this->uiActiveQuestionCategoryId = $this->questionnaireCategories[0]['id'] ?? null;
        }

        $selectedCategory = collect($this->questionnaireCategories)
            ->first(fn (array $cat) => (int) $cat['id'] === (int) $this->uiActiveQuestionCategoryId);
        $availableSubcategoryIds = collect($selectedCategory['subcategorias'] ?? [])
            ->map(fn (array $sub): int => (int) $sub['id'])
            ->all();
        if ($this->uiActiveQuestionSubcategoryId === null || !in_array((int) $this->uiActiveQuestionSubcategoryId, $availableSubcategoryIds, true)) {
            $this->uiActiveQuestionSubcategoryId = $selectedCategory['subcategorias'][0]['id'] ?? null;
        }
    }

    private function parseRespuestaValores(string $raw): array
    {
        $raw = trim($raw);
        if ($raw === '') {
            return [];
        }

        $normalized = preg_replace('/^\s*(in|out)\s*:/i', '', $raw);
        $parts = array_filter(array_map('trim', explode(',', (string) $normalized)));
        $options = [];
        foreach ($parts as $part) {
            if (str_contains($part, '=>')) {
                [$key, $label] = array_map('trim', explode('=>', $part, 2));
                $options[] = ['value' => $key, 'label' => $label];
            } else {
                $options[] = ['value' => $part, 'label' => $part];
            }
        }
        return $options;
    }

    private function persistResponse(int $responseId): void
    {
        if (!isset($this->responsesInput[$responseId])) {
            return;
        }

        $input = $this->responsesInput[$responseId] ?? [];
        CuestionarioRespuesta::query()
            ->whereKey($responseId)
            ->update([
                'ingreso_respuesta' => $this->normalizeNullableText($input['ingreso'] ?? null),
                'salida_respuesta' => $this->normalizeNullableText($input['salida'] ?? null),
                'updated_by' => $this->actorId(),
            ]);
    }

    private function buildObservationList(int $responseId): array
    {
        return CuestionarioRespuestaObservacion::query()
            ->where('cuestionario_respuesta_id', $responseId)
            ->where('estado', 1)
            ->latest('id')
            ->get()
            ->map(fn (CuestionarioRespuestaObservacion $obs) => [
                'id' => (int) $obs->id,
                'momento' => match ((string) $obs->momento) {
                    'ingreso' => 'Ingreso',
                    'salida' => 'Salida',
                    default => 'Ambos',
                },
                'descripcion' => (string) $obs->descripcion,
                'fecha' => $obs->created_at ? $obs->created_at->format('d/m/Y H:i') : '-',
            ])
            ->all();
    }

    private function normalizeNullableText($value): ?string
    {
        $text = trim((string) ($value ?? ''));
        return $text === '' ? null : $text;
    }

    private function sanitizeStorageText(string $value): string
    {
        $ascii = Str::ascii(trim($value));
        $ascii = preg_replace('/[^A-Za-z0-9\\s\\-_.]/', '', $ascii) ?? '';
        $ascii = preg_replace('/\\s+/', ' ', $ascii) ?? '';
        return trim($ascii) !== '' ? trim($ascii) : 'archivo';
    }

    private function sanitizeStorageFileToken(string $value, string $fallback): string
    {
        $token = Str::of(trim($value))
            ->ascii()
            ->lower()
            ->replaceMatches('/[^a-z0-9\\-_]+/u', '-')
            ->trim('-_')
            ->value();

        return $token !== '' ? $token : $fallback;
    }

    private function sanitizeStoragePathSegment(string $value, string $fallback): string
    {
        $segment = Str::of(trim($value))
            ->ascii()
            ->lower()
            ->replaceMatches('/[^a-z0-9\\-_]+/u', '_')
            ->trim('_')
            ->value();

        return $segment !== '' ? $segment : $fallback;
    }

    private function resolveInspectionStoragePath(Inspeccion $inspeccion, string $codigoInspeccion, string $bucket): string
    {
        $empresaEquipo = $inspeccion->empresaEquipo;
        $serieTipo = trim((string) ($empresaEquipo?->serie_tipo ?: 'SERIE'));
        $serieCodigo = trim((string) ($empresaEquipo?->serie_codigo ?: ('EQ-' . $inspeccion->empresa_equipo_id)));

        $serieFolder = $this->sanitizeStoragePathSegment($serieTipo . '_' . $serieCodigo, 'serie');
        $codigoFolder = $this->sanitizeStoragePathSegment($codigoInspeccion, 'inspeccion');
        $bucketFolder = $this->sanitizeStoragePathSegment($bucket, 'archivos');

        return 'uploads/' . $serieFolder . '/' . $codigoFolder . '/' . $bucketFolder;
    }

    private function buildGeneratedPdfFileName(string $prefix, string $codigoInspeccion): string
    {
        $timestamp = now()->format('Ymd_His');
        $codigo = $this->sanitizeStorageFileToken($codigoInspeccion, 'inspeccion');
        $normalizedPrefix = Str::of(trim($prefix))
            ->lower()
            ->replaceMatches('/[^a-z0-9\\-]+/u', '-')
            ->trim('-')
            ->value();

        if ($normalizedPrefix === 'certificado') {
            return "certificado-{$timestamp}-{$codigo}.pdf";
        }

        if ($normalizedPrefix === 'resumen-inspeccion' || $normalizedPrefix === 'reporte-detallado') {
            return "resumen-inspeccion-{$timestamp}-{$codigo}.pdf";
        }

        $fallbackPrefix = $normalizedPrefix !== '' ? $normalizedPrefix : 'documento';
        return "{$fallbackPrefix}-{$timestamp}-{$codigo}.pdf";
    }

    private function actorId(): ?int
    {
        $user = Auth::user();
        if (!$user) {
            return null;
        }

        $id = $user->getAuthIdentifier();
        if ($id === null && isset($user->id)) {
            $id = $user->id;
        }
        if ($id === null && isset($user->user_id)) {
            $id = $user->user_id;
        }

        return $id !== null ? (int) $id : null;
    }

    private function defaultCustomQuestionForm(): array
    {
        return [
            'cuestionario_categoria_id' => null,
            'cuestionario_sub_categoria_id' => null,
            'enunciado' => '',
            'ingreso_respuesta' => '',
            'salida_respuesta' => '',
        ];
    }

    private function resolveInspectionNumber(): int
    {
        if ($this->currentDetalleInspeccionId) {
            $numero = (int) (DetalleInspeccion::query()->whereKey($this->currentDetalleInspeccionId)->value('inespeccion_numero') ?? 0);
            if ($numero > 0) {
                return $numero;
            }
        }

        return 1;
    }

    private function refreshCertificateState(): void
    {
        $this->observedParametersCount = 0;
        $this->certificateStatusLabel = 'en proceso';
        $this->inspectionFinalized = false;
        $this->certificateGenerated = false;
        $this->canFinalizeInspection = false;
        $this->canGenerateCertificate = false;
        $this->canEditInspectionFromCertificate = false;
        $this->finalizedAtLabel = null;
        $this->certificatePdfUrl = null;
        $this->reportPdfUrl = null;
        $this->remediationDueDate = null;

        if (!$this->currentInspeccionId || !$this->currentDetalleInspeccionId) {
            return;
        }

        $inspeccion = Inspeccion::query()
            ->with(['ultimoDetalle', 'certificados' => fn ($q) => $q->orderByDesc('id')])
            ->find($this->currentInspeccionId);

        if (!$inspeccion) {
            return;
        }

        $detalle = DetalleInspeccion::query()->find($this->currentDetalleInspeccionId);
        if (!$detalle) {
            return;
        }

        $this->observedParametersCount = CuestionarioRespuesta::query()
            ->where('detalle_inspeccion_id', $detalle->id)
            ->whereHas('observacionesAdjuntas')
            ->count();

        $state = (string) $detalle->inspeccion_estado;
        $this->certificateStatusLabel = match ($state) {
            'aprobado' => 'finalizado',
            'observado', 'subsanacion' => 'observado',
            'anulado' => 'anulado',
            'rechazado' => 'rechazado',
            default => 'en proceso',
        };

        $this->inspectionFinalized = in_array($state, ['aprobado', 'observado', 'rechazado', 'anulado'], true);
        $this->canFinalizeInspection = in_array($state, ['en_inspeccion', 'subsanacion'], true);
        $this->canEditInspectionFromCertificate = (bool) $inspeccion->certificado_generado;

        $latestCert = Certificado::query()
            ->where('inspeccion_id', $inspeccion->id)
            ->where('anulado', 0)
            ->latest('id')
            ->first();

        $this->certificateGenerated = (bool) $inspeccion->certificado_generado && (bool) $latestCert;
        $this->canGenerateCertificate = $this->inspectionFinalized && $this->observedParametersCount === 0 && !$this->certificateGenerated;
        $this->finalizedAtLabel = $detalle->inspeccion_fecha ? Carbon::parse($detalle->inspeccion_fecha)->format('d/m/Y H:i') : null;
        $this->certificatePdfUrl = $latestCert?->pdf_ruta ? asset((string) $latestCert->pdf_ruta) : null;

        if ($this->remediationDueDate === null && $detalle->correcion_vigencia_fecha) {
            $this->remediationDueDate = Carbon::parse($detalle->correcion_vigencia_fecha)->toDateString();
        }

        $reportPath = (string) ($detalle->pdf_ruta ?? '');
        if ($reportPath === '') {
            $latestReport = InspeccionArchivoEquipo::query()
                ->where('inspeccion_id', $inspeccion->id)
                ->where('archivo_origen', 'autogenerado')
                ->where('archivo_descripcion', 'like', 'Reporte detallado%')
                ->latest('id')
                ->first();
            $reportPath = (string) ($latestReport?->archivo_ruta ?? '');
        }
        $this->reportPdfUrl = $reportPath !== '' ? asset($reportPath) : null;
    }

    private function resolveTipoCertificadoId(): int
    {
        $tipo = TipoCertificado::query()->where('estado', 1)->orderBy('id')->first();
        if ($tipo) {
            return (int) $tipo->id;
        }

        $tipo = TipoCertificado::query()->create([
            'tipo_certificado' => 'INSPECCION',
            'estado' => 1,
            'created_by' => $this->actorId(),
            'updated_by' => $this->actorId(),
        ]);

        return (int) $tipo->id;
    }

    private function nextCertificateNumber(): string
    {
        $year = now()->format('Y');
        $next = ((int) (Certificado::query()->max('id') ?? 0)) + 1;
        return sprintf('CERT-%s-%06d', $year, $next);
    }

    private function ensureDetailReportPdf(bool $forceGenerate = false): ?string
    {
        if (!$this->currentInspeccionId || !$this->currentDetalleInspeccionId) {
            return null;
        }

        $inspeccion = Inspeccion::query()->find((int) $this->currentInspeccionId);
        $detalle = DetalleInspeccion::query()->find((int) $this->currentDetalleInspeccionId);
        if (!$inspeccion || !$detalle) {
            return null;
        }

        return app(InspeccionService::class)->generateDetailReportPdf(
            $inspeccion,
            $detalle,
            $this->actorId(),
            $forceGenerate
        );
    }

    private function generateInspectionPdf(string $titleText, string $prefix): string
    {
        $inspeccion = Inspeccion::query()->findOrFail($this->currentInspeccionId);
        $numeroInspeccion = (string) $this->resolveInspectionNumber();
        $targetRelativePath = $this->resolveInspectionStoragePath($inspeccion, $numeroInspeccion, 'archivos_generados');
        $targetDirectory = public_path($targetRelativePath);
        if (!File::exists($targetDirectory)) {
            File::makeDirectory($targetDirectory, 0755, true);
        }

        $fileName = $this->buildGeneratedPdfFileName($prefix, $numeroInspeccion);
        $absoluteFile = $targetDirectory . DIRECTORY_SEPARATOR . $fileName;
        File::put($absoluteFile, $this->buildSimplePdf($titleText));

        return $targetRelativePath . '/' . $fileName;
    }

    private function generateCertificatePdf(Inspeccion $inspeccion, DetalleInspeccion $detalle): string
    {
        $empresaEquipo = $inspeccion->empresaEquipo;
        $numeroInspeccion = (string) $this->resolveInspectionNumber();

        $targetRelativePath = $this->resolveInspectionStoragePath($inspeccion, $numeroInspeccion, 'archivos_generados');
        $targetDirectory = public_path($targetRelativePath);
        if (!File::exists($targetDirectory)) {
            File::makeDirectory($targetDirectory, 0755, true);
        }

        $templateImage = $this->prepareJpegForPdf(public_path('img/plantilla.png'));

        $selectedFiles = InspeccionArchivoEquipo::query()
            ->where('inspeccion_id', (int) $inspeccion->id)
            ->where('estado', 1)
            ->where('mostrar_certificado', 1)
            ->orderBy('id')
            ->get();

        $summaryLines = [
            'Certificado de inspeccion',
            'Codigo: ' . (string) ($inspeccion->codigo_formateado ?: ('#' . $inspeccion->id)),
            'Fecha de emision: ' . now()->format('d/m/Y H:i'),
            'Empresa: ' . (string) ($inspeccion->empresa?->razon_social ?: 'No registrada'),
            'Equipo: ' . (string) ($empresaEquipo?->descripcion ?: $inspeccion->equipo?->descripcion ?: 'No registrado'),
            'Serie: ' . (string) ($empresaEquipo?->serie_codigo ?: '-'),
            'Estado de inspeccion: ' . Str::title(str_replace('_', ' ', (string) $detalle->inspeccion_estado)),
            'Observaciones del detalle: ' . (string) $this->observedParametersCount,
            'Archivos visibles en certificado: ' . (string) $selectedFiles->count(),
        ];

        $pages = [[
            'title' => 'CERTIFICADO DE INSPECCION',
            'lines' => $summaryLines,
            'image' => null,
        ]];

        foreach ($selectedFiles as $file) {
            $absolutePath = public_path((string) $file->archivo_ruta);
            $attachmentImage = $this->prepareJpegForPdf($absolutePath);
            if ($attachmentImage) {
                $pages[] = [
                    'title' => 'ANEXO - ' . (string) ($file->archivo_descripcion ?: ('Archivo #' . $file->id)),
                    'lines' => [
                        'Archivo: ' . (string) ($file->archivo_descripcion ?: ('Adjunto #' . $file->id)),
                        'Tipo: ' . strtoupper((string) ($file->archivo_tipo ?: 'archivo')),
                    ],
                    'image' => $attachmentImage['path'],
                ];
                continue;
            }

            $pages[] = [
                'title' => 'ANEXO - ' . (string) ($file->archivo_descripcion ?: ('Archivo #' . $file->id)),
                'lines' => [
                    'Archivo no visualizable como imagen dentro del PDF.',
                    'Descripcion: ' . (string) ($file->archivo_descripcion ?: '-'),
                    'Ruta: ' . (string) ($file->archivo_ruta ?: '-'),
                ],
                'image' => null,
            ];
        }

        $pdfBinary = $this->buildRichPdfDocument(
            $pages,
            $templateImage['path'] ?? null
        );

        $fileName = $this->buildGeneratedPdfFileName('certificado', $numeroInspeccion);
        $absoluteFile = $targetDirectory . DIRECTORY_SEPARATOR . $fileName;
        File::put($absoluteFile, $pdfBinary);

        if ($templateImage && !empty($templateImage['cleanup'])) {
            File::delete((string) $templateImage['path']);
        }

        foreach ($pages as $page) {
            if (!empty($page['image']) && isset($page['image']) && str_contains((string) $page['image'], 'tmp_pdf_')) {
                File::delete((string) $page['image']);
            }
        }

        return $targetRelativePath . '/' . $fileName;
    }

    private function prepareJpegForPdf(string $absolutePath): ?array
    {
        if (!File::exists($absolutePath)) {
            return null;
        }

        $imageInfo = @getimagesize($absolutePath);
        if (!$imageInfo || empty($imageInfo['mime'])) {
            return null;
        }

        $mime = strtolower((string) $imageInfo['mime']);
        if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
            return [
                'path' => $absolutePath,
                'cleanup' => false,
            ];
        }

        if (!function_exists('imagecreatefromstring') || !function_exists('imagejpeg')) {
            return null;
        }

        $raw = @file_get_contents($absolutePath);
        if ($raw === false) {
            return null;
        }

        $source = @imagecreatefromstring($raw);
        if (!$source) {
            return null;
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $canvas = imagecreatetruecolor($width, $height);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        imagefill($canvas, 0, 0, $white);
        imagecopy($canvas, $source, 0, 0, 0, 0, $width, $height);

        $tmpPath = storage_path('app/tmp_pdf_' . Str::random(24) . '.jpg');
        @imagejpeg($canvas, $tmpPath, 88);
        imagedestroy($source);
        imagedestroy($canvas);

        if (!File::exists($tmpPath)) {
            return null;
        }

        return [
            'path' => $tmpPath,
            'cleanup' => true,
        ];
    }

    private function buildRichPdfDocument(array $pages, ?string $templateImagePath = null): string
    {
        $a4Width = 595;
        $a4Height = 842;

        $objects = [];
        $addObject = function (string $content) use (&$objects): int {
            $objects[] = $content;
            return count($objects);
        };

        $catalogId = $addObject('');
        $pagesId = $addObject('');
        $fontId = $addObject('<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>');

        $imageObjectIds = [];
        $imageSizes = [];

        $registerImage = function (?string $path) use (&$imageObjectIds, &$imageSizes, $addObject): ?int {
            if (!$path || !File::exists($path)) {
                return null;
            }
            if (isset($imageObjectIds[$path])) {
                return $imageObjectIds[$path];
            }

            $size = @getimagesize($path);
            if (!$size || empty($size[0]) || empty($size[1])) {
                return null;
            }
            $raw = @file_get_contents($path);
            if ($raw === false) {
                return null;
            }

            $imgObj = sprintf(
                '<< /Type /XObject /Subtype /Image /Width %d /Height %d /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length %d >>' . "\nstream\n",
                (int) $size[0],
                (int) $size[1],
                strlen($raw)
            ) . $raw . "\nendstream";

            $imgId = $addObject($imgObj);
            $imageObjectIds[$path] = $imgId;
            $imageSizes[$path] = [(float) $size[0], (float) $size[1]];

            return $imgId;
        };

        $templateObjId = $registerImage($templateImagePath);
        $pageIds = [];

        foreach ($pages as $page) {
            $xObjectMap = [];
            if ($templateObjId) {
                $xObjectMap['ImTpl'] = $templateObjId;
            }

            $attachmentPath = (string) ($page['image'] ?? '');
            $attachmentObjId = $registerImage($attachmentPath !== '' ? $attachmentPath : null);
            if ($attachmentObjId) {
                $xObjectMap['ImFile'] = $attachmentObjId;
            }

            $stream = '';

            if (isset($xObjectMap['ImTpl'])) {
                $stream .= "q {$a4Width} 0 0 {$a4Height} 0 0 cm /ImTpl Do Q\n";
            }

            $title = $this->escapePdfText((string) ($page['title'] ?? 'CERTIFICADO'));
            $stream .= "BT /F1 15 Tf 42 790 Td ({$title}) Tj ET\n";

            $currentY = 760;
            foreach ((array) ($page['lines'] ?? []) as $line) {
                $text = $this->escapePdfText((string) $line);
                $stream .= "BT /F1 11 Tf 42 {$currentY} Td ({$text}) Tj ET\n";
                $currentY -= 18;
                if ($currentY < 110) {
                    break;
                }
            }

            if (isset($xObjectMap['ImFile']) && isset($imageSizes[$attachmentPath])) {
                [$imgW, $imgH] = $imageSizes[$attachmentPath];
                $maxW = 500.0;
                $maxH = 470.0;
                $scale = min($maxW / max($imgW, 1.0), $maxH / max($imgH, 1.0), 1.0);
                $drawW = $imgW * $scale;
                $drawH = $imgH * $scale;
                $x = ($a4Width - $drawW) / 2;
                $y = 90;
                $stream .= sprintf("q %.3f 0 0 %.3f %.3f %.3f cm /ImFile Do Q\n", $drawW, $drawH, $x, $y);
            }

            $contentId = $addObject('<< /Length ' . strlen($stream) . " >>\nstream\n" . $stream . "endstream");

            $xObjResource = '';
            if (!empty($xObjectMap)) {
                $parts = [];
                foreach ($xObjectMap as $name => $objId) {
                    $parts[] = '/' . $name . ' ' . $objId . ' 0 R';
                }
                $xObjResource = '/XObject << ' . implode(' ', $parts) . ' >>';
            }

            $pageId = $addObject(
                "<< /Type /Page /Parent {$pagesId} 0 R /MediaBox [0 0 {$a4Width} {$a4Height}] /Resources << /Font << /F1 {$fontId} 0 R >> {$xObjResource} >> /Contents {$contentId} 0 R >>"
            );
            $pageIds[] = $pageId;
        }

        $kids = implode(' ', array_map(fn (int $id) => $id . ' 0 R', $pageIds));
        $objects[$pagesId - 1] = '<< /Type /Pages /Kids [' . $kids . '] /Count ' . count($pageIds) . ' >>';
        $objects[$catalogId - 1] = '<< /Type /Catalog /Pages ' . $pagesId . ' 0 R >>';

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $i => $obj) {
            $offsets[] = strlen($pdf);
            $pdf .= ($i + 1) . " 0 obj\n" . $obj . "\nendobj\n";
        }

        $xrefPos = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }
        $pdf .= "trailer << /Size " . (count($objects) + 1) . " /Root {$catalogId} 0 R >>\n";
        $pdf .= "startxref\n{$xrefPos}\n%%EOF";

        return $pdf;
    }

    private function escapePdfText(string $text): string
    {
        return str_replace(
            ['\\', '(', ')', "\r", "\n"],
            ['\\\\', '\\(', '\\)', ' ', ' '],
            trim($text)
        );
    }

    private function buildSimplePdf(string $text): string
    {
        $text = strtoupper(trim($text));
        $stream = "BT /F1 28 Tf 160 430 Td (" . str_replace(['\\', '(', ')'], ['\\\\', '\\(', '\\)'], $text) . ") Tj ET";
        $objects = [];
        $objects[] = "1 0 obj << /Type /Catalog /Pages 2 0 R >> endobj";
        $objects[] = "2 0 obj << /Type /Pages /Kids [3 0 R] /Count 1 >> endobj";
        $objects[] = "3 0 obj << /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >> endobj";
        $objects[] = "4 0 obj << /Type /Font /Subtype /Type1 /BaseFont /Helvetica >> endobj";
        $objects[] = "5 0 obj << /Length " . strlen($stream) . " >> stream\n" . $stream . "\nendstream endobj";

        $pdf = "%PDF-1.4\n";
        $offsets = [0];
        foreach ($objects as $object) {
            $offsets[] = strlen($pdf);
            $pdf .= $object . "\n";
        }

        $xrefPosition = strlen($pdf);
        $pdf .= "xref\n0 " . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$i]);
        }
        $pdf .= "trailer << /Size " . (count($objects) + 1) . " /Root 1 0 R >>\n";
        $pdf .= "startxref\n" . $xrefPosition . "\n%%EOF";
        return $pdf;
    }

    private function loadInspectionFiles(?int $inspeccionId): void
    {
        $this->inspectionFiles = [];
        if (!$inspeccionId) {
            return;
        }

        $this->inspectionFiles = InspeccionArchivoEquipo::query()
            ->where('inspeccion_id', $inspeccionId)
            ->where('archivo_origen', 'original')
            ->latest('id')
            ->get()
            ->map(fn (InspeccionArchivoEquipo $archivo) => [
                'id' => (int) $archivo->id,
                'descripcion' => (string) $archivo->archivo_descripcion,
                'tipo' => (string) $archivo->archivo_tipo,
                'origen' => (string) $archivo->archivo_origen,
                'mostrar_certificado' => (bool) $archivo->mostrar_certificado,
                'ruta' => (string) $archivo->archivo_ruta,
                'url' => asset($archivo->archivo_ruta),
                'fecha' => $archivo->created_at ? $archivo->created_at->format('d/m/Y H:i') : '-',
            ])
            ->all();
    }

    private function quickSummaryDefaults(): array
    {
        return [
            'estado' => 'borrador',
            'descripcion' => 'No se ha seleccionado ningun equipo/vehiculo. Selecciona un vehiculo para continuar.',
            'inspeccion_numero' => null,
            'show_create' => false,
            'show_continue' => false,
            'show_view' => false,
            'show_start_observed' => false,
            'started' => false,
            'inspection_finalized' => false,
        ];
    }

    private function refreshInspectionContext(): void
    {
        if (!$this->selectedEmpresaEquipoId) {
            $this->quickSummary = $this->quickSummaryDefaults();
            $this->inspectionHistory = [];
            $this->loadQuestionnaireForDetalle(null);
            $this->currentDetalleInspeccionId = null;
            $this->currentInspeccionId = null;
            $this->inspectionUploadFile = null;
            $this->inspectionFileForm = $this->defaultInspectionFileForm();
            $this->inspectionFiles = [];
            $this->inspectionFilePreviewModal = false;
            $this->inspectionFilePreview = [];
            $this->refreshCertificateState();
            $this->dispatch('inspection-state', started: false, inspectionFinalized: false);
            return;
        }

        $latest = Inspeccion::query()
            ->with([
                'ultimoDetalle',
                'certificados' => fn ($q) => $q->where('anulado', 0)->orderByDesc('fecha_vencimiento'),
            ])
            ->where('empresa_equipo_id', $this->selectedEmpresaEquipoId)
            ->latest('id')
            ->first();

        if (!$latest) {
            $this->quickSummary = [
                'estado' => 'borrador',
                'descripcion' => 'Equipo sin inspecciones registradas. Puedes crear una nueva inspeccion.',
                'inspeccion_numero' => null,
                'show_create' => true,
                'show_continue' => false,
                'show_view' => false,
                'show_start_observed' => false,
                'started' => false,
                'inspection_finalized' => false,
            ];
        } else {
            $lastCert = $latest->certificados->first();
            $lastDetailNumber = $latest->ultimoDetalle?->inespeccion_numero;
            $estado = (string) ($latest->ultimoDetalle?->inspeccion_estado ?: $latest->estado_inspeccion);
            $descripcion = 'Inspeccion en estado ' . $estado . '.';
            $showCreate = false;
            $showContinue = false;
            $showView = true;
            $showStartObserved = false;
            $started = true;
            $inspectionFinalized = in_array($estado, ['observado', 'aprobado', 'rechazado', 'anulado'], true);

            if ($estado === 'en_inspeccion') {
                $showContinue = true;
                $showView = false;
                $inspectionFinalized = false;
                $when = $latest->fecha_ingreso ? $latest->fecha_ingreso->format('d/m/Y') : $latest->created_at?->format('d/m/Y H:i');
                $descripcion = 'El equipo se encuentra en inspeccion desde ' . ($when ?: 'fecha no registrada') . '.';
            } elseif ($estado === 'subsanacion') {
                $showContinue = true;
                $showView = false;
                $inspectionFinalized = false;
                $when = $latest->ultimoDetalle?->inspeccion_fecha ? Carbon::parse($latest->ultimoDetalle->inspeccion_fecha)->format('d/m/Y H:i') : null;
                $descripcion = 'Se encuentra en subsanacion de observaciones' . ($when ? ' desde ' . $when : '') . '.';
            } elseif ($estado === 'observado') {
                $limitDate = $latest->ultimoDetalle?->correcion_vigencia_fecha
                    ? Carbon::parse($latest->ultimoDetalle->correcion_vigencia_fecha)->endOfDay()
                    : null;
                $limitExpired = $limitDate ? $limitDate->isPast() : true;

                if ($limitExpired) {
                    $estado = 'rechazado';
                    $inspectionFinalized = true;
                    $showCreate = true;
                    $descripcion = 'La inspeccion observada vencio su plazo de subsanacion. Debes crear una nueva inspeccion.';

                    if ((string) $latest->estado_inspeccion === 'observado') {
                        $latest->update([
                            'estado_inspeccion' => 'rechazado',
                            'updated_by' => $this->actorId(),
                        ]);
                        if ($latest->ultimoDetalle && (string) $latest->ultimoDetalle->inspeccion_estado === 'observado') {
                            $latest->ultimoDetalle->update([
                                'inspeccion_estado' => 'rechazado',
                                'updated_by' => $this->actorId(),
                            ]);
                        }
                    }
                } else {
                    $showStartObserved = true;
                    $limitLabel = $limitDate?->format('d/m/Y') ?? 'sin fecha limite';
                    $descripcion = 'El equipo se encuentra observado. Fecha limite para subsanar: ' . $limitLabel . '.';
                }
            } elseif ($estado === 'aprobado') {
                $expireDate = $lastCert?->fecha_vencimiento ? Carbon::parse($lastCert->fecha_vencimiento)->endOfDay() : null;
                if ($expireDate && $expireDate->isPast()) {
                    $showCreate = true;
                    $descripcion = 'El certificado vencio el ' . $expireDate->format('d/m/Y') . '. Puedes crear una nueva inspeccion.';
                } elseif ($expireDate) {
                    $descripcion = 'El certificado de inspeccion se encuentra vigente hasta ' . $expireDate->format('d/m/Y') . '.';
                } else {
                    $showCreate = false;
                    $descripcion = 'La inspeccion fue finalizada sin observaciones, pero aun no se ha generado el certificado.';
                }
            } elseif ($estado === 'rechazado') {
                $showCreate = true;
                $descripcion = 'La inspeccion fue rechazada por vencimiento de subsanacion. Debes crear una nueva inspeccion.';
            } else {
                $descripcion = 'Puedes visualizar la ultima inspeccion registrada.';
            }

            $this->quickSummary = [
                'estado' => $estado,
                'descripcion' => $descripcion,
                'inspeccion_numero' => $lastDetailNumber,
                'show_create' => $showCreate,
                'show_continue' => $showContinue,
                'show_view' => $showView,
                'show_start_observed' => $showStartObserved,
                'started' => $started,
                'inspection_finalized' => $inspectionFinalized,
            ];
        }

        $this->inspectionHistory = Inspeccion::query()
            ->with([
                'certificados' => fn ($q) => $q->where('anulado', 0)->orderByDesc('fecha_vencimiento'),
                'ultimoDetalle',
            ])
            ->where('empresa_equipo_id', $this->selectedEmpresaEquipoId)
            ->latest('id')
            ->limit(10)
            ->get()
            ->map(function (Inspeccion $item) {
                $cert = $item->certificados->first();
                return [
                    'id' => (int) $item->id,
                    'codigo' => (string) ($item->codigo_formateado ?: 'Sin codigo'),
                    'fecha' => $item->fecha_ingreso ? $item->fecha_ingreso->format('d/m/Y') : ($item->created_at?->format('d/m/Y') ?: '-'),
                    'estado' => (string) $item->estado_inspeccion,
                    'vencimiento' => $cert?->fecha_vencimiento ? Carbon::parse($cert->fecha_vencimiento)->format('d/m/Y') : 'Sin certificado',
                ];
            })
            ->all();

        $latestDetalleId = $latest?->ultimoDetalle?->id;
        $this->currentInspeccionId = $latest ? (int) $latest->id : null;
        $this->currentDetalleInspeccionId = $latestDetalleId ? (int) $latestDetalleId : null;
        if ($latestDetalleId) {
            $this->loadQuestionnaireForDetalle((int) $latestDetalleId);
        } else {
            $this->loadQuestionnaireForDetalle(null);
        }
        $this->loadInspectionFiles($this->currentInspeccionId);
        $this->refreshCertificateState();

        $this->dispatch(
            'inspection-state',
            started: (bool) ($this->quickSummary['started'] ?? false),
            inspectionFinalized: (bool) ($this->quickSummary['inspection_finalized'] ?? false)
        );
    }
}









