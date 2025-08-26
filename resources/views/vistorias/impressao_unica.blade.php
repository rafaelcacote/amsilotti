@php
    $imgPath = public_path('img/cabecalho_vistoria.png');
@endphp
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Perícia</title>
    <style>
        /* RESET */
        html,
        body {
            margin: 0;
            padding: 0;
        }

        *,
        *:before,
        *:after {
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', 'Times New Roman', serif;
            background: #ffffff;
            color: #1a1a1a;
            font-size: 12px;
            line-height: 1.6;
            padding: 0;
        }

        @page {
            header: html_myHeader;
            footer: html_myFooter;
            margin-top: 100px;
            margin-bottom: 60px;
            margin-left: 20px;
            margin-right: 20px;
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            background: #ffffff;
            padding: 15px;
        }

        /* Section Title - Elegante e minimalista */
        .section-title {
            font-size: 16px;
            color: #1a1a1a;
            font-weight: 700;
            margin-top: 30px;
            margin-bottom: 15px;
            padding: 12px 0;
            border-bottom: 2px solid #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: left;
        }

        /* Card - Design limpo */
        .card {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
            padding: 15px;
        }

        .card-header {
            color: #1a1a1a;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e0e0e0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Info Table - Clean design */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .info-table th,
        .info-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #f0f0f0;
            text-align: left;
            font-size: 12px;
        }

        .info-table th {
            background: #f8f8f8;
            color: #1a1a1a;
            font-weight: 600;
            width: 35%;
        }

        .info-table td.label {
            color: #1a1a1a;
            font-weight: 600;
            width: 35%;
            background: #f8f8f8;
            vertical-align: top;
        }

        .info-table td.value {
            font-size: 12px;
            font-weight: 400;
            color: #1a1a1a;
            background: #ffffff;
            vertical-align: top;
        }

        /* Observations */
        .observations {
            background: #f8f8f8;
            border: 1px solid #e0e0e0;
            padding: 15px;
            margin-bottom: 25px;
            font-size: 12px;
            color: #1a1a1a;
            text-align: justify;
        }

        /* Technical Team */
        .team-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin-bottom: 25px;
        }

        .team-member {
            border: 1px solid #e0e0e0;
            background: #f8f8f8;
            padding: 12px;
            text-align: center;
        }

        .team-member h4 {
            margin: 0 0 5px 0;
            color: #1a1a1a;
            font-size: 13px;
            font-weight: 600;
        }

        .team-member p {
            margin: 0;
            color: #1a1a1a;
            font-size: 11px;
            font-style: italic;
        }

        /* Croqui */
        .croqui-container {
            text-align: center;
            margin: 25px 0;
            page-break-inside: avoid;
        }

        .croqui-img {
            max-width: 100%;
            max-height: 400px;
            border: 1px solid #e0e0e0;
            object-fit: contain;
            /* Garantir que a orientação seja respeitada */
            image-orientation: from-image;
            /* Reset de transformações que possam causar rotação */
            transform: none !important;
        }

        /* Photos */
        .photo-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
            margin-bottom: 20px;
        }

        .photo-item {
            background: #ffffff;
            border: 1px solid #e0e0e0;
            padding: 10px;
            text-align: center;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .photo-img {
            display: block;
            margin: 0 auto 10px auto;
            width: 100%;
            max-width: 600px;
            max-height: 350px;
            border: 1px solid #e0e0e0;
            object-fit: contain;
            /* Garantir que a orientação seja respeitada */
            image-orientation: from-image;
            /* Reset de transformações que possam causar rotação */
            transform: none !important;
        }

        }

        .photo-caption {
            font-size: 12px;
            color: #1a1a1a;
            background: #f8f8f8;
            padding: 8px 15px;
            margin: 0 auto;
            display: block;
            text-align: center;
            font-weight: 600;
            border: 1px solid #e0e0e0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .photo-page-break {
            page-break-before: always;
        }

        /* Signature */
        .assinatura-final {
            padding-top: 40px;
            text-align: left;
            font-size: 12px;
            color: #1a1a1a;
            page-break-inside: avoid;
            border-top: 2px solid #1a1a1a;
            margin-top: 30px;
            padding-top: 20px;
        }

        .assinatura-final .nome {
            font-weight: bold;
            font-size: 14px;
            margin-top: 15px;
            text-transform: uppercase;
        }

        .assinatura-final .titulo {
            font-style: italic;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .assinatura-final .dados {
            color: #1a1a1a;
            margin-bottom: 15px;
            font-size: 11px;
            line-height: 1.4;
        }

        /* Header/Footer for PDF (mPDF) */
        .header-bar {
            text-align: center;
            margin-bottom: 4px;
        }

        .header-bar img {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
        }

        .header-meta {
            text-align: right;
            font-size: 10px;
            color: #666666;
            margin-right: 5px;
        }

        .footer-bar {
            background: #1a1a1a;
            color: #ffffff;
            width: 100%;
            height: 30px;
            line-height: 30px;
            font-size: 11px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .footer-bar .left {
            position: absolute;
            left: 20px;
        }

        .footer-bar .right {
            position: absolute;
            right: 20px;
        }

        /* Page break for print/pdf */
        pagebreak,
        .page-break {
            page-break-before: always;
        }

        /* Typography improvements */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #1a1a1a;
            font-weight: 600;
        }

        /* Enhanced spacing */
        .card-body {
            padding: 0;
        }

        /* No data message */
        .no-data {
            color: #666666;
            font-style: italic;
            text-align: center;
            padding: 15px;
            background: #f8f8f8;
            border: 1px solid #e0e0e0;
        }

        /* Responsive for screen viewing (optional) */
        @media print {
            body {
                background: #fff;
            }

            .container {
                box-shadow: none;
            }
        }
    </style>
</head>

.photo-page-break {
page-break-before: always;
}

/* Signature */
.assinatura-final {
padding-top: 50px;
text-align: left;
font-size: 1.12rem;
color: #222;
}

.assinatura-final .nome {
font-weight: bold;
font-size: 1.13rem;
margin-top: 16px;
}

.assinatura-final .titulo {
font-style: italic;
margin-bottom: 2px;
}

.assinatura-final .dados {
color: #555;
margin-bottom: 16px;
font-size: 1.01rem;
}

/* Header/Footer for PDF (mPDF) */
.header-bar {
text-align: center;
margin-bottom: 4px;
}

.header-bar img {
width: 100%;
max-width: 650px;
margin: 0 auto;
}

.header-meta {
text-align: right;
font-size: 0.73rem;
color: #7e8790;
margin-right: 5px;
}

.footer-bar {
background: #6277a7;
color: #fff;
width: 100%;
height: 34px;
line-height: 34px;
font-size: 1.06rem;
display: flex;
justify-content: space-between;
align-items: center;
padding: 0 32px;
letter-spacing: .5px;
}

.footer-bar .left {
position: absolute;
left: 32px;
}

.footer-bar .right {
position: absolute;
right: 32px;
}

/* Page break for print/pdf */
pagebreak,
.page-break {
page-break-before: always;
}

/* Responsive for screen viewing (optional) */
@media print {
body {
background: #fff;
}

.container {
box-shadow: none;
}
}
</style>
</head>

<body>

    <!-- HEADER (mPDF) -->
    <htmlpageheader name="myHeader">
        <div class="header-bar">
            <img src="{{ $imgPath }}" alt="Cabeçalho">
        </div>
        <div class="header-meta">
            <b>Data/Hora da Impressão:</b> {{ now()->format('d/m/Y H:i') }} &nbsp;&nbsp;
            <b>Usuário:</b> {{ $usuarioLogado->name ?? 'Não identificado' }}
        </div>
    </htmlpageheader>
    <!-- FOOTER (mPDF) -->
    <htmlpagefooter name="myFooter">
        <div style="background: #1a1a1a; color: #ffffff; width: 100%; height: 20px; font-size: 11px;">
            <table style="width: 100%; height: 100%; border-collapse: collapse;">
                <tr style="vertical-align: middle;">
                    <td style="text-align: left; padding-left: 20px; color: #ffffff;">www.amsilotti.com</td>
                    <td style="text-align: right; padding-right: 20px; color: #ffffff;">MANAUS/AMAZONAS</td>
                </tr>
            </table>
        </div>
    </htmlpagefooter>

    <sethtmlpageheader name="myHeader" value="on" show-this-page="1" />
    <sethtmlpagefooter name="myFooter" value="on" />

    <div class="container">

        <!-- Informações Básicas -->
        <div class="section-title">Informações Básicas</div>
        <div class="card">
            <table class="info-table">
                {{-- <tr>
                    <td class="label">Código:</td>
                    <td class="value">{{ $vistoria->id }}</td>
                </tr> --}}
                <tr>
                    <td class="label">Processo:</td>
                    <td class="value">{{ $vistoria->num_processo }}</td>
                </tr>
                <tr>
                    <td class="label">Data:</td>
                    <td class="value">
                        {{ $vistoria->agenda && $vistoria->agenda->data ? \Carbon\Carbon::parse($vistoria->agenda->data)->format('d/m/Y') : '-' }}
                        @if ($vistoria->agenda && $vistoria->agenda->hora)
                            às {{ \Carbon\Carbon::parse($vistoria->agenda->hora)->format('H:i') }}
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <!-- Partes Envolvidas -->
        <div class="section-title">Partes Envolvidas</div>
        <div class="card">
            <table class="info-table">
                <tr>
                    <td class="label">Requerente:</td>
                    <td class="value">{{ $vistoria->requerente->nome ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Requerido:</td>
                    <td class="value">{{ $vistoria->requerido ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Localização -->
        <div class="section-title">Localização</div>
        <div class="card">
            <table class="info-table">
                <tr>
                    <td class="label">Endereço:</td>
                    <td class="value">
                        {{ $vistoria->endereco ?? '-' }}
                        {{ $vistoria->num ? ', nº ' . $vistoria->num : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Bairro:</td>
                    <td class="value">{{ $vistoria->bairro ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Cidade/UF:</td>
                    <td class="value">{{ $vistoria->cidade ?? '-' }}/{{ $vistoria->estado ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <pagebreak />

        <!-- Características do Imóvel -->
        <div class="section-title">Características do Imóvel</div>
        <div class="card">
            <div class="card-header">Limites e Confrontações</div>
            <div class="card-body">
                @if (is_array($vistoria->limites_confrontacoes))
                    <table class="info-table">
                        <tr>
                            <td class="label">Norte:</td>
                            <td class="value">{{ $vistoria->limites_confrontacoes['norte'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Sul:</td>
                            <td class="value">{{ $vistoria->limites_confrontacoes['sul'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Leste:</td>
                            <td class="value">{{ $vistoria->limites_confrontacoes['leste'] ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Oeste:</td>
                            <td class="value">{{ $vistoria->limites_confrontacoes['oeste'] ?? '-' }}</td>
                        </tr>
                    </table>
                @else
                    <div class="no-data">
                        Nenhuma informação registrada
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">Detalhes do Terreno</div>
            <div class="card-body">
                <table class="info-table">
                    <tr>
                        <td class="label">Topografia:</td>
                        <td class="value">{{ $vistoria->topografia ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Formato:</td>
                        <td class="value">{{ $vistoria->formato_terreno ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Superfície:</td>
                        <td class="value">{{ $vistoria->superficie ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Documentação:</td>
                        <td class="value">{{ $vistoria->documentacao ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Ocupação</div>
            <div class="card-body">
                <table class="info-table">
                    <tr>
                        <td class="label">Reside no Imóvel:</td>
                        <td class="value">{{ $vistoria->reside_no_imovel ? 'Sim' : 'Não' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Data de Ocupação:</td>
                        <td class="value">
                            {{ $vistoria->data_ocupacao ? \Carbon\Carbon::parse($vistoria->data_ocupacao)->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Tipo de Ocupação:</td>
                        <td class="value">{{ $vistoria->tipo_ocupacao ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Exerce Pacificamente:</td>
                        <td class="value">{{ $vistoria->exerce_pacificamente_posse ? 'Sim' : 'Não' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Utilização:</td>
                        <td class="value">{{ $vistoria->utiliza_benfeitoria ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <pagebreak />

        <!-- Construção -->
        <div class="section-title">Construção</div>
        <div class="card">
            <table class="info-table">
                <tr>
                    <td class="label">Tipo:</td>
                    <td class="value">{{ $vistoria->tipo_construcao ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Padrão Acabamento:</td>
                    <td class="value">{{ $vistoria->padrao_acabamento ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Idade Aparente:</td>
                    <td class="value">{{ $vistoria->idade_aparente ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Estado Conservação:</td>
                    <td class="value">{{ $vistoria->estado_conservacao ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Observações -->
        <div class="section-title">Observações</div>
        <div class="observations">
            {{ $vistoria->observacoes ?? 'Nenhuma observação registrada.' }}
        </div>

        <!-- Construção -->
        <div class="section-title">Acompanhamento</div>
        <div class="card">
            <table class="info-table">
                <tr>
                    <td class="label">Nome do Acompanhante:</td>
                    <td class="value">{{ $vistoria->acompanhamento_vistoria ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">CPF do Acompanhante:</td>
                    <td class="value">
                        @if ($vistoria->cpf_acompanhante)
                            {{ substr($vistoria->cpf_acompanhante, 0, 3) }}.{{ substr($vistoria->cpf_acompanhante, 3, 3) }}.{{ substr($vistoria->cpf_acompanhante, 6, 3) }}-{{ substr($vistoria->cpf_acompanhante, 9, 2) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label">Telefone do Acompanhante:</td>
                    <td class="value">
                        @if ($vistoria->telefone_acompanhante)
                            {{ substr($vistoria->telefone_acompanhante, 0, 2) }}.{{ substr($vistoria->telefone_acompanhante, 2, 5) }}-{{ substr($vistoria->telefone_acompanhante, 7, 4) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>

            </table>
        </div>


        <!-- Equipe Técnica -->
        <div class="section-title">Equipe Técnica</div>
        @if ($vistoria->membrosEquipeTecnica->count() > 0)
            <table class="team-table">
                <tr>
                    @foreach ($vistoria->membrosEquipeTecnica as $index => $membro)
                        @if ($index > 0 && $index % 2 == 0)
                </tr>
                <tr>
        @endif
        <td>
            <div class="team-member">
                <h4>{{ $membro->nome }}</h4>
                <p>{{ $membro->cargo }}</p>
            </div>
        </td>
        @endforeach
        @if ($vistoria->membrosEquipeTecnica->count() % 2 !== 0)
            <td></td>
        @endif
        </tr>
        </table>
    @else
        <div class="no-data">
            Nenhum membro registrado
        </div>
        @endif

        <!-- Croqui -->
        @if (isset($vistoria->croqui_imagem) &&
                $vistoria->croqui_imagem &&
                file_exists(public_path('storage/' . $vistoria->croqui_imagem)))
            <pagebreak />
            <div class="section-title">Croqui do Imóvel</div>
            <div class="croqui-container">
                <img src="{{ public_path('storage/' . $vistoria->croqui_imagem) }}" class="croqui-img"
                    alt="Croqui do imóvel">
            </div>
        @endif

        <pagebreak />

        <!-- Registro Fotográfico -->
        <div class="section-title">Registro Fotográfico</div>
        @if ($vistoria->fotos->count() > 0)
            @php
                $fotos = $vistoria->fotos->toArray();
                $totalFotos = count($fotos);
                $fotosPorPagina = 2;
                $totalPaginas = ceil($totalFotos / $fotosPorPagina);
            @endphp
            @for ($pagina = 0; $pagina < $totalPaginas; $pagina++)
                @if ($pagina > 0)
                    <pagebreak />
                @endif
                <table class="photo-table">
                    @for ($linha = 0; $linha < $fotosPorPagina; $linha++)
                        @php
                            $indice = $pagina * $fotosPorPagina + $linha;
                        @endphp
                        @if ($indice < $totalFotos)
                            @php
                                $foto = (object) $fotos[$indice];
                            @endphp
                            <tr>
                                <td style="width:100%; vertical-align:top; text-align:center;">
                                    <div class="photo-item">
                                        @if (file_exists(public_path('storage/' . $foto->url)))
                                            <img src="{{ public_path('storage/' . $foto->url) }}" class="photo-img"
                                                alt="Foto da vistoria">
                                        @else
                                            <div class="no-data">
                                                Imagem não encontrada
                                            </div>
                                        @endif
                                        <div class="photo-caption">{{ $foto->descricao ?? 'Sem descrição' }}</div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endfor
                </table>
            @endfor
        @else
            <div class="no-data">
                Nenhuma foto adicionada
            </div>
        @endif

        <!-- Assinatura -->
        <div class="assinatura-final" style="page-break-inside: avoid;">
            Manaus, {{ \Carbon\Carbon::now()->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') }}
            <br><br>
            <span class="nome">Amanda da Rocha Silotti</span><br>
            <span class="titulo">Especialista em Engenharia de Avaliações e Perícias</span><br>
            <span class="dados">
                Arquiteta e Urbanista - CAU-AM NºA123105-7<br>
                IBAPE/SP 2262<br>
                Perita Judicial
            </span>
        </div>

    </div>
</body>

</html>
