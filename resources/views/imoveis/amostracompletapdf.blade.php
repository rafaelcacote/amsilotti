<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório do Imóvel</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 15px;
        }

        /* Cabeçalho */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header-images {
            flex: 0 0 auto;
            display: flex;
            align-items: center;
        }

        .header-images img {
            max-height: 50px;
        }

        .header-title {
            flex: 1;
            text-align: center;
        }

        .header-title h1 {
            font-size: 18px;
            margin: 0;
            color: #333;
            text-transform: uppercase;
        }

        .header-contact {
            text-align: right;
            font-size: 14px;
            margin-top: -80; /* Ajuste para subir o bloco de contato */
        }

        .header-contact p {
            margin: 0; /* Remove margem padrão do parágrafo */
            line-height: 1.2; /* Ajusta o espaçamento entre as linhas */
        }

        /* Seções */
        .section {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .section-title {
            color: #0057b8;
            font-size: 13px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 3px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
        }

        .data-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .data-label {
            font-weight: bold;
            min-width: 120px;
        }

        .data-value {
            flex: 1;
        }

        /* Fotos */
        .photos-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 15px;
        }

        .photo-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .photo-caption {
            font-size: 10px;
            margin-top: 3px;
            text-align: center;
        }

        /* Duas colunas para dados do terreno */
        .double-column {
            column-count: 2;
            column-gap: 20px;
        }

        .grid-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .subgrid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .border-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
        }

        .checkbox-group {
            margin: 10px 0;
        }

        /* Ajuste existente no .grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
    </style>
</head>
<body>
    <!-- Cabeçalho com imagens -->
    <div class="header">
        <!-- Logo à esquerda -->
        <div class="header-images" style="margin-bottom: -50px">
            <img src="{{ $logo }}" alt="Logo">
        </div>

        <!-- Título no centro -->
        <div class="header-title">
            <h1>PESQUISA DE MERCADO</h1>
            <div class="header-contact">
                <p><strong>Arquitetura, Avaliações <br>
                    e Perícias de Engenharia</strong></p>
                pericias@amsilott.com<br>
                (92) 99510-0573
            </div>
        </div>
    </div>

    <div class="grid-section">
        <!-- Coluna Esquerda -->
        <div>
            <!-- Tipo do Imóvel -->
            <div class="section border-box">
                <div class="section-title">TIPO DO IMÓVEL</div>
                <div class="subgrid">
                    <div class="data-item">
                        <span class="data-label">Tipo:</span>
                        <span class="data-value">Terreno</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">PGM:</span>
                        <span class="data-value">209.51</span>
                    </div>
                </div>
            </div>

            <!-- Endereço e Localização -->
            <div class="section border-box">
                <div class="checkbox-group">
                    <input type="checkbox" checked> Endereço e Localização
                </div>
                <div class="grid">
                    <div class="data-item">
                        <span class="data-label">Endereço:</span>
                        <span class="data-value">Rua eu não sei</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Número:</span>
                        <span class="data-value">45</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Bairro:</span>
                        <span class="data-value">N. S. Aparecida</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Zona:</span>
                        <span class="data-value">SUL</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Latitude:</span>
                        <span class="data-value">-3.0555315697541987</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Longitude:</span>
                        <span class="data-value">60.06037437826739</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Direita -->
        <div>
            <!-- Dados do Terreno -->
            <div class="section border-box">
                <div class="section-title">DADOS DO TERRENO</div>
                <div class="subgrid">
                    <div class="data-item">
                        <span class="data-label">Área:</span>
                        <span class="data-value">-</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Formato:</span>
                        <span class="data-value">-</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Topografia:</span>
                        <span class="data-value">-</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Posição Quadra:</span>
                        <span class="data-value">-</span>
                    </div>
                </div>
            </div>

            <!-- Dados Econômicos -->
            <div class="section border-box">
                <div class="section-title">DADOS ECONÔMICOS</div>
                <div class="subgrid">
                    <div class="data-item">
                        <span class="data-label">Valor Total:</span>
                        <span class="data-value">-</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Valor Terreno:</span>
                        <span class="data-value">-</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Fator Oferta:</span>
                        <span class="data-value">-</span>
                    </div>
                    <div class="data-item">
                        <span class="data-label">Preço Unitário:</span>
                        <span class="data-value">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Seção: Fotos do Imóvel -->
    <div class="section">
        <div class="section-title">FOTOS DO IMÓVEL</div>
        <div class="photos-container">
            @foreach($imovel->fotos as $foto)
            <div class="photo-item">
                <img src="{{ asset('storage/' . $foto->caminho) }}" alt="Foto do Imóvel">
                <div class="photo-caption">{{ $foto->descricao }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Seção: Fonte da Informação -->
    <div class="section">
        <div class="section-title">FONTE DA INFORMAÇÃO</div>
        <div class="grid">
            <div class="data-item">
                <span class="data-label">Contato:</span>
                <span class="data-value">{{ $imovel->fonte_informacao }}</span>
            </div>
            <div class="data-item">
                <span class="data-label">Telefone:</span>
                <span class="data-value">{{ $imovel->contato }}</span>
            </div>
        </div>
    </div>
</body>
</html>