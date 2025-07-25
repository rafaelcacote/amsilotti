<!-- Modal Detalhes do Evento -->
<div class="modal fade" id="modalDetalhesEvento" tabindex="-1" aria-labelledby="modalDetalhesEventoLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetalhesEventoLabel">
                    <i class="fas fa-calendar-check me-2"></i>Detalhes da Vistoria
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Seção para vistorias -->
                <div class="modal-vistoria">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="card-title text-primary mb-3">
                                        <i class="fas fa-file-alt me-2"></i>Informações do Processo
                                    </h6>
                                    <div class="mb-2">
                                        <strong>Número do Processo:</strong>
                                        <span id="detalhe-num-processo" class="badge bg-secondary ms-2"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Status:</strong>
                                        <span id="detalhe-status" class="badge ms-2"></span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Data da Vistoria:</strong>
                                        <span id="detalhe-data" class="text-muted ms-2"></span>
                                    </div>
                                    <div>
                                        <strong>Hora da Vistoria:</strong>
                                        <span id="detalhe-hora" class="text-muted ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="card-title text-success mb-3">
                                        <i class="fas fa-users me-2"></i>Partes Envolvidas
                                    </h6>
                                    <div class="mb-2">
                                        <strong>Requerido:</strong>
                                        <span id="detalhe-requerido" class="text-muted ms-2"></span>
                                    </div>
                                    <div>
                                        <strong>Requerente:</strong>
                                        <span id="detalhe-requerente" class="text-muted ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h6 class="card-title text-info mb-3">
                                <i class="fas fa-map-marker-alt me-2"></i>Endereço da Vistoria
                            </h6>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-2">
                                        <strong>Endereço:</strong>
                                        <span id="detalhe-endereco" class="text-muted ms-2"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <strong>Número:</strong>
                                        <span id="detalhe-numero" class="text-muted ms-2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <strong>Bairro:</strong>
                                        <span id="detalhe-bairro" class="text-muted ms-2"></span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2">
                                        <strong>Cidade:</strong>
                                        <span id="detalhe-cidade" class="text-muted ms-2"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="mb-2">
                                        <strong>Estado:</strong>
                                        <span id="detalhe-estado" class="text-muted ms-2"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div>
                                        <strong>CEP:</strong>
                                        <span id="detalhe-cep" class="text-muted ms-2"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção para compromissos simples -->
                <div class="modal-simples">
                    <div class="card border-0 bg-light mb-3">
                        <div class="card-body">
                            <h6 class="card-title text-primary mb-3">
                                <i class="fas fa-calendar-day me-2"></i>Informações do Compromisso
                            </h6>
                            <div class="mb-2">
                                <strong>Título:</strong>
                                <span id="detalhe-titulo" class="text-muted ms-2"></span>
                            </div>
                            <div class="mb-2">
                                <strong>Local:</strong>
                                <span id="detalhe-local" class="text-muted ms-2"></span>
                            </div>
                            <div class="mb-2">
                                <strong>Hora:</strong>
                                <span id="detalhe-hora-simples" class="text-muted ms-2"></span>
                            </div>
                            <div class="mb-2">
                                <strong>Tipo:</strong>
                                <span id="detalhe-tipo" class="text-muted ms-2"></span>
                            </div>
                            <div class="mb-2">
                                <strong>Observações:</strong>
                                <p id="detalhe-nota" class="text-muted mt-2 mb-0"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Fechar
                </button>
                <button type="button" class="btn btn-success" id="btn-imprimir-evento">
                    <i class="fas fa-print me-1"></i>Imprimir
                </button>
                <button type="button" class="btn btn-primary" id="btn-editar-evento">
                    <i class="fas fa-edit me-1"></i>Editar
                </button>
                <button type="button" class="btn btn-danger" id="btn-excluir-evento">
                    <i class="fas fa-trash me-1"></i>Excluir
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Elemento oculto para armazenar o ID do evento -->
<span id="detalhe-id" class="d-none"></span>
