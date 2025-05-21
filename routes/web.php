<?php

use App\Livewire\Admin\EquiposLive;
use App\Livewire\Admin\InformacionLive;
use App\Livewire\Admin\SoportesLive;
use App\Livewire\Admin\UsuariosLive;
use App\Livewire\Support\InformeLive;
use App\Livewire\Support\SolicitudesLive;
use App\Livewire\User\InformacionLive as UserInformacionLive;
use App\Livewire\User\SoportesLive as UserSoportesLive;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/equipos', [EquiposLive::class, 'render'])->name('equipos');
    Route::get('/soportes', [SoportesLive::class, 'render'])->name('soportes');
    Route::get('/informacion', [InformacionLive::class, 'render'])->name('informacion');
    Route::get('/usuarios', [UsuariosLive::class, 'render'])->name('usuarios');

    Route::get('/solicitudes', [SolicitudesLive::class, 'render'])->name('solicitudes');
    Route::get('/informe', [InformeLive::class, 'render'])->name('informe');

    Route::get('/soportes-crear', [UserSoportesLive::class, 'render'])->name('soportes.user');
    Route::get('/informacion-user', [UserInformacionLive::class, 'render'])->name('informacion.user');

    Route::get('/inventarios', function () {
        return \App\Models\Inventario::all();
    });
});
