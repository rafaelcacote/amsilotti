<?php
use Illuminate\Support\Facades\Route;

Route::post('vigencia_pgm/switch/{vigencia}', [App\Http\Controllers\VigenciaPgmController::class, 'switchStatus'])->name('vigencia_pgm.switch');
