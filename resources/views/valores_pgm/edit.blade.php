@extends('layouts.app')

@section('content')
    <h1>Editar Valor PGM</h1>
    <form action="{{ route('valores_pgm.update', $valores_pgm) }}" method="POST">
        @csrf
        @method('PUT')
        <label>Bairro:</label>
        <select name="bairro_id" required>
            @foreach ($bairros as $bairro)
                <option value="{{ $bairro->id }}" @if ($valores_pgm->bairro_id == $bairro->id) selected @endif>{{ $bairro->nome }}
                </option>
            @endforeach
        </select>
        <label>Vigência:</label>
        <select name="vigencia_id" required>
            @foreach ($vigencias as $vigencia)
                <option value="{{ $vigencia->id }}" @if ($valores_pgm->vigencia_id == $vigencia->id) selected @endif>
                    {{ $vigencia->descricao }}</option>
            @endforeach
        </select>
        <label>Valor:</label>
        <input type="number" name="valor" value="{{ $valores_pgm->valor }}" step="0.01" required>
        <button type="submit">Atualizar</button>
    </form>
@endsection
