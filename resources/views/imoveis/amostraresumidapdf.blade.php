<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório do Imóvel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            color: #000;
            margin: 0;
            padding-top: 80px;
            /* Espaço para o cabeçalho fixo */
        }

        /* Cabeçalho fixo */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: white;
            display: block;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding: 5px 10px;
            z-index: 1000;
        }

        .header-images {
            float: left;
        }

        .header-images img {
            max-height: 40px;
        }

        .header-title {
            text-align: center;
            margin-right: 150px;
        }

        .header-title h1 {
            font-size: 14px;
            margin: 0;
            color: #333;
            text-transform: uppercase;
        }

        .header-contact {
            text-align: right;
            font-size: 12px;
            margin-top: -60px;
        }

        .header-contact p {
            margin: 0;
            line-height: 1.2;
        }

        /* Container para cada imóvel */
        .imovel-container {
            page-break-after: always;
            page-break-inside: avoid;
            margin-bottom: 20px;
        }

        /* Seções */
        .section {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .section-title {
            color: #0057b8;
            font-size: 11px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 7px;
        }

        table td {
            padding: 5px;
            border: 1px solid #ccc;
            vertical-align: top;
        }

        .data-label {
            font-weight: bold;
        }

        .data-value {
            font-size: 9px;
            color: #555;
        }

        /* Garantir que o cabeçalho apareça em cada página impressa */
        @page {
            margin-top: 60px;
        }
    </style>
</head>

<body>
    <!-- Cabeçalho fixo que aparecerá em todas as páginas -->
    <div class="header">
        <div class="header-images">
            <img src="{{ $logo }}" alt="Logo">
        </div>
        <div class="header-title">
            <h1>PESQUISA DE MERCADO</h1>
        </div>
        <div class="header-contact">
            <p><strong>Arquitetura, Avaliações <br>
                    e Perícias de Engenharia</strong></p>
            pericias@amsilotti.com<br>
            (92) 99510-0573
        </div>
    </div>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Cód</th>
                <th>Tipo</th>
                <th>Local</th>
                <th>Bairro</th>
                <th>Preço</th>
                <th>Área (m²)</th>
                <th>Fator Oferta</th>
                <th>Preço Uni. (R$/m²)</th>
                <th>Frente</th>
                <th>Prof. Equivalente</th>
                <th>PGM</th>
                <th>Topografia</th>
                <th>Pos. Quadra</th>
                <th>Benfeitoria</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($imoveis as $imovel)
                <tr>
                    <td>{{ $imovel->id }}</td>
                    <td>{{ $imovel->tipo == 'terreno' ? 'Terreno' : ($imovel->tipo == 'apartamento' ? 'Apartamento' : ($imovel->tipo == 'imovel_urbano' ? 'Imóvel Urbano' : 'Galpão')) }}
                    </td>
                    <td>{{ $imovel->endereco }}</td>
                    <td>{{ $imovel->bairro->nome ?? 'N/A' }}</td>
                    <td>R$ {{ number_format($imovel->valor_total_imovel, 2, ',', '.') }}</td>
                    @if ($imovel->tipo == 'terreno')
                        <td>{{ number_format($imovel->area_total, 2, ',', '.') }} m²</td>
                    @elseif (in_array($imovel->tipo, ['apartamento', 'imovel_urbano', 'galpao']))
                        <td>{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</td>
                    @endif
                    <td>{{ $imovel->fator_oferta }}</td>
                    <td>R$ {{ number_format($imovel->preco_unitario1, 2, ',', '.') }}</td>
                    <td>{{ $imovel->frente }}</td>
                    <td>{{ $imovel->profundidade_equiv }}</td>
                    <td>{{ $imovel->pgm }}</td>
                    <td>{{ $imovel->topologia }}</td>
                    <td>{{ $imovel->posicao_na_quadra }}</td>
                    <td>{{ $imovel->benfeitoria }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
