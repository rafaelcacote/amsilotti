<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('ordens-de-servico', \App\Http\Controllers\OrdemDeServicoController::class)->parameters(['ordens-de-servico' => 'ordemDeServico'])->middleware('auth');

Route::resource('zonas', \App\Http\Controllers\ZonaController::class)->middleware('auth');

Route::resource('bairros', \App\Http\Controllers\BairroController::class)->middleware('auth');

Route::resource('valores-bairros', \App\Http\Controllers\ValorBairroController::class)->parameters(['valores-bairros' => 'valorBairro'])->middleware('auth');

Route::resource('vistorias', \App\Http\Controllers\VistoriaController::class)->middleware('auth');
Route::delete('vistorias/fotos/{id}', [\App\Http\Controllers\VistoriaController::class, 'deleteFoto'])->name('vistorias.delete-foto')->middleware('auth');

Route::resource('membro-equipe-tecnicas', \App\Http\Controllers\MembroEquipeTecnicaController::class)->parameters(['membro-equipe-tecnicas' => 'membroEquipeTecnica'])->middleware('auth');

require __DIR__ . '/auth.php';
