@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3">
                            <h3 class="mb-0 text-success">
                                <i class="fas fa-edit me-2"></i>Editar Registro Financeiro
                            </h3>
                            <div class="d-flex gap-2">
                                <a href="{{ route('entrega-laudos-financeiro.index') }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Voltar
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('entrega-laudos-financeiro.update', $entregaLaudosFinanceiro->id) }}" method="POST" class="row g-3 needs-validation" novalidate>
                                @csrf
                                @method('PUT')
                                
                                <!-- Alert com informações da perícia -->
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Informações da Perícia</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Processo:</strong> {{ $entregaLaudosFinanceiro->controlePericia->numero_processo ?? 'N/A' }}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Requerente:</strong> {{ $entregaLaudosFinanceiro->controlePericia->requerente->nome ?? 'N/A' }}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Vara:</strong> {{ $entregaLaudosFinanceiro->controlePericia->vara ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Primeira linha - Status e UPJ -->
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Selecione o status</option>
                                        @foreach (App\Models\EntregaLaudoFinanceiro::statusOptions() as $statusOption)
                                            <option value="{{ $statusOption }}" {{ old('status', $entregaLaudosFinanceiro->status) == $statusOption ? 'selected' : '' }}>
                                                {{ $statusOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="upj" class="form-label">UPJ</label>
                                    <select class="form-select @error('upj') is-invalid @enderror" id="upj" name="upj">
                                        <option value="">Selecione a UPJ</option>
                                        @foreach (App\Models\EntregaLaudoFinanceiro::upjOptions() as $upjOption)
                                            <option value="{{ $upjOption }}" {{ old('upj', $entregaLaudosFinanceiro->upj) == $upjOption ? 'selected' : '' }}>
                                                {{ $upjOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('upj')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Segunda linha - Financeiro e Valor -->
                                <div class="col-md-6 mb-3">
                                    <label for="financeiro" class="form-label">Financeiro</label>
                                    <select class="form-select @error('financeiro') is-invalid @enderror" id="financeiro" name="financeiro">
                                        <option value="">Selecione o financeiro</option>
                                        @foreach (App\Models\EntregaLaudoFinanceiro::financeiroOptions() as $financeiroOption)
                                            <option value="{{ $financeiroOption }}" {{ old('financeiro', $entregaLaudosFinanceiro->financeiro) == $financeiroOption ? 'selected' : '' }}>
                                                {{ $financeiroOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('financeiro')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="valor" class="form-label">Valor</label>
                                    <input type="text" class="form-control money @error('valor') is-invalid @enderror" 
                                           id="valor" name="valor" value="{{ old('valor', $entregaLaudosFinanceiro->valor) }}"
                                           placeholder="R$ 0,00">
                                    @error('valor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Terceira linha - Protocolo do Laudo e Mês de Pagamento -->
                                <div class="col-md-6 mb-3">
                                    <label for="protocolo_laudo" class="form-label">Data do Protocolo do Laudo</label>
                                    <input type="date" class="form-control @error('protocolo_laudo') is-invalid @enderror" 
                                           id="protocolo_laudo" name="protocolo_laudo" 
                                           value="{{ old('protocolo_laudo', $entregaLaudosFinanceiro->protocolo_laudo ? $entregaLaudosFinanceiro->protocolo_laudo->format('Y-m-d') : '') }}">
                                    @error('protocolo_laudo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="mes_pagamento" class="form-label">Mês de Pagamento</label>
                                    <select class="form-select @error('mes_pagamento') is-invalid @enderror" id="mes_pagamento" name="mes_pagamento">
                                        <option value="">Selecione o mês</option>
                                        @foreach (App\Models\EntregaLaudoFinanceiro::mesPagamentoOptions() as $mesOption)
                                            <option value="{{ $mesOption }}" {{ old('mes_pagamento', $entregaLaudosFinanceiro->mes_pagamento) == $mesOption ? 'selected' : '' }}>
                                                {{ $mesOption }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('mes_pagamento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Quarta linha - Número SEI, Nota Fiscal e Empenho -->
                                <div class="col-md-4 mb-3">
                                    <label for="numero_sei" class="form-label">Número SEI</label>
                                    <input type="text" class="form-control @error('numero_sei') is-invalid @enderror" 
                                           id="numero_sei" name="numero_sei" value="{{ old('numero_sei', $entregaLaudosFinanceiro->sei) }}"
                                           placeholder="Digite o número SEI">
                                    @error('numero_sei')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="nota_fiscal" class="form-label">Nota Fiscal</label>
                                    <input type="text" class="form-control @error('nota_fiscal') is-invalid @enderror" 
                                           id="nota_fiscal" name="nota_fiscal" value="{{ old('nota_fiscal', $entregaLaudosFinanceiro->nf) }}"
                                           placeholder="Digite o número da nota fiscal">
                                    @error('nota_fiscal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="empenho" class="form-label">Empenho</label>
                                    <div class="input-group">
                                        <span class="input-group-text">NE nº</span>
                                        <input type="text" class="form-control @error('empenho') is-invalid @enderror" 
                                               id="empenho" name="empenho" value="{{ old('empenho', $entregaLaudosFinanceiro->empenho) }}"
                                               placeholder="000000" maxlength="45">
                                        @error('empenho')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Quinta linha - Observações -->
                                <div class="col-12 mb-3">
                                    <label for="observacoes" class="form-label">Observações</label>
                                    <textarea class="form-control @error('observacoes') is-invalid @enderror" 
                                              id="observacoes" name="observacoes" rows="3"
                                              placeholder="Digite observações adicionais">{{ old('observacoes', $entregaLaudosFinanceiro->observacoes) }}</textarea>
                                    @error('observacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Botões -->
                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-success me-md-2">
                                            <i class="fas fa-save me-1"></i> Salvar Alterações
                                        </button>
                                        <a href="{{ route('entrega-laudos-financeiro.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> Cancelar
                                        </a>
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

@section('scripts')
<script>
    $(document).ready(function() {
        // Máscara para valor monetário
        $('.money').mask('#.##0,00', {
            reverse: true,
            translation: {
                '#': {pattern: /[0-9]/}
            }
        });
    });

    // Bootstrap form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection