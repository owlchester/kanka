<?php

return [
    'actions'       => [
        'remove'    => 'Remover premium',
        'unlock'    => 'Torne-se premium',
    ],
    'create'        => [
        'actions'   => [
            'confirm'   => 'Torne-se premium!',
        ],
        'confirm'   => 'Que legal! Você está prestes a desbloquear recursos premium para :campaign. Isso usará uma de suas campanhas premium disponíveis.',
        'duration'  => 'As campanhas remium permanecem assim até removê-las manualmente ou quando sua assinatura terminar.',
        'pitch'     => 'Torne-se um assinante para desbloquear campanhas premium.',
        'success'   => 'A campanha :campaign agora é premium. Aproveite todos os novos recursos incríveis!',
    ],
    'exceptions'    => [
        'already'       => 'Os recursos premium já foram desbloqueados para esta campanha.',
        'out-of-stock'  => 'Você não tem campanhas premium suficientes disponíveis para desbloquear esta campanha. Remova o status premium de outra campanha ou :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Seja premium em campanhas e ajude a desbloquear recursos incríveis para todos os envolvidos.',
        'more'          => 'Confira a lista completa de vantagens em nossa página :premium.',
        'title'         => 'Campanhas premium recebem',
    ],
    'ready'         => [
        'available'         => 'Suas campanhas premium disponíveis.',
        'pricing'           => 'Todos os nossos níveis de assinatura incluem pelo menos uma campanha premium e iniciam por :amount por mês.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Torne-se premium',
    ],
    'remove'        => [
        'confirm'   => 'Sim, tenho certeza',
        'success'   => 'Os recursos premium foram removidos da campanha :campaign. Agora você pode desbloquear recursos premium em outra campanha.',
        'title'     => 'Removendo recursos premium',
        'warning'   => 'Tem certeza de que deseja remover os recursos premium de :campaign? Isso permitirá que você desbloqueie outra campanha e oculte todo o conteúdo e recursos relacionados às vantagens até que o status premium da campanha seja reativado.',
    ],
];
