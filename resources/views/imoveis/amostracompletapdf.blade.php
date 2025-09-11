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
            margin: 10px;
        }

        /* Cabeçalho */
        .header {
            display: block;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 5px;
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

        /* Seções */
        .section {
            margin-bottom: 10px;
            page-break-inside: avoid;
        }

        .section-title {
            color: #0057b8;
            font-size: 10pt;
            font-weight: 600;
            border-bottom: 1px solid #ddd;
            padding-bottom: 3px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background-color: #e9eaf0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 5px;
            border: 1.5px solid #ccc;
            vertical-align: top;
        }

        .data-label {
            font-size: 8pt;
            font-weight: bold;
        }

        .data-value {
            font-size: 9px;
            color: black;
        }

        .photos-container {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
        }

        .photo-item {
            width: 33.33%;
            /* 3 fotos por linha */
            text-align: center;
            vertical-align: top;
            padding: 5px;
            height: 100%;
            page-break-inside: avoid;
        }

        .photo-wrapper {
            display: flex;
            flex-direction: column;
            height: 100%;
            page-break-inside: avoid;
        }

        .photo-image {
            width: 350px;
            height: 200px;
            /* Reduzi a altura para caber na página */
            object-fit: cover;
            border: 1px solid black;
            border-radius: 3px;
            margin: 0 auto;
        }

        .photo-caption {
            font-size: 13px;
            /* Aumentei o tamanho da legenda */
            font-weight: 900;
            margin-top: 5px;
            color: black;
            word-break: break-word;
            text-align: center;
            padding: 0 5px;
        }

        /* Garantir que as fotos não quebrem para outra página */
        .photo-row {
            page-break-inside: avoid;
        }

        .dual-column-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .dual-column-section .section-title {
            flex: 1;
            margin-bottom: 0;
            background-color: transparent;
            border-bottom: none;
            padding-bottom: 0;
        }

        .dual-column-section .section-title:first-child {
            margin-right: 20px;
        }
    </style>
</head>

<body>

    <div style="width: 100%; text-align: center; margin-bottom: 15px;" style="padding-top: -140px">
        <img src="{{ $logo }}" style="width: 100%; height: auto; max-height: 150px;">
    </div>

    <!-- Seção: Tipo do Imóvel -->
    <table style="width: 100%; margin-bottom: 10px; border: none; border-collapse: collapse;">
        <tr>

            <td style="width: 33,33%; background-color: #e9eaf0; border: none;">
                <div class="section-title">Cód AMOSTRA:
                    <strong><span class="data-value">
                            {{ $imovel->id }}
                        </span></strong>
                </div>
            </td>
            <td style="width: 33,33%; background-color: #e9eaf0; border: none;">
                <div class="section-title">TIPO DO IMÓVEL:
                    <strong><span class="data-value">
                            {{ ucfirst(str_replace('_', ' ', $imovel->tipo)) }}
                        </span></strong>
                </div>
            </td>
            <td style="width: 33,33%; background-color: #e9eaf0; border: none;">
                <div class="section-title">FATOR DE FUNDAMENTAÇÃO:
                    <strong><span class="data-value">
                            {{ $imovel->fator_fundamentacao }}
                        </span></strong>
                </div>
            </td>
        </tr>
    </table>

    <!-- Seção: Endereço e Localização -->
    <div class="section">
        <div class="section-title">ENDEREÇO E LOCALIZAÇÃO</div>
        <table>
            <tr>
                <td>
                    <span class="data-label">Endereço:</span><br>
                    <span class="data-value">{{ $imovel->endereco }}</span>
                </td>
                <td>
                    <span class="data-label">Número:</span><br>
                    <span class="data-value">{{ $imovel->numero }}</span>
                </td>
                <td>
                    <span class="data-label">Bairro:</span><br>
                    <span class="data-value">{{ $imovel->bairro->nome ?? '-' }} </span>
                </td>
                <td>
                    <span class="data-label">Zona:</span><br>
                    <span class="data-value">{{ $imovel->bairro->zona->nome ?? '-' }}</span>
                </td>
                <td align="center" rowspan="2" style="vertical-align: middle;">
                    <span class="data-label">PGM:</span><br>
                    <span class="data-value">{{ $imovel->bairro->valor_pgm }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="data-label">Latitude:</span><br>
                    <span class="data-value">{{ $imovel->latitude }}</span>
                </td>
                <td>
                    <span class="data-label">Longitude:</span><br>
                    <span class="data-value">{{ $imovel->longitude }}</span>
                </td>
                <td colspan="2">
                    <span class="data-label">Via Específica:</span><br>
                    <span class="data-value">{{ $imovel->viaEspecifica->trecho ?? '-' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- Seção: Dados do Terreno (se for terreno) -->
    @if ($imovel->tipo == 'terreno')
        <div class="section">
            <div class="section-title">DADOS DO TERRENO</div>
            <table>
                <tr>
                    <td>
                        <span class="data-label">Área Total:</span><br>
                        <span class="data-value">{{ number_format($imovel->area_total, 2, ',', '.') }} m²</span>
                    </td>
                    <td>
                        <span class="data-label">Benfeitoria:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->benfeitoria) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Posição na Quadra:</span><br>
                        <span
                            class="data-value">{{ ucfirst(str_replace('_', ' ', $imovel->posicao_na_quadra)) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Topografia:</span><br>
                        <span class="data-value">{{ $imovel->topologia }}</span>
                    </td>
                    <td>
                        <span class="data-label">Tipologia:</span><br>
                        <span class="data-value">{{ $imovel->tipologia ?? '-' }} </span>
                    </td>
                    <td>
                        <span class="data-label">Marina:</span><br>
                        @if($imovel->marina === 1 || $imovel->marina === '1')
                                                        <span class="data-value">Sim</span>
                                                    @elseif($imovel->marina === 0 || $imovel->marina === '0')
                                                        <span class="data-value">Não</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                    </td>
                    <td>
                        <span class="data-label">Frente:</span><br>
                        <span class="data-value">{{ $imovel->frente }}</span>
                    </td>
                    <td>
                        <span class="data-label">Profundidade Equivalente:</span><br>
                        <span class="data-value">{{ $imovel->profundidade_equiv }}</span>
                    </td>
                </tr>

            </table>
        </div>
    @endif

    <!-- Seção: Dados da Construção (Apartamento) -->
    @if ($imovel->tipo == 'apartamento')
        <div class="section">
            <div class="section-title">DADOS DA CONSTRUÇÃO</div>
            <table>
                <tr>
                    <td>
                        <span class="data-label">Área Util:</span><br>
                        <span class="data-value">{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</span>
                    </td>
                    <td>
                        <span class="data-label">Mobiliado:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->mobiliado) }}</span>
                    </td>
                    <td>
                        <span class="data-label">
                            {{ $imovel->banheiros == 1 ? 'Banheiro' : 'Banheiros' }}:
                        </span><br>
                        <span class="data-value">{{ $imovel->banheiros }}</span>
                    </td>
                    <td>
                        <span class="data-label">Gerador Energia:</span><br>
                        <span class="data-value">{{ $imovel->gerador }}</span>
                    </td>
                    <td>
                        <span class="data-label">Padrão Construtivo:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->padrao) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Estado Conservação:</span><br>
                        <span
                            class="data-value">{{ ucfirst(str_replace('_', ' ', $imovel->estado_conservacao)) }}</span>
                    </td>
                </tr>

                <tr>
                    <td>
                        <span class="data-label">Andar:</span><br>
                        <span class="data-value">{{ $imovel->andar }}</span>
                    </td>
                    <td>
                        <span class="data-label">Idade do Prédio:</span><br>
                        <span class="data-value">{{ $imovel->idade_predio }} anos</span>
                    </td>
                    <td>
                        <span class="data-label">
                            {{ $imovel->quantidade_suites == 1 ? 'Quant. Suíte' : 'Quant. Suítes' }}:
                        </span><br>
                        <span class="data-value">{{ $imovel->quantidade_suites }}</span>
                    </td>
                    <td>
                        <span class="data-label">Vagas de Garagem:</span><br>
                        <span class="data-value">{{ $imovel->vagas_garagem }}</span>
                    </td>
                    <td colspan="2">
                        <span class="data-label">Area de Lazer:</span><br>
                        <span class="data-value">{{ $imovel->area_lazer }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <span class="data-label">Descrição do Imóvel:</span><br>
                        <span class="data-value">{{ $imovel->descricao_imovel }}</span>
                    </td>
                </tr>
            </table>
        </div>
    @endif

    <!-- Seção: Dados da Construção (imovel_urbano) -->
    @if ($imovel->tipo == 'imovel_urbano')
        <div class="section">
            <div class="section-title">DADOS DA CONSTRUÇÃO</div>
            <table>
                <tr>
                    <td>
                        <span class="data-label">Área Construída:</span><br>
                        <span class="data-value">{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</span>
                    </td>
                    <td>
                        <span class="data-label">Benfeitoria:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->benfeitoria) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Posição na Quadra:</span><br>
                        <span class="data-value">{{ $imovel->posicao_na_quadra }}</span>
                    </td>
                    <td>
                        <span class="data-label">Topologia:</span><br>
                        <span class="data-value">{{ $imovel->topologia }}</span>
                    </td>
                    <td>
                        <span class="data-label">Padrão Construtivo:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->padrao) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Estado Conservação:</span><br>
                        <span
                            class="data-value">{{ ucfirst(str_replace('_', ' ', $imovel->estado_conservacao)) }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <span class="data-label">Descrição do Imóvel:</span><br>
                        <span class="data-value">{{ $imovel->descricao_imovel }}</span>
                    </td>
                </tr>
            </table>
        </div>
    @endif

    <!-- Seção: Dados da Construção (galpao) -->
    @if ($imovel->tipo == 'galpao')
        <div class="section">
            <div class="section-title">DADOS DA CONSTRUÇÃO</div>
            <table>
                <tr>
                    <td>
                        <span class="data-label">Área Construída:</span><br>
                        <span class="data-value">{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</span>
                    </td>
                    <td>
                        <span class="data-label">Benfeitoria:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->benfeitoria) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Posição na Quadra:</span><br>
                        <span class="data-value">{{ $imovel->posicao_na_quadra }}</span>
                    </td>
                    <td>
                        <span class="data-label">Topologia:</span><br>
                        <span class="data-value">{{ $imovel->topologia }}</span>
                    </td>
                    <td>
                        <span class="data-label">Padrão Construtivo:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->padrao) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Estado Conservação:</span><br>
                        <span
                            class="data-value">{{ ucfirst(str_replace('_', ' ', $imovel->estado_conservacao)) }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <span class="data-label">Descrição do Imóvel:</span><br>
                        <span class="data-value">{{ $imovel->descricao_imovel }}</span>
                    </td>
                </tr>
            </table>
        </div>
    @endif

    <!-- Seção: Dados da Construção (sala_comercial) -->
    @if ($imovel->tipo == 'sala_comercial')
        <div class="section">
            <div class="section-title">DADOS DA CONSTRUÇÃO</div>
            <table>
                <tr>
                    <td>
                        <span class="data-label">Área Util:</span><br>
                        <span class="data-value">{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</span>
                    </td>
                    <td>
                        <span class="data-label">Mobiliado:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->mobiliado) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Banheiros:</span><br>
                        <span class="data-value">{{ $imovel->banheiros }}</span>
                    </td>
                    <td>
                        <span class="data-label">Gerador:</span><br>
                        <span class="data-value">{{ $imovel->gerador }}</span>
                    </td>
                    <td>
                        <span class="data-label">Padrão Construtivo:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->padrao) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Estado Conservação:</span><br>
                        <span
                            class="data-value">{{ ucfirst(str_replace('_', ' ', $imovel->estado_conservacao)) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Vagas Garagem:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->vagas_garagem) }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <span class="data-label">Descrição do Imóvel:</span><br>
                        <span class="data-value">{{ $imovel->descricao_imovel }}</span>
                    </td>
                </tr>
            </table>
        </div>
    @endif


    <!-- Seção: Dados da Construção (se não for terreno) -->
    {{-- @if ($imovel->tipo != 'terreno')
        <div class="section">
            <div class="section-title">DADOS DA CONSTRUÇÃO</div>
            <table>
                <tr>
                    <td>
                        <span class="data-label">Área Construída:</span><br>
                        <span class="data-value">{{ number_format($imovel->area_construida, 2, ',', '.') }} m²</span>
                    </td>
                    <td>
                        <span class="data-label">Benfeitoria:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->benfeitoria) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Posição na Quadra:</span><br>
                        <span
                            class="data-value">{{ ucfirst(str_replace('_', ' ', $imovel->posicao_na_quadra)) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Topologia:</span><br>
                        <span class="data-value">{{ $imovel->topologia }}</span>
                    </td>
                    <td>
                        <span class="data-label">Padrão Construtivo:</span><br>
                        <span class="data-value">{{ ucfirst($imovel->padrao) }}</span>
                    </td>
                    <td>
                        <span class="data-label">Estado Conservação:</span><br>
                        <span
                            class="data-value">{{ ucfirst(str_replace('_', ' ', $imovel->estado_conservacao)) }}</span>
                    </td>
                </tr>
                <!-- Campos específicos para Apartamento -->
                @if ($imovel->tipo == 'apartamento')
                    <tr>
                        <td colspan="2">
                            <span class="data-label">Andar:</span><br>
                            <span class="data-value">{{ $imovel->andar }}</span>
                        </td>
                        <td colspan="2">
                            <span class="data-label">Idade do Prédio:</span><br>
                            <span class="data-value">{{ $imovel->idade_predio }} anos</span>
                        </td>
                        <td colspan="2">
                            <span class="data-label">Quant. Suítes:</span><br>
                            <span class="data-value">{{ $imovel->quatidade_suites }}</span>
                        </td>
                    </tr>
                @endif
                <tr>

                    <td colspan="6">
                        <span class="data-label">Descrição do Imóvel:</span><br>
                        <span class="data-value">{{ $imovel->descricao_imovel }}</span>
                    </td>
                </tr>
            </table>
        </div>
    @endif --}}


    <table style="width: 100%; margin-bottom: 10px; border: none; border-collapse: collapse;">
        <tr>
            <td style="width: 50%; background-color: #e9eaf0; border: none;">
                <div class="section-title">DADOS ECONÔMICOS </div>
            </td>
            <td style="width: 50%; background-color: #e9eaf0; border: none;">
                <div class="section-title">FONTE DA INFORMAÇÃO</div>
            </td>
        </tr>
    </table>
    <table style="width: 100%;">
        <tr>
            <td style="width: 16,66%;">
                <span class="data-label">Valor Total:</span><br>
                <span class="data-value">R$ {{ number_format($imovel->valor_total_imovel, 2, ',', '.') }}</span>
            </td>
            <td style="width: 16,66%;">
                <span class="data-label">Fator Oferta:</span><br>
                <span class="data-value">{{ number_format($imovel->fator_oferta, 2, ',', '.') }}</span>
            </td>
            <td style="width: 16,66%;">
                <span class="data-label">Preço Unitário:</span><br>
                <span class="data-value">R$ {{ number_format($imovel->preco_unitario1, 2, ',', '.') }}</span>
            </td>
            <td style="width: 16,66%;">
                <span class="data-label">Fonte:</span><br>
                <span class="data-value">{{ $imovel->fonte_informacao }}</span>
            </td>
            <td style="width: 16,66%;">
                <span class="data-label">Contato:</span><br>
                <span class="data-value">{{ $imovel->contato }}</span>
            </td>
            <td style="width: 16,66%;">
                <span class="data-label">Link:</span><br>
                <span class="data-value">{{ $imovel->link ? Str::limit($imovel->link, 30) : '-' }}</span>
            </td>
        </tr>

    </table>


    <!-- Seção: Fotos do Imóvel -->
    @php
        // Ordena para: 1) Localização, 2) Fachada, 3) qualquer outra
        usort($fotos, function ($a, $b) {
            $ordem = ['localização', 'fachada'];
            $aIndex = 2; // padrão: outros
            $bIndex = 2;
            foreach ($ordem as $i => $palavra) {
                if (stripos($a['descricao'], $palavra) !== false) {
                    $aIndex = $i;
                    break;
                }
            }
            foreach ($ordem as $i => $palavra) {
                if (stripos($b['descricao'], $palavra) !== false) {
                    $bIndex = $i;
                    break;
                }
            }
            return $aIndex <=> $bIndex;
        });
    @endphp
    <div class="section" style="page-break-inside: avoid; margin-top: 20px;">
        <div class="section-title">FOTOS DO IMÓVEL</div>
        <table class="photos-container">
            @foreach (array_chunk($fotos, 3) as $chunk)
                <tr class="photo-row">
                    @foreach ($chunk as $foto)
                        <td class="photo-item">
                            <div class="photo-wrapper">
                                <img src="{{ $foto['url'] }}" alt="Foto do Imóvel" class="photo-image">
                                <div class="photo-caption">{{ $foto['descricao'] }}</div>
                            </div>
                        </td>
                    @endforeach
                    @if (count($chunk) < 3)
                        @for ($i = 0; $i < 3 - count($chunk); $i++)
                            <td class="photo-item"></td>
                        @endfor
                    @endif
                </tr>
            @endforeach
        </table>
    </div>

</body>

</html>
