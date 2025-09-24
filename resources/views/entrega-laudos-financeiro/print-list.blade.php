@php
    $imgPath = public_path('img/cabecalho_pericia.png');
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Entrega de Laudos Financeiros</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #222;
        }
        
        .header {
            width: 100%;
            margin-bottom: 20px;
        }

        .header img {
            width: 100%;
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }
        
        .title-section {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #0d6efd;
        }
        
        .title-section h1 {
            color: #0d6efd;
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .title-section h2 {
            color: #666;
            font-size: 14px;
            font-weight: normal;
        }
        
        .info-section {
            margin-bottom: 15px;
            padding: 10px 15px;
            background: linear-gradient(90deg, #e3f0ff 0%, #f8f9fa 100%);
            border-radius: 6px;
        }
        
        .info-row {
            display: inline-block;
            margin-right: 25px;
            margin-bottom: 5px;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        
        .info-value {
            color: #0d6efd;
            font-weight: 500;
        }
        
        .filtros-section {
            margin-bottom: 20px;
            padding: 12px 15px;
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
        }
        
        .filtros-title {
            font-weight: 600;
            color: #856404;
            margin-bottom: 8px;
            font-size: 11px;
        }
        
        .filtro-item {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 3px;
            font-size: 9px;
        }
        
        .table-container {
            width: 100%;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
        }
        
        th {
            background: linear-gradient(90deg, #0d6efd 0%, #0056b3 100%);
            color: white;
            padding: 10px 6px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
        }
        
        td {
            padding: 8px 6px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
            word-wrap: break-word;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tr:nth-child(odd) {
            background-color: white;
        }
        
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 7px;
            font-weight: 600;
            text-align: center;
            color: white;
            display: inline-block;
        }
        
        .status-liquidado { background-color: #28a745; }
        .status-pagamento { background-color: #ffc107; color: #333; }
        .status-aguardando { background-color: #17a2b8; }
        .status-secoft { background-color: #0d6efd; }
        .status-default { background-color: #6c757d; }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #6c757d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
            background-color: #f8f9fa;
            border-radius: 6px;
        }
        
        .processo-link {
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        
        .valor-money {
            color: #0d6efd;
            font-weight: 600;
        }
        
        .col-processo { width: 12%; }
        .col-vara { width: 8%; }
        .col-upj { width: 8%; }
        .col-financeiro { width: 10%; }
        .col-protocolo { width: 10%; }
        .col-valor { width: 10%; }
        .col-sei { width: 10%; }
        .col-empenho { width: 10%; }
        .col-nf { width: 8%; }
        .col-mes { width: 14%; }
        
        .break-word {
            word-break: break-word;
            max-width: 80px;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ $imgPath }}" alt="Cabeçalho">
    </div>

    <!-- <div class="title-section">
        <h1>Relatório Financeiro de Laudos</h1>
        <h2>Listagem de Entrega de Laudos</h2>
    </div> -->

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Data/Hora da Impressão:</span>
            <span class="info-value">{{ date('d/m/Y H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de Registros:</span>
            <span class="info-value">{{ $entregasLaudos->count() }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Usuário:</span>
            <span class="info-value">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <!-- @if(array_filter($filtrosAplicados))
    <div class="filtros-section">
        <div class="filtros-title">Filtros Aplicados:</div>
        @if($filtrosAplicados['search'])
            <div class="filtro-item"><strong>Busca:</strong> {{ $filtrosAplicados['search'] }}</div>
        @endif
        @if($filtrosAplicados['status'])
            <div class="filtro-item"><strong>Status:</strong> {{ $filtrosAplicados['status'] }}</div>
        @endif
        @if($filtrosAplicados['upj'])
            <div class="filtro-item"><strong>UPJ:</strong> {{ $filtrosAplicados['upj'] }}</div>
        @endif
        @if($filtrosAplicados['mes_pagamento'])
            <div class="filtro-item"><strong>Mês Pagamento:</strong> {{ $filtrosAplicados['mes_pagamento'] }}</div>
        @endif
    </div>
    @endif -->

    <div class="table-container">
        @if($entregasLaudos->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-processo">Processo</th>
                        <th class="col-vara">Vara</th>
                        <th class="col-upj">UPJ</th>
                        <th class="col-financeiro">Financeiro</th>
                        <th class="col-protocolo">Protocolo Laudo</th>
                        <th class="col-valor">R$</th>
                        <th class="col-sei">SEI</th>
                        <th class="col-empenho">Empenho</th>
                        <th class="col-nf">NF</th>
                        <th class="col-mes">Mês Pagamento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entregasLaudos as $entregaLaudo)
                        <tr>
                            <td class="break-word">
                                @if($entregaLaudo->controlePericia && $entregaLaudo->controlePericia->numero_processo)
                                    <span class="processo-link">{{ $entregaLaudo->controlePericia->numero_processo }}</span>
                                @else
                                    <em style="color: #6c757d; font-size: 7px;">sem processo</em>
                                @endif
                            </td>
                            <td class="break-word">{{ $entregaLaudo->controlePericia->vara ?? '-' }}</td>
                            <td class="break-word">{{ ucfirst($entregaLaudo->upj ?? '-') }}</td>
                            <td class="break-word">{{ ucfirst($entregaLaudo->financeiro ?? '-') }}</td>
                            <td class="break-word">
                                {{ $entregaLaudo->protocolo_laudo ? \Carbon\Carbon::parse($entregaLaudo->protocolo_laudo)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="break-word">
                                @if($entregaLaudo->valor)
                                    <span class="valor-money">{{ $entregaLaudo->valor_formatado }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="break-word">{{ $entregaLaudo->sei ?? '-' }}</td>
                            <td class="break-word">{{ $entregaLaudo->empenho ?? '-' }}</td>
                            <td class="break-word">{{ $entregaLaudo->nf ?? '-' }}</td>
                            <td class="break-word">{{ $entregaLaudo->mes_pagamento ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>Nenhum registro encontrado com os filtros aplicados.</p>
            </div>
        @endif
    </div>

    <div class="footer">
        <p>Relatório gerado automaticamente pelo Sistema de Controle de Perícias</p>
        <p>Gerado em {{ date('d/m/Y') }} às {{ date('H:i:s') }}</p>
    </div>
</body>
</html>