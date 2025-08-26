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
        'password' => [
            'required' => 'O campo senha é obrigatório.',
        ],
        'password_confirmation' => [
            'confirmed' => 'A confirmação da senha não confere.',
        ],
    ],

    'attributes' => [
        'email' => 'e-mail',
        'password' => 'senha',
        'password_confirmation' => 'confirmação da senha',
    ],
];
