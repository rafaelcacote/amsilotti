@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex align-items-center py-3">
                            <h3 class="mb-0 text-primary"><i class="fas fa-clipboard-check me-2"></i>Nova Vistoria</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('vistorias.store') }}" method="POST" class="row g-3 needs-validation"
                                enctype="multipart/form-data" novalidate>
                                @csrf

                                <!-- Dados do Processo -->
                                <div class="col-12 mb-3">
                                    <h5 class="border-bottom pb-2"><strong>Dados do Local Vistoria</strong></h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="num_processo">Número do Processo</label>
                                    <input type="text" class="form-control @error('num_processo') is-invalid @enderror"
                                        id="num_processo" name="num_processo" value="{{ old('num_processo') }}">
                                    @error('num_processo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="requerente">Requerente</label>
                                    <input type="text" class="form-control @error('requerente') is-invalid @enderror"
                                        id="requerente" name="requerente" value="{{ old('requerente') }}">
                                    @error('requerente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="requerido">Requerido</label>
                                    <input type="text" class="form-control @error('requerido') is-invalid @enderror"
                                        id="requerido" name="requerido" value="{{ old('requerido') }}">
                                    @error('requerido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Dados Pessoais -->
                                <div class="col-12 mt-4 mb-3">
                                    <h5 class="border-bottom pb-2">Dados Pessoais</h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="nome">Nome</label>
                                    <input type="text" class="form-control @error('nome') is-invalid @enderror"
                                        id="nome" name="nome" value="{{ old('nome') }}" required>
                                    @error('nome')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="cpf">CPF</label>
                                    <input type="text" class="form-control @error('cpf') is-invalid @enderror"
                                        id="cpf" name="cpf" value="{{ old('cpf') }}">
                                    @error('cpf')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="telefone">Telefone</label>
                                    <input type="text" class="form-control @error('telefone') is-invalid @enderror"
                                        id="telefone" name="telefone" value="{{ old('telefone') }}">
                                    @error('telefone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Endereço -->
                                <div class="col-12 mt-4 mb-3">
                                    <h5 class="border-bottom pb-2">Endereço</h5>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="endereco">Endereço</label>
                                    <input type="text" class="form-control @error('endereco') is-invalid @enderror"
                                        id="endereco" name="endereco" value="{{ old('endereco') }}" required>
                                    @error('endereco')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label" for="num">Número</label>
                                    <input type="text" class="form-control @error('num') is-invalid @enderror"
                                        id="num" name="num" value="{{ old('num') }}">
                                    @error('num')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="bairro">Bairro</label>
                                    <input type="text" class="form-control @error('bairro') is-invalid @enderror"
                                        id="bairro" name="bairro" value="{{ old('bairro') }}" required>
                                    @error('bairro')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="cidade">Cidade</label>
                                    <input type="text" class="form-control @error('cidade') is-invalid @enderror"
                                        id="cidade" name="cidade" value="{{ old('cidade') }}" required>
                                    @error('cidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label" for="estado">Estado</label>
                                    <input type="text" class="form-control @error('estado') is-invalid @enderror"
                                        id="estado" name="estado" value="{{ old('estado') }}" maxlength="2"
                                        required>
                                    @error('estado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Características do Imóvel -->
                                <div class="col-12 mt-4 mb-3">
                                    <h5 class="border-bottom pb-2">Características do Imóvel</h5>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="limites_confrontacoes">Limites e Confrontações</label>
                                    <textarea class="form-control @error('limites_confrontacoes') is-invalid @enderror" id="limites_confrontacoes"
                                        name="limites_confrontacoes" rows="3">{{ old('limites_confrontacoes') }}</textarea>
                                    @error('limites_confrontacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="lado_direito">Lado Direito</label>
                                    <input type="text"
                                        class="form-control @error('lado_direito') is-invalid @enderror"
                                        id="lado_direito" name="lado_direito" value="{{ old('lado_direito') }}">
                                    @error('lado_direito')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="lado_esquerdo">Lado Esquerdo</label>
                                    <input type="text"
                                        class="form-control @error('lado_esquerdo') is-invalid @enderror"
                                        id="lado_esquerdo" name="lado_esquerdo" value="{{ old('lado_esquerdo') }}">
                                    @error('lado_esquerdo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="topografia">Topografia</label>
                                    <input type="text" class="form-control @error('topografia') is-invalid @enderror"
                                        id="topografia" name="topografia" value="{{ old('topografia') }}">
                                    @error('topografia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="formato_terreno">Formato do Terreno</label>
                                    <input type="text"
                                        class="form-control @error('formato_terreno') is-invalid @enderror"
                                        id="formato_terreno" name="formato_terreno"
                                        value="{{ old('formato_terreno') }}">
                                    @error('formato_terreno')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="superficie">Superfície</label>
                                    <select class="form-select @error('superficie') is-invalid @enderror" id="superficie"
                                        name="superficie" required>
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
                                <div class="col-md-12">
                                    <label class="form-label" for="documentacao">Documentação</label>
                                    <textarea class="form-control @error('documentacao') is-invalid @enderror" id="documentacao" name="documentacao"
                                        rows="3">{{ old('documentacao') }}</textarea>
                                    @error('documentacao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Ocupação -->
                                <div class="col-12 mt-4 mb-3">
                                    <h5 class="border-bottom pb-2">Ocupação</h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="reside_no_imovel"
                                            name="reside_no_imovel" value="1"
                                            {{ old('reside_no_imovel') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="reside_no_imovel">Reside no Imóvel</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="data_ocupacao">Data de Ocupação</label>
                                    <input type="date"
                                        class="form-control @error('data_ocupacao') is-invalid @enderror"
                                        id="data_ocupacao" name="data_ocupacao" value="{{ old('data_ocupacao') }}">
                                    @error('data_ocupacao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="tipo_ocupacao">Tipo de Ocupação</label>
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
                                <div class="col-md-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="exerce_pacificamente_posse"
                                            name="exerce_pacificamente_posse" value="1"
                                            {{ old('exerce_pacificamente_posse', '1') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="exerce_pacificamente_posse">Exerce
                                            Pacificamente a Posse</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="utiliza_da_benfeitoria">Utilização da
                                        Benfeitoria</label>
                                    <select class="form-select @error('utiliza_da_benfeitoria') is-invalid @enderror"
                                        id="utiliza_da_benfeitoria" name="utiliza_da_benfeitoria" required>
                                        <option value="">Selecione</option>
                                        @foreach ($utilizaDaBenfeitoriaValues as $utilizacao)
                                            <option value="{{ $utilizacao }}"
                                                {{ old('utiliza_da_benfeitoria') == $utilizacao ? 'selected' : '' }}>
                                                {{ $utilizacao }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('utiliza_da_benfeitoria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Construção -->
                                <div class="col-12 mt-4 mb-3">
                                    <h5 class="border-bottom pb-2">Construção</h5>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="tipo_construcao">Tipo de Construção</label>
                                    <input type="text"
                                        class="form-control @error('tipo_construcao') is-invalid @enderror"
                                        id="tipo_construcao" name="tipo_construcao"
                                        value="{{ old('tipo_construcao') }}">
                                    @error('tipo_construcao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="padrao_acabamento">Padrão de Acabamento</label>
                                    <input type="text"
                                        class="form-control @error('padrao_acabamento') is-invalid @enderror"
                                        id="padrao_acabamento" name="padrao_acabamento"
                                        value="{{ old('padrao_acabamento') }}">
                                    @error('padrao_acabamento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="idade_aparente">Idade Aparente</label>
                                    <input type="text"
                                        class="form-control @error('idade_aparente') is-invalid @enderror"
                                        id="idade_aparente" name="idade_aparente" value="{{ old('idade_aparente') }}">
                                    @error('idade_aparente')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label" for="estado_de_conservacao">Estado de Conservação</label>
                                    <input type="text"
                                        class="form-control @error('estado_de_conservacao') is-invalid @enderror"
                                        id="estado_de_conservacao" name="estado_de_conservacao"
                                        value="{{ old('estado_de_conservacao') }}">
                                    @error('estado_de_conservacao')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Observações -->
                                <div class="col-12 mt-4 mb-3">
                                    <h5 class="border-bottom pb-2">Observações</h5>
                                </div>
                                <div class="col-md-12">
                                    <textarea class="form-control @error('observacoes') is-invalid @enderror" id="observacoes" name="observacoes"
                                        rows="3">{{ old('observacoes') }}</textarea>
                                    @error('observacoes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Acompanhamento da Vistoria -->
                                <div class="col-12 mt-4 mb-3">
                                    <h5 class="border-bottom pb-2">Acompanhamento da Vistoria</h5>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="acompanhamento_vistoria">Nome do Acompanhante</label>
                                    <input type="text"
                                        class="form-control @error('acompanhamento_vistoria') is-invalid @enderror"
                                        id="acompanhamento_vistoria" name="acompanhamento_vistoria"
                                        value="{{ old('acompanhamento_vistoria') }}">
                                    @error('acompanhamento_vistoria')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="cpf_acompanhante">CPF do Acompanhante</label>
                                    <input type="text"
                                        class="form-control @error('cpf_acompanhante') is-invalid @enderror"
                                        id="cpf_acompanhante" name="cpf_acompanhante"
                                        value="{{ old('cpf_acompanhante') }}">
                                    @error('cpf_acompanhante')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label" for="telefone_acompanhante">Telefone do Acompanhante</label>
                                    <input type="text"
                                        class="form-control @error('telefone_acompanhante') is-invalid @enderror"
                                        id="telefone_acompanhante" name="telefone_acompanhante"
                                        value="{{ old('telefone_acompanhante') }}">
                                    @error('telefone_acompanhante')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Fotos -->
                                <div class="col-12 mt-4 mb-3">
                                    <h5 class="border-bottom pb-2">Fotos</h5>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="foto-container" id="foto-container">
                                        <div class="row mb-3 foto-item">
                                            <div class="col-md-6">
                                                <label class="form-label" for="fotos[0]">Foto</label>
                                                <input type="file"
                                                    class="form-control @error('fotos.0') is-invalid @enderror"
                                                    id="fotos[0]" name="fotos[]" accept="image/*">
                                                @error('fotos.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label" for="descricoes[0]">Descrição</label>
                                                <input type="text"
                                                    class="form-control @error('descricoes.0') is-invalid @enderror"
                                                    id="descricoes[0]" name="descricoes[]">
                                                @error('descricoes.0')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="add-foto">
                                        <i class="fas fa-plus me-1"></i> Adicionar Mais Fotos
                                    </button>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('vistorias.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times me-1"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save me-1"></i> Salvar
                                        </button>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('foto-container');
            const addButton = document.getElementById('add-foto');
            let fotoCount = 1;

            addButton.addEventListener('click', function() {
                const fotoItem = document.createElement('div');
                fotoItem.className = 'row mb-3 foto-item';
                fotoItem.innerHTML = `
                <div class="col-md-6">
                    <label class="form-label" for="fotos[${fotoCount}]">Foto</label>
                    <input type="file" class="form-control" id="fotos[${fotoCount}]" name="fotos[]" accept="image/*">
                </div>
                <div class="col-md-5">
                    <label class="form-label" for="descricoes[${fotoCount}]">Descrição</label>
                    <input type="text" class="form-control" id="descricoes[${fotoCount}]" name="descricoes[]">
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-foto">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
                container.appendChild(fotoItem);
                fotoCount++;

                // Adicionar evento para remover foto
                const removeButtons = document.querySelectorAll('.remove-foto');
                removeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        this.closest('.foto-item').remove();
                    });
                });
            });
        });
    </script>
@endpush
