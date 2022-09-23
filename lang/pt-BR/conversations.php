<?php

return [
    'create'        => [
        'title' => 'Nova conversa',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Conversa :name',
    ],
    'fields'        => [
        'is_closed'     => 'Fechado',
        'messages'      => 'Mensagens',
        'name'          => 'Nome',
        'participants'  => 'Participantes',
        'target'        => 'Alvo',
        'type'          => 'Tipo',
    ],
    'hints'         => [
        'participants'  => 'Por favor, adicione participantes à sua conversa pressionando o ícone :icon no canto superior direito.',
    ],
    'index'         => [
        'title' => 'Conversas',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Mensagem removida',
        ],
        'is_updated'    => 'Atualizada',
        'load_previous' => 'Carregar mensagens mais antigas',
        'placeholders'  => [
            'message'   => 'Sua mensagem',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Participante :entity adicionado(a) à conversa',
        ],
        'destroy'   => [
            'success'   => 'Participante :entity removido(a) da conversa',
        ],
        'modal'     => 'Participantes',
        'title'     => 'Participantes de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nome da conversa',
        'type'  => 'Dentro do jogo, Pré-mesa, Plot',
    ],
    'show'          => [
        'is_closed' => 'Conversa está fechada.',
    ],
    'tabs'          => [
        'conversation'  => 'Conversa',
        'participants'  => 'Participantes',
    ],
    'targets'       => [
        'characters'    => 'Personagens',
        'members'       => 'Membros',
    ],
];
