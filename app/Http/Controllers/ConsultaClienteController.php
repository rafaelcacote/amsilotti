<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Models\Bairro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsultaClienteController extends Controller
{
    public function __construct()
    {
        // Middleware para garantir que apenas usuários com role 'cliente_amostra' acessem
        $this->middleware(['auth', 'role:cliente_amostra']);
    }

    public function index()
    {
        $query = Imovel::with(['bairro', 'zona']);

        // Filtros
        if (request('bairro_id')) {
            $query->where('bairro_id', request('bairro_id'));
        }

        if (request('tipo')) {
            $query->where('tipo', request('tipo'));
        }

        if (request('area_min')) {
            $area_min = floatval(str_replace(',', '.', request('area_min')));
            $query->where(function ($q) use ($area_min) {
                $q->where(function ($subQ) use ($area_min) {
                    $subQ->where('tipo', 'terreno')
                         ->where('area_total', '>=', $area_min);
                })->orWhere(function ($subQ) use ($area_min) {
                    $subQ->whereIn('tipo', ['apartamento', 'imovel_urbano', 'galpao', 'sala_comercial'])
                         ->where('area_construida', '>=', $area_min);
                });
            });
        }

        if (request('area_max')) {
            $area_max = floatval(str_replace(',', '.', request('area_max')));
            $query->where(function ($q) use ($area_max) {
                $q->where(function ($subQ) use ($area_max) {
                    $subQ->where('tipo', 'terreno')
                         ->where('area_total', '<=', $area_max);
                })->orWhere(function ($subQ) use ($area_max) {
                    $subQ->whereIn('tipo', ['apartamento', 'imovel_urbano', 'galpao', 'sala_comercial'])
                         ->where('area_construida', '<=', $area_max);
                });
            });
        }

        $imoveis = $query->orderBy('created_at', 'desc')->paginate(15);
        $bairros = Bairro::orderBy('nome')->get();

        // Busca os itens que já estão no carrinho do usuário
        $itensNoCarrinho = collect();
        if (Auth::check()) {
            $itensNoCarrinho = DB::table('carrinho')
                ->where('usuario_id', Auth::id())
                ->pluck('imovel_id');
        }

        return view('consulta_cliente.index', compact('imoveis', 'bairros', 'itensNoCarrinho'));
    }

    public function show(Imovel $imovel)
    {
        $imovel->load(['bairro', 'zona', 'viaEspecifica', 'fotos']);
        
        // Verifica se o item já está no carrinho do usuário
        $itemNoCarrinho = false;
        if (Auth::check()) {
            $itemNoCarrinho = DB::table('carrinho')
                ->where('usuario_id', Auth::id())
                ->where('imovel_id', $imovel->id)
                ->exists();
        }
        
        return view('consulta_cliente.show', compact('imovel', 'itemNoCarrinho'));
    }
}
