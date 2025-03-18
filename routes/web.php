<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('users', \App\Http\Controllers\UserController::class)->middleware('auth');
Route::resource('ordens-de-servico', \App\Http\Controllers\OrdemDeServicoController::class)->parameters(['ordens-de-servico' => 'ordemDeServico'])->middleware('auth');

Route::resource('zonas', \App\Http\Controllers\ZonaController::class)->middleware('auth');

Route::resource('bairros', \App\Http\Controllers\BairroController::class)->middleware('auth');
Route::get('/bairro/{id}', [\App\Http\Controllers\BairroController::class, 'getBairroData'])->name('getBairroData')->middleware('auth');
//Route::get('/bairro/{id}', [BairroController::class, 'getBairroData']);
Route::resource('valores-bairros', \App\Http\Controllers\ValorBairroController::class)->parameters(['valores-bairros' => 'valorBairro'])->middleware('auth');

Route::resource('vistorias', \App\Http\Controllers\VistoriaController::class)->middleware('auth');
Route::delete('vistorias/fotos/{id}', [\App\Http\Controllers\VistoriaController::class, 'deleteFoto'])->name('vistorias.delete-foto')->middleware('auth');

Route::resource('membro-equipe-tecnicas', \App\Http\Controllers\MembroEquipeTecnicaController::class)->parameters(['membro-equipe-tecnicas' => 'membroEquipeTecnica'])->middleware('auth');

Route::resource('imoveis', \App\Http\Controllers\ImovelController::class)->parameters(['imoveis' => 'imovel'])->middleware('auth');
Route::get('/gerar-pdf/{id}', [\App\Http\Controllers\ImovelController::class, 'gerarPdf'])->middleware('auth')->name('gerar.pdf');

Route::resource('clientes', \App\Http\Controllers\ClienteController::class)->middleware('auth');

Route::resource('controle_de_tarefas', \App\Http\Controllers\ControleDeTarefasController::class)
    ->parameters(['controle_de_tarefas' => 'controleDeTarefas'])
    ->middleware('auth');

require __DIR__ . '/auth.php';
