@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Editar Imóvel</h1>
    <form action="{{ route('imovel.update', $imovel->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" value="{{ $imovel->endereco }}" required>
        </div>
        <div class="form-group">
            <label for="bairro_id">Bairro</label>
            <select class="form-control" id="bairro_id" name="bairro_id" required>
                @foreach($bairros as $bairro)
                    <option value="{{ $bairro->id }}" {{ $bairro->id == $imovel->bairro_id ? 'selected' : '' }}>{{ $bairro->nome }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="valor_estimado">Valor Estimado</label>
            <input type="number" step="0.01" class="form-control" id="valor_estimado" name="valor_estimado" value="{{ $imovel->valor_estimado }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection