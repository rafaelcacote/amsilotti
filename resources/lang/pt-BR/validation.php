<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'Por favor, insira um endereço de e-mail válido.',
    'unique' => 'Este :attribute já está sendo usado.',
    'size' => 'O :attribute deve ter exatamente :size caracteres.',
    'regex' => 'O formato do :attribute é inválido.',

    'custom' => [
        'descricao' => [
            'required' => 'Por favor, insira uma descrição.',
        ],
        'user_id' => [
            'required' => 'Por favor, selecione um usuário.',
        ],
        'status' => [
            'required' => 'Por favor, selecione um status.',
        ],
        'email' => [
            'required' => 'O campo e-mail é obrigatório.',
            'email' => 'Por favor, insira um endereço de e-mail válido.',
        ],
        'password' => [
            'required' => 'O campo senha é obrigatório.',
        ],
        'cpf' => [
            'required' => 'O campo CPF é obrigatório.',
            'unique' => 'Este CPF já está cadastrado no sistema.',
            'size' => 'O CPF deve ter exatamente 11 números.',
            'regex' => 'O CPF deve conter apenas números.',
        ],
        'requerente_id' => [
            'required' => 'Por favor, selecione um requerente.',
        ],
        'numero_processo' => [
            'required' => 'O campo número do processo é obrigatório.',
        ],
        'requerido' => [
            'required' => 'O campo requerido é obrigatório.',
        ],
        'vara' => [
            'required' => 'Por favor, selecione uma vara.',
        ],
        'tipo_pericia' => [
            'required' => 'Por favor, selecione o tipo de perícia.',
        ],
        'status_atual' => [
            'required' => 'Por favor, selecione o status atual.',
        ],
    ],

    'attributes' => [
        'email' => 'e-mail',
        'password' => 'senha',
        'cpf' => 'CPF',
        'numero_processo' => 'número do processo',
        'requerente_id' => 'requerente',
        'requerido' => 'requerido',
        'vara' => 'vara',
        'tipo_pericia' => 'tipo de perícia',
        'data_nomeacao' => 'data de nomeação',
        'status_atual' => 'status',
        'data_vistoria' => 'data da vistoria',
        'prazo_final' => 'prazo final',
        'decurso_prazo' => 'decurso de prazo',
        'valor' => 'valor',
        'responsavel_tecnico_id' => 'responsável técnico',
        'protocolo_responsavel_id' => 'protocolo responsável',
        'cadeia_dominial' => 'cadeia dominial',
        'protocolo' => 'protocolo',
        'data_protocolo' => 'data do protocolo',
        'observacoes' => 'observações',
    ],
];
