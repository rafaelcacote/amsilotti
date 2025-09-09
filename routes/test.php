<?php

use Illuminate\Support\Facades\Route;

Route::get('/test-tarefas', function () {
    return response()->json(['message' => 'Rota funcionando', 'data' => []]);
});
