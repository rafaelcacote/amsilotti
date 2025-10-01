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
                            <div class="col-md-6">
                                <strong>Processo:</strong> <span id="info_processo">-</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Requerente:</strong> <span id="info_requerente">-</span>
                            </div>
                        </div>
                         <div class="row">  
                            <div class="col-md-6">
                                <strong>Data Laudo:</strong> <span id="info_prazo_final">-</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Vara:</strong> <span id="info_vara">-</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="status_financeiro" class="form-label">Status *</label>
                            <select class="form-select" id="status_financeiro" name="status" required>
                                <option value="">Selecione o status</option>
                                @foreach (App\Models\EntregaLaudoFinanceiro::statusOptions() as $statusOption)
                                    <option value="{{ $statusOption }}" {{ (isset($financeiro) && is_object($financeiro) && $financeiro->status == $statusOption) ? 'selected' : '' }}>{{ $statusOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="upj" class="form-label">UPJ</label>
                            <select class="form-select" id="upj" name="upj">
                                <option value="">Selecione a UPJ</option>
                                @foreach (App\Models\EntregaLaudoFinanceiro::upjOptions() as $upjOption)
                                    <option value="{{ $upjOption }}" 
                                            data-varas="{{ $upjOption === '1ª UPJ' ? '9ª Cível,10ª Cível,19ª Cível,20ª Cível,22ª Cível' : 
                                                      ($upjOption === '2ª UPJ' ? '2ª Cível,6ª Cível,15ª Cível,13ª Cível' : 
                                                      ($upjOption === '3ª UPJ' ? '14ª Cível,16ª Cível,17ª Cível,18ª Cível' : 
                                                      ($upjOption === '4ª UPJ' ? '1ª Cível,2ª Cível,5ª Cível,11ª Cível,12ª Cível' : ''))) }}"
                                            {{ (isset($financeiro) && is_object($financeiro) && $financeiro->upj == $upjOption) ? 'selected' : '' }}>
                                        {{ $upjOption }}
                                    </option>
                                @endforeach
                                <option value="none" style="display:none;" id="no-upj-option">Nenhuma UPJ relacionada</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="financeiro" class="form-label">Financeiro</label>
                            <select class="form-select" id="financeiro" name="financeiro">
                                <option value="">Selecione o financeiro</option>
                                @foreach (App\Models\EntregaLaudoFinanceiro::financeiroOptions() as $financeiroOption)
                                    <option value="{{ $financeiroOption }}" {{ (isset($financeiro) && is_object($financeiro) && $financeiro->financeiro == $financeiroOption) ? 'selected' : '' }}>{{ $financeiroOption }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="valor" class="form-label">Valor</label>
                            <input type="text" class="form-control money" id="valor" name="valor" placeholder="R$ 0,00" value="{{ (isset($financeiro) && is_object($financeiro)) ? $financeiro->valor : '' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="mes_pagamento" class="form-label">Mês de Pagamento</label>
                            <select class="form-select" id="mes_pagamento" name="mes_pagamento">
                                <option value="">Selecione o mês</option>
                                @foreach (App\Models\EntregaLaudoFinanceiro::mesPagamentoOptions() as $mesOption)
                                    <option value="{{ $mesOption }}" {{ (isset($financeiro) && is_object($financeiro) && $financeiro->mes_pagamento == $mesOption) ? 'selected' : '' }}>{{ $mesOption }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="ano_pagamento" class="form-label">Ano de Pagamento</label>
                            <input type="text" class="form-control" id="ano_pagamento" name="ano_pagamento" maxlength="4" value="{{ (isset($financeiro) && is_object($financeiro)) ? $financeiro->ano_pagamento : '' }}">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tipo_pessoa" class="form-label">Tipo Pessoa</label>
                            <select class="form-select" id="tipo_pessoa" name="tipo_pessoa" required>
                                <option value="">Selecione o tipo</option>
                                <option value="PF">Pessoa Física (PF)</option>
                                <option value="PJ">Pessoa Jurídica (PJ)</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sei" class="form-label">Proc Adm</label>
                                <input type="text" class="form-control" id="sei" name="sei" maxlength="50" value="{{ (isset($financeiro) && is_object($financeiro)) ? $financeiro->sei : '' }}">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="nf" class="form-label">NF</label>
                                <div class="input-group">
                                    <span class="input-group-text">NF nº</span>
                                    <input type="text" class="form-control" id="nf" name="nf" placeholder="000000" maxlength="45" value="{{ (isset($financeiro) && is_object($financeiro)) ? $financeiro->nf : '' }}">
                                </div>
                            </div>
                        
                             <div class="col-md-3 mb-3">
                                <label for="empenho" class="form-label">Empenho</label>
                                <div class="input-group">
                                    <span class="input-group-text">NE nº</span>
                                    <input type="text" class="form-control" id="empenho" name="empenho" placeholder="000000" maxlength="45" value="{{ (isset($financeiro) && is_object($financeiro)) ? $financeiro->empenho : '' }}">
                                </div>
                            </div>
                    </div>


                   

                   
                    <div class="mb-3">
                        <label for="observacao" class="form-label">Observações</label>
                        <textarea class="form-control" id="observacao" name="observacao" rows="3" placeholder="Digite observações adicionais">{{ (isset($financeiro) && is_object($financeiro)) ? $financeiro->observacao : '' }}</textarea>
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
    function filterUpjByVara(vara, preserveValue = false) {
        const upjSelect = document.getElementById('upj');
        const allOptions = upjSelect.querySelectorAll('option');
        const currentValue = upjSelect.value;
        let validOptions = [];
        let hasRelated = false;
        allOptions.forEach((option, index) => {
            if (index === 0) {
                option.style.display = '';
                return;
            }
            const varasPermitidas = option.dataset.varas;
            if (varasPermitidas && vara) {
                const varasArray = varasPermitidas.split(',').map(v => v.trim());
                if (varasArray.includes(vara)) {
                    option.style.display = '';
                    validOptions.push(option);
                    hasRelated = true;
                } else {
                    option.style.display = 'none';
                }
            } else {
                option.style.display = vara ? 'none' : '';
                if (!vara) {
                    validOptions.push(option);
                }
            }
        });
        // Se não tem UPJ relacionada, mostrar opção informativa
        const noUpjOption = document.getElementById('no-upj-option');
        if (!hasRelated && vara) {
            noUpjOption.style.display = '';
            upjSelect.value = 'none';
        } else {
            noUpjOption.style.display = 'none';
            if (!upjSelect.value && validOptions.length === 1) {
                upjSelect.value = validOptions[0].value;
            }
        }
        // Verificar se o valor atual ainda é válido após o filtro
        const currentOption = upjSelect.querySelector(`option[value="${currentValue}"]`);
        const isCurrentValid = currentOption && currentOption.style.display !== 'none';
        
        if (!isCurrentValid && !preserveValue && currentValue !== '') {
            console.log('Valor atual não é válido, resetando'); // Debug
            upjSelect.value = '';
        }
        
        // Se preserveValue = true e o valor atual não é válido, mas temos o valor, tentar manter
        if (preserveValue && !isCurrentValid && currentValue !== '') {
            console.log('Tentando preservar valor:', currentValue); // Debug
            // Verificar se existe uma opção com esse valor entre as válidas
            const matchingOption = validOptions.find(opt => opt.value === currentValue);
            if (matchingOption) {
                console.log('Opção correspondente encontrada, mantendo valor'); // Debug
                upjSelect.value = currentValue;
            }
        }
        
        // Auto-selecionar se for a única opção disponível e não temos valor definido
        if (!upjSelect.value && validOptions.length === 1) {
            console.log('Auto-selecionando única opção disponível:', validOptions[0].value); // Debug
            upjSelect.value = validOptions[0].value;
        }
    }

    // Função global para ser chamada quando o modal for aberto
    window.updateModalPericia = function(periciaData) {
        console.log('updateModalPericia chamada com:', periciaData); // Debug
        
        if (periciaData) {
            document.getElementById('info_processo').textContent = periciaData.processo || '-';
            document.getElementById('info_requerente').textContent = periciaData.requerente || '-';
            document.getElementById('info_vara').textContent = periciaData.vara || '-';
            // Formatar data prazo_final para DD/MM/YYYY
            let dataFormatada = '-';
            if (periciaData.prazo_final) {
                const d = new Date(periciaData.prazo_final);
                if (!isNaN(d.getTime())) {
                    const dia = String(d.getDate()).padStart(2, '0');
                    const mes = String(d.getMonth() + 1).padStart(2, '0');
                    const ano = d.getFullYear();
                    dataFormatada = `${dia}/${mes}/${ano}`;
                } else {
                    // Se não for uma data válida, exibe como veio
                    dataFormatada = periciaData.prazo_final;
                }
            }
            document.getElementById('info_prazo_final').textContent = dataFormatada;
            // Se temos uma UPJ específica, definir primeiro
            if (periciaData.upj) {
                console.log('Definindo UPJ para:', periciaData.upj); // Debug
                document.getElementById('upj').value = periciaData.upj;
            }
            
            // Filtrar UPJs baseado na vara, preservando o valor se já foi definido
            filterUpjByVara(periciaData.vara, !!periciaData.upj);
            
            // Verificar se o valor foi definido corretamente
            const upjValue = document.getElementById('upj').value;
            console.log('UPJ final após filtro:', upjValue); // Debug
        }
    };
    
    // Função para limpar as informações quando o modal for fechado
    window.clearModalPericia = function() {
        document.getElementById('info_processo').textContent = '-';
        document.getElementById('info_requerente').textContent = '-';  
        document.getElementById('info_vara').textContent = '-';
        document.getElementById('info_prazo_final').textContent = '-';
        
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
