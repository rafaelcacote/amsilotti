<?php
namespace App\Http\Controllers;

use App\Models\ValoresPgm;
use App\Models\Bairro;
use App\Models\VigenciaPgm;
use Illuminate\Http\Request;

class ValoresPgmController extends Controller
{
    public function index()
    {
        $valores = ValoresPgm::with(['bairro', 'vigencia'])->get();
        return view('valores_pgm.index', compact('valores'));
    }

    public function create()
    {
        $bairros = Bairro::all();
        $vigencias = VigenciaPgm::all();
        return view('valores_pgm.create', compact('bairros', 'vigencias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bairro_id' => 'required|exists:bairros,id',
            'vigencia_id' => 'required|exists:vigencia_pgm,id',
            'valor' => 'required|numeric',
        ]);
        ValoresPgm::create($request->all());
        return redirect()->route('valores_pgm.index');
    }

    public function edit(ValoresPgm $valores_pgm)
    {
        $bairros = Bairro::all();
        $vigencias = VigenciaPgm::all();
        return view('valores_pgm.edit', compact('valores_pgm', 'bairros', 'vigencias'));
    }

    public function update(Request $request, ValoresPgm $valores_pgm)
    {
        $request->validate([
            'bairro_id' => 'required|exists:bairros,id',
            'vigencia_id' => 'required|exists:vigencia_pgm,id',
            'valor' => 'required|numeric',
        ]);
        $valores_pgm->update($request->all());
        return redirect()->route('valores_pgm.index');
    }

    public function destroy(ValoresPgm $valores_pgm)
    {
        $valores_pgm->delete();
        return redirect()->route('valores_pgm.index');
    }

        // Método show para evitar erro de rota resource
        public function show(ValoresPgm $valores_pgm)
        {
            // Você pode customizar a visualização se desejar
            return redirect()->route('valores_pgm.index');
        }

        // Exibe o formulário de upload em massa
        public function upload()
        {
            return view('valores_pgm.upload');
        }

        // Processa o upload em massa
        public function storeUpload(Request $request)
        {
            $request->validate([
                'descricao' => 'required',
                'data_inicio' => 'required|date',
                'data_fim' => 'required|date',
                'ativo' => 'required|boolean',
                'dados' => 'required|string',
            ]);

            // Cria a vigência
            $vigencia = VigenciaPgm::create([
                'descricao' => $request->descricao,
                'data_inicio' => $request->data_inicio,
                'data_fim' => $request->data_fim,
                'ativo' => $request->ativo,
            ]);

            $linhas = preg_split('/\r?\n/', $request->dados);
            foreach ($linhas as $linha) {
                $linha = trim($linha);
                if (empty($linha)) continue;
                // Aceita tabulação ou múltiplos espaços
                $partes = preg_split('/\t|\s{2,}|\s(?=\S*\s)/', $linha);
                if (count($partes) < 3) continue;
                $zonaNome = trim($partes[0]);
                $bairroNome = trim($partes[1]);
                $valor = str_replace(',', '.', trim($partes[2]));

                // Busca ou cria zona
                $zona = \App\Models\Zona::firstOrCreate(['nome' => $zonaNome]);
                // Busca ou cria bairro
                $bairro = \App\Models\Bairro::firstOrCreate([
                    'nome' => $bairroNome,
                    'zona_id' => $zona->id
                ]);

                // Cria valor
                ValoresPgm::create([
                    'bairro_id' => $bairro->id,
                    'vigencia_id' => $vigencia->id,
                    'valor' => floatval($valor),
                ]);
            }

            return redirect()->route('valores_pgm.index')->with('success', 'Upload realizado com sucesso!');
        }
}
