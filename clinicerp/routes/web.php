<?php

use App\Http\Controllers\AtendenteController;
use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\EspecialidadeController;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnidadeConsultorioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));
Route::get('/dashboard', fn () => view('dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('usuarios', UsuarioController::class)->except(['show']);
    Route::resource('atendentes', AtendenteController::class)->except(['show']);
    Route::resource('pacientes', PacienteController::class)->except(['show']);
    Route::resource('medicos', MedicoController::class)->except(['show']);
    Route::resource('especialidades', EspecialidadeController::class)->except(['show']);
    Route::resource('convenios', ConvenioController::class)->except(['show']);
    Route::resource('unidades-consultorios', UnidadeConsultorioController::class)->except(['show'])->parameters(['unidades-consultorios' => 'unidades_consultorio']);
});

require __DIR__.'/auth.php';
