<?php

return [
    'create'        => [
        'title' => 'Nouvelle Conversation',
    ],
    'fields'        => [
        'is_closed'     => 'Fermée',
        'messages'      => 'Messages',
        'participants'  => 'Participants',
    ],
    'hints'         => [
        'empty'         => 'Il n\'y a aucun participant dans cette convertation.',
        'participants'  => 'Ajoute des participants à la conversation.',
    ],
    'lists'         => [
        'empty' => 'Enregistre les dialogues, les lettres ou les échanges entre les personnages et les factions.',
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
        'helper'    => 'Ajouter et retirer des participants de :name.',
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
        'participants'  => 'Participants',
    ],
    'targets'       => [
        'characters'    => 'Personnages',
        'members'       => 'Membres',
    ],
];
