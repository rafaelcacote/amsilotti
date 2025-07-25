<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CarrinhoController extends Controller
{
    public function index()
    {
        $usuarioId = Auth::id();
        $itens = DB::table('carrinho')
            ->join('imoveis', 'carrinho.imovel_id', '=', 'imoveis.id')
            ->leftJoin('bairros', 'imoveis.bairro_id', '=', 'bairros.id')
            ->where('carrinho.usuario_id', $usuarioId)
            ->select(
                'carrinho.*', 
                'imoveis.preco_venda_amostra', 
                'imoveis.tipo', 
                'imoveis.area_total',
                'imoveis.area_construida',
                'bairros.nome as bairro_nome'
            )
            ->get();
            
        $valorTotal = $itens->sum(function($item) {
            return $item->preco_venda_amostra * $item->quantidade;
        });
        
        return view('carrinho.index', compact('itens', 'valorTotal'));
    }

    public function adicionar(Request $request)
    {
        try {
            $usuarioId = Auth::id();
            $amostraId = $request->input('amostra_id');
            $quantidade = $request->input('quantidade', 1);

            // Verifica se o usuário tem a role cliente_amostra
            if (!Auth::user()->hasRole('cliente_amostra')) {
                \Log::warning('Usuário sem permissão tentou adicionar ao carrinho', ['usuario_id' => $usuarioId]);
                return response()->json(['success' => false, 'message' => 'Usuário sem permissão']);
            }

            // Log para debug
            \Log::info('Tentando adicionar ao carrinho', [
                'usuario_id' => $usuarioId,
                'amostra_id' => $amostraId,
                'quantidade' => $quantidade
            ]);

            // Verifica se o imóvel existe e tem preço de amostra
            $imovel = DB::table('imoveis')
                ->where('id', $amostraId)
                ->where('preco_venda_amostra', '>', 0)
                ->first();
                
            if (!$imovel) {
                \Log::warning('Amostra não encontrada ou sem preço', ['amostra_id' => $amostraId]);
                return response()->json(['success' => false, 'message' => 'Amostra não disponível']);
            }

            $item = DB::table('carrinho')
                ->where('usuario_id', $usuarioId)
                ->where('imovel_id', $amostraId)
                ->first();

            if ($item) {
                DB::table('carrinho')
                    ->where('id', $item->id)
                    ->update(['quantidade' => $item->quantidade + $quantidade]);
                \Log::info('Item atualizado no carrinho', ['item_id' => $item->id]);
            } else {
                $id = DB::table('carrinho')->insertGetId([
                    'usuario_id' => $usuarioId,
                    'imovel_id' => $amostraId,
                    'quantidade' => $quantidade,
                    'adicionado_em' => now(),
                ]);
                \Log::info('Novo item adicionado ao carrinho', ['item_id' => $id]);
            }
            
            // Retorna a quantidade total de itens no carrinho
            $totalItens = DB::table('carrinho')
                ->where('usuario_id', $usuarioId)
                ->sum('quantidade');
            
            return response()->json([
                'success' => true, 
                'message' => 'Amostra adicionada ao carrinho',
                'total_itens' => $totalItens
            ]);
        } catch (\Exception $e) {
            \Log::error('Erro ao adicionar ao carrinho', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Erro interno do servidor']);
        }
    }

    public function remover(Request $request)
    {
        $usuarioId = Auth::id();
        $itemId = $request->input('item_id');

        DB::table('carrinho')
            ->where('id', $itemId)
            ->where('usuario_id', $usuarioId)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Item removido do carrinho']);
    }

    public function contador()
    {
        $usuarioId = Auth::id();
        $totalItens = DB::table('carrinho')
            ->where('usuario_id', $usuarioId)
            ->sum('quantidade');
            
        return response()->json(['total_itens' => $totalItens]);
    }
}
