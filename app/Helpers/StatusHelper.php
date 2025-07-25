<?php

namespace App\Helpers;

class StatusHelper
{
    /**
     * Get the Bootstrap color class for a given status
     *
     * @param string $status
     * @return string
     */
    public static function statusColor($status)
    {
        $status = strtolower($status);
        return [
            'pendente' => 'warning',
            'em andamento' => 'info',
            'concluído' => 'success',
            'cancelada' => 'danger',
            'atrasado' => 'primary',
        ][$status] ?? 'secondary';
    }

    public static function prioridadeColor($prioridade)
    {
        $prioridade = strtolower($prioridade);
        return [
            'alta' => 'danger',
            'media' => 'warning',
            'baixa' => 'info',
        ][$prioridade] ?? 'secondary';
    }
}
