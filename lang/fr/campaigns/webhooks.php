<?php

return [
    'actions'       => [
        'action'    => 'Changer le status',
        'add'       => 'Créer un webhook',
        'bulks'     => [
            'delete_success'    => '{1} Supprimé :count webhook.|[2,*] Supprimé :count webhooks.',
            'disable'           => 'Désactiver',
            'disable_success'   => '{1} Desactivé :count webhook.|[2,*] Desactivé :count webhooks.',
            'enable'            => 'Activer',
            'enable_success'    => '{1} Activé :count webhook.|[2,*] Activé :count webhooks.',
        ],
        'test'      => 'Tester le webhook',
        'update'    => 'Modifier le webhook',
    ],
    'create'        => [
        'success'   => 'Webhook créé avec succès',
        'title'     => 'Ajouter un nouveau webhook',
    ],
    'destroy'       => [
        'success'   => 'Webhook supprimé avec succès',
    ],
    'edit'          => [
        'success'   => 'Webhook modifié avec succès',
        'title'     => 'Modifier le webhook',
    ],
    'fields'        => [
        'enabled'           => 'Activé',
        'event'             => 'Événement',
        'events'            => [
            'deleted'   => 'Entité supprimée',
            'edited'    => 'Entité modifiée',
            'new'       => 'Nouvelle entité',
        ],
        'message'           => 'Message',
        'private_entities'  => [
            'helper'    => 'Ne pas déclencher le webhook lors de la mise à jour d\'entités privées.',
            'skip'      => 'Ignorer les entités privées',
        ],
        'type'              => 'Type',
        'types'             => [
            'custom'    => 'Message',
            'payload'   => 'Payload',
        ],
        'url'               => 'URL',
    ],
    'helper'        => [
        'active'    => 'Si le webhook est actuellement activé',
        'message'   => 'Ajouter un message personnalisé avec prise en charge des paramètres',
        'status'    => 'Basculer l\'état actif du webhook',
    ],
    'pitch'         => 'Créer des webhooks personnalisés pour recevoir des mises à jour personnalisées chaque fois qu\'une entité de la campagne est mise à jour.',
    'placeholders'  => [
        'message'   => '{who} a apporté des modifications à {name}, consulter le site {url}',
        'url'       => 'URL du webhook cible',
    ],
    'test'          => [
        'success'   => 'Test envoyé',
    ],
    'title'         => 'Webhooks',
];
