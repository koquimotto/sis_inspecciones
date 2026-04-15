<?php

use App\Models\Inspeccion;
use App\Models\DetalleInspeccion;
use App\Services\InspeccionService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
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
