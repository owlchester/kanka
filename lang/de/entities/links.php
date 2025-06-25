<?php

return [
    'actions'           => [
        'add'   => 'Link hinzufügen',
    ],
    'call-to-action'    => 'Füge Links zu externen Ressourcen auf diesem Objekt hinzu, wie z. B. zu DnDBeyond, und sie werden direkt in der Übersicht des Objekts angezeigt.',
    'create'            => [
        'helper'    => 'Füge einen externen Link zu :name hinzu, zum Beispiel zu deiner DnDBeyond-Seite.',
        'success'   => 'Link :name hinzugefügt zu :entity.',
        'title'     => 'Fügen Sie einen Link hinzu zu :name',
    ],
    'destroy'           => [
        'success'   => 'Link :name entfernt von :entity.',
    ],
    'fields'            => [
        'icon'      => 'Symbol',
        'name'      => 'Name',
        'position'  => 'Position',
        'url'       => 'URL',
    ],
    'go'                => [
        'actions'       => [
            'confirm'   => 'Ich bin mir sicher',
            'trust'     => 'Frage nicht noch einmal',
        ],
        'description'   => 'Dieser Link führt dich zu :link. Bist du sicher, dass du dorthin gehen möchtest?',
        'title'         => 'verlasse Kanka',
    ],
    'helpers'           => [
        'icon'      => 'Sie können das für den Link angezeigte Symbol anpassen. Verwenden Sie eines der kostenlosen Symbole von :fontawesome oder lassen Sie dieses Feld für die Standardeinstellung leer.',
        'parent'    => 'Zeige diesen Quick-Link nach einem Element der Seitenleiste an, anstatt im Quick-Links-Bereich der Seitenleiste.',
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'Durch geboostete Kampagnen können Links zu Objekten hinzufügen, die auf externe Websites verweisen.',
        'title'     => 'Links für :name',
    ],
    'unboosted'         => [],
    'update'            => [
        'success'   => 'Link :name aktualisiert für :entity.',
        'title'     => 'Link aktualisieren für :name',
    ],
];
