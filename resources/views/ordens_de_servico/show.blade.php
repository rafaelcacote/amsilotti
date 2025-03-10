@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Detalhes da Ordem de Serviço
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Descrição:</label>
                            <p>{{ $ordemDeServico->descricao }}</p>
                        </div>
                        <div class="form-group">
                            <label>Usuário:</label>
                            <p>{{ $ordemDeServico->user->name }}</p>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <p>{{ $ordemDeServico->status }}</p>
                        </div>
                        <a href="{{ route('ordens-de-servico.index') }}" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection