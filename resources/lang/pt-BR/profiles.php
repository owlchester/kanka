<?php

return [
    'description'   => 'Atualize os detalhes da sua conta',
    'edit'          => [
        'success'   => 'Perfil atualizado',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Email',
        'name'                      => 'Nome',
        'new_password'              => 'Nova senha (opcional)',
        'new_password_confirmation' => 'Confirmação da Nova Senha',
        'newsletter'                => 'Eu desejo ser contatado via email esporadicamente.',
        'password'                  => 'Senha atual',
    ],
    'password'      => [
        'success'   => 'Senha atualizada',
    ],
    'placeholders'  => [
        'email'                     => 'Seu endereço de email',
        'name'                      => 'Seu nome como exibido',
        'new_password'              => 'Sua nova senha',
        'new_password_confirmation' => 'Confirme sua nova senha',
        'password'                  => 'Forneça sua senha atual para qualquer mudança',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Deletar minha conta',
            'title'     => 'Deletar sua conta',
            'warning'   => 'Deletando sua conta, todos os seus dados serão perdidos. Você tem certeza?',
        ],
        'password'  => [
            'title' => 'Alterar sua senha',
        ],
    ],
    'title'         => 'Atualizar seu perfil',
];
