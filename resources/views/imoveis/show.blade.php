@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Detalhes do Imóvel</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $imovel->endereco }}</h5>
            <p class="card-text">
                <strong>Bairro:</strong> {{ $imovel->bairro->nome }}<br>
                <strong>Valor Estimado:</strong> R$ {{ number_format($imovel->valor_estimado, 2, ',', '.') }}
            </p>
            <a href="{{ route('imovel.edit', $imovel->id) }}" class="btn btn-warning">Editar</a>
            <form action="{{ route('imovel.destroy', $imovel->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Excluir</button>
            </form>
        </div>
    </div>
</div>
@endsection