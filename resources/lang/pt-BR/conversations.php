<?php

return [
    'create'        => [
        'description'   => 'Criar nova conversa',
        'success'       => 'Conversa \':name\' criada',
        'title'         => 'Nova conversa',
    ],
    'destroy'       => [
        'success'   => 'Conversa \':name\' apagada',
    ],
    'edit'          => [
        'description'   => 'Atualizar conversa',
        'success'       => 'Conversa \':name\' atualizada',
        'title'         => 'Conversa :name',
    ],
    'fields'        => [
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
        'add'           => 'Nova conversa',
        'description'   => 'Gerenciar categoria de :name',
        'header'        => 'Conversas em :name',
        'title'         => 'Conversas',
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
        'create'        => [
            'success'   => 'Participante :entity adicionado(a) à conversa',
        ],
        'description'   => 'Adicionar ou remover participantes da conversa',
        'destroy'       => [
            'success'   => 'Participante :entity removido(a) da conversa',
        ],
        'modal'         => 'Participantes',
        'title'         => 'Participantes de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nome da conversa',
        'type'  => 'Dentro do jogo, Pré-mesa, Plot',
    ],
    'show'          => [
        'description'   => 'Uma vista detalhada da conversa',
        'title'         => 'Conversa :name',
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
