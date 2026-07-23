<?php

use App\Http\Controllers\Admin\ConfiguracionVentaController;
use App\Http\Controllers\Admin\PlanVentaController;
use App\Http\Controllers\Admin\ServidorController;
use App\Http\Controllers\Admin\VentaController;
use App\Http\Controllers\Admin\VentasPanelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Route;

// Landing comercial (home del subdominio).
Route::get('/', ServicioController::class)->name('servicio');

// Acceso al panel de administracion.
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

// Panel de administracion: precios de venta, ventas y servidores.
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', VentasPanelController::class)->name('dashboard');

    Route::get('/configuracion', [ConfiguracionVentaController::class, 'edit'])->name('configuracion.edit');
    Route::put('/configuracion', [ConfiguracionVentaController::class, 'update'])->name('configuracion.update');

    Route::get('/planes', [PlanVentaController::class, 'index'])->name('planes.index');
    Route::get('/planes/nuevo', [PlanVentaController::class, 'create'])->name('planes.create');
    Route::post('/planes', [PlanVentaController::class, 'store'])->name('planes.store');
    Route::get('/planes/{plan}/editar', [PlanVentaController::class, 'edit'])->name('planes.edit');
    Route::put('/planes/{plan}', [PlanVentaController::class, 'update'])->name('planes.update');
    Route::delete('/planes/{plan}', [PlanVentaController::class, 'destroy'])->name('planes.destroy');

    Route::get('/servidores', [ServidorController::class, 'index'])->name('servidores.index');
    Route::get('/servidores/nuevo', [ServidorController::class, 'create'])->name('servidores.create');
    Route::post('/servidores', [ServidorController::class, 'store'])->name('servidores.store');
    Route::get('/servidores/{servidor}/editar', [ServidorController::class, 'edit'])->name('servidores.edit');
    Route::put('/servidores/{servidor}', [ServidorController::class, 'update'])->name('servidores.update');
    Route::delete('/servidores/{servidor}', [ServidorController::class, 'destroy'])->name('servidores.destroy');

    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/nueva', [VentaController::class, 'create'])->name('ventas.create');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{venta}/editar', [VentaController::class, 'edit'])->name('ventas.edit');
    Route::put('/ventas/{venta}', [VentaController::class, 'update'])->name('ventas.update');
    Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])->name('ventas.destroy');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
