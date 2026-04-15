<?php

use App\Models\Inspeccion;
use App\Models\DetalleInspeccion;
use App\Services\InspeccionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CursoController;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->to('/login');
});

Route::get('/home', function () {
    return view('livewire.dashboard.index');
})->middleware(['auth'])->name('dashboard');

// Gestión de usuarios
Route::prefix('usuarios')->name('usuarios.')->group(function () {

    // Vista (Index)
    Route::get('/', function () {
        return view('livewire.usuarios.index');
    })->name('index'); // ✅ admin.usuarios.index

    // // DataTables (server-side)
    // Route::get('/data', [UsuarioController::class, 'data'])->name('data'); // admin.usuarios.data

    // Route::get('/persona/{dni}', [UsuarioController::class, 'buscarPersonaPorDni'])
    //     ->where('dni', '[0-9]{8}')
    //     ->name('persona');

    // // CRUD (modal)
    // Route::post('/', [UsuarioController::class, 'store'])->name('store'); // admin.usuarios.store
    // Route::get('/{user}', [UsuarioController::class, 'show'])->name('show'); // admin.usuarios.show
    // Route::put('/{user}', [UsuarioController::class, 'update'])->name('update'); // admin.usuarios.update
    // Route::patch('/{user}/toggle-estado', [UsuarioController::class, 'toggleEstado'])->name('toggle'); // admin.usuarios.toggle
});

// Gestión de certificados
Route::prefix('certificados')->name('certificados.')->group(function () {

    Route::get('/', function () {
        return view('livewire.certificados.index');
    })->name('index');

});

// Gestión de empresas
Route::prefix('empresas')->name('empresas.')->group(function () {

    Route::get('/', function () {
        return view('livewire.empresas.index');
    })->name('index');

});

// Gestión de equipos
Route::prefix('equipos')->name('equipos.')->group(function () {

    Route::get('/', function () {
        return view('livewire.equipos.index');
    })->name('index');

});

