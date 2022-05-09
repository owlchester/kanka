<?php

return [
    'create'        => [
        'success'   => 'Conversation \':name\' créée.',
        'title'     => 'Nouvelle Conversation',
    ],
    'destroy'       => [
        'success'   => 'Conversation \':name\' supprimée.',
    ],
    'edit'          => [
        'success'   => 'Conversation \':name\' modifiée.',
        'title'     => 'Conversation :name',
    ],
    'fields'        => [
        'is_closed'     => 'Fermée',
        'messages'      => 'Messages',
        'name'          => 'Nom',
        'participants'  => 'Participants',
        'target'        => 'Cible',
        'type'          => 'Type',
    ],
    'hints'         => [
        'participants'  => 'Ajoute des participants à la conversation.',
    ],
    'index'         => [
        'title' => 'Conversations',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Message supprimé.',
        ],
        'is_updated'    => 'Modifié',
        'load_previous' => 'Messages précédents',
        'placeholders'  => [
            'message'   => 'Ton message',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Participant :entity ajouté à la conversation.',
        ],
        'destroy'   => [
            'success'   => 'Participant :entity retiré de la conversation.',
        ],
        'modal'     => 'Participants',
        'title'     => 'Participants de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la conversation',
        'type'  => 'In Game, Préparation, Quête',
    ],
    'show'          => [
        'is_closed' => 'La conversation est fermée.',
    ],
    'tabs'          => [
        'conversation'  => 'Conversation',
        'participants'  => 'Participants',
    ],
    'targets'       => [
        'characters'    => 'Personnages',
        'members'       => 'Membres',
    ],
];
