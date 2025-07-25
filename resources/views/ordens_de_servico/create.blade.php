@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-clipboard-list me-2"></i>Ordem de
                                Serviço</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('ordens-de-servico.store') }}" method="POST"
                                class="row g-3 needs-validation" novalidate>
                                @csrf
                                @include('ordens_de_servico.form')
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary me-md-2"><i
                                                class="fa-solid fa-floppy-disk"></i>
                                            Salvar</button>
                                        <a href="{{ route('ordens-de-servico.index') }}"
                                            class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-left"></i>
                                            Cancelar</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
