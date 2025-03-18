@extends('layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-primary">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">{{ $tarefasEmAndamento }}</div>
                            <div>Tarefas em Andamento</div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Listar Tarefas</a>
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <canvas class="chart" id="card-chart1" height="70"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-info">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">{{ $quantidadeVistorias }}</div>
                            <div>Vistorias Cadastradas</div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Listar Vistorias</a>
                                <a class="dropdown-item" href="#">Vistorias Pendentes</a>
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <canvas class="chart" id="card-chart2" height="70"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-warning">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">{{ $quantidadeImoveis }}</div>
                            <div>Imóveis Cadastrados</div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Listar Imóveis</a>
                            </div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3" style="height:70px;">
                        <canvas class="chart" id="card-chart3" height="70"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>

        <!-- /.row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Controle de Tarefas </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <thead class="fw-semibold text-nowrap">
                                    <tr class="table-light">
                                        <th class="bg-body-secondary">Descrição da Atividade</th>
                                        <th class="bg-body-secondary text-center">Status</th>
                                        <th class="bg-body-secondary">Responsável</th>
                                        <th class="bg-body-secondary">Prazo</th>
                                        <th class="bg-body-secondary">Situação</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tarefas as $tarefa)
                                    <tr class="border-bottom border-light">
                                        <td>
                                            <div class="text-nowrap">{{ $tarefa->descricao_atividade }}</div>
                                            <div class="small text-body-secondary text-nowrap">
                                                <span>{{ $tarefa->tipo }}</span> | Registrada: {{ $tarefa->created_at->format('d/m/Y') }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            {{ $tarefa->status }}
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <div class="fw-semibold">{{ $tarefa->progresso }}%</div>
                                                <div class="text-nowrap small text-body-secondary ms-3">
                                                    {{ $tarefa->data_inicio }} - {{ $tarefa->data_fim }}
                                                </div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $tarefa->progresso }}%" aria-valuenow="{{ $tarefa->progresso }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-nowrap">{{ $tarefa->prazo }}</div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-nowrap">{{ $tarefa->situacao }}</div>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
    </div>
    </div>
@endsection
