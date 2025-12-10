@php
    $imgPath = public_path('img/cabecalho_tarefas.png');
    
    // Preparar filtros aplicados (se não vier do controller, criar array vazio)
    $filtrosAplicados = $filtrosAplicados ?? [];
    
    // Garantir que selectedColumns sempre tenha um valor padrão
    $selectedColumns = $selectedColumns ?? ['processo', 'cliente', 'tipo_atividade', 'descricao', 'responsavel', 'prioridade', 'prazo', 'situacao'];
    
    // Se selectedColumns estiver vazio, usar todas as colunas
    if (empty($selectedColumns)) {
        $selectedColumns = ['processo', 'cliente', 'tipo_atividade', 'descricao', 'responsavel', 'prioridade', 'prazo', 'situacao'];
    }
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Tarefas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 11px;
            line-height: 1.5;
            color: #2c3e50;
            background: #fff;
            padding: 20px;
            margin: 0 auto;
            max-width: 1200px;
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
            height: auto;
        }
        
        .content-wrapper {
            position: relative;
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
            padding: 12px 15px;
            background: linear-gradient(135deg, #e3f0ff 0%, #f0f7ff 100%);
            border-radius: 8px;
            border-left: 4px solid #0d6efd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .info-row {
            display: inline-block;
            margin-right: 30px;
            margin-bottom: 6px;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
            margin-right: 5px;
        }
        
        .info-value {
            color: #0d6efd;
            font-weight: 600;
        }
        
        .filtros-section {
            margin-bottom: 20px;
            padding: 12px 15px;
            background-color: #fff9e6;
            border: 1px solid #ffd700;
            border-left: 4px solid #ffc107;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .filtros-title {
            font-weight: 700;
            color: #856404;
            margin-bottom: 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .filtro-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
            font-size: 10px;
            color: #856404;
        }
        
        .table-container {
            width: 100%;
            overflow: visible;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border: none;
            margin-bottom: 20px;
            background: #fff;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            background: #fff;
        }
        
        thead {
            display: table-header-group;
        }
        
        tbody {
            display: table-row-group;
        }
        
        th {
            background: #0d6efd;
            color: #ffffff !important;
            padding: 14px 10px;
            text-align: center;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-right: 2px solid #ffffff;
            border-bottom: 3px solid #0056b3;
            position: relative;
            vertical-align: middle;
        }
        
        th:last-child {
            border-right: none;
        }
        
        th:first-child {
            border-top-left-radius: 7px;
        }
        
        th:last-child {
            border-top-right-radius: 7px;
        }
        
        td {
            padding: 12px 10px;
            border-right: 1.5px solid #dee2e6;
            border-bottom: 1.5px solid #dee2e6;
            vertical-align: middle;
            word-wrap: break-word;
            font-size: 10px;
            color: #495057;
            text-align: left;
        }
        
        td:last-child {
            border-right: none;
        }
        
        tbody tr:last-child td {
            border-bottom: none;
        }
        
        tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tr:nth-child(odd) {
            background-color: #ffffff;
        }
        
        tbody tr:hover {
            background-color: #e7f3ff;
            transition: background-color 0.2s ease;
        }
        
        tbody tr:last-child td:first-child {
            border-bottom-left-radius: 7px;
        }
        
        tbody tr:last-child td:last-child {
            border-bottom-right-radius: 7px;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 9px;
            font-weight: 700;
            text-align: center;
            color: white;
            display: inline-block;
            white-space: nowrap;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
            border: 1px solid rgba(0,0,0,0.1);
        }
        
        .badge-alta { 
            background-color: #dc3545; 
            border-color: #bd2130;
        }
        .badge-media { 
            background-color: #ffc107; 
            color: #000; 
            border-color: #d39e00;
        }
        .badge-baixa { 
            background-color: #17a2b8; 
            border-color: #117a8b;
        }
        .badge-em-andamento { 
            background-color: #17a2b8; 
            border-color: #117a8b;
        }
        .badge-atrasado { 
            background-color: #dc3545; 
            border-color: #bd2130;
        }
        .badge-nao-iniciada { 
            background-color: #ffc107; 
            color: #000; 
            border-color: #d39e00;
        }
        .badge-concluida { 
            background-color: #28a745; 
            border-color: #1e7e34;
        }
        .badge-default { 
            background-color: #6c757d; 
            border-color: #545b62;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #6c757d;
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
        }
        
        .no-data {
            text-align: center;
            padding: 50px;
            color: #6c757d;
            font-style: italic;
            background-color: #f8f9fa;
            border-radius: 8px;
            font-size: 12px;
        }
        
        .break-word {
            word-break: break-word;
            max-width: 200px;
            line-height: 1.5;
        }
        
        @media print {
            @page {
                margin: 15mm;
            }
            
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                padding: 0;
                margin: 0;
            }
            
            .header {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                width: 100%;
                z-index: 9999;
                background: white;
                padding: 5mm 10mm;
                margin: 0;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            }
            
            .header img {
                width: 100%;
                display: block;
                max-height: 70mm;
            }
            
            .content-wrapper {
                margin-top: 85mm;
            }
            
            .info-section {
                margin-top: 5mm;
            }
            
            .info-section,
            .filtros-section {
                page-break-inside: avoid;
            }
            
            .table-container {
                box-shadow: none;
                border: none !important;
                border-radius: 0;
                page-break-inside: auto;
            }
            
            table {
                border-collapse: collapse;
            }
            
            thead {
                display: table-header-group;
            }
            
            tbody {
                display: table-row-group;
            }
            
            th {
                background: #0d6efd !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color: #ffffff !important;
                border-right: 2px solid #ffffff !important;
                border-bottom: 3px solid #000 !important;
                font-size: 11px !important;
                font-weight: 700 !important;
                padding: 14px 10px !important;
                text-align: center !important;
            }
            
            th:last-child {
                border-right: none !important;
            }
            
            td {
                border-right: 1.5px solid #000 !important;
                border-bottom: 1.5px solid #000 !important;
                padding: 12px 10px !important;
            }
            
            td:last-child {
                border-right: none !important;
            }
            
            tbody tr:last-child td {
                border-bottom: none !important;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            /* Zebrado na impressão */
            tbody tr:nth-child(even) {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            tbody tr:nth-child(odd) {
                background-color: #ffffff !important;
            }
            
            .status-badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .badge-alta { 
                background-color: #dc3545 !important; 
                color: white !important;
            }
            .badge-media { 
                background-color: #ffc107 !important; 
                color: #000 !important;
            }
            .badge-baixa,
            .badge-em-andamento { 
                background-color: #17a2b8 !important; 
                color: white !important;
            }
            .badge-atrasado { 
                background-color: #dc3545 !important; 
                color: white !important;
            }
            .badge-nao-iniciada { 
                background-color: #ffc107 !important; 
                color: #000 !important;
            }
            .badge-concluida { 
                background-color: #28a745 !important; 
                color: white !important;
            }
            
            .footer {
                page-break-inside: avoid;
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ $imgPath }}" alt="Cabeçalho">
    </div>

    <div class="content-wrapper">
        <!-- <div class="title-section">
            <h1>Relatório de Tarefas</h1>
            <h2>Listagem de Controle de Tarefas</h2>
        </div> -->

        <div class="info-section">
        <div class="info-row">
            <span class="info-label">Data/Hora da Impressão:</span>
            <span class="info-value">{{ date('d/m/Y H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total de Registros:</span>
            <span class="info-value">{{ $tarefas->count() }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Usuário:</span>
            <span class="info-value">{{ auth()->user()->name ?? auth()->user()->nome ?? '-' }}</span>
        </div>
    </div>

    @if(array_filter($filtrosAplicados))
    <div class="filtros-section">
        <div class="filtros-title">Filtros Aplicados:</div>
        @if(isset($filtrosAplicados['cliente']) && $filtrosAplicados['cliente'])
            <div class="filtro-item"><strong>Cliente:</strong> {{ $filtrosAplicados['cliente'] }}</div>
        @endif
        @if(isset($filtrosAplicados['prioridade']) && $filtrosAplicados['prioridade'])
            <div class="filtro-item"><strong>Prioridade:</strong> {{ ucfirst($filtrosAplicados['prioridade']) }}</div>
        @endif
        @if(isset($filtrosAplicados['situacao']) && $filtrosAplicados['situacao'])
            <div class="filtro-item"><strong>Situação:</strong> {{ ucfirst($filtrosAplicados['situacao']) }}</div>
        @endif
        @if(isset($filtrosAplicados['status']) && $filtrosAplicados['status'])
            <div class="filtro-item"><strong>Status:</strong> {{ ucfirst($filtrosAplicados['status']) }}</div>
        @endif
        @if(isset($filtrosAplicados['tipo_atividade']) && $filtrosAplicados['tipo_atividade'])
            <div class="filtro-item"><strong>Tipo de Atividade:</strong> {{ $filtrosAplicados['tipo_atividade'] }}</div>
        @endif
        @if(isset($filtrosAplicados['responsavel']) && $filtrosAplicados['responsavel'])
            <div class="filtro-item"><strong>Responsável:</strong> {{ $filtrosAplicados['responsavel'] }}</div>
        @endif
        @if(isset($filtrosAplicados['mes_termino']) && $filtrosAplicados['mes_termino'])
            <div class="filtro-item"><strong>Mês Término:</strong> {{ $filtrosAplicados['mes_termino'] }}</div>
        @endif
        @if(isset($filtrosAplicados['ano_termino']) && $filtrosAplicados['ano_termino'])
            <div class="filtro-item"><strong>Ano Término:</strong> {{ $filtrosAplicados['ano_termino'] }}</div>
        @endif
    </div>
    @endif

    <div class="table-container">
        @if($tarefas->count() > 0)
            <table>
                <thead>
                    <tr>
                        @if(in_array('processo', $selectedColumns))
                            <th>Processo</th>
                        @endif
                        @if(in_array('cliente', $selectedColumns))
                            <th>Cliente</th>
                        @endif
                        @if(in_array('tipo_atividade', $selectedColumns))
                            <th>Tipo de Atividade</th>
                        @endif
                        @if(in_array('descricao', $selectedColumns))
                            <th>Descrição</th>
                        @endif
                        @if(in_array('responsavel', $selectedColumns))
                            <th>Responsável</th>
                        @endif
                        @if(in_array('prioridade', $selectedColumns))
                            <th>Prioridade</th>
                        @endif
                        @if(in_array('prazo', $selectedColumns))
                            <th>Prazo</th>
                        @endif
                        @if(in_array('situacao', $selectedColumns))
                            <th>Situação</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarefas as $tarefa)
                        <tr>
                            @if(in_array('processo', $selectedColumns))
                                <td class="break-word">{{ $tarefa->processo ?? '-' }}</td>
                            @endif
                            @if(in_array('cliente', $selectedColumns))
                                <td class="break-word">{{ $tarefa->cliente->nome ?? '-' }}</td>
                            @endif
                            @if(in_array('tipo_atividade', $selectedColumns))
                                <td class="break-word">{{ $tarefa->tipo_atividade ?? '-' }}</td>
                            @endif
                            @if(in_array('descricao', $selectedColumns))
                                <td class="break-word">{{ $tarefa->descricao_atividade ?? '-' }}</td>
                            @endif
                            @if(in_array('responsavel', $selectedColumns))
                                <td class="break-word">{{ $tarefa->membroEquipe->nome ?? '-' }}</td>
                            @endif
                            @if(in_array('prioridade', $selectedColumns))
                                <td style="text-align: center;">
                                    @php
                                        $prioridadeLower = strtolower($tarefa->prioridade ?? '');
                                        $badgeClass = 'badge-default';
                                        if ($prioridadeLower == 'alta') {
                                            $badgeClass = 'badge-alta';
                                        } elseif ($prioridadeLower == 'média' || $prioridadeLower == 'media') {
                                            $badgeClass = 'badge-media';
                                        } elseif ($prioridadeLower == 'baixa') {
                                            $badgeClass = 'badge-baixa';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $badgeClass }}">
                                        {{ ucfirst($tarefa->prioridade ?? '-') }}
                                    </span>
                                </td>
                            @endif
                            @if(in_array('prazo', $selectedColumns))
                                <td style="text-align: center;">
                                    @if($tarefa->prazo)
                                        @php
                                            try {
                                                // Tenta fazer o parse como data
                                                $prazoFormatado = \Carbon\Carbon::parse($tarefa->prazo)->format('d/m/Y');
                                                echo $prazoFormatado;
                                            } catch (\Exception $e) {
                                                // Se não for uma data válida, exibe o valor original
                                                echo $tarefa->prazo;
                                            }
                                        @endphp
                                    @else
                                        -
                                    @endif
                                </td>
                            @endif
                            @if(in_array('situacao', $selectedColumns))
                                <td style="text-align: center;">
                                    @php
                                        $situacaoLower = strtolower($tarefa->situacao ?? '');
                                        $badgeClass = 'badge-default';
                                        if ($situacaoLower == 'em andamento') {
                                            $badgeClass = 'badge-em-andamento';
                                        } elseif ($situacaoLower == 'atrasado') {
                                            $badgeClass = 'badge-atrasado';
                                        } elseif ($situacaoLower == 'nao iniciada') {
                                            $badgeClass = 'badge-nao-iniciada';
                                        } elseif ($situacaoLower == 'concluida' || $situacaoLower == 'concluída') {
                                            $badgeClass = 'badge-concluida';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $badgeClass }}">
                                        {{ ucfirst($tarefa->situacao ?? '-') }}
                                    </span>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>Nenhuma tarefa encontrada com os filtros aplicados.</p>
            </div>
        @endif
    </div>

        <div class="footer">
            <p>Relatório gerado automaticamente pelo Sistema de Controle de Tarefas</p>
            <p>Gerado em {{ date('d/m/Y') }} às {{ date('H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
