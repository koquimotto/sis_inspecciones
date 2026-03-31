<?php

namespace App\Livewire\Inspecciones;

use App\Models\Empresa;
use App\Models\Inspeccion;
use App\Models\Servicio;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Bandeja extends Component
{
    use WithPagination;

    public string $estadoFiltro = '';
    public string $empresaFiltro = '';
    public string $equipoFiltro = '';
    public string $servicioFiltro = '';
    public string $fechaDesde = '';
    public string $fechaHasta = '';
    public string $texto = '';
    public string $search = '';

    protected $queryString = [
        'estadoFiltro' => ['except' => ''],
        'empresaFiltro' => ['except' => ''],
        'equipoFiltro' => ['except' => ''],
        'servicioFiltro' => ['except' => ''],
        'fechaDesde' => ['except' => ''],
        'fechaHasta' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    public function updating($name): void
    {
        if (in_array($name, [
            'estadoFiltro',
            'empresaFiltro',
            'equipoFiltro',
            'servicioFiltro',
            'fechaDesde',
            'fechaHasta',
            'search',
        ], true)) {
            $this->resetPage();
        }
    }

    public function buscar(): void
    {
        $this->search = trim($this->texto);
        $this->resetPage();
    }

    public function limpiarFiltros(): void
    {
        $this->reset([
            'estadoFiltro',
            'empresaFiltro',
            'equipoFiltro',
            'servicioFiltro',
            'fechaDesde',
            'fechaHasta',
            'texto',
            'search',
        ]);

        $this->resetPage();
    }

    public function getEstadoOptionsProperty(): array
    {
        return [
            'borrador' => 'Borrador',
            'en_inspeccion' => 'En inspeccion',
            'observado' => 'Pendiente de subsanar',
            'subsanacion' => 'En subsanacion',
            'aprobado' => 'Aprobado',
            'rechazado' => 'No subsanada',
            'anulado' => 'Anulado',
        ];
    }

    public function getCardsProperty(): array
    {
        $base = $this->baseQuery();

        return [
            [
                'label' => 'Inspecciones pendientes',
                'count' => (clone $base)->whereIn('estado_inspeccion', ['borrador', 'en_inspeccion'])->count(),
                'hint' => 'Borrador o en proceso de inspeccion',
                'style' => 'background: linear-gradient(135deg, #2563eb 0%, #0ea5e9 100%);',
            ],
            [
                'label' => 'Pendientes de subsanar',
                'count' => (clone $base)->whereIn('estado_inspeccion', ['observado', 'subsanacion'])->count(),
                'hint' => 'Requieren levantamiento de observaciones',
                'style' => 'background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);',
            ],
            [
                'label' => 'No subsanadas',
                'count' => (clone $base)->where('estado_inspeccion', 'rechazado')->count(),
                'hint' => 'Inspecciones cerradas sin subsanacion',
                'style' => 'background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);',
            ],
            [
                'label' => 'Certificados emitidos',
                'count' => (clone $base)->where('certificado_generado', true)->count(),
                'hint' => 'Inspecciones con certificado generado',
                'style' => 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);',
            ],
        ];
    }

    public function getEmpresasProperty()
    {
        return Empresa::query()
            ->where('estado', true)
            ->orderBy('razon_social')
            ->get(['id', 'razon_social', 'nombre_comercial']);
    }

    public function getServiciosProperty()
    {
        return Servicio::query()
            ->where('estado', true)
            ->orderBy('descripcion')
            ->get(['id', 'descripcion']);
    }

    public function getEquiposProperty()
    {
        return Inspeccion::query()
            ->select('empresa_equipos.id', 'empresa_equipos.descripcion', 'empresa_equipos.serie_codigo')
            ->join('empresa_equipos', 'empresa_equipos.id', '=', 'inspecciones.empresa_equipo_id')
            ->whereNull('inspecciones.deleted_at')
            ->whereNull('empresa_equipos.deleted_at')
            ->distinct()
            ->orderBy('empresa_equipos.descripcion')
            ->get();
    }

    public function render(): View
    {
        $inspecciones = $this->filteredQuery()
            ->paginate(12);

        return view('livewire.inspecciones.bandeja', [
            'cards' => $this->cards,
            'estadoOptions' => $this->estadoOptions,
            'empresas' => $this->empresas,
            'servicios' => $this->servicios,
            'equipos' => $this->equipos,
            'inspecciones' => $inspecciones,
        ]);
    }

    protected function baseQuery()
    {
        return Inspeccion::query()
            ->with([
                'empresaEquipo.empresa.contactoPrincipal.persona',
                'empresaEquipo.servicio',
                'empresaEquipo.equipo',
                'ultimoDetalle',
            ])
            ->where('estado', true);
    }

    protected function filteredQuery()
    {
        return $this->baseQuery()
            ->when($this->estadoFiltro !== '', fn ($query) => $query->where('estado_inspeccion', $this->estadoFiltro))
            ->when($this->empresaFiltro !== '', fn ($query) => $query->whereHas('empresaEquipo', fn ($sub) => $sub->where('empresa_id', $this->empresaFiltro)))
            ->when($this->equipoFiltro !== '', fn ($query) => $query->where('empresa_equipo_id', $this->equipoFiltro))
            ->when($this->servicioFiltro !== '', fn ($query) => $query->whereHas('empresaEquipo', fn ($sub) => $sub->where('servicio_id', $this->servicioFiltro)))
            ->when($this->fechaDesde !== '', fn ($query) => $query->whereDate('fecha_ingreso', '>=', $this->fechaDesde))
            ->when($this->fechaHasta !== '', fn ($query) => $query->whereDate('fecha_ingreso', '<=', $this->fechaHasta))
            ->when($this->search !== '', function ($query) {
                $text = $this->search;

                $query->whereHas('empresaEquipo', function ($sub) use ($text) {
                    $sub->where(function ($empresaEquipo) use ($text) {
                        $empresaEquipo
                            ->where('descripcion', 'like', '%' . $text . '%')
                            ->orWhere('serie_codigo', 'like', '%' . $text . '%');
                    });
                });
            })
            ->orderByDesc('fecha_ingreso')
            ->orderByDesc('id');
    }
}
