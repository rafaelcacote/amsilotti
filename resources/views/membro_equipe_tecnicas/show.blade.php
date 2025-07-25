@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-users me-2"></i>Detalhes do Membro da Equipe
                                Técnica</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4 class="mb-0">{{ $membroEquipeTecnica->nome }}</h4>
                                        <span
                                            class="badge {{ $membroEquipeTecnica->cargo == 'Perita Judicial' ? 'bg-primary' : 'bg-info' }} fs-6">
                                            {{ $membroEquipeTecnica->cargo }}
                                        </span>
                                    </div>

                                    <div class="card mb-4 border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Informações de Contato</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Telefone:</strong></p>
                                                    <p>{{ $membroEquipeTecnica->telefone ?: 'Não informado' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Usuário:</strong></p>
                                                    <p>{{ $membroEquipeTecnica->usuario->name ?? 'Não informado' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <h5 class="card-title">Informações Adicionais</h5>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Data de Cadastro:</strong></p>
                                                    <p>{{ $membroEquipeTecnica->created_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p class="mb-1"><strong>Última Atualização:</strong></p>
                                                    <p>{{ $membroEquipeTecnica->updated_at->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('membro-equipe-tecnicas.index') }}"
                                    class="btn btn-outline-secondary me-2">
                                    <i class="fas fa-arrow-left me-1"></i> Voltar
                                </a>
                                <a href="{{ route('membro-equipe-tecnicas.edit', $membroEquipeTecnica->id) }}"
                                    class="btn btn-primary me-2">
                                    <i class="fas fa-pencil-alt me-1"></i> Editar
                                </a>
                                {{-- <form action="{{ route('membro-equipe-tecnicas.destroy', $membroEquipeTecnica->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir este membro?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i> Excluir
                                </button>
                            </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
