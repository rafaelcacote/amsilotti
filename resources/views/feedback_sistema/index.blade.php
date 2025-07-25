@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="row mb-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                        <h3 class="mb-0 text-primary"><i class="fa fa-comment me-2"></i>Feedbacks do Sistema</h3>
                        <div class="d-flex gap-2">
                            <a href="{{ route('feedback_sistema.create') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-2 px-3 py-2">
                                <i class="fas fa-plus" style="font-size: 0.9rem;"></i>
                                <span>Novo Feedback</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 border-bottom-0">#</th>
                                        <th class="px-4 py-3 border-bottom-0">Usuário</th>
                                        <th class="px-4 py-3 border-bottom-0">Título</th>
                                        <th class="px-4 py-3 border-bottom-0">Tipo</th>
                                        <th class="px-4 py-3 border-bottom-0">Status</th>
                                        <th class="px-4 py-3 border-bottom-0">Prioridade</th>
                                        <th class="px-4 py-3 border-bottom-0">Descrição</th>
                                        <th class="px-4 py-3 border-bottom-0 text-center" style="width: 160px;">Ações</th>
                                        <th class="px-4 py-3 border-bottom-0 text-center">Resolver</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($feedbacks as $feedback)
                                        <tr class="border-bottom border-light">
                                            <td class="px-4 fw-medium text-muted"><strong>#{{ $feedback->id }}</strong></td>
                                            <td class="px-4">{{ $feedback->usuario->name ?? $feedback->usuario_id }}</td>
                                            <td class="px-4">{{ $feedback->titulo }}</td>
                                            <td class="px-4">{{ ucfirst($feedback->tipo_feedback) }}</td>
                                            <td class="px-4">
                                                <span class="badge 
                                                    @if($feedback->status == 'pendente') bg-warning text-dark
                                                    @elseif($feedback->status == 'em andamento') bg-info text-dark
                                                    @elseif($feedback->status == 'resolvido') bg-success
                                                    @elseif($feedback->status == 'rejeitado') bg-danger
                                                    @endif
                                                ">
                                                    {{ ucfirst($feedback->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4">
                                                <span class="badge 
                                                    @if($feedback->prioridade == 'baixa') bg-secondary
                                                    @elseif($feedback->prioridade == 'média') bg-primary
                                                    @elseif($feedback->prioridade == 'alta') bg-danger
                                                    @endif
                                                ">
                                                    {{ ucfirst($feedback->prioridade) }}
                                                </span>
                                            </td>
                                            <td class="px-4" style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                <span title="{{ $feedback->descricao }}">{{ \Illuminate\Support\Str::limit($feedback->descricao, 40) }}</span>
                                            </td>
                                            <td class="px-4 text-center">
                                                <x-action-buttons 
                                                    :showRoute="'feedback_sistema.show'" 
                                                    :editRoute="'feedback_sistema.edit'" 
                                                    :destroyRoute="'feedback_sistema.destroy'" 
                                                    :itemId="$feedback->id" 
                                                    :showButton="true" 
                                                    :editButton="true" 
                                                    :deleteButton="true" 
                                                    :duplicateButton="false" />
                                            </td>
                                            <td class="px-4 text-center">
                                                @if($feedback->status != 'resolvido')
                                                    <form action="{{ route('feedback_sistema.resolver', $feedback->id) }}" method="POST" style="display:inline-block">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success" title="Marcar como resolvido" style="cursor:pointer;">
                                                            <i class="fa fa-check"></i> Resolver
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-success"><i class="fa fa-check-circle"></i></span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center py-4">
                                                <p class="text-muted mb-0">Nenhum feedback encontrado.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $feedbacks->links('vendor.pagination.simple-coreui') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
