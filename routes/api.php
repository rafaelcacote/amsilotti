<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BairroController;

Route::get('/bairros', [BairroController::class, 'index']);