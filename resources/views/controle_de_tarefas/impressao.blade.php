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
    <!-- <div class="header">
        <div class="header-images">
            <img src="{{ $logo }}" alt="Logo">
        </div>
        <div class="header-title">
            <h1>LISTA DE TAREFAS</h1>
        </div>
        <div class="header-contact">
            <p><strong>Arquitetura, Avaliações <br>
                    e Perícias de Engenharia</strong></p>
            pericias@amsilotti.com<br>
            (92) 99510-0573
        </div>
    </div> -->
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Processo</th>
                <th>Cliente</th>
                <th>Tipo de Atividade</th>
                <th>Descrição</th>
                <th>Responsável</th>
                <th>Prioridade</th>
                <th>Prazo</th>
                <th>Situação</th>

            </tr>
        </thead>
        <tbody>
            @if ($tarefas->count() > 0)
                @foreach ($tarefas as $tarefa)
                    <tr>
                        <td>{{ $tarefa->processo }}</td>
                        <td>{{ $tarefa->cliente->nome ?? '-' }}</td>
                        <td>{{ $tarefa->tipo_atividade }}</td>
                        <td>{{ $tarefa->descricao_atividade }}</td>
                        <td>{{ $tarefa->membroEquipe->nome ?? '-' }}</td>
                        <td>
                            <span
                                class="badge
                            @if (strtolower($tarefa->prioridade) == 'alta') bg-danger
                            @elseif(strtolower($tarefa->prioridade) == 'média' || strtolower($tarefa->prioridade) == 'media') bg-warning
                            @elseif(strtolower($tarefa->prioridade) == 'baixa') bg-info
                            @else bg-secondary @endif">
                                {{ ucfirst($tarefa->prioridade) }}
                            </span>
                        </td>
                        <td>
                            {{ $tarefa->prazo }}
                        </td>
                        <td>
                            <span
                                class="badge
                            @if ($tarefa->situacao == 'em andamento') bg-info
                            @elseif($tarefa->situacao == 'atrasado') bg-danger
                            @elseif($tarefa->situacao == 'nao iniciada') bg-warning
                            @elseif($tarefa->situacao == 'concluida') bg-success @endif">
                                {{ ucfirst($tarefa->situacao) }}
                            </span>
                        </td>

                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="11" class="text-center py-4" align="center">
                        <p class="mb-0 text-muted"> <strong> Nenhuma tarefa encontrada para impressão. </strong></p>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</body>

</html>
