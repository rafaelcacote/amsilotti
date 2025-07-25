@extends('layouts.app')
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
                            <form action="{{ route('vistorias.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <!-- Seção: Dados do Processo -->
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3"><i class="fas fa-file-alt me-2"></i>Dados do Processo</h5>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="num_processo" class="form-label">Número do Processo</label>
                                                <input type="text"
                                                    class="form-control @error('num_processo') is-invalid @enderror {{ isset($agenda) ? 'bg-light text-muted' : '' }}"
                                                    id="num_processo" name="num_processo"
                                                    value="{{ isset($agenda) ? $agenda->num_processo : old('num_processo') }}"
                                                    {{ isset($agenda) ? 'readonly' : '' }}>
                                                @error('num_processo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="requerente" class="form-label">Requerente</label>
                                                <input type="text"
                                                    class="form-control @error('requerente') is-invalid @enderror {{ isset($agenda) ? 'bg-light text-muted' : '' }}"
                                                    id="requerente" name="requerente"
                                                    value="{{ isset($agenda) ? $agenda->requerente->nome : old('requerente') }}"
                                                    {{ isset($agenda) ? 'readonly' : '' }}>
                                                @error('requerente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="requerido" class="form-label">Requerido</label>
                                                <input type="text"
                                                    class="form-control @error('requerido') is-invalid @enderror {{ isset($agenda) ? 'bg-light text-muted' : '' }}"
                                                    id="requerido" name="requerido"
                                                    value="{{ isset($agenda) ? $agenda->requerido : old('requerido') }}"
                                                    {{ isset($agenda) ? 'readonly' : '' }}>
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
                                                    name="nome" value="{{ old('nome') }}" required>
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
                                                    name="cpf" value="{{ old('cpf') }}">
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
                                                    id="telefone" name="telefone" value="{{ old('telefone') }}">
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
                                                    value="{{ isset($agenda) ? $agenda->endereco : old('endereco') }}"
                                                    required>
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
                                                    name="num"
                                                    value="{{ isset($agenda) ? $agenda->num : old('num') }}">
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
                                                    value="{{ isset($agenda) ? $agenda->bairro : old('bairro') }}"
                                                    required>
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
                                                    value="{{ isset($agenda) ? $agenda->cidade : old('cidade') }}"
                                                    required>
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
                                                    value="{{ isset($agenda) ? $agenda->estado : old('estado') }}"
                                                    maxlength="2" required>
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
                                                <label for="limites_confrontacoes" class="form-label">Limites e
                                                    Confrontações</label>
                                                <input type="text"
                                                    class="form-control @error('limites_confrontacoes') is-invalid @enderror"
                                                    id="limites_confrontacoes" name="limites_confrontacoes"
                                                    value="{{ old('limites_confrontacoes') }}">
                                                @error('limites_confrontacoes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="lado_direito" class="form-label">Lado Direito</label>
                                                <input type="text"
                                                    class="form-control @error('lado_direito') is-invalid @enderror"
                                                    id="lado_direito" name="lado_direito"
                                                    value="{{ old('lado_direito') }}">
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
                                                    value="{{ old('lado_esquerdo') }}">
                                                @error('lado_esquerdo')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="topografia" class="form-label">Topografia</label>
                                                <input type="text"
                                                    class="form-control @error('topografia') is-invalid @enderror"
                                                    id="topografia" name="topografia" value="{{ old('topografia') }}">
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
                                                    value="{{ old('formato_terreno') }}">
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
                                                            {{ old('superficie') == $superficie ? 'selected' : '' }}>
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
                                                    value="{{ old('documentacao') }}">
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
                                                        {{ old('reside_no_imovel') == '1' ? 'selected' : '' }}>Sim</option>
                                                    <option value="0"
                                                        {{ old('reside_no_imovel') == '0' ? 'selected' : '' }}>Não</option>
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
                                                    value="{{ old('data_ocupacao') }}">
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
                                                            {{ old('tipo_ocupacao') == $tipo ? 'selected' : '' }}>
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
                                                        {{ old('exerce_pacificamente_posse', '1') == '1' ? 'selected' : '' }}>
                                                        Sim</option>
                                                    <option value="0"
                                                        {{ old('exerce_pacificamente_posse') == '0' ? 'selected' : '' }}>
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
                                                        {{ old('utiliza_benfeitoria') == 'Uso Próprio' ? 'selected' : '' }}>
                                                        Uso Próprio</option>
                                                    <option value="Alugada"
                                                        {{ old('utiliza_benfeitoria') == 'Alugada' ? 'selected' : '' }}>
                                                        Alugada</option>
                                                    <option value="Outros"
                                                        {{ old('utiliza_benfeitoria') == 'Outros' ? 'selected' : '' }}>
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
                                                    value="{{ old('tipo_construcao') }}">
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
                                                    value="{{ old('padrao_acabamento') }}">
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
                                                    value="{{ old('idade_aparente') }}">
                                                @error('idade_aparente')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="estado_conservacao" class="form-label">Estado de
                                                    Conservação</label>
                                                <input type="text"
                                                    class="form-control @error('estado_conservacao') is-invalid @enderror"
                                                    id="estado_conservacao" name="estado_conservacao"
                                                    value="{{ old('estado_conservacao') }}">
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
                                                    rows="3">{{ old('observacoes') }}</textarea>
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
                                        Edificação</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-12">
                                                <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
                                                    <label class="form-label mb-0">Ferramenta:</label>
                                                    <select id="tool-select" class="form-select form-select-sm w-auto">
                                                        <option value="free">Livre</option>
                                                        <option value="line">Linha</option>
                                                        <option value="rect">Retângulo</option>
                                                        <option value="circle">Círculo</option>
                                                        <option value="text">Texto</option>
                                                        <option value="eraser">Borracha</option>
                                                    </select>
                                                    <label class="form-label mb-0 ms-2">Cor:</label>
                                                    <input type="color" id="color-picker" value="#222222"
                                                        class="form-control form-control-color form-control-sm w-auto">
                                                    <input type="text" id="text-input"
                                                        class="form-control form-control-sm w-auto"
                                                        placeholder="Digite o texto" style="display:none;">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm ms-2"
                                                        id="undo-croqui">Desfazer</button>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm ms-2"
                                                        id="clear-croqui">Limpar Croqui</button>
                                                </div>
                                                <canvas id="croqui-canvas" width="600" height="400"
                                                    style="border:1px solid #ccc; touch-action: none; background: #fff; border-radius: 8px;"></canvas>
                                                <input type="hidden" name="croqui" id="croqui">
                                                <small class="text-muted">Desenhe o croqui usando o mouse ou o dedo (em
                                                    tablets). Use as ferramentas acima para adicionar formas ou
                                                    texto.</small>
                                            </div>
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
                                                    value="{{ old('acompanhamento_vistoria') }}">
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
                                                    value="{{ old('cpf_acompanhante') }}">
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
                                                    value="{{ old('telefone_acompanhante') }}">
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

                                            <!-- Preview das Fotos -->
                                            <div id="fotos-preview" class="row"></div>

                                            <!-- Container para inputs hidden das fotos em base64 -->
                                            <div id="fotos-inputs-container"></div>
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
        document.addEventListener('DOMContentLoaded', function() {
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
            let fotoCounter = 0;
            let fotosData = [];

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
                fotosData = fotosData.filter(foto => foto.id !== fotoId);
                document.getElementById(fotoId).remove();
                atualizarInputsHidden();
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
                fotosInputsContainer.innerHTML = '';

                fotosData.forEach((foto, index) => {
                    // Input para foto em base64
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
                });

                // Atualizar contador
                const contadorFotos = document.getElementById('contador-fotos');
                if (contadorFotos) {
                    const quantidade = fotosData.length;
                    contadorFotos.textContent =
                        `${quantidade} foto${quantidade !== 1 ? 's' : ''} adicionada${quantidade !== 1 ? 's' : ''}`;
                    contadorFotos.className = quantidade > 0 ? 'text-success' : 'text-muted';
                }
            }

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
            }

            // Carregar dados temporários se existirem
            function carregarDadosTemporarios() {
                const dadosTemp = localStorage.getItem('vistoria_temp_dados');
                const fotosTemp = localStorage.getItem('vistoria_temp_fotos');
                const membrosTemp = localStorage.getItem('vistoria_temp_membros');

                if (dadosTemp) {
                    const dados = JSON.parse(dadosTemp);
                    Object.keys(dados).forEach(key => {
                        const campo = document.querySelector(`[name="${key}"]`);
                        if (campo) {
                            if (campo.type === 'checkbox' || campo.type === 'radio') {
                                campo.checked = campo.value === dados[key];
                            } else {
                                campo.value = dados[key];
                            }
                        }
                    });
                }

                if (fotosTemp) {
                    const fotos = JSON.parse(fotosTemp);
                    fotos.forEach(foto => {
                        adicionarFoto(foto.data, foto.descricao, foto.nome);
                    });
                }

                if (membrosTemp) {
                    const membros = JSON.parse(membrosTemp);
                    membros.forEach(membro => {
                        membrosAdicionados.push(membro);
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

                        const removeBtn = novaLinha.querySelector('.remove-membro');
                        removeBtn.addEventListener('click', function() {
                            removerMembro(this.getAttribute('data-id'), novaLinha);
                        });
                    });
                    updateTableVisibility();
                    updateMembrosIds();
                }
            }

            // Salvar dados automaticamente a cada mudança
            document.addEventListener('change', salvarDadosTemporarios);
            document.addEventListener('input', salvarDadosTemporarios);

            // Carregar dados ao inicializar
            carregarDadosTemporarios();

            // Limpar dados temporários ao enviar formulário com sucesso
            document.querySelector('form').addEventListener('submit', function() {
                salvarDadosTemporarios(); // Salvar uma última vez
                saveCroqui();

                // Limpar após um pequeno delay (para garantir que o formulário foi enviado)
                setTimeout(() => {
                    localStorage.removeItem('vistoria_temp_dados');
                    localStorage.removeItem('vistoria_temp_fotos');
                    localStorage.removeItem('vistoria_temp_membros');
                }, 1000);
            });

            // Controle de fotos (código antigo removido)
            // addButton.addEventListener('click', function() { ... }); // REMOVIDO
        });

        // Croqui Canvas
        const canvas = document.getElementById('croqui-canvas');
        const ctx = canvas.getContext('2d');
        let drawing = false;
        let tool = 'free';
        let color = '#222222';
        let startX = 0,
            startY = 0;
        let savedImage = null;
        let textValue = '';
        const toolSelect = document.getElementById('tool-select');
        const colorPicker = document.getElementById('color-picker');
        const textInput = document.getElementById('text-input');
        const undoBtn = document.getElementById('undo-croqui');
        const clearBtn = document.getElementById('clear-croqui');
        let undoStack = [];

        toolSelect.addEventListener('change', function() {
            tool = this.value;
            textInput.style.display = (tool === 'text') ? 'inline-block' : 'none';
        });
        colorPicker.addEventListener('change', function() {
            color = this.value;
        });
        textInput.addEventListener('input', function() {
            textValue = this.value;
        });

        function saveCroqui() {
            document.getElementById('croqui').value = canvas.toDataURL('image/png');
        }

        function pushUndo() {
            // Limita o stack para não crescer indefinidamente
            if (undoStack.length > 30) undoStack.shift();
            undoStack.push(ctx.getImageData(0, 0, canvas.width, canvas.height));
        }

        // Desenho livre e borracha
        function drawFree(x, y, isDown) {
            if (isDown) {
                ctx.beginPath();
                ctx.moveTo(startX, startY);
                ctx.lineTo(x, y);
                ctx.strokeStyle = (tool === 'eraser') ? '#fff' : color;
                ctx.lineWidth = (tool === 'eraser') ? 16 : 2;
                ctx.lineCap = 'round';
                ctx.stroke();
                ctx.closePath();
            }
            startX = x;
            startY = y;
        }

        // Mouse events
        canvas.addEventListener('mousedown', function(e) {
            drawing = true;
            startX = e.offsetX;
            startY = e.offsetY;
            if (tool !== 'free' && tool !== 'eraser') {
                savedImage = ctx.getImageData(0, 0, canvas.width, canvas.height);
            }
            pushUndo();
        });
        canvas.addEventListener('mouseup', function(e) {
            if (!drawing) return;
            drawing = false;
            if (tool === 'line') {
                ctx.putImageData(savedImage, 0, 0);
                ctx.beginPath();
                ctx.moveTo(startX, startY);
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.strokeStyle = color;
                ctx.lineWidth = 2;
                ctx.stroke();
                ctx.closePath();
            } else if (tool === 'rect') {
                ctx.putImageData(savedImage, 0, 0);
                ctx.strokeStyle = color;
                ctx.lineWidth = 2;
                ctx.strokeRect(startX, startY, e.offsetX - startX, e.offsetY - startY);
            } else if (tool === 'circle') {
                ctx.putImageData(savedImage, 0, 0);
                ctx.beginPath();
                let radius = Math.sqrt(Math.pow(e.offsetX - startX, 2) + Math.pow(e.offsetY - startY, 2));
                ctx.arc(startX, startY, radius, 0, 2 * Math.PI);
                ctx.strokeStyle = color;
                ctx.lineWidth = 2;
                ctx.stroke();
                ctx.closePath();
            } else if (tool === 'text') {
                ctx.putImageData(savedImage, 0, 0);
                ctx.font = '20px Arial';
                ctx.fillStyle = color;
                ctx.fillText(textValue, startX, startY);
            }
            saveCroqui();
        });
        canvas.addEventListener('mouseout', function() {
            drawing = false;
        });
        canvas.addEventListener('mousemove', function(e) {
            if (!drawing) return;
            if (tool === 'free' || tool === 'eraser') {
                drawFree(e.offsetX, e.offsetY, drawing);
            } else {
                ctx.putImageData(savedImage, 0, 0);
                if (tool === 'line') {
                    ctx.beginPath();
                    ctx.moveTo(startX, startY);
                    ctx.lineTo(e.offsetX, e.offsetY);
                    ctx.strokeStyle = color;
                    ctx.lineWidth = 2;
                    ctx.stroke();
                    ctx.closePath();
                } else if (tool === 'rect') {
                    ctx.strokeStyle = color;
                    ctx.lineWidth = 2;
                    ctx.strokeRect(startX, startY, e.offsetX - startX, e.offsetY - startY);
                } else if (tool === 'circle') {
                    ctx.beginPath();
                    let radius = Math.sqrt(Math.pow(e.offsetX - startX, 2) + Math.pow(e.offsetY - startY, 2));
                    ctx.arc(startX, startY, radius, 0, 2 * Math.PI);
                    ctx.strokeStyle = color;
                    ctx.lineWidth = 2;
                    ctx.stroke();
                    ctx.closePath();
                }
            }
        });

        // Touch events (apenas desenho livre e borracha para simplificar)
        canvas.addEventListener('touchstart', function(e) {
            if (e.touches.length === 1) {
                const rect = canvas.getBoundingClientRect();
                startX = e.touches[0].clientX - rect.left;
                startY = e.touches[0].clientY - rect.top;
                drawing = true;
                pushUndo();
            }
        });
        canvas.addEventListener('touchend', function() {
            drawing = false;
            saveCroqui();
        });
        canvas.addEventListener('touchcancel', function() {
            drawing = false;
        });
        canvas.addEventListener('touchmove', function(e) {
            if (drawing && e.touches.length === 1 && (tool === 'free' || tool === 'eraser')) {
                const rect = canvas.getBoundingClientRect();
                const x = e.touches[0].clientX - rect.left;
                const y = e.touches[0].clientY - rect.top;
                drawFree(x, y, true);
                e.preventDefault();
            }
        }, {
            passive: false
        });

        // Limpar croqui
        clearBtn.addEventListener('click', function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            saveCroqui();
            undoStack = [];
        });

        // Desfazer croqui
        undoBtn.addEventListener('click', function() {
            if (undoStack.length > 0) {
                ctx.putImageData(undoStack.pop(), 0, 0);
                saveCroqui();
            }
        });

        // Salvar croqui ao enviar o formulário
        document.querySelector('form').addEventListener('submit', function() {
            saveCroqui();
        });
    </script>
@endsection