// Gestión de inspecciones
Route::prefix('inspecciones')->name('inspecciones.')->group(function () {

    Route::get('/', function () {
        return view('livewire.inspecciones.index');
    })->name('index');

    Route::get('/nueva', function () {
        return view('livewire.inspecciones.form', [
            'inspeccion' => null,
        ]);
    })->name('create');

    Route::get('/catalogos', function () {
        return view('livewire.inspecciones.catalogos');
    })->name('catalogos');

    Route::get('/{inspeccion}/certificado/pdf', function (Inspeccion $inspeccion, InspeccionService $service) {
        $relative = $service->getGeneratedCertificatePath($inspeccion);
        abort_unless($relative, 404, 'No hay certificado generado para esta inspeccion.');

        $absolute = public_path($relative);
        abort_unless(File::exists($absolute), 404, 'El archivo de certificado no existe en almacenamiento.');

        return response()->file($absolute, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="certificado-' . ((string) ($inspeccion->codigo_formateado ?: $inspeccion->id)) . '.pdf"',
        ]);
    })->name('pdf.certificado');

    Route::get('/{inspeccion}/detalles/{detalle}/informe/pdf', function (Inspeccion $inspeccion, DetalleInspeccion $detalle, InspeccionService $service) {
        abort_unless((int) $detalle->inspeccion_id === (int) $inspeccion->id, 404, 'El detalle no pertenece a la inspeccion.');

        $relative = $service->getGeneratedDetailReportPath($inspeccion, $detalle);
        abort_unless($relative, 404, 'No hay informe generado para este detalle.');

        $absolute = public_path($relative);
        abort_unless(File::exists($absolute), 404, 'El archivo de informe no existe en almacenamiento.');

        return response()->file($absolute, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="informe-' . ((string) ($inspeccion->codigo_formateado ?: $inspeccion->id)) . '-detalle-' . ((int) $detalle->id) . '.pdf"',
        ]);
    })->name('pdf.informe');

    Route::get('/pruebas/pdf/certificado', function (Request $request) {
        $inspeccion = (object) [
            'id' => 999,
            'codigo_formateado' => '26-0001-XXX-069',
            'servicio' => (object) ['descripcion' => 'INSPECCION GENERAL'],
        ];

        $detalle = (object) [
            'id' => 1,
            'inspeccion_estado' => 'aprobado',
        ];

        $empresa = (object) [
            'razon_social' => 'EMPRESA DEMO S.A.C.',
            'ruc' => '20123456789',
        ];

        $equipo = (object) [
            'descripcion' => 'Equipo de elevacion DEMO',
        ];

        $empresaEquipo = (object) [
            'descripcion' => 'Unidad DEMO',
            'serie_codigo' => 'ABC-123',
        ];

        $uploadsRoot = public_path('uploads');
        $demoImages = collect(File::exists($uploadsRoot) ? File::allFiles($uploadsRoot) : [])
            ->filter(fn ($file) => in_array(strtolower((string) $file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'], true))
            ->take(24)
            ->map(function ($file, $idx) {
                $raw = @file_get_contents($file->getPathname());
                if ($raw === false) {
                    return null;
                }

                $mime = File::mimeType($file->getPathname()) ?: 'image/jpeg';
                return [
                    'title' => 'EVIDENCIA ' . ((int) $idx + 1),
                    'src' => 'data:' . $mime . ';base64,' . base64_encode($raw),
                ];
            })
            ->filter()
            ->values()
            ->all();

        $showObservationDemo = $request->boolean('mostrar_observaciones', true);
        $observationDemoItems = $showObservationDemo ? [
            ['descripcion' => 'No cuenta con jabon liquido', 'estado' => 'Observacion levantada (subsanada)'],
            ['descripcion' => 'Cambio de posicion del extintor', 'estado' => 'Observacion levantada (subsanada)'],
            ['descripcion' => 'Placa posterior suelta', 'estado' => 'Observacion levantada (subsanada)'],
        ] : [];

        $pdf = Pdf::loadView('pdf.certificado-inspeccion', [
            'inspeccion' => $inspeccion,
            'detalle' => $detalle,
            'empresa' => $empresa,
            'equipo' => $equipo,
            'empresaEquipo' => $empresaEquipo,
            'observedParametersCount' => 0,
            'selectedFilesCount' => 2,
            'imagePages' => $demoImages,
            //'imagePages' => array_chunk($demoImages, 24),
            'pdfPages' => [],
            'nonImageAttachments' => [],
            'hasPenultimateObservationSection' => $showObservationDemo,
            'penultimateObservationItems' => $observationDemoItems,
        ])->setPaper('a4');

        return $pdf->stream('preview-certificado.pdf');
    })->name('pdf.pruebas.certificado');

    Route::get('/pruebas/pdf/resumen-inspeccion', function () {
        $inspeccion = (object) [
            'id' => 999,
            'codigo_formateado' => '26-0001-XXX-069',
            'empresaEquipo' => (object) [
                'descripcion' => 'Unidad DEMO',
                'serie_codigo' => 'ABC-123',
            ],
        ];

        $detalle = (object) [
            'id' => 1,
            'inespeccion_numero' => 1,
            'inspeccion_fecha' => now(),
            'inspeccion_estado' => 'en_inspeccion',
            'inspeccion_observaciones' => 'Observaciones de prueba para revisar estilos del PDF.',
        ];

        $empresa = (object) [
            'razon_social' => 'EMPRESA DEMO S.A.C.',
        ];

        $equipo = (object) [
            'descripcion' => 'Equipo de elevacion DEMO',
        ];

        $pdf = Pdf::loadView('pdf.informe-detallado-inspeccion', [
            'inspeccion' => $inspeccion,
            'detalle' => $detalle,
            'empresa' => $empresa,
            'equipo' => $equipo,
        ])->setPaper('a4');

        return $pdf->stream('preview-resumen-inspeccion.pdf');
    })->name('pdf.pruebas.resumen');

    Route::get('/{inspeccion}', function (Inspeccion $inspeccion) {
        return view('livewire.inspecciones.form', [
            'inspeccion' => $inspeccion,
        ]);
    })->name('edit');

});

// Gestión de observaciones
Route::prefix('observaciones')->name('observaciones.')->group(function () {

    Route::get('/', function () {
        return view('livewire.observaciones.index');
    })->name('index');

});

// Gestión de personas
Route::prefix('personas')->name('personas.')->group(function () {

    Route::get('/', function () {
        return view('livewire.personas.index');
    })->name('index');

});

// Gestión de marcas
Route::prefix('marcas')->name('marcas.')->group(function () {

    Route::get('/', function () {
        return view('livewire.marcas.index');
    })->name('index');

});

// Gestión de categorias
Route::prefix('categorias')->name('categorias.')->group(function () {

    Route::get('/', function () {
        return view('livewire.categorias.index');
    })->name('index');

});

// Gestión de modelos
Route::prefix('modelos')->name('modelos.')->group(function () {

    Route::get('/', function () {
        return view('livewire.modelos.index');
    })->name('index');

});

// Gestión de tipos
Route::prefix('tipos')->name('tipos.')->group(function () {

    Route::get('/', function () {
        return view('livewire.tipos.index');
    })->name('index');

});

// Gestión de servicios
Route::prefix('servicios')->name('servicios.')->group(function () {

    Route::get('/', function () {
        return view('livewire.servicios.index');
    })->name('index');

});




// Gestión de interfaces
Route::prefix('pages')->name('pages.')->group(function () {

    Route::prefix('/inspections')->name('pages.inspections.')->group(function () {

        Route::get('/', function () {
            return view('livewire.pages.inspections.index');
        })->name('index');
    
    });
    
    Route::prefix('/items')->name('pages.items.')->group(function () {

        Route::get('/', function () {
            return view('livewire.pages.items.index');
        })->name('index');
    
    });
});