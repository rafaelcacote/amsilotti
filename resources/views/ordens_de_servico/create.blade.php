@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h3 class="card-title mb-0"><i class="cil-plus me-2"></i>Criar Nova Ordem de Serviço</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ordens-de-servico.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder=" " required></textarea>
                                <label for="descricao">Descrição</label>
                                <div class="invalid-feedback">Por favor insira uma descrição.</div>
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select" id="user_id" name="user_id" required>
                                    <option value="">Selecione um usuário</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <label for="user_id">Usuário</label>
                                <div class="invalid-feedback">Por favor selecione um usuário.</div>
                            </div>
                            <div class="form-floating mb-4">
                                <select class="form-select" id="status" name="status" required>
                                    <option value="">Selecione um status</option>
                                    @foreach($statusValues as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                                <label for="status">Status</label>
                                <div class="invalid-feedback">Por favor selecione um status.</div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary me-md-2"><i class="cil-save"></i> Criar</button>
                                <a href="{{ route('ordens-de-servico.index') }}" class="btn btn-outline-secondary"><i class="cil-x"></i> Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
