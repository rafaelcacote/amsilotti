@php
    $imgPath = public_path('img/cabecalho_pericia.png');
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Perícias</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
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
            font-size: 14px;
        }
        
        .filtro-item {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 3px;
            font-size: 12px;
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
            font-size: 11px;
        }
        
        th {
            background: linear-gradient(90deg, #0d6efd 0%, #0056b3 100%);
            color: white;
            padding: 13px 9px;
            text-align: left;
            font-weight: 600;
            font-size: 12px;
        }
        
        td {
            padding: 11px 9px;
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
            padding: 5px 11px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-align: center;
            color: white;
            display: inline-block;
        }
        
        .status-aguardando-vistoria { background-color: #17a2b8; }
        .status-em-redacao { background-color: #0d6efd; }
        .status-aguardando-pagamento { background-color: #ffc107; color: #333; }
        .status-aguardando-documentacao { background-color: #6c757d; }
        .status-concluido { background-color: #28a745; }
        .status-entregue { background-color: #28a745; }
        .status-cancelado { background-color: #dc3545; }
        .status-default { background-color: #e9ecef; color: #333; }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 11px;
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
        
        .col-processo { width: 12%; }
        .col-requerente { width: 15%; }
        .col-requerido { width: 15%; }
        .col-vara { width: 12%; }
        .col-responsavel { width: 12%; }
        .col-tipo { width: 10%; }
        .col-status { width: 8%; }
        .col-entrega { width: 8%; }
        
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
        <h1>Relatório de Perícias</h1>
        <h2>Listagem Completa</h2>
    </div> -->

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Data/Hora da Impressão:</span>
            <span class="info-value">{{ date('d/m/Y H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de Registros:</span>
            <span class="info-value">{{ $pericias->count() }}</span>
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
        @if($filtrosAplicados['vara'])
            <div class="filtro-item"><strong>Vara:</strong> {{ $filtrosAplicados['vara'] }}</div>
        @endif
        @if($filtrosAplicados['responsavel'])
            <div class="filtro-item"><strong>Responsável:</strong> {{ $filtrosAplicados['responsavel'] }}</div>
        @endif
        @if($filtrosAplicados['status'])
            <div class="filtro-item"><strong>Status:</strong> {{ $filtrosAplicados['status'] }}</div>
        @endif
        @if($filtrosAplicados['tipo_pericia'])
            <div class="filtro-item"><strong>Tipo:</strong> {{ $filtrosAplicados['tipo_pericia'] }}</div>
        @endif
        @if($filtrosAplicados['mes'])
            <div class="filtro-item"><strong>Mês:</strong> {{ str_pad($filtrosAplicados['mes'], 2, '0', STR_PAD_LEFT) }}</div>
        @endif
        @if($filtrosAplicados['ano'])
            <div class="filtro-item"><strong>Ano:</strong> {{ $filtrosAplicados['ano'] }}</div>
        @endif
    </div>
    @endif -->

    <div class="table-container">
        @if($pericias->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th class="col-processo">Nº Processo</th>
                        <th class="col-requerente">Requerente</th>
                        <th class="col-requerido">Requerido</th>
                        <th class="col-vara">Vara</th>
                        <th class="col-responsavel">Responsável</th>
                        <th class="col-tipo">Tipo de Perícia</th>
                        <th class="col-status">Status</th>
                        <th class="col-entrega">Laudo Entregue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pericias as $pericia)
                        <tr>
                            <td class="break-word">
                                @if($pericia->numero_processo)
                                    <span class="processo-link">{{ $pericia->numero_processo }}</span>
                                @else
                                    <em style="color: #6c757d; font-size: 10px;">sem processo</em>
                                @endif
                            </td>
                            <td class="break-word">
                                {{ $pericia->requerente ? $pericia->requerente->nome : '-' }}
                            </td>
                            <td class="break-word">
                                {{ $pericia->requerido ?? '-' }}
                            </td>
                            <td class="break-word">{{ $pericia->vara }}</td>
                            <td class="break-word">
                                {{ $pericia->responsavelTecnico ? $pericia->responsavelTecnico->nome : 'Não atribuído' }}
                            </td>
                            <td class="break-word">
                                {{ $pericia->tipo_pericia ?: 'Não informado' }}
                            </td>
                            <td>
                                @php
                                    $statusClass = match (strtolower($pericia->status_atual)) {
                                        'aguardando vistoria' => 'status-aguardando-vistoria',
                                        'em redação', 'em redacao' => 'status-em-redacao',
                                        'aguardando pagamento' => 'status-aguardando-pagamento',
                                        'aguardando documentação' => 'status-aguardando-documentacao',
                                        'concluído', 'concluido' => 'status-concluido',
                                        'entregue' => 'status-entregue',
                                        'cancelado' => 'status-cancelado',
                                        default => 'status-default',
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $pericia->status_atual }}
                                </span>
                            </td>
                            <td>
                                {{ $pericia->prazo_final ? $pericia->prazo_final->format('d/m/Y') : 'Não definido' }}
                            </td>
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
