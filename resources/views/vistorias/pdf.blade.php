<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Vistorias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin: 0;
            margin-bottom: 15px;
            border-bottom: 2px solid #ccc;
            padding: 0;
            padding-bottom: 10px;
        }

        .header img {
            max-width: 100%;
            height: auto;
            margin: 0;
            display: block;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0 0 0;
            color: #333;
        }

        .filters {
            background-color: #f5f5f5;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .filters h4 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666;
        }

        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }

        .filter-label {
            font-weight: bold;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            color: white;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-primary {
            background-color: #007bff;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-secondary {
            background-color: #6c757d;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        @if (file_exists(public_path('img/cabecalho_listavistoria.png')))
            <img src="{{ public_path('img/cabecalho_listavistoria.png') }}" alt="Cabeçalho Lista Vistoria">
        @endif
        {{-- <div class="title">LISTA DE VISTORIAS</div> --}}
    </div>

    @if ($request->hasAny(['num_processo', 'bairro', 'data_inicio', 'data_fim']))
        <div class="filters">
            <h4>Filtros Aplicados:</h4>
            @if ($request->filled('num_processo'))
                <div class="filter-item">
                    <span class="filter-label">Processo:</span> {{ $request->num_processo }}
                </div>
            @endif
            @if ($request->filled('bairro'))
                <div class="filter-item">
                    <span class="filter-label">Bairro:</span> {{ $request->bairro }}
                </div>
            @endif
            @if ($request->filled('data_inicio'))
                <div class="filter-item">
                    <span class="filter-label">Data Início:</span>
                    {{ \Carbon\Carbon::parse($request->data_inicio)->format('d/m/Y') }}
                </div>
            @endif
            @if ($request->filled('data_fim'))
                <div class="filter-item">
                    <span class="filter-label">Data Fim:</span>
                    {{ \Carbon\Carbon::parse($request->data_fim)->format('d/m/Y') }}
                </div>
            @endif
        </div>
    @endif

    @if ($vistorias->count() > 0)
        <table>
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">Processo</th>
                    <th width="25%">Requerido X Requerente</th>
                    <th width="15%">Data - Horário</th>
                    <th width="15%">Endereço</th>
                    <th width="15%">Bairro</th>

                    <th width="15%">Observações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vistorias as $vistoria)
                    <tr>
                        <td class="text-center">#{{ $vistoria->id }}</td>
                        <td>{{ $vistoria->num_processo ?? '-' }}</td>
                        <td>{{ $vistoria->requerente->nome ?? '-' }} X {{ $vistoria->requerido ?? '-' }}</td>
                        <td>
                            @if ($vistoria->data)
                                {{ \Carbon\Carbon::parse($vistoria->data)->format('d/m/Y') }}
                                @if ($vistoria->hora)
                                    {{ ' - ' . \Carbon\Carbon::parse($vistoria->hora)->format('H:i') }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @php
                                $enderecoCompleto = trim(
                                    ($vistoria->endereco ?? '') .
                                        (isset($vistoria->num) ? ', nº ' . $vistoria->num : ''),
                                );
                            @endphp
                            {{ $enderecoCompleto ?: '-' }}
                        </td>
                        <td>{{ $vistoria->bairro ?? '-' }}</td>
                        <td>{{ $vistoria->observacoes ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p><strong>Total de vistorias:</strong> {{ $vistorias->count() }}</p>
            <p>Relatório gerado em: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        </div>
    @else
        <div class="no-data">
            <p>Nenhuma vistoria encontrada com os filtros aplicados.</p>
        </div>
    @endif
</body>

</html>
