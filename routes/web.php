<?php

use App\Models\Inspeccion;
use Illuminate\Support\Facades\Route;
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
