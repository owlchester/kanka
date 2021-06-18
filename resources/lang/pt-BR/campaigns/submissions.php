<?php

return [
    'actions'       => [
        'accept'    => 'Aceitar',
        'reject'    => 'Rejeitar',
    ],
    'apply'         => [
        'apply'         => 'Aplicar',
        'help'          => 'Essa campanha é aberta a novos membros. Inscreva-se para participar preenchendo o formulário. Você será notificado quando os administradores da campanha revisarem sua solicitação.',
        'remove_text'   => 'sua submissão',
        'success'       => [
            'apply' => 'Sua solicitação foi salva. Você ainda pode alterá-la ou cancelá-la a qualquer momento. Você será notificado quando os adms da campanha revisarem o pedido.',
            'remove'=> 'Sua aplicação foi removida.',
            'update'=> 'Sua solicitação foi atualizada. Você ainda pode alterá-la ou cancelá-la a qualquer momento. Você será notificado quando os admins da campanha revisarem o pedido.',
        ],
        'title'         => 'Inscreva-se :name',
    ],
    'errors'        => [
        'not_open'  => 'A campanha não é aberta a novos membros. Edita as configurações da campanha se você quiser permitir usuários de enviar solicitações para entrar nela.',
    ],
    'fields'        => [
        'application'   => 'Solicitação',
        'rejection'     => 'Razão da rejeição',
    ],
    'helpers'       => [
        'open_and_public'   => 'A campanha está aceitando solicitações para se inscrever nela. Para parar isso, edite a campanha e mude a configuração Aberto sobre a tab :tab.',
    ],
    'placeholders'  => [
        'note'  => 'Escreva a sua solicitação para se inscrever na campanha.',
    ],
    'title'         => 'Solicitações da Campanha',
    'update'        => [
        'approve'   => 'Selecione a função do usuário que será adicionado em sua campanha.',
        'approved'  => 'Solicitação aprovada.',
        'reject'    => 'Escreva uma mensagem opcional para os usuários explicando por que você está rejeitando sua solicitação.',
        'rejected'  => 'Solicitação rejeitada.',
    ],
];
