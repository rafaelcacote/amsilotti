<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ControleDeTarefas;
use App\Models\Vistoria;
use App\Models\Imovel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Obtém o usuário logado
        $user = Auth::user();

        // Obtém as tarefas do usuário logado
        $tarefas = ControleDeTarefas::whereHas('membroEquipe', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();


        $tarefasEmAndamento = ControleDeTarefas::whereHas('membroEquipe', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'em_andamento')->count();

        $quantidadeVistorias = Vistoria::count();

        $quantidadeImoveis = Imovel::count();



        // Passa as tarefas para a view
        return view('dashboard', compact('tarefas', 'tarefasEmAndamento', 'quantidadeVistorias', 'quantidadeImoveis'));
    }
}
