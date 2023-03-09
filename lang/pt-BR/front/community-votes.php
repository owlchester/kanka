<?php

return [
    'actions'       => [
        'return'    => 'Voltar para todos os votos da comunidade',
        'show'      => 'Exibir resultado das votações',
        'subscribe' => 'Inscreva-se para votar no Kanka',
        'vote'      => 'Votar',
    ],
    'description'   => 'Os usuários que apoiam o Kanka ajudam a moldar a evolução do aplicativo participando de votações frequentes da comunidade.',
    'index'         => [
        'past'      => 'Votos da Comunidade Fechadas',
        'voting'    => 'Votos da Comunidade Ativos',
    ],
    'latest'        => [
        'title' => 'Votações Recentes',
    ],
    'show'          => [
        'restricted'    => 'Votos da Comunidade estão disponíveis apenas para usuários que apoiam o Kanka',
        'title'         => 'Votos da Comunidade - :name',
        'vote_count'    => '{1} :number participantes que votaram.|[2,*] :number votos de participantes.',
        'voted_lasted'  => 'As votações aconteceram de :from GMT até :until GMT.',
        'voting_until'  => 'As votações estão abertas até :until GMT.',
    ],
    'title'         => 'Votos da Comunidade',
];
