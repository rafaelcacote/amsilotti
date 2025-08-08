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
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f7f9fb;
            color: #222;
            font-size: 1.02rem;
            padding: 0;
        }

        @page {
            header: html_myHeader;
            footer: html_myFooter;
            margin-top: 100px;
            margin-bottom: 60px;
            margin-left: 22px;
            margin-right: 22px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto 30px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 2px 18px rgba(0, 35, 80, 0.08);
            padding: 22px 30px 28px 30px;
        }

        /* Section Title */
        .section-title {
            font-size: 1.5rem;
            color: #1b3970;
            font-weight: 700;
            margin-top: 40px;
            margin-bottom: 16px;
            border-left: 7px solid #1976d2;
            background: #f0f4fc;
            padding: 6px 0 6px 18px;
            letter-spacing: .4px;
        }

        /* Card (Group of Info) */
        .card {
            background: #f7faff;
            border-radius: 12px;
            box-shadow: 0 1px 7px rgba(25, 118, 210, 0.07);
            margin-bottom: 22px;
            padding: 18px 26px 8px 26px;
            border-left: 4px solid #1976d2;
        }

        .card-header {
            color: #1976d2;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 10px;
            border-bottom: 1px solid #e3eafc;
            padding-bottom: 5px;
            letter-spacing: .2px;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table th,
        .info-table td {
            padding: 7px 4px;
            border-bottom: 1px solid #f0f2f7;
            text-align: left;
            font-size: 1.02rem;
        }

        .info-table th {
            background: #eef3fd;
            color: #295897;
            font-weight: 600;
            width: 30%;
        }

        .info-table td.label {
            color: #4e647a;
            font-weight: 500;
            width: 30%;
            background: #f6f8fd;
        }

        .info-table td.value {
            font-size: 1.08rem;
            font-weight: 500;
            color: #292929;
            background: #fff;
        }

        /* Observations */
        .observations {
            background: #f6fafd;
            border-left: 5px solid #1976d2;
            border-radius: 0 10px 10px 0;
            padding: 14px 24px;
            margin-bottom: 32px;
            font-size: 1.06rem;
            font-style: italic;
            color: #345;
        }

        /* Technical Team */
        .team-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 12px 8px;
            margin-bottom: 30px;
        }

        .team-member {
            border: 1px solid #e3eafc;
            border-radius: 8px;
            background: #fcfdff;
            padding: 11px 14px;
            box-shadow: 0 1px 4px rgba(25, 118, 210, 0.06);
        }

        .team-member h4 {
            margin: 0 0 3px 0;
            color: #1565c0;
            font-size: 1.05rem;
        }

        .team-member p {
            margin: 0;
            color: #405068;
            font-size: 0.96rem;
        }

        /* Croqui */
        .croqui-container {
            text-align: center;
            margin: 28px 0 30px 0;
        }

        .croqui-img {
            max-width: 94%;
            max-height: 350px;
            border-radius: 10px;
            box-shadow: 0 2px 14px rgba(25, 118, 210, 0.09);
            border: 1.5px solid #d6e0f3;
        }

        /* Photos */
        .photo-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
            margin-bottom: 25px;
        }

        .photo-item {
            background: #fcfdff;
            border-radius: 9px;
            box-shadow: 0 1px 6px rgba(25, 118, 210, 0.07);
            padding: 12px 8px 10px 8px;
            text-align: center;
            margin-bottom: 20px;
        }

        .photo-img {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 98%;
            max-width: 580px;
            max-height: 320px;
            border-radius: 8px;
            border: 2px solid #e3eafc;
            object-fit: contain;
            margin-bottom: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .photo-caption {
            font-size: 1.18rem;
            color: #222;
            /* preto elegante */
            background: #f5f5f5;
            border-radius: 8px;
            padding: 7px 28px;
            margin: 0 auto;
            display: block;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(34, 34, 34, 0.07);
            letter-spacing: 0.5px;
            border: 1.5px solid #e0e0e0;
        }

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
        <div
            style="background: #6277a7; color: #fff; width: 100%; height: 20px; font-size: 1.06rem; letter-spacing: 0.5px; ">
            <table style="width: 100%; height: 100%; border-collapse: collapse;">
                <tr style="vertical-align: middle;">
                    <td style="text-align: left; padding-left: 32px; color: #fff;">www.amsilotti.com</td>
                    <td style="text-align: right; padding-right: 32px; color: #fff;">MANAUS/AMAZONAS</td>
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
                <tr>
                    <td class="label">Código:</td>
                    <td class="value">{{ $vistoria->id }}</td>
                </tr>
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
                            <td class="value">{{ $vistoria->limites_confrontacoes['norte'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Sul:</td>
                            <td class="value">{{ $vistoria->limites_confrontacoes['sul'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Leste:</td>
                            <td class="value">{{ $vistoria->limites_confrontacoes['leste'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Oeste:</td>
                            <td class="value">{{ $vistoria->limites_confrontacoes['oeste'] ?? 'N/A' }}</td>
                        </tr>
                    </table>
                @else
                    <div style="color: #8792a1; font-style: italic; text-align: center;">
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
                        <td class="value">{{ $vistoria->topografia ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Formato:</td>
                        <td class="value">{{ $vistoria->formato_terreno ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Superfície:</td>
                        <td class="value">{{ $vistoria->superficie ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Documentação:</td>
                        <td class="value">{{ $vistoria->documentacao ?? 'N/A' }}</td>
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
                            {{ $vistoria->data_ocupacao ? \Carbon\Carbon::parse($vistoria->data_ocupacao)->format('d/m/Y') : 'N/A' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Tipo de Ocupação:</td>
                        <td class="value">{{ $vistoria->tipo_ocupacao ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Exerce Pacificamente:</td>
                        <td class="value">{{ $vistoria->exerce_pacificamente_posse ? 'Sim' : 'Não' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Utilização:</td>
                        <td class="value">{{ $vistoria->utiliza_benfeitoria ?? 'N/A' }}</td>
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
                    <td class="value">{{ $vistoria->tipo_construcao ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Padrão Acabamento:</td>
                    <td class="value">{{ $vistoria->padrao_acabamento ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Idade Aparente:</td>
                    <td class="value">{{ $vistoria->idade_aparente ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">Estado Conservação:</td>
                    <td class="value">{{ $vistoria->estado_conservacao ?? 'N/A' }}</td>
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
                    <td class="value">{{ $vistoria->acompanhamento_vistoria ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">CPF do Acompanhante:</td>
                    <td class="value">
                        @if ($vistoria->cpf_acompanhante)
                            {{ substr($vistoria->cpf_acompanhante, 0, 3) }}.{{ substr($vistoria->cpf_acompanhante, 3, 3) }}.{{ substr($vistoria->cpf_acompanhante, 6, 3) }}-{{ substr($vistoria->cpf_acompanhante, 9, 2) }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="label">Telefone do Acompanhante:</td>
                    <td class="value">
                        @if ($vistoria->telefone_acompanhante)
                            {{ substr($vistoria->telefone_acompanhante, 0, 2) }}.{{ substr($vistoria->telefone_acompanhante, 2, 5) }}-{{ substr($vistoria->telefone_acompanhante, 7, 4) }}
                        @else
                            N/A
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
        <div style="color: #8792a1; font-style: italic; text-align: center; padding: 10mm;">
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
                                            <div style="color: #c0392b; text-align: center; padding: 20px;">
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
            <div style="color: #8792a1; font-style: italic; text-align: center; padding: 10mm;">
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
