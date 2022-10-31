<?php

return [
    'create'        => [
        'title' => 'Nouvelle Conversation',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Conversation :name',
    ],
    'fields'        => [
        'is_closed'     => 'Fermée',
        'messages'      => 'Messages',
        'participants'  => 'Participants',
        'target'        => 'Cible',
    ],
    'hints'         => [
        'participants'  => 'Ajoute des participants à la conversation.',
    ],
    'index'         => [],
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
