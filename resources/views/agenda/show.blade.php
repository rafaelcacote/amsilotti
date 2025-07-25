@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-calendar-check me-2"></i>Detalhes da Agenda</h3>
                            <a href="{{ route('agenda.edit', $agenda) }}" class="btn btn-primary ms-auto"><i
                                    class="fas fa-edit"></i> Editar</a>
                        </div>
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-sm-3">Tipo</dt>
                                <dd class="col-sm-9">{{ $agenda->tipo_nome }}</dd>
                                @if ($agenda->tipo === 'vistoria')
                                    <dt class="col-sm-3">Nº Processo</dt>
                                    <dd class="col-sm-9">{{ $agenda->num_processo }}</dd>
                                    <dt class="col-sm-3">Requerido</dt>
                                    <dd class="col-sm-9">{{ $agenda->requerido }}</dd>
                                    <dt class="col-sm-3">Requerente</dt>
                                    <dd class="col-sm-9">{{ $agenda->requerente ? $agenda->requerente->nome : '-' }}</dd>
                                    <dt class="col-sm-3">Endereço</dt>
                                    <dd class="col-sm-9">{{ $agenda->endereco }}, {{ $agenda->num }} -
                                        {{ $agenda->bairro }}, {{ $agenda->cidade }}/{{ $agenda->estado }} - CEP:
                                        {{ $agenda->cep }}</dd>
                                @else
                                    <dt class="col-sm-3">Título</dt>
                                    <dd class="col-sm-9">{{ $agenda->titulo }}</dd>
                                    <dt class="col-sm-3">Local</dt>
                                    <dd class="col-sm-9">{{ $agenda->local }}</dd>
                                @endif
                                <dt class="col-sm-3">Data</dt>
                                <dd class="col-sm-9">
                                    {{ $agenda->data ? \Carbon\Carbon::parse($agenda->data)->format('d/m/Y') : '-' }}</dd>
                                <dt class="col-sm-3">Horário</dt>
                                <dd class="col-sm-9">{{ $agenda->hora }}</dd>
                                <dt class="col-sm-3">Status</dt>
                                <dd class="col-sm-9">{{ $agenda->status_nome }}</dd>
                                <dt class="col-sm-3">Notas</dt>
                                <dd class="col-sm-9">{{ $agenda->nota }}</dd>
                            </dl>
                            <a href="{{ route('agenda.index') }}" class="btn btn-secondary mt-3">Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
