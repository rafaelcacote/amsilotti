@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Editar Ordem de Serviço
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ordens-de-servico.update', $ordemDeServico->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" required>{{ $ordemDeServico->descricao }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="user_id">Usuário</label>
                                <select class="form-control" id="user_id" name="user_id" required>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $user->id == $ordemDeServico->user_id ? 'selected' : '' }}>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    @foreach($statusValues as $status)
                                        <option value="{{ $status }}" {{ $status == $ordemDeServico->status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <a href="{{ route('ordens-de-servico.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
