<?php

namespace App\Helpers;

class CpfHelper
{
    /**
     * Valida se um CPF é válido
     */
    public static function isValid(string $cpf): bool
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        // Verifica se tem 11 dígitos
        if (strlen($cpf) !== 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }

    /**
     * Formata um CPF ou CNPJ para exibição
     */
    public static function format(string $cpfCnpj): string
    {
        $cpfCnpj = preg_replace('/[^0-9]/', '', $cpfCnpj);
        
        if (strlen($cpfCnpj) === 11) {
            // Formato CPF: XXX.XXX.XXX-XX
            return substr($cpfCnpj, 0, 3) . '.' . 
                   substr($cpfCnpj, 3, 3) . '.' . 
                   substr($cpfCnpj, 6, 3) . '-' . 
                   substr($cpfCnpj, 9, 2);
        } elseif (strlen($cpfCnpj) === 14) {
            // Formato CNPJ: XX.XXX.XXX/XXXX-XX
            return substr($cpfCnpj, 0, 2) . '.' . 
                   substr($cpfCnpj, 2, 3) . '.' . 
                   substr($cpfCnpj, 5, 3) . '/' . 
                   substr($cpfCnpj, 8, 4) . '-' . 
                   substr($cpfCnpj, 12, 2);
        }
        
        return $cpfCnpj;
    }

    /**
     * Remove formatação do CPF
     */
    public static function clean(string $cpf): string
    {
        return preg_replace('/[^0-9]/', '', $cpf);
    }
}
