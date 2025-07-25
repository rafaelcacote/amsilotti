@extends('layouts.app')


@section('head')
    <!-- Fabric.js CDN (versão estável mais recente) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>
@endsection

@section('content')
    <style>
        #cameraVideo {
            background: #000;
            border-radius: 8px;
        }

        .foto-preview-card {
            transition: transform 0.2s;
        }

        .foto-preview-card:hover {
            transform: scale(1.02);
        }

        .btn-camera-action {
            min-width: 120px;
        }

        .camera-controls {
            background: rgba(0, 0, 0, 0.1);
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
        }

        @media (max-width: 768px) {
            .modal-lg {
                max-width: 95% !important;
            }

            #cameraVideo {
                height: 300px;
                object-fit: cover;
            }
        }

        /* Modal de Descrição da Foto */
        .modal-descricao-foto .modal-content {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .modal-descricao-foto .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom: none;
            padding: 20px 30px;
        }

        .modal-descricao-foto .modal-title {
            font-weight: 600;
            font-size: 1.2rem;
        }

        .modal-descricao-foto .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .modal-descricao-foto .modal-body {
            padding: 30px;
            background: #f8f9fa;
        }

        .foto-preview-modal {
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .modal-descricao-foto .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
        }

        .modal-descricao-foto .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .modal-descricao-foto .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .modal-descricao-foto .modal-footer {
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 20px 30px;
        }

        .modal-descricao-foto .btn {
            border-radius: 25px;
            padding: 10px 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .modal-descricao-foto .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .modal-descricao-foto .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .modal-descricao-foto .btn-secondary {
            background: #6c757d;
            border: none;
        }

        .modal-descricao-foto .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        /* Animações suaves */
        .modal-descricao-foto .modal-content {
            animation: slideInUp 0.3s ease-out;
        }

        @keyframes slideInUp {
            from {
                transform: translate3d(0, 100%, 0);
                opacity: 0;
            }

            to {
                transform: translate3d(0, 0, 0);
                opacity: 1;
            }
        }

        /* Responsividade para tablets */
        @media (max-width: 768px) {
            .modal-descricao-foto .modal-dialog {
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }

            .modal-descricao-foto .modal-body {
                padding: 20px;
            }

            .modal-descricao-foto .modal-header,
            .modal-descricao-foto .modal-footer {
                padding: 15px 20px;
            }

            .foto-preview-modal {
                max-height: 150px;
            }

            .modal-descricao-foto .form-control {
                font-size: 16px;
                /* Evita zoom no iOS */
                padding: 12px;
            }

            .modal-descricao-foto .btn {
                padding: 12px 20px;
                font-size: 1rem;
            }
        }

        /* Melhorias para touch */
        @media (pointer: coarse) {
            .modal-descricao-foto .btn {
                min-height: 44px;
                min-width: 44px;
            }

            .modal-descricao-foto .btn-close {
                width: 44px;
                height: 44px;
            }
        }

        /* Estilos para sugestões */
        .sugestao-btn {
            border-radius: 20px;
            padding: 5px 12px;

            /* Estilos para o Fabric.js Canvas */
            .fabric-tool.active {
                background-color: #0d6efd;
                border-color: #0d6efd;
                color: white;
            }

            .fabric-shape:hover {
                transform: translateY(-1px);
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            #fabric-canvas {
                cursor: crosshair;
                max-width: 100%;
                height: auto;
            }

            .canvas-container {
                margin: 0 auto;
                border: 2px solid #e9ecef;
                border-radius: 8px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .form-range::-webkit-slider-thumb {
                background: #0d6efd;
            }

            .form-range::-moz-range-thumb {
                background: #0d6efd;
                border: none;
            }

            @media (max-width: 768px) {
                #fabric-canvas {
                    width: 100% !important;
                    height: 300px !important;
                }

                .btn-group-sm>.btn {
                    padding: 0.25rem 0.4rem;
                    font-size: 0.75rem;
                }
            }

            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .sugestao-btn:hover {
            background-color: #667eea;
            border-color: #667eea;
            color: white;
            transform: translateY(-1px);
        }

        .sugestao-btn.selected {
            background-color: #667eea;
            border-color: #667eea;
            color: white;
        }

        #sugestoes-descricao {
            max-height: 100px;
            overflow-y: auto;
        }

        /* Modal de Confirmação de Exclusão */
        #confirmDeleteModal .modal-content {
            border-radius: 15px;
            overflow: hidden;
            animation: modalSlideIn 0.3s ease-out;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        #confirmDeleteModal .modal-header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-bottom: none;
            padding: 25px 30px;
            position: relative;
        }

        #confirmDeleteModal .modal-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #dc3545, #ff6b7a, #dc3545);
        }

        #confirmDeleteModal .modal-title {
            font-weight: 600;
            font-size: 1.3rem;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        #confirmDeleteModal .modal-body {
            padding: 35px 30px;
            background: linear-gradient(145deg, #f8f9fa 0%, #ffffff 100%);
        }

        #confirmDeleteModal .modal-body h6 {
            color: #2c3e50;
            font-size: 1.1rem;
        }

        #confirmDeleteModal .modal-body .text-muted {
            font-size: 0.95rem;
            line-height: 1.5;
        }

        #confirmDeleteModal .modal-footer {
            background: white;
            border-top: 1px solid #e9ecef;
            padding: 25px 30px;
        }

        #confirmDeleteModal .btn {
            border-radius: 30px;
            padding: 12px 30px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            min-width: 130px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        #confirmDeleteModal .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        #confirmDeleteModal .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
            background: linear-gradient(135deg, #c82333 0%, #a71e2a 100%);
        }

        #confirmDeleteModal .btn-danger:active {
            transform: translateY(-1px);
        }

        #confirmDeleteModal .btn-outline-secondary {
            border: 2px solid #6c757d;
            color: #6c757d;
            background: transparent;
        }

        #confirmDeleteModal .btn-outline-secondary:hover {
            background: #6c757d;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
        }

        #deletePreviewImg {
            border-radius: 12px;
            border: 3px solid #e3e6f0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        #deletePreviewImg:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        @keyframes modalSlideIn {
            from {
                transform: translate3d(0, -50px, 0) scale(0.95);
                opacity: 0;
            }

            to {
                transform: translate3d(0, 0, 0) scale(1);
                opacity: 1;
            }
        }

        /* Animação para o ícone de lixeira */
        #confirmDeleteModal .fa-trash-alt {
            animation: trashPulse 2s infinite;
        }

        @keyframes trashPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Responsividade para o modal de exclusão */
        @media (max-width: 768px) {
            #confirmDeleteModal .modal-dialog {
                margin: 1rem;
                max-width: calc(100% - 2rem);
            }

            #confirmDeleteModal .modal-body {
                padding: 20px;
            }

            #confirmDeleteModal .modal-header,
            #confirmDeleteModal .modal-footer {
                padding: 15px 20px;
            }

            #confirmDeleteModal .btn {
                padding: 12px 20px;
                font-size: 1rem;
                min-width: 100px;
            }

            #deletePreviewImg {
                max-height: 100px;
                max-width: 150px;
            }
        }

        /* Estilos para notificações toast */
        #notificacao-toast {
            animation: slideInRight 0.4s ease-out;
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(10px);
        }

        #notificacao-toast.alert-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-left: 4px solid #155724;
        }

        #notificacao-toast.alert-danger {
            background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
            color: white;
            border-left: 4px solid #721c24;
        }

        #notificacao-toast .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        #notificacao-toast .btn-close:hover {
            opacity: 1;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    </style>

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-clipboard-check me-2"></i>Nova Vistoria</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <form action="{{ route('vistorias.update', $vistoria->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Campo hidden para imagem do croqui (PNG gerado do canvas) -->
                                <input type="hidden" name="croqui_imagem_base64" id="croqui_imagem_base64">

                                <!-- Seção: Dados do Processo -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-file-alt me-2"></i>Dados do Processo</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="num_processo" class="form-label">Número do Processo</label>
                                                <input type="text"
                                                    class="form-control bg-light text-muted @error('num_processo') is-invalid @enderror"
                                                    id="num_processo" name="num_processo"
                                                    value="{{ old('num_processo', $vistoria->num_processo) }}" readonly>
                                                @error('num_processo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="requerente_nome" class="form-label">Requerente</label>
                                                <input type="text" class="form-control bg-light text-muted"
                                                    id="requerente_nome"
                                                    value="{{ $vistoria->requerente ? $vistoria->requerente->nome : '' }}"
                                                    readonly>
                                                <input type="hidden" name="requerente_id"
                                                    value="{{ $vistoria->requerente_id }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="requerido" class="form-label">Requerido</label>
                                                <input type="text"
                                                    class="form-control bg-light text-muted @error('requerido') is-invalid @enderror"
                                                    id="requerido" name="requerido"
                                                    value="{{ old('requerido', $vistoria->requerido) }}" readonly>
                                                @error('requerido')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Dados Pessoais -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Dados Pessoais</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="nome" class="form-label">Nome</label>
                                                <input type="text"
                                                    class="form-control @error('nome') is-invalid @enderror" id="nome"
                                                    name="nome" value="{{ old('nome', $vistoria->nome) }}" required>
                                                @error('nome')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="cpf" class="form-label">CPF</label>
                                                <input type="text"
                                                    class="form-control @error('cpf') is-invalid @enderror" id="cpf"
                                                    name="cpf" value="{{ old('cpf', $vistoria->cpf) }}" maxlength="11"
                                                    pattern="\d{11}" inputmode="numeric"
                                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0,11)"
                                                    title="Digite apenas 11 números">
                                                @error('cpf')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="telefone" class="form-label">Telefone</label>
                                                <input type="text"
                                                    class="form-control @error('telefone') is-invalid @enderror"
                                                    id="telefone" name="telefone"
                                                    value="{{ old('telefone', $vistoria->telefone) }}">
                                                @error('telefone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Endereço -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-map-marker-alt me-2"></i>Endereço</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="endereco" class="form-label">Endereço</label>
                                                <input type="text"
                                                    class="form-control @error('endereco') is-invalid @enderror"
                                                    id="endereco" name="endereco"
                                                    value="{{ old('endereco', $vistoria->endereco) }}" required>
                                                @error('endereco')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="num" class="form-label">Número</label>
                                                <input type="text"
                                                    class="form-control @error('num') is-invalid @enderror" id="num"
                                                    name="num" value="{{ old('num', $vistoria->num) }}">
                                                @error('num')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="bairro" class="form-label">Bairro</label>
                                                <input type="text"
                                                    class="form-control @error('bairro') is-invalid @enderror"
                                                    id="bairro" name="bairro"
                                                    value="{{ old('bairro', $vistoria->bairro) }}" required>
                                                @error('bairro')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="cidade" class="form-label">Cidade</label>
                                                <input type="text"
                                                    class="form-control @error('cidade') is-invalid @enderror"
                                                    id="cidade" name="cidade"
                                                    value="{{ old('cidade', $vistoria->cidade) }}" required>
                                                @error('cidade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="estado" class="form-label">Estado</label>
                                                <input type="text"
                                                    class="form-control @error('estado') is-invalid @enderror"
                                                    id="estado" name="estado"
                                                    value="{{ old('estado', $vistoria->estado) }}" maxlength="2"
                                                    required>
                                                @error('estado')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Características do Imóvel -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-home me-2"></i>Características do
                                        Imóvel</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Limites e Confrontações</label>
                                                <div class="row g-2">
                                                    <div class="col-md-3">
                                                        <input type="text"
                                                            class="form-control @error('limites_confrontacoes.norte') is-invalid @enderror"
                                                            name="limites_confrontacoes[norte]" placeholder="Norte"
                                                            value="{{ old('limites_confrontacoes.norte', is_array($vistoria->limites_confrontacoes) ? $vistoria->limites_confrontacoes['norte'] ?? '' : '') }}">
                                                        @error('limites_confrontacoes.norte')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text"
                                                            class="form-control @error('limites_confrontacoes.sul') is-invalid @enderror"
                                                            name="limites_confrontacoes[sul]" placeholder="Sul"
                                                            value="{{ old('limites_confrontacoes.sul', is_array($vistoria->limites_confrontacoes) ? $vistoria->limites_confrontacoes['sul'] ?? '' : '') }}">
                                                        @error('limites_confrontacoes.sul')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text"
                                                            class="form-control @error('limites_confrontacoes.leste') is-invalid @enderror"
                                                            name="limites_confrontacoes[leste]" placeholder="Leste"
                                                            value="{{ old('limites_confrontacoes.leste', is_array($vistoria->limites_confrontacoes) ? $vistoria->limites_confrontacoes['leste'] ?? '' : '') }}">
                                                        @error('limites_confrontacoes.leste')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text"
                                                            class="form-control @error('limites_confrontacoes.oeste') is-invalid @enderror"
                                                            name="limites_confrontacoes[oeste]" placeholder="Oeste"
                                                            value="{{ old('limites_confrontacoes.oeste', is_array($vistoria->limites_confrontacoes) ? $vistoria->limites_confrontacoes['oeste'] ?? '' : '') }}">
                                                        @error('limites_confrontacoes.oeste')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="lado_direito" class="form-label">Lado Direito</label>
                                                        <input type="text"
                                                            class="form-control @error('lado_direito') is-invalid @enderror"
                                                            id="lado_direito" name="lado_direito"
                                                            value="{{ old('lado_direito', $vistoria->lado_direito) }}">
                                                        @error('lado_direito')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="lado_esquerdo" class="form-label">Lado Esquerdo</label>
                                                        <input type="text"
                                                            class="form-control @error('lado_esquerdo') is-invalid @enderror"
                                                            id="lado_esquerdo" name="lado_esquerdo"
                                                            value="{{ old('lado_esquerdo', $vistoria->lado_esquerdo) }}">
                                                        @error('lado_esquerdo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
                                                    </div>
                                                </div>  -->

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="topografia" class="form-label">Topografia</label>
                                                <input type="text"
                                                    class="form-control @error('topografia') is-invalid @enderror"
                                                    id="topografia" name="topografia"
                                                    value="{{ old('topografia', $vistoria->topografia) }}">
                                                @error('topografia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="formato_terreno" class="form-label">Formato do Terreno</label>
                                                <input type="text"
                                                    class="form-control @error('formato_terreno') is-invalid @enderror"
                                                    id="formato_terreno" name="formato_terreno"
                                                    value="{{ old('formato_terreno', $vistoria->formato_terreno) }}">
                                                @error('formato_terreno')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="superficie" class="form-label">Superfície</label>
                                                <select class="form-select @error('superficie') is-invalid @enderror"
                                                    id="superficie" name="superficie" required>
                                                    <option value="">Selecione</option>
                                                    @foreach ($superficieValues as $superficie)
                                                        <option value="{{ $superficie }}"
                                                            {{ old('superficie', $vistoria->superficie) == $superficie ? 'selected' : '' }}>
                                                            {{ $superficie }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('superficie')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="documentacao" class="form-label">Documentação</label>
                                                <input type="text"
                                                    class="form-control @error('documentacao') is-invalid @enderror"
                                                    id="documentacao" name="documentacao"
                                                    value="{{ old('documentacao', $vistoria->documentacao) }}">
                                                @error('documentacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Ocupação -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-user-check me-2"></i>Ocupação</h5>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="reside_no_imovel" class="form-label">Reside no Imóvel</label>
                                                <select
                                                    class="form-select @error('reside_no_imovel') is-invalid @enderror"
                                                    id="reside_no_imovel" name="reside_no_imovel">
                                                    <option value="1"
                                                        {{ old('reside_no_imovel', $vistoria->reside_no_imovel) == '1' ? 'selected' : '' }}>
                                                        Sim</option>
                                                    <option value="0"
                                                        {{ old('reside_no_imovel', $vistoria->reside_no_imovel) == '0' ? 'selected' : '' }}>
                                                        Não</option>
                                                </select>
                                                @error('reside_no_imovel')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="data_ocupacao" class="form-label">Data de Ocupação</label>
                                                <input type="date"
                                                    class="form-control @error('data_ocupacao') is-invalid @enderror"
                                                    id="data_ocupacao" name="data_ocupacao"
                                                    value="{{ old('data_ocupacao', $vistoria->data_ocupacao) }}">
                                                @error('data_ocupacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="tipo_ocupacao" class="form-label">Tipo de Ocupação</label>
                                                <select class="form-select @error('tipo_ocupacao') is-invalid @enderror"
                                                    id="tipo_ocupacao" name="tipo_ocupacao" required>
                                                    <option value="">Selecione</option>
                                                    @foreach ($tipoOcupacaoValues as $tipo)
                                                        <option value="{{ $tipo }}"
                                                            {{ old('tipo_ocupacao', $vistoria->tipo_ocupacao) == $tipo ? 'selected' : '' }}>
                                                            {{ $tipo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('tipo_ocupacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="mb-3">
                                                <label for="exerce_pacificamente_posse" class="form-label">Exerce
                                                    Pacificamente a Posse</label>
                                                <select
                                                    class="form-select @error('exerce_pacificamente_posse') is-invalid @enderror"
                                                    id="exerce_pacificamente_posse" name="exerce_pacificamente_posse">
                                                    <option value="1"
                                                        {{ old('exerce_pacificamente_posse', $vistoria->exerce_pacificamente_posse) == '1' ? 'selected' : '' }}>
                                                        Sim</option>
                                                    <option value="0"
                                                        {{ old('exerce_pacificamente_posse', $vistoria->exerce_pacificamente_posse) == '0' ? 'selected' : '' }}>
                                                        Não</option>
                                                </select>
                                                @error('exerce_pacificamente_posse')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="utiliza_benfeitoria" class="form-label">Utilização da
                                                    Benfeitoria</label>
                                                <select
                                                    class="form-select @error('utiliza_benfeitoria') is-invalid @enderror"
                                                    id="utiliza_benfeitoria" name="utiliza_benfeitoria" required>
                                                    <option value="">Selecione</option>
                                                    <option value="Uso Próprio"
                                                        {{ old('utiliza_benfeitoria', $vistoria->utiliza_benfeitoria) == 'Uso Próprio' ? 'selected' : '' }}>
                                                        Uso Próprio</option>
                                                    <option value="Alugada"
                                                        {{ old('utiliza_benfeitoria', $vistoria->utiliza_benfeitoria) == 'Alugada' ? 'selected' : '' }}>
                                                        Alugada</option>
                                                    <option value="Outros"
                                                        {{ old('utiliza_benfeitoria', $vistoria->utiliza_benfeitoria) == 'Outros' ? 'selected' : '' }}>
                                                        Outros</option>
                                                </select>
                                                @error('utiliza_benfeitoria')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Construção -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-building me-2"></i>Construção</h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="tipo_construcao" class="form-label">Tipo de Construção</label>
                                                <input type="text"
                                                    class="form-control @error('tipo_construcao') is-invalid @enderror"
                                                    id="tipo_construcao" name="tipo_construcao"
                                                    value="{{ old('tipo_construcao', $vistoria->tipo_construcao) }}">
                                                @error('tipo_construcao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="padrao_acabamento" class="form-label">Padrão de
                                                    Acabamento</label>
                                                <input type="text"
                                                    class="form-control @error('padrao_acabamento') is-invalid @enderror"
                                                    id="padrao_acabamento" name="padrao_acabamento"
                                                    value="{{ old('padrao_acabamento', $vistoria->padrao_acabamento) }}">
                                                @error('padrao_acabamento')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="idade_aparente" class="form-label">Idade Aparente</label>
                                                <input type="text"
                                                    class="form-control @error('idade_aparente') is-invalid @enderror"
                                                    id="idade_aparente" name="idade_aparente"
                                                    value="{{ old('idade_aparente', $vistoria->idade_aparente) }}">
                                                @error('idade_aparente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="estado_conservacao" class="form-label">Estado de
                                                    Conservação</label>
                                                <select name="estado_conservacao" id="estado_conservacao"
                                                    class="form-select @error('estado_conservacao') is-invalid @enderror">
                                                    <option value="">Selecione...</option>
                                                    <option value="novo"
                                                        {{ old('estado_conservacao', $vistoria->estado_conservacao) == 'novo' ? 'selected' : '' }}>
                                                        Novo</option>
                                                    <option value="entre_regular_e_regular_reparos_simples"
                                                        {{ old('estado_conservacao', $vistoria->estado_conservacao) == 'entre_regular_e_regular_reparos_simples' ? 'selected' : '' }}>
                                                        Entre Regular e Regular e Reparo Simples</option>
                                                    <option value="entre_e_regular"
                                                        {{ old('estado_conservacao', $vistoria->estado_conservacao) == 'entre_e_regular' ? 'selected' : '' }}>
                                                        Entre e Regular</option>
                                                    <option value="reparos_simples"
                                                        {{ old('estado_conservacao', $vistoria->estado_conservacao) == 'reparos_simples' ? 'selected' : '' }}>
                                                        Reparos Simples</option>
                                                    <option value="regular"
                                                        {{ old('estado_conservacao', $vistoria->estado_conservacao) == 'regular' ? 'selected' : '' }}>
                                                        Regular</option>
                                                    <option value="entre_reparos_simples_e_importantes"
                                                        {{ old('estado_conservacao', $vistoria->estado_conservacao) == 'entre_reparos_simples_e_importantes' ? 'selected' : '' }}>
                                                        Entre reparos simples e Importantes</option>
                                                    <option value="reparos_importantes"
                                                        {{ old('estado_conservacao', $vistoria->estado_conservacao) == 'reparos_importantes' ? 'selected' : '' }}>
                                                        Reparos Importantes</option>
                                                </select>
                                                @error('estado_conservacao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Observações -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-sticky-note me-2"></i>Observações</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="observacoes" class="form-label">Observações</label>
                                                <textarea class="form-control @error('observacoes') is-invalid @enderror" id="observacoes" name="observacoes"
                                                    rows="3">{{ old('observacoes', $vistoria->observacoes) }}</textarea>
                                                @error('observacoes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Croqui da Edificação -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-pencil-ruler me-2"></i>Croqui da
                                        Edificação
                                    </h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <!-- Barra de Ferramentas do Croqui -->
                                                <div class="card border-0 shadow-sm mb-3">
                                                    <div class="card-body p-3">
                                                        <div class="row align-items-center">
                                                            <!-- Ferramentas de Desenho -->
                                                            <div class="col-md-6 mb-2 mb-md-0">
                                                                <label class="form-label mb-2 fw-bold text-secondary">
                                                                    <i class="fas fa-tools me-1"></i>Ferramentas:
                                                                </label>
                                                                <div class="btn-group btn-group-sm me-2" role="group">
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary fabric-tool active"
                                                                        data-tool="select" title="Selecionar">
                                                                        <i class="fas fa-mouse-pointer"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary fabric-tool"
                                                                        data-tool="draw" title="Desenho Livre">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary fabric-tool"
                                                                        data-tool="line" title="Linha">
                                                                        <i class="fas fa-slash"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary fabric-tool"
                                                                        data-tool="rectangle" title="Retângulo">
                                                                        <i class="far fa-square"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary fabric-tool"
                                                                        data-tool="circle" title="Círculo">
                                                                        <i class="far fa-circle"></i>
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary fabric-tool"
                                                                        data-tool="text" title="Texto">
                                                                        <i class="fas fa-font"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <!-- Controles de Aparência -->
                                                            <div class="col-md-6">
                                                                <div class="row g-2 align-items-center">
                                                                    <div class="col-auto">
                                                                        <label
                                                                            class="form-label mb-0 small text-secondary">Cor:</label>
                                                                        <input type="color" id="fabric-color-picker"
                                                                            value="#000000"
                                                                            class="form-control form-control-color form-control-sm">
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <label
                                                                            class="form-label mb-0 small text-secondary">Espessura:</label>
                                                                        <input type="range" id="fabric-stroke-width"
                                                                            min="1" max="10" value="2"
                                                                            class="form-range" style="width: 80px;">
                                                                        <span id="stroke-width-value"
                                                                            class="small text-muted">2px</span>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <div class="btn-group btn-group-sm">
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary"
                                                                                id="fabric-undo" title="Desfazer">
                                                                                <i class="fas fa-undo"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-outline-secondary"
                                                                                id="fabric-redo" title="Refazer">
                                                                                <i class="fas fa-redo"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-outline-danger"
                                                                                id="fabric-delete"
                                                                                title="Apagar Item Selecionado">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                            <button type="button"
                                                                                class="btn btn-outline-warning"
                                                                                id="fabric-clear" title="Limpar Tudo">
                                                                                <i class="fas fa-eraser"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Ferramentas Específicas para Croqui de Localização -->
                                                        <hr class="my-3">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label class="form-label mb-2 fw-bold text-secondary">
                                                                    <i class="fas fa-map-marked-alt me-1"></i>Elementos de
                                                                    Localização:
                                                                </label>
                                                                <div class="btn-group btn-group-sm me-2" role="group">
                                                                    <button type="button"
                                                                        class="btn btn-outline-success fabric-shape"
                                                                        data-shape="house" title="Casa/Edificação">
                                                                        <i class="fas fa-home"></i> Casa
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-info fabric-shape"
                                                                        data-shape="road" title="Rua/Via">
                                                                        <i class="fas fa-road"></i> Rua
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-warning fabric-shape"
                                                                        data-shape="tree" title="Árvore/Vegetação">
                                                                        <i class="fas fa-tree"></i> Árvore
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-secondary fabric-shape"
                                                                        data-shape="fence" title="Cerca/Muro">
                                                                        <i class="fas fa-border-style"></i> Cerca
                                                                    </button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-primary fabric-shape"
                                                                        data-shape="arrow" title="Seta Direcional">
                                                                        <i class="fas fa-arrow-up"></i> Seta
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Canvas do Croqui -->
                                                <div class="border rounded shadow-sm p-2 bg-white">
                                                    <canvas id="fabric-canvas" width="800" height="500"
                                                        style="border: 1px solid #dee2e6; border-radius: 4px; display: block; margin: 0 auto;"></canvas>
                                                </div>

                                                <input type="hidden" name="croqui" id="croqui">

                                                <!-- Instruções -->
                                                <div class="mt-3">
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        <strong>Instruções:</strong> Use as ferramentas acima para criar seu
                                                        croqui de localização.
                                                        Clique em "Selecionar" para mover ou redimensionar elementos.
                                                        Use os elementos de localização para marcar casas, ruas, árvores e
                                                        outros pontos de referência.
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Visualização da Imagem do Croqui Salvo -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-image me-2"></i>Imagem do Croqui (para
                                        impressão)</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if ($vistoria->croqui_imagem)
                                                <div class="mb-2">
                                                    <label class="form-label">Croqui atual salvo:</label><br>
                                                    <img src="{{ asset('storage/' . $vistoria->croqui_imagem) }}"
                                                        alt="Croqui atual"
                                                        style="max-width: 100%; max-height: 200px; border: 1px solid #ccc; border-radius: 6px;">
                                                </div>
                                            @else
                                                <div class="text-muted">Nenhum croqui foi cadastrado.</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Acompanhamento da Vistoria -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-users me-2"></i>Acompanhamento da
                                        Vistoria</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="acompanhamento_vistoria" class="form-label">Nome do
                                                    Acompanhante</label>
                                                <input type="text"
                                                    class="form-control @error('acompanhamento_vistoria') is-invalid @enderror"
                                                    id="acompanhamento_vistoria" name="acompanhamento_vistoria"
                                                    value="{{ old('acompanhamento_vistoria', $vistoria->acompanhamento_vistoria) }}">
                                                @error('acompanhamento_vistoria')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="cpf_acompanhante" class="form-label">CPF do
                                                    Acompanhante</label>
                                                <input type="text"
                                                    class="form-control @error('cpf_acompanhante') is-invalid @enderror"
                                                    id="cpf_acompanhante" name="cpf_acompanhante"
                                                    value="{{ old('cpf_acompanhante', $vistoria->cpf_acompanhante) }}"
                                                    maxlength="11" pattern="\d{11}" inputmode="numeric"
                                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0,11)"
                                                    title="Digite apenas 11 números">
                                                @error('cpf_acompanhante')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="telefone_acompanhante" class="form-label">Telefone do
                                                    Acompanhante</label>
                                                <input type="text"
                                                    class="form-control @error('telefone_acompanhante') is-invalid @enderror"
                                                    id="telefone_acompanhante" name="telefone_acompanhante"
                                                    value="{{ old('telefone_acompanhante', $vistoria->telefone_acompanhante) }}">
                                                @error('telefone_acompanhante')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Seção: Equipe Técnica -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-users-cog me-2"></i>Equipe Técnica</h5>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="membro_equipe" class="form-label">Selecionar Membro da
                                                    Equipe</label>
                                                <select class="form-select" id="membro_equipe" name="membro_equipe">
                                                    <option value="">Selecione um membro</option>
                                                    @foreach ($membrosEquipe as $membro)
                                                        <option value="{{ $membro->id }}"
                                                            data-nome="{{ $membro->nome }}"
                                                            data-cargo="{{ $membro->cargo }}"
                                                            data-telefone="{{ $membro->telefone }}">
                                                            {{ $membro->nome }} - {{ $membro->cargo }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4 d-flex align-items-end">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-primary" id="add-membro">
                                                    <i class="fas fa-plus me-2"></i>Adicionar Membro
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tabela de Membros Selecionados -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover" id="tabela-equipe">
                                                    <thead class="table-primary">
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Cargo</th>
                                                            <th>Telefone</th>
                                                            <th width="100">Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbody-equipe">
                                                        <!-- Membros adicionados aparecerão aqui -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="no-members-message" class="text-muted text-center py-3">
                                                Nenhum membro da equipe técnica foi adicionado ainda.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Campo hidden para enviar os IDs dos membros selecionados -->
                                    <input type="hidden" name="membros_equipe_ids" id="membros_equipe_ids"
                                        value="">
                                </div>

                                <!-- Seção: Fotos -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-camera me-2"></i>Fotos do Imóvel</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Botões de Ação para Fotos -->
                                            <div class="mb-3 d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-success btn-camera-action"
                                                    id="btn-tirar-foto">
                                                    <i class="fas fa-camera me-2"></i>Tirar Foto
                                                </button>
                                                <button type="button" class="btn btn-outline-primary btn-camera-action"
                                                    id="btn-adicionar-arquivo">
                                                    <i class="fas fa-upload me-2"></i>Da Galeria
                                                </button>
                                                <div class="ms-auto">
                                                    <small class="text-muted" id="contador-fotos">0 fotos
                                                        adicionadas</small>
                                                </div>
                                                <input type="file" id="file-input-hidden" accept="image/*"
                                                    style="display: none;" multiple>
                                            </div>

                                            <!-- Modal para Tirar Foto -->
                                            <div class="modal fade" id="cameraModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tirar Foto</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <video id="cameraVideo" autoplay playsinline
                                                                class="w-100 mb-3"
                                                                style="max-height: 400px; border-radius: 8px;"></video>
                                                            <canvas id="captureCanvas" style="display: none;"></canvas>
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                <button type="button" class="btn btn-primary"
                                                                    id="btn-capturar">
                                                                    <i class="fas fa-camera me-2"></i>Capturar
                                                                </button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    id="btn-trocar-camera">
                                                                    <i class="fas fa-sync-alt me-2"></i>Trocar Câmera
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal para Descrição da Foto -->
                                            <div class="modal fade modal-descricao-foto" id="descricaoModal"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i class="fas fa-image me-2"></i>Descrever Foto
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <div class="mb-4">
                                                                <img id="preview-foto-descricao" src=""
                                                                    alt="Preview da foto" class="foto-preview-modal">
                                                            </div>
                                                            <div class="text-start">
                                                                <label for="input-descricao-foto" class="form-label">
                                                                    <i class="fas fa-edit me-2"></i>Adicione uma descrição
                                                                    para esta foto:
                                                                </label>
                                                                <textarea class="form-control" id="input-descricao-foto" rows="4"
                                                                    placeholder="Ex: Fachada principal do imóvel, Sala de estar, Cozinha, etc."></textarea>

                                                                <!-- Sugestões rápidas -->
                                                                <div class="mt-3">
                                                                    <label class="form-label text-muted mb-2">
                                                                        <i class="fas fa-lightbulb me-1"></i>Sugestões
                                                                        rápidas:
                                                                    </label>
                                                                    <div class="d-flex flex-wrap gap-2"
                                                                        id="sugestoes-descricao">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm sugestao-btn"
                                                                            data-descricao="Fachada principal">
                                                                            Fachada principal
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm sugestao-btn"
                                                                            data-descricao="Sala de estar">
                                                                            Sala de estar
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm sugestao-btn"
                                                                            data-descricao="Cozinha">
                                                                            Cozinha
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm sugestao-btn"
                                                                            data-descricao="Banheiro">
                                                                            Banheiro
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm sugestao-btn"
                                                                            data-descricao="Quarto">
                                                                            Quarto
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm sugestao-btn"
                                                                            data-descricao="Área externa">
                                                                            Área externa
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm sugestao-btn"
                                                                            data-descricao="Detalhes construtivos">
                                                                            Detalhes construtivos
                                                                        </button>
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-sm sugestao-btn"
                                                                            data-descricao="Patologias encontradas">
                                                                            Patologias encontradas
                                                                        </button>
                                                                    </div>
                                                                </div>

                                                                <div class="form-text mt-2">
                                                                    <i class="fas fa-lightbulb me-1 text-warning"></i>
                                                                    A descrição ajuda na organização e identificação das
                                                                    fotos no relatório.
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-2"></i>Pular Descrição
                                                            </button>
                                                            <button type="button" class="btn btn-primary"
                                                                id="btn-salvar-descricao">
                                                                <i class="fas fa-check me-2"></i>Salvar Foto
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal para Confirmação de Exclusão -->
                                            <div class="modal fade" id="confirmDeleteModal" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow-lg">
                                                        <div class="modal-header border-0 bg-danger text-white">
                                                            <h5 class="modal-title fw-bold">
                                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                                Confirmar Exclusão
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Fechar"></button>
                                                        </div>
                                                        <div class="modal-body text-center py-4">
                                                            <div class="mb-3">
                                                                <i class="fas fa-trash-alt text-danger"
                                                                    style="font-size: 3rem;"></i>
                                                            </div>
                                                            <h6 class="fw-bold mb-3">Deseja realmente excluir esta foto?
                                                            </h6>
                                                            <p class="text-muted mb-0">Esta ação não pode ser desfeita. A
                                                                foto será removida permanentemente.</p>
                                                            <div class="mt-3">
                                                                <img id="deletePreviewImg" src="" alt="Preview"
                                                                    class="img-thumbnail"
                                                                    style="max-height: 120px; max-width: 200px;">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer border-0 justify-content-center pb-4">
                                                            <button type="button"
                                                                class="btn btn-outline-secondary px-4 me-2"
                                                                data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-2"></i>Cancelar
                                                            </button>
                                                            <button type="button" class="btn btn-danger px-4"
                                                                id="confirmDeleteBtn">
                                                                <i class="fas fa-trash me-2"></i>Sim, Excluir
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Preview das Fotos -->
                                            <div id="fotos-preview" class="row"></div>
                                            <div id="fotos-inputs-container"></div>

                                            <!-- Container para IDs de fotos existentes removidas -->
                                            <div id="fotos-removidas-container"></div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Botões de Ação -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Salvar
                                    </button>
                                    <a href="{{ route('vistorias.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-2"></i>Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- INÍCIO: Carregar fotos existentes do backend ---
        const fotosExistentes = [
            @foreach ($vistoria->fotos as $foto)
                {
                    id: 'foto_existente_{{ $foto->id }}',
                    data: '{{ asset('storage/' . $foto->url) }}',
                    descricao: @json($foto->descricao ?? ''),
                    nome: '{{ basename($foto->url) }}',
                    existente: true,
                    foto_id: {{ $foto->id }}
                },
            @endforeach
        ];
        // --- FIM: Carregar fotos existentes do backend ---

        // --- INÍCIO: Carregar membros existentes do backend ---
        const membrosExistentes = [
            @foreach ($vistoria->membrosEquipeTecnica as $membro)
                {
                    id: '{{ $membro->id }}',
                    nome: '{{ $membro->nome }}',
                    cargo: '{{ $membro->cargo }}',
                    telefone: '{{ $membro->telefone ?? '' }}'
                },
            @endforeach
        ];
        // --- FIM: Carregar membros existentes do backend ---

        // --- INÍCIO: Variáveis globais para controle de fotos ---
        let fotosData = [];
        let fotosRemovidasIds = [];
        let fotoCounter = 0;
        // --- FIM: Variáveis globais para controle de fotos ---

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM carregado, iniciando script...');
            console.log('Fotos existentes:', fotosExistentes);
            console.log('Membros existentes:', membrosExistentes);
            // Controle de fotos removidas (variáveis antigas não são mais necessárias)
            let fotoCount = 1;

            // Controle da Equipe Técnica
            const membroSelect = document.getElementById('membro_equipe');
            const addMembroBtn = document.getElementById('add-membro');
            const tabelaEquipe = document.getElementById('tabela-equipe');
            const tbodyEquipe = document.getElementById('tbody-equipe');
            const noMembersMessage = document.getElementById('no-members-message');
            const membrosEquipeIds = document.getElementById('membros_equipe_ids');
            let membrosAdicionados = [];

            // Função para atualizar a visibilidade da tabela
            function updateTableVisibility() {
                if (membrosAdicionados.length > 0) {
                    tabelaEquipe.style.display = 'table';
                    noMembersMessage.style.display = 'none';
                } else {
                    tabelaEquipe.style.display = 'none';
                    noMembersMessage.style.display = 'block';
                }
            }

            // Função para atualizar o campo hidden com os IDs dos membros
            function updateMembrosIds() {
                const ids = membrosAdicionados.map(membro => membro.id);
                membrosEquipeIds.value = JSON.stringify(ids);
            }

            // Função para adicionar membro à tabela
            function adicionarMembro() {
                const selectedOption = membroSelect.options[membroSelect.selectedIndex];

                if (membroSelect.value === '') {
                    alert('Por favor, selecione um membro da equipe.');
                    return;
                }

                const membroId = selectedOption.value;
                const membroNome = selectedOption.getAttribute('data-nome');
                const membroCargo = selectedOption.getAttribute('data-cargo');
                const membroTelefone = selectedOption.getAttribute('data-telefone');

                // Verificar se o membro já foi adicionado
                if (membrosAdicionados.some(membro => membro.id === membroId)) {
                    alert('Este membro já foi adicionado à equipe.');
                    return;
                }

                // Adicionar membro ao array
                const novoMembro = {
                    id: membroId,
                    nome: membroNome,
                    cargo: membroCargo,
                    telefone: membroTelefone
                };
                membrosAdicionados.push(novoMembro);

                // Criar nova linha na tabela
                const novaLinha = document.createElement('tr');
                novaLinha.innerHTML = `
                        <td>${membroNome}</td>
                        <td>${membroCargo}</td>
                        <td>${membroTelefone || 'N/A'}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-membro" data-id="${membroId}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;

                tbodyEquipe.appendChild(novaLinha);

                // Adicionar evento de remoção
                const removeBtn = novaLinha.querySelector('.remove-membro');
                removeBtn.addEventListener('click', function() {
                    removerMembro(this.getAttribute('data-id'), novaLinha);
                });

                // Resetar o select
                membroSelect.value = '';

                // Atualizar visibilidade e campo hidden
                updateTableVisibility();
                updateMembrosIds();
            }

            // Função para remover membro
            function removerMembro(membroId, linha) {
                // Remover do array
                membrosAdicionados = membrosAdicionados.filter(membro => membro.id !== membroId);

                // Remover da tabela
                linha.remove();

                // Atualizar visibilidade e campo hidden
                updateTableVisibility();
                updateMembrosIds();
            }

            // Event listener para o botão de adicionar membro
            addMembroBtn.addEventListener('click', adicionarMembro);

            // Inicializar visibilidade da tabela
            updateTableVisibility();

            // Controle de Fotos com Câmera
            const btnTirarFoto = document.getElementById('btn-tirar-foto');
            const btnAdicionarArquivo = document.getElementById('btn-adicionar-arquivo');
            const fileInputHidden = document.getElementById('file-input-hidden');
            const cameraModal = new bootstrap.Modal(document.getElementById('cameraModal'));
            const cameraVideo = document.getElementById('cameraVideo');
            const captureCanvas = document.getElementById('captureCanvas');
            const btnCapturar = document.getElementById('btn-capturar');
            const btnTrocarCamera = document.getElementById('btn-trocar-camera');
            const fotosPreview = document.getElementById('fotos-preview');
            const fotosInputsContainer = document.getElementById('fotos-inputs-container');

            let currentStream = null;
            let currentFacingMode = 'environment'; // 'user' para frontal, 'environment' para traseira

            // Função para iniciar a câmera
            async function iniciarCamera() {
                try {
                    if (currentStream) {
                        currentStream.getTracks().forEach(track => track.stop());
                    }

                    const constraints = {
                        video: {
                            facingMode: currentFacingMode,
                            width: {
                                ideal: 1920
                            },
                            height: {
                                ideal: 1080
                            }
                        }
                    };

                    currentStream = await navigator.mediaDevices.getUserMedia(constraints);
                    cameraVideo.srcObject = currentStream;
                } catch (error) {
                    console.error('Erro ao acessar a câmera:', error);
                    alert('Não foi possível acessar a câmera. Verifique as permissões.');
                }
            }

            // Função para capturar foto
            function capturarFoto() {
                const context = captureCanvas.getContext('2d');
                captureCanvas.width = cameraVideo.videoWidth;
                captureCanvas.height = cameraVideo.videoHeight;

                context.drawImage(cameraVideo, 0, 0);

                // Converter para base64 com qualidade otimizada para tablet
                const dataURL = captureCanvas.toDataURL('image/jpeg', 0.8);

                // Fechar modal da câmera e parar stream
                cameraModal.hide();
                if (currentStream) {
                    currentStream.getTracks().forEach(track => track.stop());
                    currentStream = null;
                }

                // Mostrar modal de descrição com preview da foto
                mostrarModalDescricao(dataURL);
            }

            // Função para mostrar modal de descrição
            function mostrarModalDescricao(dataURL, nomeArquivoOriginal = null) {
                const descricaoModal = new bootstrap.Modal(document.getElementById('descricaoModal'));
                const previewImg = document.getElementById('preview-foto-descricao');
                const inputDescricao = document.getElementById('input-descricao-foto');
                const btnSalvarDescricao = document.getElementById('btn-salvar-descricao');

                // Configurar preview da imagem
                previewImg.src = dataURL;
                inputDescricao.value = '';

                // Sugerir descrição baseada no nome do arquivo se for da galeria
                if (nomeArquivoOriginal) {
                    const nomeBase = nomeArquivoOriginal.replace(/\.[^/.]+$/, ""); // Remove extensão
                    const nomeLimpo = nomeBase.replace(/[_-]/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    inputDescricao.placeholder = `Ex: ${nomeLimpo}, Fachada principal, Sala de estar...`;
                } else {
                    inputDescricao.placeholder = "Ex: Fachada principal do imóvel, Sala de estar, Cozinha, etc.";
                }

                // Remover listeners anteriores para evitar duplicação
                const newBtnSalvar = btnSalvarDescricao.cloneNode(true);
                btnSalvarDescricao.parentNode.replaceChild(newBtnSalvar, btnSalvarDescricao);

                // Permitir salvar com Enter
                const newInputDescricao = inputDescricao.cloneNode(true);
                inputDescricao.parentNode.replaceChild(newInputDescricao, inputDescricao);

                // Adicionar listener para salvar
                newBtnSalvar.addEventListener('click', function() {
                    const descricao = newInputDescricao.value.trim();
                    const nomeArquivo = nomeArquivoOriginal || `foto_${Date.now()}.jpg`;

                    // Fechar modal com animação suave
                    descricaoModal.hide();

                    // Adicionar foto com descrição após pequeno delay para suavizar transição
                    setTimeout(() => {
                        adicionarFoto(dataURL, descricao, nomeArquivo);
                    }, 300);
                });

                newInputDescricao.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        newBtnSalvar.click();
                    }
                });

                // Adicionar contador de caracteres
                const contadorCaracteres = document.createElement('div');
                contadorCaracteres.className = 'form-text text-muted mt-2';
                contadorCaracteres.innerHTML = '<i class="fas fa-keyboard me-1"></i>0 caracteres';
                newInputDescricao.parentNode.appendChild(contadorCaracteres);

                newInputDescricao.addEventListener('input', function() {
                    const length = this.value.length;
                    contadorCaracteres.innerHTML =
                        `<i class="fas fa-keyboard me-1"></i>${length} caracteres`;

                    if (length > 200) {
                        contadorCaracteres.className = 'form-text text-warning mt-2';
                        contadorCaracteres.innerHTML =
                            `<i class="fas fa-exclamation-triangle me-1"></i>${length} caracteres (muito longo)`;
                    } else if (length > 100) {
                        contadorCaracteres.className = 'form-text text-info mt-2';
                        contadorCaracteres.innerHTML =
                            `<i class="fas fa-info-circle me-1"></i>${length} caracteres`;
                    } else {
                        contadorCaracteres.className = 'form-text text-muted mt-2';
                        contadorCaracteres.innerHTML =
                            `<i class="fas fa-keyboard me-1"></i>${length} caracteres`;
                    }

                    // Remover seleção das sugestões quando o usuário digita
                    document.querySelectorAll('.sugestao-btn.selected').forEach(btn => {
                        btn.classList.remove('selected');
                    });
                });

                // Adicionar funcionalidade às sugestões
                document.querySelectorAll('.sugestao-btn').forEach(btn => {
                    // Remover listeners anteriores
                    btn.replaceWith(btn.cloneNode(true));
                });

                document.querySelectorAll('.sugestao-btn').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const descricao = this.dataset.descricao;

                        // Remover seleção de outras sugestões
                        document.querySelectorAll('.sugestao-btn.selected').forEach(otherBtn => {
                            otherBtn.classList.remove('selected');
                        });

                        // Marcar esta sugestão como selecionada
                        this.classList.add('selected');

                        // Definir a descrição no textarea
                        newInputDescricao.value = descricao;

                        // Atualizar contador
                        const length = descricao.length;
                        contadorCaracteres.innerHTML =
                            `<i class="fas fa-keyboard me-1"></i>${length} caracteres`;
                        contadorCaracteres.className = 'form-text text-muted mt-2';

                        // Focar no textarea para permitir edição
                        newInputDescricao.focus();
                    });
                });

                // Mostrar modal
                descricaoModal.show();

                // Focar no input após modal abrir
                document.getElementById('descricaoModal').addEventListener('shown.bs.modal', function() {
                    newInputDescricao.focus();
                    // Adicionar efeito suave de entrada
                    previewImg.style.transform = 'scale(0.8)';
                    previewImg.style.opacity = '0';
                    setTimeout(() => {
                        previewImg.style.transition = 'all 0.3s ease';
                        previewImg.style.transform = 'scale(1)';
                        previewImg.style.opacity = '1';
                    }, 100);
                }, {
                    once: true
                });

                // Limpar contador e efeitos quando modal for fechado
                document.getElementById('descricaoModal').addEventListener('hidden.bs.modal', function() {
                    if (contadorCaracteres.parentNode) {
                        contadorCaracteres.remove();
                    }
                    previewImg.style.transition = '';
                    previewImg.style.transform = '';
                    previewImg.style.opacity = '';
                }, {
                    once: true
                });
            } // Função para adicionar foto ao preview e aos dados
            function adicionarFoto(dataURL, descricao, nomeArquivo) {
                const fotoId = `foto_${fotoCounter++}`;

                // Adicionar aos dados
                fotosData.push({
                    id: fotoId,
                    data: dataURL,
                    descricao: descricao || '', // Garantir que não seja undefined
                    nome: nomeArquivo
                });

                // Criar preview
                const fotoDiv = document.createElement('div');
                fotoDiv.className = 'col-md-6 col-lg-4 mb-3';
                fotoDiv.id = fotoId;
                fotoDiv.innerHTML = `
                        <div class="card foto-preview-card">
                            <img src="${dataURL}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-2">
                                <div class="mb-2">
                                    <input type="text" class="form-control form-control-sm"
                                           placeholder="Descrição da foto"
                                           value="${descricao || ''}"
                                           onchange="atualizarDescricaoFoto('${fotoId}', this.value)">
                                </div>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-danger flex-fill"
                                            onclick="removerFoto('${fotoId}')">
                                        <i class="fas fa-trash"></i> Remover
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;

                fotosPreview.appendChild(fotoDiv);
                atualizarInputsHidden();

                // Feedback visual
                const btnTirarFoto = document.getElementById('btn-tirar-foto');
                if (btnTirarFoto) {
                    const originalClass = btnTirarFoto.className;
                    const originalText = btnTirarFoto.innerHTML;

                    btnTirarFoto.className = 'btn btn-success btn-camera-action';
                    btnTirarFoto.innerHTML = '<i class="fas fa-check me-2"></i>Foto Adicionada!';

                    setTimeout(() => {
                        btnTirarFoto.className = originalClass;
                        btnTirarFoto.innerHTML = originalText;
                    }, 2000);
                }
            }

            // Função para remover foto
            window.removerFoto = function(fotoId) {
                // Obter a imagem para mostrar no modal
                const fotoElement = document.getElementById(fotoId);
                const imgSrc = fotoElement ? fotoElement.querySelector('img').src : '';

                // Configurar o modal de confirmação
                const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                const deletePreviewImg = document.getElementById('deletePreviewImg');
                const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

                // Definir a imagem de preview
                deletePreviewImg.src = imgSrc;

                // Armazenar informações da foto no modal
                deleteModal._currentFotoId = fotoId;

                // Remover listeners anteriores para evitar duplicação
                const newConfirmBtn = confirmDeleteBtn.cloneNode(true);
                confirmDeleteBtn.parentNode.replaceChild(newConfirmBtn, confirmDeleteBtn);

                // Adicionar listener para confirmação
                newConfirmBtn.addEventListener('click', function() {
                    const currentFotoId = deleteModal._currentFotoId;

                    // Fechar o modal
                    deleteModal.hide();

                    console.log('Removendo foto nova:', currentFotoId);

                    // Adicionar efeito de fade out
                    const elemento = document.getElementById(currentFotoId);
                    if (elemento) {
                        elemento.style.transition = 'all 0.3s ease';
                        elemento.style.transform = 'scale(0.8)';
                        elemento.style.opacity = '0';

                        setTimeout(() => {
                            // Remove do array local
                            console.log('Removendo foto nova do array. ID:', currentFotoId);
                            console.log('Array antes:', fotosData.length, 'fotos');
                            fotosData = fotosData.filter(foto => foto.id !== currentFotoId);
                            console.log('Array depois:', fotosData.length, 'fotos');

                            // Remove da tela
                            elemento.remove();
                            console.log('✓ Foto nova removida da tela');

                            // Atualiza inputs E contador
                            atualizarInputsHidden();

                            // Mostrar notificação de sucesso
                            mostrarNotificacao('Foto removida com sucesso!', 'success');
                        }, 300);
                    }
                });

                // Mostrar o modal
                deleteModal.show();
            };

            // Função para atualizar descrição
            window.atualizarDescricaoFoto = function(fotoId, novaDescricao) {
                const foto = fotosData.find(f => f.id === fotoId);
                if (foto) {
                    foto.descricao = novaDescricao;
                    atualizarInputsHidden();
                }
            }; // Função para atualizar inputs hidden
            function atualizarInputsHidden() {
                // Primeiro, limpar fotosData de fotos que não existem mais na DOM
                fotosData = fotosData.filter(foto => {
                    const elementoExiste = document.getElementById(foto.id);
                    if (!elementoExiste) {
                        console.log('Removendo foto do array (não existe na DOM):', foto.id);
                        return false;
                    }
                    return true;
                });

                fotosInputsContainer.innerHTML = '';

                console.log('Atualizando inputs hidden para', fotosData.length, 'fotos');

                fotosData.forEach((foto, index) => {
                    // Só processar fotos que não são existentes (fotos novas precisam ser enviadas via base64)
                    if (!foto.existente) {
                        // Input para foto em base64 (só para fotos novas)
                        const inputFoto = document.createElement('input');
                        inputFoto.type = 'hidden';
                        inputFoto.name = `fotos_base64[${index}]`;
                        inputFoto.value = foto.data;
                        fotosInputsContainer.appendChild(inputFoto);

                        // Input para descrição
                        const inputDescricao = document.createElement('input');
                        inputDescricao.type = 'hidden';
                        inputDescricao.name = `descricoes[${index}]`;
                        inputDescricao.value = foto.descricao || '';
                        fotosInputsContainer.appendChild(inputDescricao);

                        // Input para nome do arquivo
                        const inputNome = document.createElement('input');
                        inputNome.type = 'hidden';
                        inputNome.name = `nomes_arquivos[${index}]`;
                        inputNome.value = foto.nome;
                        fotosInputsContainer.appendChild(inputNome);
                    }
                });

                // Atualizar inputs de fotos removidas
                const fotosRemovidasContainer = document.getElementById('fotos-removidas-container');
                if (fotosRemovidasContainer) {
                    fotosRemovidasContainer.innerHTML = '';
                    fotosRemovidasIds.forEach((fotoId, index) => {
                        const inputRemovida = document.createElement('input');
                        inputRemovida.type = 'hidden';
                        inputRemovida.name = `fotos_removidas[${index}]`;
                        inputRemovida.value = fotoId;
                        fotosRemovidasContainer.appendChild(inputRemovida);
                    });
                }

                // Atualizar contador
                const contadorFotos = document.getElementById('contador-fotos');
                if (contadorFotos) {
                    const quantidade = fotosData.length;

                    console.log('Atualizando contador:', quantidade, 'fotos totais');
                    contadorFotos.textContent =
                        `${quantidade} foto${quantidade !== 1 ? 's' : ''} adicionada${quantidade !== 1 ? 's' : ''}`;
                    contadorFotos.className = quantidade > 0 ? 'text-success' : 'text-muted';
                }
            }

            // --- INÍCIO: Popular preview com fotos existentes ---
            console.log('Tentando carregar', fotosExistentes.length, 'fotos existentes');
            if (fotosExistentes.length > 0) {
                fotosExistentes.forEach(foto => {
                    console.log('Carregando foto:', foto);
                    fotosData.push(foto);
                    // Criar preview
                    const fotoDiv = document.createElement('div');
                    fotoDiv.className = 'col-md-6 col-lg-4 mb-3';
                    fotoDiv.id = foto.id;
                    fotoDiv.innerHTML = `
                        <div class="card foto-preview-card">
                            <img src="${foto.data}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-2">
                                <div class="mb-2">
                                    <input type="text" class="form-control form-control-sm"
                                           placeholder="Descrição da foto"
                                           value="${foto.descricao || ''}"
                                           onchange="atualizarDescricaoFoto('${foto.id}', this.value)">
                                </div>
                                <div class="d-flex gap-1">
                                    <button type="button" class="btn btn-sm btn-outline-danger flex-fill"
                                            onclick="removerFotoExistente('${foto.id}', ${foto.foto_id})">
                                        <i class="fas fa-trash"></i> Remover
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    const fotosPreview = document.getElementById('fotos-preview');
                    if (fotosPreview) {
                        fotosPreview.appendChild(fotoDiv);
                        console.log('Foto adicionada ao preview:', foto.id);
                    } else {
                        console.error('Elemento fotos-preview não encontrado!');
                    }
                });
                atualizarInputsHidden();
            } else {
                console.log('Nenhuma foto existente encontrada');
                // Inicializar contador mesmo sem fotos
                atualizarInputsHidden();
            }
            // --- FIM: Popular preview com fotos existentes ---

            // --- INÍCIO: Popular tabela com membros existentes ---
            if (membrosExistentes.length > 0) {
                membrosExistentes.forEach(membro => {
                    membrosAdicionados.push(membro);

                    // Criar nova linha na tabela
                    const novaLinha = document.createElement('tr');
                    novaLinha.innerHTML = `
                        <td>${membro.nome}</td>
                        <td>${membro.cargo}</td>
                        <td>${membro.telefone || 'N/A'}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-membro" data-id="${membro.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    `;

                    tbodyEquipe.appendChild(novaLinha);

                    // Adicionar evento de remoção
                    const removeBtn = novaLinha.querySelector('.remove-membro');
                    removeBtn.addEventListener('click', function() {
                        removerMembro(this.getAttribute('data-id'), novaLinha);
                    });
                });

                updateTableVisibility();
                updateMembrosIds();
            }
            // --- FIM: Popular tabela com membros existentes ---

            // Event Listeners
            btnTirarFoto.addEventListener('click', function() {
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    cameraModal.show();
                    setTimeout(iniciarCamera, 500); // Aguardar modal abrir
                } else {
                    alert('Câmera não disponível neste dispositivo/navegador.');
                }
            });

            btnCapturar.addEventListener('click', capturarFoto);

            btnTrocarCamera.addEventListener('click', function() {
                currentFacingMode = currentFacingMode === 'user' ? 'environment' : 'user';
                iniciarCamera();
            });

            btnAdicionarArquivo.addEventListener('click', function() {
                fileInputHidden.click();
            });

            fileInputHidden.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);

                files.forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            // Para múltiplos arquivos, adicionar um pequeno delay entre os modais
                            setTimeout(() => {
                                mostrarModalDescricao(event.target.result, file.name);
                            }, index * 100);
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Limpar input
                e.target.value = '';
            });

            // Parar câmera quando modal é fechado
            document.getElementById('cameraModal').addEventListener('hidden.bs.modal', function() {
                if (currentStream) {
                    currentStream.getTracks().forEach(track => track.stop());
                    currentStream = null;
                }
            });

            // Salvar dados no localStorage antes de qualquer ação que possa sair da página
            function salvarDadosTemporarios() {
                const formData = new FormData(document.querySelector('form'));
                const dadosTemp = {};

                for (let [key, value] of formData.entries()) {
                    if (key !== 'fotos_base64[]' && key !== '_token') {
                        dadosTemp[key] = value;
                    }
                }

                localStorage.setItem('vistoria_temp_dados', JSON.stringify(dadosTemp));
                localStorage.setItem('vistoria_temp_fotos', JSON.stringify(fotosData));
                localStorage.setItem('vistoria_temp_membros', JSON.stringify(membrosAdicionados));
                localStorage.setItem('vistoria_temp_fotos_removidas', JSON.stringify(fotosRemovidasIds));
            }



            // Salvar dados automaticamente a cada mudança
            document.addEventListener('change', salvarDadosTemporarios);
            document.addEventListener('input', salvarDadosTemporarios);

            // Limpar dados temporários ao enviar formulário com sucesso

            document.querySelector('form').addEventListener('submit', function(e) {
                salvarDadosTemporarios(); // Salvar uma última vez
                saveCroqui(); // Isso chamará saveCroquiData e preencherá ambos os campos

                // Verificar se há desenho no canvas
                if (window.fabricCanvas && window.fabricCanvas.getObjects().length === 0) {
                    e.preventDefault();
                    alert('Por favor, desenhe o croqui antes de salvar!');
                    return false;
                }

                // Verificar se o campo foi preenchido
                const croquiBase64 = document.getElementById('croqui_imagem_base64').value;
                if (!croquiBase64) {
                    e.preventDefault();
                    alert('Por favor, desenhe o croqui antes de salvar!');
                    return false;
                }

                console.log('Formulário será enviado com croqui_imagem_base64:', croquiBase64.substring(0,
                    50) + '...');

                // Limpar após um pequeno delay (para garantir que o formulário foi enviado)
                setTimeout(() => {
                    localStorage.removeItem('vistoria_temp_dados');
                    localStorage.removeItem('vistoria_temp_fotos');
                    localStorage.removeItem('vistoria_temp_membros');
                    localStorage.removeItem('vistoria_temp_fotos_removidas');
                }, 1000);
            });

            // Remover referência ao select antigo
            // const toolSelect = document.getElementById('tool-select'); // REMOVIDO

            // ==================== FABRIC.JS CROQUI ====================
            let fabricCanvas;
            let currentTool = 'select';
            let isDrawing = false;
            let drawingPath = null;
            let undoStack = [];
            let redoStack = [];

            // Inicializar Fabric.js Canvas
            function initFabricCanvas() {
                // Verificar se o Fabric.js está carregado
                if (typeof fabric === 'undefined') {
                    console.error('Fabric.js não foi carregado!');
                    alert('Erro: Fabric.js não foi carregado. Verifique sua conexão ou tente recarregar a página.');
                    return;
                }

                fabricCanvas = new fabric.Canvas('fabric-canvas', {
                    backgroundColor: '#ffffff',
                    selection: true,
                    preserveObjectStacking: true
                });

                // Tornar o canvas acessível globalmente
                window.fabricCanvas = fabricCanvas;

                // Configurar responsividade
                setCanvasSize();
                window.addEventListener('resize', setCanvasSize);

                // Carregar croqui existente se houver
                @if ($vistoria->croqui)
                    loadExistingCroqui(@json($vistoria->croqui));
                @endif

                // Configurar eventos
                setupFabricEvents();
                setupToolEvents();
                setupControlEvents();

                // Salvar estado inicial
                saveCanvasState();
            }

            // Configurar tamanho do canvas
            function setCanvasSize() {
                const container = document.querySelector('.canvas-container');
                if (container) {
                    const containerWidth = container.offsetWidth - 20;
                    const maxWidth = Math.min(containerWidth, 800);
                    const height = Math.min(500, maxWidth * 0.625);

                    fabricCanvas.setWidth(maxWidth);
                    fabricCanvas.setHeight(height);
                    fabricCanvas.renderAll();
                }
            }

            // Carregar croqui existente
            function loadExistingCroqui(croquisData) {
                try {
                    fabricCanvas.loadFromJSON(croquisData, function() {
                        fabricCanvas.renderAll();
                    });
                } catch (e) {
                    console.log('Erro ao carregar croqui:', e);
                }
            }

            // Configurar eventos do Fabric.js
            function setupFabricEvents() {
                // Eventos de desenho livre
                fabricCanvas.on('path:created', function(e) {
                    saveCanvasState();
                    saveCroquiData();
                });

                // Eventos de modificação de objetos
                fabricCanvas.on('object:modified', function(e) {
                    saveCanvasState();
                    saveCroquiData();
                });

                // Eventos de adição de objetos
                fabricCanvas.on('object:added', function(e) {
                    if (e.target.type !== 'path') {
                        saveCanvasState();
                        saveCroquiData();
                    }
                });

                // Eventos de remoção de objetos
                fabricCanvas.on('object:removed', function(e) {
                    saveCanvasState();
                    saveCroquiData();
                });
            }

            // Configurar eventos das ferramentas
            function setupToolEvents() {
                // Botões de ferramentas
                document.querySelectorAll('.fabric-tool').forEach(btn => {
                    btn.addEventListener('click', function() {
                        // Remover classe active de todos os botões
                        document.querySelectorAll('.fabric-tool').forEach(b => b.classList.remove(
                            'active'));
                        this.classList.add('active');

                        currentTool = this.getAttribute('data-tool');
                        setCanvasMode(currentTool);
                    });
                });

                // Botões de formas pré-definidas
                document.querySelectorAll('.fabric-shape').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const shape = this.getAttribute('data-shape');
                        addPredefinedShape(shape);
                    });
                });
            }

            // Configurar eventos dos controles
            function setupControlEvents() {
                // Seletor de cor
                document.getElementById('fabric-color-picker').addEventListener('change', function() {
                    const color = this.value;
                    fabricCanvas.freeDrawingBrush.color = color;

                    // Aplicar cor ao objeto selecionado
                    const activeObject = fabricCanvas.getActiveObject();
                    if (activeObject) {
                        if (activeObject.type === 'text') {
                            activeObject.set('fill', color);
                        } else {
                            activeObject.set('stroke', color);
                        }
                        fabricCanvas.renderAll();
                        saveCroquiData();
                    }
                });

                // Controle de espessura
                const strokeWidthSlider = document.getElementById('fabric-stroke-width');
                const strokeWidthValue = document.getElementById('stroke-width-value');

                strokeWidthSlider.addEventListener('input', function() {
                    const width = parseInt(this.value);
                    strokeWidthValue.textContent = width + 'px';
                    fabricCanvas.freeDrawingBrush.width = width;

                    // Aplicar espessura ao objeto selecionado
                    const activeObject = fabricCanvas.getActiveObject();
                    if (activeObject && activeObject.type !== 'text') {
                        activeObject.set('strokeWidth', width);
                        fabricCanvas.renderAll();
                        saveCroquiData();
                    }
                });

                // Botões de controle
                document.getElementById('fabric-undo').addEventListener('click', undoCanvas);
                document.getElementById('fabric-redo').addEventListener('click', redoCanvas);
                document.getElementById('fabric-delete').addEventListener('click', deleteSelectedObject);
                document.getElementById('fabric-clear').addEventListener('click', clearCanvas);
            }

            // Definir modo do canvas
            function setCanvasMode(tool) {
                // Resetar modos
                fabricCanvas.isDrawingMode = false;
                fabricCanvas.selection = true;
                fabricCanvas.forEachObject(function(obj) {
                    obj.selectable = true;
                    obj.evented = true;
                });

                switch (tool) {
                    case 'select':
                        fabricCanvas.defaultCursor = 'default';
                        break;
                    case 'draw':
                        fabricCanvas.isDrawingMode = true;
                        fabricCanvas.freeDrawingBrush.width = parseInt(document.getElementById(
                            'fabric-stroke-width').value);
                        fabricCanvas.freeDrawingBrush.color = document.getElementById('fabric-color-picker').value;
                        fabricCanvas.defaultCursor = 'crosshair';
                        break;
                    case 'line':
                    case 'rectangle':
                    case 'circle':
                    case 'text':
                        fabricCanvas.defaultCursor = 'crosshair';
                        fabricCanvas.selection = false;
                        setupShapeDrawing(tool);
                        break;
                }
            }

            // Configurar desenho de formas
            function setupShapeDrawing(tool) {
                let isDown = false;
                let origX, origY;
                let shape = null;

                fabricCanvas.on('mouse:down', function(o) {
                    if (currentTool !== tool) return;

                    isDown = true;
                    const pointer = fabricCanvas.getPointer(o.e);
                    origX = pointer.x;
                    origY = pointer.y;

                    if (tool === 'text') {
                        addTextAtPosition(origX, origY);
                        return;
                    }

                    // Criar forma temporária
                    shape = createShape(tool, origX, origY, 0, 0);
                    fabricCanvas.add(shape);
                    fabricCanvas.renderAll();
                });

                fabricCanvas.on('mouse:move', function(o) {
                    if (!isDown || currentTool !== tool || tool === 'text') return;

                    const pointer = fabricCanvas.getPointer(o.e);
                    const width = Math.abs(origX - pointer.x);
                    const height = Math.abs(origY - pointer.y);

                    if (tool === 'line') {
                        shape.set({
                            x2: pointer.x,
                            y2: pointer.y
                        });
                    } else {
                        shape.set({
                            left: Math.min(origX, pointer.x),
                            top: Math.min(origY, pointer.y),
                            width: width,
                            height: height
                        });

                        if (tool === 'circle') {
                            const radius = Math.min(width, height) / 2;
                            shape.set({
                                radius: radius
                            });
                        }
                    }

                    fabricCanvas.renderAll();
                });

                fabricCanvas.on('mouse:up', function(o) {
                    if (currentTool !== tool) return;

                    isDown = false;
                    shape = null;

                    // Remover eventos temporários
                    fabricCanvas.off('mouse:down');
                    fabricCanvas.off('mouse:move');
                    fabricCanvas.off('mouse:up');

                    saveCanvasState();
                    saveCroquiData();
                });
            }

            // Criar formas
            function createShape(type, x, y, width, height) {
                const color = document.getElementById('fabric-color-picker').value;
                const strokeWidth = parseInt(document.getElementById('fabric-stroke-width').value);

                switch (type) {
                    case 'line':
                        return new fabric.Line([x, y, x, y], {
                            stroke: color,
                            strokeWidth: strokeWidth,
                            selectable: true
                        });
                    case 'rectangle':
                        return new fabric.Rect({
                            left: x,
                            top: y,
                            width: width,
                            height: height,
                            fill: 'transparent',
                            stroke: color,
                            strokeWidth: strokeWidth,
                            selectable: true
                        });
                    case 'circle':
                        return new fabric.Circle({
                            left: x,
                            top: y,
                            radius: Math.min(width, height) / 2,
                            fill: 'transparent',
                            stroke: color,
                            strokeWidth: strokeWidth,
                            selectable: true
                        });
                }
            }

            // Adicionar texto
            function addTextAtPosition(x, y) {
                const text = prompt('Digite o texto:');
                if (text) {
                    const textObj = new fabric.Text(text, {
                        left: x,
                        top: y,
                        fill: document.getElementById('fabric-color-picker').value,
                        fontSize: 16,
                        selectable: true
                    });
                    fabricCanvas.add(textObj);
                    fabricCanvas.renderAll();
                    saveCanvasState();
                    saveCroquiData();
                }
            }

            // Adicionar formas pré-definidas para croqui de localização
            function addPredefinedShape(shape) {
                const centerX = fabricCanvas.width / 2;
                const centerY = fabricCanvas.height / 2;

                switch (shape) {
                    case 'house':
                        addHouseShape(centerX, centerY);
                        break;
                    case 'road':
                        addRoadShape(centerX, centerY);
                        break;
                    case 'tree':
                        addTreeShape(centerX, centerY);
                        break;
                    case 'fence':
                        addFenceShape(centerX, centerY);
                        break;
                    case 'arrow':
                        addArrowShape(centerX, centerY);
                        break;
                }
            }

            // Formas pré-definidas para croqui de localização
            function addHouseShape(x, y) {
                const house = new fabric.Group([
                    new fabric.Rect({
                        width: 60,
                        height: 40,
                        fill: 'transparent',
                        stroke: '#8B4513',
                        strokeWidth: 2
                    }),
                    new fabric.Triangle({
                        width: 70,
                        height: 30,
                        fill: '#DC143C',
                        stroke: '#8B0000',
                        strokeWidth: 1,
                        top: -35,
                        left: -5
                    })
                ], {
                    left: x - 30,
                    top: y - 20,
                    selectable: true
                });

                fabricCanvas.add(house);
                fabricCanvas.renderAll();
                saveCanvasState();
                saveCroquiData();
            }

            function addRoadShape(x, y) {
                const road = new fabric.Rect({
                    width: 100,
                    height: 20,
                    fill: '#696969',
                    stroke: '#2F2F2F',
                    strokeWidth: 1,
                    left: x - 50,
                    top: y - 10,
                    selectable: true
                });

                fabricCanvas.add(road);
                fabricCanvas.renderAll();
                saveCanvasState();
                saveCroquiData();
            }

            function addTreeShape(x, y) {
                const tree = new fabric.Group([
                    new fabric.Rect({
                        width: 8,
                        height: 20,
                        fill: '#8B4513',
                        left: -4,
                        top: 0
                    }),
                    new fabric.Circle({
                        radius: 15,
                        fill: '#228B22',
                        left: -15,
                        top: -25
                    })
                ], {
                    left: x,
                    top: y - 10,
                    selectable: true
                });

                fabricCanvas.add(tree);
                fabricCanvas.renderAll();
                saveCanvasState();
                saveCroquiData();
            }

            function addFenceShape(x, y) {
                const fence = new fabric.Group([
                    new fabric.Line([0, 0, 80, 0], {
                        stroke: '#8B4513',
                        strokeWidth: 3
                    }),
                    new fabric.Line([10, -10, 10, 10], {
                        stroke: '#8B4513',
                        strokeWidth: 2
                    }),
                    new fabric.Line([30, -10, 30, 10], {
                        stroke: '#8B4513',
                        strokeWidth: 2
                    }),
                    new fabric.Line([50, -10, 50, 10], {
                        stroke: '#8B4513',
                        strokeWidth: 2
                    }),
                    new fabric.Line([70, -10, 70, 10], {
                        stroke: '#8B4513',
                        strokeWidth: 2
                    })
                ], {
                    left: x - 40,
                    top: y,
                    selectable: true
                });

                fabricCanvas.add(fence);
                fabricCanvas.renderAll();
                saveCanvasState();
                saveCroquiData();
            }

            function addArrowShape(x, y) {
                const arrow = new fabric.Group([
                    new fabric.Line([0, 0, 0, -40], {
                        stroke: '#FF0000',
                        strokeWidth: 3
                    }),
                    new fabric.Triangle({
                        width: 15,
                        height: 15,
                        fill: '#FF0000',
                        left: -7.5,
                        top: -50,
                        angle: 0
                    })
                ], {
                    left: x,
                    top: y + 20,
                    selectable: true
                });

                fabricCanvas.add(arrow);
                fabricCanvas.renderAll();
                saveCanvasState();
                saveCroquiData();
            }

            // Salvar estado do canvas para undo/redo
            function saveCanvasState() {
                const state = JSON.stringify(fabricCanvas.toJSON());
                undoStack.push(state);
                if (undoStack.length > 20) {
                    undoStack.shift();
                }
                redoStack = []; // Limpar redo stack ao fazer nova ação
            }

            // Desfazer
            function undoCanvas() {
                if (undoStack.length > 1) {
                    redoStack.push(undoStack.pop());
                    const previousState = undoStack[undoStack.length - 1];
                    fabricCanvas.loadFromJSON(previousState, function() {
                        fabricCanvas.renderAll();
                        saveCroquiData();
                    });
                }
            }

            // Refazer
            function redoCanvas() {
                if (redoStack.length > 0) {
                    const nextState = redoStack.pop();
                    undoStack.push(nextState);
                    fabricCanvas.loadFromJSON(nextState, function() {
                        fabricCanvas.renderAll();
                        saveCroquiData();
                    });
                }
            }

            // Deletar objeto selecionado
            function deleteSelectedObject() {
                const activeObject = fabricCanvas.getActiveObject();
                const activeGroup = fabricCanvas.getActiveObjects();

                if (activeGroup && activeGroup.length > 0) {
                    // Se há múltiplos objetos selecionados
                    if (confirm(`Tem certeza que deseja excluir ${activeGroup.length} item(ns) selecionado(s)?`)) {
                        activeGroup.forEach(obj => {
                            fabricCanvas.remove(obj);
                        });
                        fabricCanvas.discardActiveObject();
                        fabricCanvas.renderAll();
                        saveCanvasState();
                        saveCroquiData();
                    }
                } else if (activeObject) {
                    // Se há apenas um objeto selecionado
                    if (confirm('Tem certeza que deseja excluir o item selecionado?')) {
                        fabricCanvas.remove(activeObject);
                        fabricCanvas.renderAll();
                        saveCanvasState();
                        saveCroquiData();
                    }
                } else {
                    // Nenhum objeto selecionado
                    alert('Selecione um item no croqui para excluir.');
                }
            }

            // Limpar canvas
            function clearCanvas() {
                if (confirm('Tem certeza que deseja limpar todo o croqui?')) {
                    fabricCanvas.clear();
                    fabricCanvas.backgroundColor = '#ffffff';
                    fabricCanvas.renderAll();
                    saveCanvasState();
                    saveCroquiData();
                }
            }

            // Salvar dados do croqui
            function saveCroquiData() {
                const canvasData = JSON.stringify(fabricCanvas.toJSON());
                document.getElementById('croqui').value = canvasData;

                // Também salvar a imagem PNG automaticamente
                if (fabricCanvas.getObjects().length > 0) {
                    const dataUrl = fabricCanvas.toDataURL({
                        format: 'png',
                        multiplier: 2
                    });
                    document.getElementById('croqui_imagem_base64').value = dataUrl;
                    console.log('Campo croqui_imagem_base64 atualizado automaticamente');
                }
            }

            // Função de compatibilidade com o código existente
            function saveCroqui() {
                saveCroquiData();
            }

            // Inicializar Fabric.js quando o DOM estiver pronto
            if (typeof fabric !== 'undefined') {
                initFabricCanvas();
            } else {
                console.error('Fabric.js não foi carregado no momento da inicialização!');
            }
            // ==================== FIM FABRIC.JS CROQUI ====================
        });

        // --- INÍCIO: Função para remover foto existente do banco ---
        window.removerFotoExistente = function(fotoId, fotoDbId) {
            // Obter a imagem para mostrar no modal
            const fotoElement = document.getElementById(fotoId);
            const imgSrc = fotoElement ? fotoElement.querySelector('img').src : '';

            // Configurar o modal de confirmação
            const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            const deletePreviewImg = document.getElementById('deletePreviewImg');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            // Definir a imagem de preview
            deletePreviewImg.src = imgSrc;

            // Armazenar informações da foto no modal para evitar conflitos
            deleteModal._fotoId = fotoId;
            deleteModal._fotoDbId = fotoDbId;

            // Remover listeners anteriores para evitar duplicação
            const newConfirmBtn = confirmDeleteBtn.cloneNode(true);
            confirmDeleteBtn.parentNode.replaceChild(newConfirmBtn, confirmDeleteBtn);

            // Adicionar listener para confirmação
            newConfirmBtn.addEventListener('click', function() {
                const currentFotoId = deleteModal._fotoId;
                const currentFotoDbId = deleteModal._fotoDbId;

                // Fechar o modal
                deleteModal.hide();

                // Mostrar loading no botão
                newConfirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Excluindo...';
                newConfirmBtn.disabled = true;

                console.log('Removendo foto:', currentFotoId, currentFotoDbId);

                // Fazer requisição AJAX para remover do banco
                fetch(`/vistorias/fotos/${currentFotoDbId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => {
                        console.log('Response status:', response.status);
                        console.log('Response ok:', response.ok);

                        if (!response.ok) {
                            console.error('Response não OK, status:', response.status);
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }

                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data completo:', JSON.stringify(data));

                        if (data && data.success === true) {
                            console.log('✓ Sucesso confirmado, removendo foto da interface');

                            // Encontrar a foto no array para obter o foto_id do banco
                            const fotoRemovida = fotosData.find(f => f.id === currentFotoId);
                            if (fotoRemovida && fotoRemovida.foto_id) {
                                // Adicionar ao array de fotos removidas para informar o backend
                                fotosRemovidasIds.push(fotoRemovida.foto_id);
                                console.log('Foto ID', fotoRemovida.foto_id,
                                    'adicionada à lista de removidas');
                            }

                            // Adicionar efeito de fade out
                            const elemento = document.getElementById(currentFotoId);
                            if (elemento) {
                                elemento.style.transition = 'all 0.3s ease';
                                elemento.style.transform = 'scale(0.8)';
                                elemento.style.opacity = '0';

                                setTimeout(() => {
                                    // Remove do array local - CORRIGIDO: usar o ID correto
                                    console.log('Removendo foto do array fotosData. ID:',
                                        currentFotoId);
                                    console.log('Array antes:', fotosData.length, 'fotos');
                                    fotosData = fotosData.filter(f => {
                                        console.log('Comparando:', f.id, 'com',
                                            currentFotoId);
                                        return f.id !== currentFotoId;
                                    });
                                    console.log('Array depois:', fotosData.length, 'fotos');

                                    // Remove da tela
                                    elemento.remove();
                                    console.log('✓ Elemento removido da tela');

                                    // Atualiza inputs E contador
                                    atualizarInputsHidden();

                                    // Mostrar notificação de sucesso
                                    mostrarNotificacao('Foto removida com sucesso!', 'success');
                                }, 300);
                            }
                        } else {
                            console.error('✗ Condição de sucesso falhou');
                            const errorMessage = data && data.message ? data.message : 'Erro desconhecido';
                            mostrarNotificacao('Erro ao remover foto: ' + errorMessage, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('✗ Erro detalhado:', error);
                        mostrarNotificacao('Erro ao remover foto: ' + error.message, 'error');
                    })
                    .finally(() => {
                        // Resetar botão
                        newConfirmBtn.innerHTML = '<i class="fas fa-trash me-2"></i>Sim, Excluir';
                        newConfirmBtn.disabled = false;
                    });
            });

            // Mostrar o modal
            deleteModal.show();
        }

        // Função para mostrar notificações elegantes
        function mostrarNotificacao(mensagem, tipo = 'success') {
            // Remover notificação anterior se existir
            const notificacaoExistente = document.getElementById('notificacao-toast');
            if (notificacaoExistente) {
                notificacaoExistente.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => {
                    if (notificacaoExistente.parentNode) {
                        notificacaoExistente.remove();
                    }
                }, 300);
            }

            // Aguardar um pouco antes de mostrar a nova notificação
            setTimeout(() => {
                // Criar notificação
                const notificacao = document.createElement('div');
                notificacao.id = 'notificacao-toast';
                notificacao.className =
                    `position-fixed alert alert-${tipo === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
                notificacao.style.top = '20px';
                notificacao.style.right = '20px';
                notificacao.style.zIndex = '9999';
                notificacao.style.minWidth = '320px';
                notificacao.style.maxWidth = '400px';
                notificacao.innerHTML = `
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-triangle'}" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold mb-1">${tipo === 'success' ? 'Sucesso!' : 'Erro!'}</div>
                            <div>${mensagem}</div>
                        </div>
                        <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
                    </div>
                `;

                document.body.appendChild(notificacao);

                // Auto remover após 4 segundos
                setTimeout(() => {
                    if (notificacao.parentNode) {
                        notificacao.style.animation = 'slideOutRight 0.4s ease-in';
                        setTimeout(() => {
                            if (notificacao.parentNode) {
                                notificacao.remove();
                            }
                        }, 400);
                    }
                }, 4000);
            }, notificacaoExistente ? 300 : 0);
        }
        // --- FIM: Função para remover foto existente do banco ---
        // Ativar input de arquivo ao clicar em "Da Galeria"
        document.addEventListener('DOMContentLoaded', function() {
            const btnAdicionarArquivo = document.getElementById('btn-adicionar-arquivo');
            const fileInputHidden = document.getElementById('file-input-hidden');
            if (btnAdicionarArquivo && fileInputHidden) {
                btnAdicionarArquivo.addEventListener('click', function() {
                    fileInputHidden.click();
                });
                fileInputHidden.addEventListener('change', function(e) {
                    if (e.target.files && e.target.files.length > 0) {
                        Array.from(e.target.files).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(evt) {
                                // Aqui você pode chamar a função para mostrar o modal de descrição, por exemplo:
                                if (typeof mostrarModalDescricao === 'function') {
                                    mostrarModalDescricao(evt.target.result, file.name);
                                }
                            };
                            reader.readAsDataURL(file);
                        });
                        // Limpa o input para permitir selecionar o mesmo arquivo novamente
                        e.target.value = '';
                    }
                });
            }
        });
    </script>
@endsection
