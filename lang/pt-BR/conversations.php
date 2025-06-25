<?php

return [
    'create'        => [
        'title' => 'Novo Diálogo',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_closed'     => 'Fechado',
        'messages'      => 'Mensagens',
        'participants'  => 'Participantes',
    ],
    'hints'         => [
        'empty'         => 'Não há participantes nesta conversa.',
        'participants'  => 'Por favor, adicione participantes ao seu diálogo pressionando o ícone :icon no canto superior direito.',
    ],
    'index'         => [],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Mensagem removida',
        ],
        'is_updated'    => 'Atualizado',
        'load_previous' => 'Carregar mensagens anteriores',
        'placeholders'  => [
            'message'   => 'Sua mensagem',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Participante :entity adicionado ao diálogo.',
        ],
        'destroy'   => [
            'success'   => 'Participante :entity removido do diálogo.',
        ],
        'helper'    => 'Adicione e remova participantes de :name.',
        'modal'     => 'Participantes',
        'title'     => 'Participantes de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nome do diálogo',
        'type'  => 'No Jogo, Preparação, Plot',
    ],
    'show'          => [
        'is_closed' => 'Diálogo está fechado.',
    ],
    'tabs'          => [
        'participants'  => 'Participantes',
    ],
    'targets'       => [
        'characters'    => 'Personagens',
        'members'       => 'Membros',
    ],
];
