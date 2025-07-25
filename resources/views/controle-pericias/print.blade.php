@php
    $imgPath = public_path('img/cabecalho_pericia.png');
@endphp
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Relatório de Perícia</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #222;
            margin: 0;
            padding: 0;
        }

        .header {
            width: 100%;
            margin-bottom: 30px;
        }

        .header img {
            width: 100%;
            max-width: 700px;
            display: block;
            margin: 0 auto;
        }

        .content {
            margin: 0 auto;
            max-width: 700px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            padding: 32px 40px;
        }

        .title {
            font-size: 2rem;
            color: #0d6efd;
            margin-bottom: 24px;
            text-align: center;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        .info-table th,
        .info-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        .info-table th {
            background: #f8f9fa;
            color: #495057;
            font-weight: 600;
        }

        .label {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .value {
            font-size: 1.08rem;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ $imgPath }}" alt="Cabeçalho">
    </div>
    <div class="content">
        <!-- <div class="title">Relatório de Perícia</div> -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
            <div style="font-size: 0.70rem; color: #6c757d;">
                <strong>Data/Hora da Impressão:</strong> {{ now()->format('d/m/Y H:i') }}
            </div>
            <!-- <div style="font-size: 0.70rem; color: #6c757d;">
                <strong>Usuário:</strong> {{ auth()->user()->nome ?? '-' }}
            </div> -->
        </div>
        <table class="info-table" style="border-radius: 8px; overflow: hidden; box-shadow: 0 1px 6px rgba(0,0,0,0.04);">
            <tr style="background: linear-gradient(90deg, #e3f0ff 0%, #f8f9fa 100%);">
                <th class="label" style="width: 180px;">Nº Processo</th>
                <td class="value" style="font-size: 1.15rem; color: #0d6efd; font-weight: 600;">
                    {{ $pericia->numero_processo ?? '-' }}</td>
            </tr>
            <tr>
                <th class="label">Requerente</th>
                <td class="value">{{ $pericia->requerente ? $pericia->requerente->nome : '-' }}</td>
            </tr>
            <tr>
                <th class="label">Requerido</th>
                <td class="value">{{ $pericia->requerido ?? '-' }}</td>
            </tr>
            <tr>
                <th class="label">Vara</th>
                <td class="value">{{ $pericia->vara }}</td>
            </tr>
            <tr>
                <th class="label">Responsável Técnico</th>
                <td class="value">
                    {{ $pericia->responsavelTecnico ? $pericia->responsavelTecnico->nome : 'Não atribuído' }}</td>
            </tr>
            <tr>
                <th class="label">Status</th>
                <td class="value">
                    <span
                        style="display: inline-block; padding: 4px 14px; border-radius: 16px; background: #e9ecef; color: #0d6efd; font-weight: 600; font-size: 1rem;">
                        {{ $pericia->status_atual }}
                    </span>
                </td>
            </tr>
            <tr>
                <th class="label">Tipo Perícia</th>
                <td class="value">
                    @if ($pericia->tipo_pericia)
                        {{ $pericia->tipo_pericia }}
                    @else
                        <span style="font-style: italic; font-size: 0.9em; color: #777;">Não informado</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th class="label">Data da nomeação</th>
                <td class="value">
                    {{ $pericia->data_nomeacao ? $pericia->data_nomeacao->translatedFormat('d \d\e F \d\e Y') : 'Não definido' }}
                </td>
            </tr>
            <tr>
                <th class="label">Data vistoria</th>
                <td class="value">
                    {{ $pericia->data_vistoria ? $pericia->data_vistoria->translatedFormat('d \d\e F \d\e Y') : 'Não definido' }}
                </td>
            </tr>
            <tr>
                <th class="label">Prazo Final</th>
                <td class="value">
                    {{ $pericia->prazo_final ? $pericia->prazo_final->translatedFormat('d \d\e F \d\e Y') : 'Não definido' }}
                </td>
            </tr>
        </table>
        @if ($pericia->observacoes)
            <div style="margin-top: 24px;">
                <strong>Observações:</strong>
                <div
                    style="margin-top: 8px; color: #495057; background: #f8f9fa; border-radius: 6px; padding: 12px 16px;">
                    {{ $pericia->observacoes }}</div>
            </div>
        @endif
    </div>
</body>

</html>
