@extends('layouts.app')

@section('content')
    <h1>Editar Vigência PGM</h1>
    <form action="{{ route('vigencia_pgm.update', $vigencia_pgm) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Descrição:</label>
        <input type="text" name="descricao" value="{{ $vigencia_pgm->descricao }}" required>
        <label>Data Início:</label>
        <input type="date" name="data_inicio" value="{{ $vigencia_pgm->data_inicio }}" required>
        <label>Data Fim:</label>
        <input type="date" name="data_fim" value="{{ $vigencia_pgm->data_fim }}" required>
        <label>Ativo:</label>
        <select name="ativo" required>
            <option value="1" @if ($vigencia_pgm->ativo) selected @endif>Sim</option>
            <option value="0" @if (!$vigencia_pgm->ativo) selected @endif>Não</option>
        </select>
        <button type="submit">Atualizar</button>
    </form>
@endsection
