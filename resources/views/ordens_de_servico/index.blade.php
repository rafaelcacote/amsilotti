@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        @include('ordens_de_servico._filter')
        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-primary text-white py-3">
                        <h3 class="card-title mb-0"><i class="fa fa-align-justify me-2"></i>Ordens de Serviço</h3>
                        <a href="{{ route('ordens-de-servico.create') }}" class="btn btn-light btn-sm float-right"><i class="cil-plus me-2"></i>Nova Ordem</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm table-striped table-hover table-borderless">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Descrição</th>
                                    <th>Usuário</th>
                                    <th>Status</th>
                                    <th style="width: 150px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordens as $ordem)
                                <tr>
                                    <td class="align-middle">{{ $ordem->id }}</td>
                                    <td class="align-middle">{{ $ordem->descricao }}</td>
                                    <td class="align-middle">{{ $ordem->user->name }}</td>
                                    <td class="align-middle"><span class="badge bg-info">{{ $ordem->status }}</span></td>
                                    <td class="align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('ordens-de-servico.show', $ordem->id) }}" class="btn btn-sm btn-info" title="Ver"><i class="cil-magnifying-glass"></i></a>
                                            <a href="{{ route('ordens-de-servico.edit', $ordem->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="cil-pencil"></i></a>
                                            <form action="{{ route('ordens-de-servico.destroy', $ordem->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta ordem de serviço?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir"><i class="cil-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
