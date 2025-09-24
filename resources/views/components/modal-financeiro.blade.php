<div class="modal fade" id="modalFinanceiro" tabindex="-1" aria-labelledby="modalFinanceiroLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalFinanceiroLabel">
                    <i class="fas fa-money-bill-wave me-2"></i>{{ $title ?? 'Registro Financeiro do Laudo' }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formFinanceiro" method="POST" action="{{ $action ?? '#' }}">
                @csrf
                @if(isset($method) && $method === 'PUT')
                    @method('PUT')
                @endif
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ $info ?? 'Preencha os dados financeiros abaixo:' }}
                    </div>
                    
                    <input type="hidden" id="controle_pericias_id" name="controle_pericias_id" value="{{ $controle_pericias_id ?? '' }}">
                    
                    <!-- Informações da Perícia -->
                    <div class="alert alert-secondary mb-3">
                        <h6 class="mb-2"><i class="fas fa-gavel me-2"></i>Informações da Perícia</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Processo:</strong> <span id="info_processo">-</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Requerente:</strong> <span id="info_requerente">-</span>
                            </div>
                            <div class="col-md-4">
                                <strong>Vara:</strong> <span id="info_vara">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status_financeiro" class="form-label">Status *</label>
                            <select class="form-select" id="status_financeiro" name="status" required>
                                <option value="">Selecione o status</option>
                                @foreach (App\Models\EntregaLaudoFinanceiro::statusOptions() as $statusOption)
                                    <option value="{{ $statusOption }}" {{ (isset($financeiro) && $financeiro->status == $statusOption) ? 'selected' : '' }}>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="upj" class="form-label">UPJ</label>
                            <select class="form-select" id="upj" name="upj">
                                <option value="">Selecione a UPJ</option>
                                @foreach (App\Models\EntregaLaudoFinanceiro::upjOptions() as $upjOption)
                                    <option value="{{ $upjOption }}" 
                                            data-varas="{{ $upjOption === '1ª UPJ' ? '9 Cível,10 Cível,19 Cível,20 Cível,22 Cível' : 
                                                      ($upjOption === '2ª UPJ' ? '2 Cível,6 Cível,15 Cível,13 Cível' : 
                                                      ($upjOption === '3ª UPJ' ? '14 Cível,16 Cível,17 Cível,18 Cível' : 
                                                      ($upjOption === '4ª UPJ' ? '1 Cível,5 Cível,11 Cível,12 Cível' : ''))) }}"
                                            {{ (isset($financeiro) && $financeiro->upj == $upjOption) ? 'selected' : '' }}>
                                        {{ $upjOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="financeiro" class="form-label">Financeiro</label>
                            <select class="form-select" id="financeiro" name="financeiro">
                                <option value="">Selecione o financeiro</option>
                                @foreach (App\Models\EntregaLaudoFinanceiro::financeiroOptions() as $financeiroOption)
                                    <option value="{{ $financeiroOption }}" {{ (isset($financeiro) && $financeiro->financeiro == $financeiroOption) ? 'selected' : '' }}>{{ $financeiroOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="protocolo_laudo" class="form-label">Protocolo do Laudo</label>
                            <input type="date" class="form-control" id="protocolo_laudo" name="protocolo_laudo" value="{{ isset($financeiro) && $financeiro->protocolo_laudo ? $financeiro->protocolo_laudo->format('Y-m-d') : '' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="text" class="form-control money" id="valor" name="valor" placeholder="R$ 0,00" value="{{ isset($financeiro) ? $financeiro->valor : '' }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sei" class="form-label">SEI</label>
                            <input type="text" class="form-control" id="sei" name="sei" maxlength="50" value="{{ isset($financeiro) ? $financeiro->sei : '' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nf" class="form-label">NF</label>
                            <div class="input-group">
                                <span class="input-group-text">NF nº</span>
                                <input type="text" class="form-control" id="nf" name="nf" placeholder="000000" maxlength="45" value="{{ isset($financeiro) ? $financeiro->nf : '' }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="mes_pagamento" class="form-label">Mês de Pagamento</label>
                            <select class="form-select" id="mes_pagamento" name="mes_pagamento">
                                <option value="">Selecione o mês</option>
                                @foreach (App\Models\EntregaLaudoFinanceiro::mesPagamentoOptions() as $mesOption)
                                    <option value="{{ $mesOption }}" {{ (isset($financeiro) && $financeiro->mes_pagamento == $mesOption) ? 'selected' : '' }}>{{ $mesOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="empenho" class="form-label">Empenho</label>
                        <div class="input-group">
                            <span class="input-group-text">NE nº</span>
                            <input type="text" class="form-control" id="empenho" name="empenho" placeholder="000000" maxlength="45" value="{{ isset($financeiro) ? $financeiro->empenho : '' }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="observacoes" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacoes" name="observacoes" rows="3" placeholder="Digite observações adicionais">{{ isset($financeiro) ? $financeiro->observacoes : '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Salvar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Função para filtrar UPJs baseado na vara
    function filterUpjByVara(vara) {
        const upjSelect = document.getElementById('upj');
        const allOptions = upjSelect.querySelectorAll('option');
        
        // Primeiro esconder todas as opções (exceto a primeira "Selecione")
        allOptions.forEach((option, index) => {
            if (index === 0) {
                option.style.display = ''; // Manter "Selecione a UPJ"
                return;
            }
            
            const varasPermitidas = option.dataset.varas;
            if (varasPermitidas && vara) {
                const varasArray = varasPermitidas.split(',').map(v => v.trim());
                if (varasArray.includes(vara)) {
                    option.style.display = '';
                    // Auto-selecionar se for a única opção disponível
                    const visibleOptions = Array.from(allOptions).filter(opt => 
                        opt.style.display !== 'none' && opt.value !== ''
                    );
                    if (visibleOptions.length === 1) {
                        upjSelect.value = option.value;
                    }
                } else {
                    option.style.display = 'none';
                }
            } else {
                option.style.display = vara ? 'none' : ''; // Se não tem vara, mostrar todas
            }
        });
        
        // Reset do select se a opção selecionada não estiver visível
        const currentOption = upjSelect.querySelector(`option[value="${upjSelect.value}"]`);
        if (currentOption && currentOption.style.display === 'none') {
            upjSelect.value = '';
        }
    }

    // Função global para ser chamada quando o modal for aberto
    window.updateModalPericia = function(periciaData) {
        if (periciaData) {
            document.getElementById('info_processo').textContent = periciaData.processo || '-';
            document.getElementById('info_requerente').textContent = periciaData.requerente || '-';
            document.getElementById('info_vara').textContent = periciaData.vara || '-';
            
            // Filtrar UPJs baseado na vara
            filterUpjByVara(periciaData.vara);
        }
    };
    
    // Função para limpar as informações quando o modal for fechado
    window.clearModalPericia = function() {
        document.getElementById('info_processo').textContent = '-';
        document.getElementById('info_requerente').textContent = '-';  
        document.getElementById('info_vara').textContent = '-';
        
        // Mostrar todas as opções de UPJ novamente
        const upjSelect = document.getElementById('upj');
        const allOptions = upjSelect.querySelectorAll('option');
        allOptions.forEach(option => {
            option.style.display = '';
        });
        upjSelect.value = '';
    };
});
</script>
