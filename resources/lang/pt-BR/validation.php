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
    ],

    'attributes' => [
        'email' => 'e-mail',
        'password' => 'senha',
        'cpf' => 'CPF',
    ],
];
