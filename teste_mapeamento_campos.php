<?php
// Simulação de teste dos campos Benfeitoria, Posição na Quadra, Topologia

echo "<h1>Teste dos Campos: Benfeitoria, Posição na Quadra, Topologia</h1>\n";

// Simular dados que vêm do formulário para tipo 'terreno'
$dadosTerreno = [
    'tipo' => 'terreno',
    'fator_fundamentacao' => 'Alto',
    'endereco' => 'Rua Teste',
    'bairro_id' => 1,
    'zona_id' => 1,
    'benfeitoria_terreno' => 'Possui',
    'posicao_na_quadra_terreno' => 'Esquina',
    'topologia_terreno' => 'Plano',
    'area_total_dados_terreno' => 500.50,
    'imagens_data' => '[]'
];

// Simular dados que vêm do formulário para outros tipos
$dadosConstrucao = [
    'tipo' => 'apartamento',
    'fator_fundamentacao' => 'Médio',
    'endereco' => 'Rua Teste 2',
    'bairro_id' => 1,
    'zona_id' => 1,
    'benfeitoria' => 'possui',
    'posicao_na_quadra' => 'esquina',
    'topologia' => 'Plano',
    'area_total_dados_terreno' => 80.00,
    'imagens_data' => '[]'
];

function simularMapeamentoController($dados) {
    $validated = $dados;

    echo "<h2>Dados ANTES do mapeamento (tipo: {$dados['tipo']}):</h2>\n";
    echo "<pre>\n";
    print_r($validated);
    echo "</pre>\n";

    // Aplicar a lógica do controller
    if ($dados['tipo'] === 'terreno') {
        // Mapear campos de terreno
        if (isset($validated['benfeitoria_terreno'])) {
            $validated['benfeitoria'] = $validated['benfeitoria_terreno'];
            unset($validated['benfeitoria_terreno']);
        }
        if (isset($validated['posicao_na_quadra_terreno'])) {
            $validated['posicao_na_quadra'] = $validated['posicao_na_quadra_terreno'];
            unset($validated['posicao_na_quadra_terreno']);
        }
        if (isset($validated['topologia_terreno'])) {
            $validated['topologia'] = $validated['topologia_terreno'];
            unset($validated['topologia_terreno']);
        }

        // Mapear área
        $validated['area_total'] = $validated['area_total_dados_terreno'] ?? null;
        unset($validated['area_total_dados_terreno']);
    }

    echo "<h2>Dados APÓS o mapeamento:</h2>\n";
    echo "<pre>\n";
    print_r($validated);
    echo "</pre>\n";

    // Verificar se os campos serão salvos corretamente
    echo "<h3>Campos que serão salvos no banco:</h3>\n";
    echo "<ul>\n";
    echo "<li><strong>benfeitoria:</strong> " . ($validated['benfeitoria'] ?? 'NÃO DEFINIDO') . "</li>\n";
    echo "<li><strong>posicao_na_quadra:</strong> " . ($validated['posicao_na_quadra'] ?? 'NÃO DEFINIDO') . "</li>\n";
    echo "<li><strong>topologia:</strong> " . ($validated['topologia'] ?? 'NÃO DEFINIDO') . "</li>\n";
    echo "<li><strong>area_total:</strong> " . ($validated['area_total'] ?? 'NÃO DEFINIDO') . "</li>\n";
    echo "</ul>\n";

    return $validated;
}

// Testar com terreno
echo "<hr>\n";
echo "<h1>TESTE 1: Tipo TERRENO</h1>\n";
simularMapeamentoController($dadosTerreno);

echo "<hr>\n";
echo "<h1>TESTE 2: Tipo APARTAMENTO (para comparar)</h1>\n";
simularMapeamentoController($dadosConstrucao);

echo "<hr>\n";
echo "<h2>CONCLUSÃO:</h2>\n";
echo "<p>✅ Para <strong>terreno</strong>: os campos _terreno devem ser mapeados para os campos principais</p>\n";
echo "<p>✅ Para <strong>outros tipos</strong>: os campos sem sufixo são usados diretamente</p>\n";
echo "<p>⚠️ <strong>IMPORTANTE:</strong> Certifique-se de que o formulário envia os nomes corretos dos campos conforme o tipo selecionado.</p>\n";

?>
