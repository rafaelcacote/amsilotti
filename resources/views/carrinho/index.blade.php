@extends('layouts.app')
@section('title', 'Meu Carrinho')

@section('styles')
<style>
    .bg-danger-soft {
        background-color: #fee2e2 !important;
    }
    
    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .modal-header {
        padding: 1.5rem 1.5rem 0 1.5rem;
    }
    
    .modal-body {
        padding: 0 1.5rem;
    }
    
    .modal-footer {
        padding: 0 1.5rem 1.5rem 1.5rem;
        gap: 10px;
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 8px 20px;
    }
    
    .btn-light {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        color: #6c757d;
    }
    
    .btn-light:hover {
        background-color: #e9ecef;
        border-color: #adb5bd;
        color: #495057;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row mb-3">
        <div class="col">
            <div class="d-flex align-items-center justify-content-between">
                <h1 class="h3 mb-0 text-gray-800">
                    <i class="fa-solid fa-cart-shopping me-2"></i>Meu Carrinho
                    <span class="badge bg-primary ms-2">{{ $itens->sum('quantidade') }} {{ $itens->sum('quantidade') == 1 ? 'item' : 'itens' }}</span>
                </h1>
                <a href="{{ route('consulta.cliente.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Continuar Comprando
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Itens do Carrinho</h5>
                </div>
                <div class="card-body">
                    @if($itens->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Amostra</th>
                                        <th>Tipo</th>
                                        <th>Bairro</th>
                                        <th>Área</th>
                                        <th>Quantidade</th>
                                        <th>Valor Unitário</th>
                                        <th>Subtotal</th>
                                        <th class="text-center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($itens as $item)
                                        <tr>
                                            <td>
                                                <span class="badge bg-light text-dark fs-6">#{{ $item->imovel_id }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">
                                                    {{ $item->tipo == 'terreno' ? 'Terreno' : 
                                                       ($item->tipo == 'apartamento' ? 'Apartamento' : 
                                                       ($item->tipo == 'imovel_urbano' ? 'Imóvel Urbano' : 
                                                       ($item->tipo == 'sala_comercial' ? 'Sala Comercial' : 'Galpão'))) }}
                                                </span>
                                            </td>
                                            <td>
                                                <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                                {{ $item->bairro_nome ?? 'Não informado' }}
                                            </td>
                                            <td>
                                                @if ($item->tipo == 'terreno')
                                                    <span class="text-info">
                                                        {{ number_format($item->area_total, 2, ',', '.') }} m²
                                                    </span>
                                                @else
                                                    <span class="text-info">
                                                        {{ $item->area_construida ? number_format($item->area_construida, 2, ',', '.') : '0,00' }} m²
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">{{ $item->quantidade }}</span>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">
                                                    R$ {{ number_format($item->preco_venda_amostra, 2, ',', '.') }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">
                                                    R$ {{ number_format($item->preco_venda_amostra * $item->quantidade, 2, ',', '.') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-danger btn-sm btn-remover" 
                                                        data-item-id="{{ $item->id }}"
                                                        data-bs-toggle="tooltip" 
                                                        title="Remover do carrinho">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Total e Ações -->
                        <div class="row mt-4">
                            <div class="col-md-8"></div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <strong>Total de Itens:</strong>
                                            <span class="badge bg-primary">{{ $itens->sum('quantidade') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="mb-0">Valor Total:</h5>
                                            <h5 class="mb-0 text-success">R$ {{ number_format($valorTotal, 2, ',', '.') }}</h5>
                                        </div>
                                        <hr>
                                        <div class="d-grid">
                                            <button class="btn btn-success btn-lg" disabled>
                                                <i class="fas fa-credit-card me-2"></i>Pagar (em breve)
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-cart-shopping fa-4x text-muted"></i>
                            </div>
                            <h4 class="text-muted mb-3">Seu carrinho está vazio</h4>
                            <p class="text-muted mb-4">
                                Explore nosso catálogo de imóveis e adicione amostras ao seu carrinho.
                            </p>
                            <a href="{{ route('consulta.cliente.index') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Explorar Imóveis
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="modalConfirmarExclusao" tabindex="-1" aria-labelledby="modalConfirmarExclusaoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title d-flex align-items-center" id="modalConfirmarExclusaoLabel">
                    <div class="rounded-circle bg-danger-soft p-2 me-3">
                        <i class="fas fa-trash text-danger"></i>
                    </div>
                    Remover Item do Carrinho
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-danger-soft mx-auto mb-3" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-exclamation-triangle text-danger fa-2x"></i>
                    </div>
                    <h6 class="mb-2">Tem certeza que deseja remover este item?</h6>
                    <p class="text-muted mb-0">
                        O imóvel <strong id="imovel-info"></strong> será removido do seu carrinho.
                        <br>Esta ação não pode ser desfeita.
                    </p>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-danger" id="btn-confirmar-exclusao">
                    <i class="fas fa-trash me-2"></i>Sim, Remover
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let itemParaRemover = null;
        let linhaParaRemover = null;
        
        // Funcionalidade para remover itens do carrinho
        document.querySelectorAll('.btn-remover').forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.dataset.itemId;
                const row = this.closest('tr');
                
                // Busca as informações do imóvel para mostrar no modal
                const codigoImovel = row.querySelector('.badge').textContent;
                const tipoImovel = row.querySelector('.fw-medium').textContent;
                
                // Armazena as informações para usar quando confirmar
                itemParaRemover = itemId;
                linhaParaRemover = row;
                
                // Atualiza o texto do modal
                document.getElementById('imovel-info').textContent = `${codigoImovel} (${tipoImovel})`;
                
                // Exibe o modal
                const modal = new bootstrap.Modal(document.getElementById('modalConfirmarExclusao'));
                modal.show();
            });
        });
        
        // Funcionalidade do botão confirmar exclusão
        document.getElementById('btn-confirmar-exclusao').addEventListener('click', function() {
            if (itemParaRemover && linhaParaRemover) {
                // Desabilita o botão durante a requisição
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Removendo...';
                
                fetch("{{ route('carrinho.remover') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ item_id: itemParaRemover })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        // Fecha o modal
                        bootstrap.Modal.getInstance(document.getElementById('modalConfirmarExclusao')).hide();
                        
                        // Remove a linha da tabela com animação
                        linhaParaRemover.style.transition = 'opacity 0.3s ease';
                        linhaParaRemover.style.opacity = '0';
                        
                        setTimeout(() => {
                            linhaParaRemover.remove();
                            
                            // Recarrega a página se não houver mais itens
                            if (document.querySelectorAll('tbody tr').length === 0) {
                                location.reload();
                            }
                        }, 300);
                        
                        // Exibe toast de sucesso
                        showToast('Item removido com sucesso!', 'success');
                    } else {
                        showToast('Erro ao remover item do carrinho', 'error');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showToast('Erro ao remover item do carrinho', 'error');
                })
                .finally(() => {
                    // Restaura o botão
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-trash me-2"></i>Sim, Remover';
                    
                    // Limpa as variáveis
                    itemParaRemover = null;
                    linhaParaRemover = null;
                });
            }
        });
        
        // Função para exibir toast notifications
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toast-container') || createToastContainer();
            const toastId = 'toast-' + Date.now();
            const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
            
            const toastHTML = `
                <div id="${toastId}" class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
            toast.show();
            
            // Remove o toast do DOM após esconder
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
        
        // Função para criar container de toasts
        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            container.style.zIndex = '1060';
            document.body.appendChild(container);
            return container;
        }

        // Inicializar tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection
