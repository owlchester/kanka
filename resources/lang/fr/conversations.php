<?php

return [
    'create'        => [
        'description'   => 'Créer une nouvelle conversation',
        'success'       => 'Conversation \':name\' créée.',
        'title'         => 'Nouvelle Conversation',
    ],
    'destroy'       => [
        'success'   => 'Conversation \':name\' supprimée.',
    ],
    'edit'          => [
        'description'   => 'Modifier la conversation',
        'success'       => 'Conversation \':name\' modifiée.',
        'title'         => 'Conversation :name',
    ],
    'fields'        => [
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
        'add'           => 'Nouvelle Conversation',
        'description'   => 'Gérer les conversations de :name.',
        'header'        => 'Conversations dans :name',
        'title'         => 'Conversations',
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
        'create'        => [
            'success'   => 'Participant :entity ajouté à la conversation.',
        ],
        'description'   => 'Ajouter ou retirer des participants à une conversation',
        'destroy'       => [
            'success'   => 'Participant :entity retiré de la conversation.',
        ],
        'modal'         => 'Participants',
        'title'         => 'Participants de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nom de la conversation',
        'type'  => 'In Game, Préparation, Quête',
    ],
    'show'          => [
        'description'   => 'Vue détaillée d\'une conversation',
        'title'         => 'Conversation :name',
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
