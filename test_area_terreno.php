<?php

// Script simples para testar se o campo area_total_dados_terreno está sendo corretamente
// mapeado para area_total quando o tipo é "terreno"

require 'vendor/autoload.php';

echo "=== TESTE: Verificação do mapeamento de área para terreno ===\n\n";

// Simular os dados que vêm do formulário para tipo terreno
$requestData = [
    'tipo' => 'terreno',
    'area_total_dados_terreno' => '1000.50',
    'area_terreno_construcao' => null,
    'area_total_terreno' => null,
    'area_construida' => null
];

echo "Dados simulados do formulário:\n";
print_r($requestData);

// Simular a lógica do controller
$validated = $requestData; // Em produção viria do validator

if ($requestData['tipo'] === 'terreno') {
    // Para terreno, usa area_total_dados_terreno
    $validated['area_total'] = $validated['area_total_dados_terreno'] ?? null;
} elseif ($requestData['tipo'] === 'galpao' || $requestData['tipo'] === 'imovel_urbano') {
    // Para galpão e imóvel urbano, usa area_terreno_construcao
    $validated['area_total'] = $validated['area_terreno_construcao'] ?? null;
} else {
    // Para outros tipos (apartamento, sala_comercial), usa area_total_dados_terreno
    $validated['area_total'] = $validated['area_total_dados_terreno'] ?? null;
}

// Remove os campos específicos
unset($validated['area_total_dados_terreno']);
unset($validated['area_terreno_construcao']);
unset($validated['area_total_terreno']);

echo "\nDados após processamento (que seriam salvos no banco):\n";
print_r($validated);

echo "\n=== RESULTADO ===\n";
if (isset($validated['area_total']) && $validated['area_total'] == '1000.50') {
    echo "✅ SUCESSO: O campo area_total_dados_terreno foi corretamente mapeado para area_total\n";
    echo "   Valor esperado: 1000.50\n";
    echo "   Valor obtido: " . $validated['area_total'] . "\n";
} else {
    echo "❌ ERRO: O mapeamento não funcionou corretamente\n";
    echo "   Valor esperado: 1000.50\n";
    echo "   Valor obtido: " . ($validated['area_total'] ?? 'null') . "\n";
}

echo "\n=== FIM DO TESTE ===\n";
