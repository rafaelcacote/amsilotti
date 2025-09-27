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
                                        <div class="card border-info mb-3" style="position:sticky;top:10px;z-index:2;">
                                            <div class="card-header bg-info text-white">
                                                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações da Perícia</h6>
                                            </div>
                                            <div class="card-body py-2">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <strong>Processo:</strong> {{ $entregaLaudosFinanceiro->controlePericia->numero_processo ?? 'N/A' }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Requerente:</strong> {{ $entregaLaudosFinanceiro->controlePericia->requerente->nome ?? 'N/A' }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Vara:</strong> {{ $entregaLaudosFinanceiro->controlePericia->vara ?? 'N/A' }}
                                                    </div>
                                                    <div class="col-md-3">
                                                        <strong>Data Laudo:</strong> {{ $entregaLaudosFinanceiro->controlePericia->prazo_final ? \Carbon\Carbon::parse($entregaLaudosFinanceiro->controlePericia->prazo_final)->format('d/m/Y') : 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>

                                <!-- Primeira linha - Status, UPJ, Financeiro e Valor -->
                                <div class="col-md-2 mb-3">
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
                                
                                <div class="col-md-2 mb-3">
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

                               
                                <div class="col-md-2 mb-3">
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
                                
                                <div class="col-md-2 mb-3">
                                    <label for="valor" class="form-label">Valor</label>
                                    <input type="text" class="form-control money @error('valor') is-invalid @enderror" 
                                           id="valor" name="valor" value="{{ old('valor', $entregaLaudosFinanceiro->valor) }}"
                                           placeholder="R$ 0,00">
                                    @error('valor')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2 mb-3">
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
                                <div class="col-md-2 mb-3">
                                        <label for="ano_pagamento" class="form-label">Ano do Pagamento</label>
                                    <input type="text" class="form-control @error('ano_pagamento') is-invalid @enderror" 
                                        id="ano_pagamento" name="ano_pagamento" maxlength="4" pattern="^(19|20)[0-9]{2}$" 
                                        title="Digite um ano válido (ex: 2025)" placeholder="2025" value="{{ old('ano_pagamento', $entregaLaudosFinanceiro->ano_pagamento ?? '') }}">
                                                    <small class="text-muted">Somente anos válidos (ex: 2025)</small>
                                                    @error('ano_pagamento')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                    </div>

                                <!-- Segunda linha - Protocolo do Laudo e Mês de Pagamento Número SEI, Nota Fiscal e Empenho --> 
                                

                               
                                <div class="col-md-3 mb-3">
                                    <label for="sei" class="form-label">Proc Adm</label>
                                    <input type="text" class="form-control @error('sei') is-invalid @enderror" 
                                           id="sei" name="sei" value="{{ old('sei', $entregaLaudosFinanceiro->sei) }}"
                                           placeholder="Digite o número Proc Adm">
                                    @error('sei')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="nf" class="form-label">Nota Fiscal</label>
                                    <input type="text" class="form-control @error('nf') is-invalid @enderror" 
                                           id="nf" name="nf" value="{{ old('nf', $entregaLaudosFinanceiro->nf) }}"
                                           placeholder="Digite o número da nota fiscal">
                                    @error('nf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
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

                                    <!-- Nova linha - Ano do Pagamento e Tipo de Pessoa -->
                                    
                                    <div class="col-md-3 mb-3">
                                        <label for="tipo_pessoa" class="form-label">Tipo de Pessoa</label>
                                        <select class="form-select @error('tipo_pessoa') is-invalid @enderror" id="tipo_pessoa" name="tipo_pessoa">
                                            <option value="">Selecione o tipo</option>
                                            <option value="PJ" {{ old('tipo_pessoa', $entregaLaudosFinanceiro->tipo_pessoa ?? '') == 'PJ' ? 'selected' : '' }}>PJ - Pessoa Jurídica</option>
                                            <option value="PF" {{ old('tipo_pessoa', $entregaLaudosFinanceiro->tipo_pessoa ?? '') == 'PF' ? 'selected' : '' }}>PF - Pessoa Física</option>
                                        </select>
                                        @error('tipo_pessoa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                <!-- Quinta linha - Observações -->
                                <div class="col-12 mb-3">
                                    <label for="observacao" class="form-label">Observações</label>
                                    <textarea class="form-control @error('observacao') is-invalid @enderror" 
                                              id="observacao" name="observacao" rows="3"
                                              placeholder="Digite observações adicionais">{{ old('observacao', $entregaLaudosFinanceiro->observacao) }}</textarea>
                                    @error('observacao')
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
            // Validação do campo ano_pagamento
            $('#ano_pagamento').on('input', function() {
                let val = this.value.replace(/[^0-9]/g, '');
                if (val.length > 4) val = val.slice(0,4);
                this.value = val;
            });
            $('#ano_pagamento').on('blur', function() {
                const ano = parseInt(this.value, 10);
                const anoAtual = new Date().getFullYear();
                if (ano < 1900 || ano > anoAtual + 1) {
                    this.setCustomValidity('Ano inválido. Informe um ano entre 1900 e ' + (anoAtual + 1));
                } else {
                    this.setCustomValidity('');
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