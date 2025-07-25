<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'Por favor, insira um endereço de e-mail válido.',
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

    ],

    'attributes' => [
        'email' => 'e-mail',
        'password' => 'senha',
    ],

    'custom' => [
        'email' => [
            'required' => 'O campo e-mail é obrigatório.',
            'email' => 'Por favor, insira um endereço de e-mail válido.',
        ],
        'password' => [
            'required' => 'O campo senha é obrigatório.',
        ],
    ],
];
