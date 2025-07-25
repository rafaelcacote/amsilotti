<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage settings');
    }

    public function test()
    {
        return response()->json([
            'message' => 'Middleware de permissão está funcionando!',
            'user' => auth()->user()->name ?? 'Usuário não autenticado',
            'permissions' => auth()->user() ? auth()->user()->getAllPermissions()->pluck('name') : []
        ]);
    }
}
