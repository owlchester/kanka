<?php

return [
    'avatar'        => [
        'success'   => 'Avatar atualizado',
    ],
    'description'   => 'Atualize os detalhes da sua conta',
    'edit'          => [
        'success'   => 'Perfil atualizado',
    ],
    'editors'       => [
        'default'       => 'Padrão (TinyMCE 4)',
        'summernote'    => 'Summernote (Experimental)',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Email',
        'last_login_share'          => 'Mostrar a outros membros da campanha a última vez que estive online.',
        'name'                      => 'Nome',
        'new_password'              => 'Nova senha (opcional)',
        'new_password_confirmation' => 'Confirmação da Nova Senha',
        'newsletter'                => 'Eu desejo ser contatado via email esporadicamente.',
        'password'                  => 'Senha atual',
        'settings'                  => 'Configurações',
        'theme'                     => 'Tema',
    ],
    'newsletter'    => [
        'links'     => [
            'community-vote'    => 'Voto da Comunidade',
            'news'              => 'Novidades',
        ],
        'settings'  => [
            'news'          => 'Novidades - Seja notificado(a) quando houver novidades.',
            'newsletter'    => 'Boletim de Notícias - receber o Boletim de Notícias do Kanka.',
            'votes'         => 'Votos da Comunidade - Ser notificado(a) assim que um novo :vote estiver disponível',
        ],
        'title'     => 'Boletim de Notícias',
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
    'settings'      => [
        'fields'    => [
            'advanced_mentions'     => 'Menções Avançadas',
            'date_format'           => 'Formato da Data',
            'default_nested'        => 'Visão Aninhada como padrão',
            'editor'                => 'Editor de texto',
            'new_entity_workflow'   => 'Novo fluxo de trabalho da entidade',
            'pagination'            => 'Paginação (elementos por página)',
        ],
        'helpers'   => [
            'editor'    => <<<'TEXT'
O editor de texto padrão (TinyMCE 4) é antigo e funciona bem no computador, mas não funciona no celular.
Summernote é um novo editor de texto que funciona em todos dispositivos mas ainda estamos testando ele.
TEXT
,
        ],
        'hints'     => [
            'advanced_mentions'     => 'Se ativado, menções vão sempre ser mostradas como [entity:123] quando editando a entidade.',
            'default_nested'        => 'Ative esta opçãp se você deseja que as listas sejam mostradas  de modo Aninhado por padrão (quando possível)',
            'new_entity_workflow'   => 'Ao criar uma nova entidade, o fluxo de trabalho padrão é ir para a lista de entidades. Você pode alterar isto para vizualizar a entidade recém-criada.',
        ],
        'success'   => 'Configurações alteradas com sucesso.',
    ],
    'theme'         => [
        'success'   => 'Tema alterado com sucesso.',
        'themes'    => [
            'dark'      => 'Escuro',
            'default'   => 'Padrão',
            'future'    => 'Futurista',
            'midnight'  => 'Azul Meia-Noite',
        ],
    ],
    'title'         => 'Atualizar seu perfil',
    'workflows'     => [
        'created'   => 'Ir para entidade recém-criada',
        'default'   => 'Lista de entidades',
    ],
];
