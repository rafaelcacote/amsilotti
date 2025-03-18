<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bairro;
use Illuminate\Http\Request;

class BairroController extends Controller
{
    public function index(Request $request)
    {
        $bairros = Bairro::when($request->zona_id, function ($query) use ($request) {
            return $query->where('zona_id', $request->zona_id);
        })->get();

        return response()->json($bairros);
    }
}