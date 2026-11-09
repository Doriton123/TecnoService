<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\EstadoSolicitudController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DashboardController;

// Página de bienvenida
Route::get('/', function () {
    return redirect()->route(
        auth()->check() ? 'dashboard' : 'login'
    );
});

// Rutas para usuarios autenticados
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [
        DashboardController::class,
        'index'
    ])->middleware('role:Administrador|Tecnico')
        ->name('dashboard');

    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // ========================================
    // RUTAS EXCLUSIVAS DEL ADMINISTRADOR
    // ========================================

    Route::middleware('role:Administrador')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Clientes
            Route::resource('clientes', ClienteController::class)
                ->except(['destroy']);

            // Equipos
            Route::resource('equipos', EquipoController::class)
                ->except(['destroy']);

            // Crear solicitud
            Route::get('solicitudes/crear', [
                SolicitudController::class,
                'create'
            ])->name('solicitudes.create');

            // Guardar solicitud
            Route::post('solicitudes', [
                SolicitudController::class,
                'store'
            ])->name('solicitudes.store');

            // Editar solicitud
            Route::get('solicitudes/{solicitud}/editar', [
                SolicitudController::class,
                'edit'
            ])->name('solicitudes.edit');

            // Actualizar solicitud
            Route::put('solicitudes/{solicitud}', [
                SolicitudController::class,
                'update'
            ])->name('solicitudes.update');

            // Usuarios
            Route::resource('usuarios', UsuarioController::class)
                ->only(['index', 'create', 'store', 'edit', 'update']);

            //Reportes
            Route::get('reportes', [
                ReporteController::class,
                'index'
            ])->name('reportes.index');

            Route::get('reportes/pdf', [
                ReporteController::class,
                'pdf'
            ])->name('reportes.pdf');

        });


    // ========================================
    // ADMINISTRADOR Y TÉCNICO
    // ========================================

    Route::middleware('role:Administrador|Tecnico')
        ->group(function () {

            // Listar solicitudes
            Route::get('solicitudes', [
                SolicitudController::class,
                'index'
            ])->name('solicitudes.index');

            // Consultar solicitud
            Route::get('solicitudes/{solicitud}', [
                SolicitudController::class,
                'show'
            ])->name('solicitudes.show');

            // Cambiar estado
            Route::patch('solicitudes/{solicitud}/estado', [
                EstadoSolicitudController::class,
                'update'
            ])->name('solicitudes.estado');

        });

});

// Autenticación de Breeze
require __DIR__ . '/auth.php';
