@extends('layouts.app')

@section('content')
    <div class="container-lg px-4">
        <div class="row g-4 mb-4">
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-primary">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">25 </div>
                            <div>Ordens de Serviços</div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                {{-- <i class="fas fa-bars"></i> --}}
                                <i class="fa-solid fa-bars"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Lista
                                    Pendentes</a><a class="dropdown-item" href="#">Listar OS</a></div>
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
                            <div class="fs-4 fw-semibold">$6.200 <span class="fs-6 fw-normal">(40.9%
                                    <i class="fas fa-arrow-up"></i>)</span></div>
                            <div>Vistorias</div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Listas
                                    Vistorias</a><a class="dropdown-item" href="#">Vistorias Pendentes</a> </div>
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
                            <div class="fs-4 fw-semibold">450 <span class="fs-6 fw-normal"></div>
                            <div>Imóveis</div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item" href="#">Listar
                                    Imóveis</a></div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3" style="height:70px;">
                        <canvas class="chart" id="card-chart3" height="70"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-xl-3">
                <div class="card text-white bg-danger">
                    <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fs-4 fw-semibold">12 </div>
                            <div>Laudos Técnicos</div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-transparent text-white p-0" type="button" data-coreui-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bars"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                    href="#">Action</a><a class="dropdown-item" href="#">Another
                                    action</a><a class="dropdown-item" href="#">Something else here</a></div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <canvas class="chart" id="card-chart4" height="70"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>

        <!-- /.row-->
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">Vistorias Pendentes</div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <thead class="fw-semibold text-nowrap">
                                    <tr class="align-middle">
                                        <th class="bg-body-secondary">Requerinte</th>
                                        <th class="bg-body-secondary text-center">Processo</th>
                                        <th class="bg-body-secondary">Imóvel Vistoriado</th>
                                        <th class="bg-body-secondary">Data</th>
                                        <th class="bg-body-secondary"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="align-middle">
                                        <td>
                                            <div class="text-nowrap">Carlos Eduardo Marcelo</div>
                                            <div class="small text-body-secondary text-nowrap"><span>Nova Vistoria</span> |
                                                Registered: Mar 02, 2025</div>
                                        </td>
                                        <td class="text-center">
                                            555224485018
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <div class="fw-semibold">50%</div>
                                                <div class="text-nowrap small text-body-secondary ms-3">Mar 07, 2025 - Mar
                                                    10, 2025</div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 75%" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>

                                            <div class="fw-semibold text-nowrap">01/03/2025</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-transparent p-0" type="button"
                                                    data-coreui-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-bars fa-lg"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                                        href="#">Info</a><a class="dropdown-item"
                                                        href="#">Edit</a><a class="dropdown-item text-danger"
                                                        href="#">Delete</a></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Linhas adicionadas -->
                                    <tr class="align-middle">
                                        <td>
                                            <div class="text-nowrap">Ana Beatriz Silva</div>
                                            <div class="small text-body-secondary text-nowrap"><span>Nova Vistoria</span> |
                                                Registered: Mar 05, 2025</div>
                                        </td>
                                        <td class="text-center">
                                            555224485019
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <div class="fw-semibold">30%</div>
                                                <div class="text-nowrap small text-body-secondary ms-3">Mar 10, 2025 - Mar
                                                    12, 2025</div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-warning" role="progressbar"
                                                    style="width: 30%" aria-valuenow="30" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-nowrap">2 dias atras</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-transparent p-0" type="button"
                                                    data-coreui-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-bars fa-lg"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                                        href="#">Info</a><a class="dropdown-item"
                                                        href="#">Edit</a><a class="dropdown-item text-danger"
                                                        href="#">Delete</a></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="align-middle">
                                        <td>
                                            <div class="text-nowrap">João Pedro Santos</div>
                                            <div class="small text-body-secondary text-nowrap"><span>Nova Vistoria</span> |
                                                Registered: Mar 06, 2025</div>
                                        </td>
                                        <td class="text-center">
                                            555224485020
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <div class="fw-semibold">40%</div>
                                                <div class="text-nowrap small text-body-secondary ms-3">Mar 11, 2025 - Mar
                                                    13, 2025</div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 40%"
                                                    aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-nowrap">4 horas atras</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-transparent p-0" type="button"
                                                    data-coreui-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-bars fa-lg"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                                        href="#">Info</a><a class="dropdown-item"
                                                        href="#">Edit</a><a class="dropdown-item text-danger"
                                                        href="#">Delete</a></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="align-middle">
                                        <td>
                                            <div class="text-nowrap">Lucas Oliveira Lima</div>
                                            <div class="small text-body-secondary text-nowrap"><span>Nova Vistoria</span> |
                                                Registered: Mar 01, 2025</div>
                                        </td>
                                        <td class="text-center">
                                            555224485021
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <div class="fw-semibold">75%</div>
                                                <div class="text-nowrap small text-body-secondary ms-3">Mar 05, 2025 - Mar
                                                    07, 2025</div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-nowrap">5 dias </div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-transparent p-0" type="button"
                                                    data-coreui-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-bars fa-lg"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                                        href="#">Info</a><a class="dropdown-item"
                                                        href="#">Edit</a><a class="dropdown-item text-danger"
                                                        href="#">Delete</a></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="align-middle">
                                        <td>
                                            <div class="text-nowrap">Juliana Almeida Costa</div>
                                            <div class="small text-body-secondary text-nowrap"><span>Nova Vistoria</span> |
                                                Registered: Mar 03, 2025</div>
                                        </td>
                                        <td class="text-center">
                                            555224485022
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <div class="fw-semibold">60%</div>
                                                <div class="text-nowrap small text-body-secondary ms-3">Mar 12, 2025 - Mar
                                                    14, 2025</div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-primary" role="progressbar"
                                                    style="width: 60%" aria-valuenow="60" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-nowrap">2 horas atras</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-transparent p-0" type="button"
                                                    data-coreui-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-bars fa-lg"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                                        href="#">Info</a><a class="dropdown-item"
                                                        href="#">Edit</a><a class="dropdown-item text-danger"
                                                        href="#">Delete</a></div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="align-middle">
                                        <td>
                                            <div class="text-nowrap">Fernanda Souza Pereira</div>
                                            <div class="small text-body-secondary text-nowrap"><span>Nova Vistoria</span> |
                                                Registered: Mar 07, 2025</div>
                                        </td>
                                        <td class="text-center">
                                            555224485023
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-baseline">
                                                <div class="fw-semibold">85%</div>
                                                <div class="text-nowrap small text-body-secondary ms-3">Mar 14, 2025 - Mar
                                                    16, 2025</div>
                                            </div>
                                            <div class="progress progress-thin">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 85%"
                                                    aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold text-nowrap">1 dia atras</div>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-transparent p-0" type="button"
                                                    data-coreui-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <i class="fas fa-bars fa-lg"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end"><a class="dropdown-item"
                                                        href="#">Info</a><a class="dropdown-item"
                                                        href="#">Edit</a><a class="dropdown-item text-danger"
                                                        href="#">Delete</a></div>
                                            </div>
                                        </td>
                                    </tr>
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
