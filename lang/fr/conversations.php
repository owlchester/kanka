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
        'actions'           => 'Actions du message',
        'confirm_delete'    => 'Supprimer ce message?',
        'copied'            => 'Message copié dans le presse-papiers.',
        'copy_failed'       => 'Impossible de copier le message dans le presse-papiers.',
        'destroy'           => [
            'success'   => 'Message supprimé.',
        ],
        'editing'           => 'Modification du message',
        'empty'             => 'Aucun message pour le moment.',
        'first_message'     => 'Lance la conversation en envoyant un message.',
        'invalid_speaker'   => 'Tu ne peux parler qu’au nom d’un participant autorisé dans cette conversation.',
        'is_updated'        => 'Modifié',
        'keyboard_hint'     => 'Entrée pour envoyer · Maj + Entrée pour aller à la ligne',
        'load_previous'     => 'Messages précédents',
        'loading'           => 'Chargement des messages…',
        'no_speaker'        => 'Aucun participant disponible au nom duquel parler.',
        'placeholders'      => [
            'message'   => 'Ton message',
        ],
        'refresh_failed'    => 'Ton message a été envoyé, mais la conversation n’a pas pu être actualisée.',
        'request_failed'    => 'La requête a échoué. Veuillez réessayer.',
        'retry'             => 'Réessayer',
        'saving'            => 'Enregistrement en cours…',
        'send'              => 'Envoyer',
        'sending'           => 'Envoi en cours…',
        'speaking_as'       => 'Parler en tant que',
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
        'entities'  => 'Entités',
        'members'   => 'Membres',
    ],
];
