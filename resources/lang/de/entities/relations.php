<?php

return [
    'create'        => [
        'success'   => 'Beziehung für :name hinzugefügt.',
        'title'     => 'Beziehung erstellen',
    ],
    'destroy'       => [
        'success'   => 'Beziehung für :name entfernt',
    ],
    'fields'        => [
        'attitude'  => 'Einstellung',
        'is_star'   => 'Fixiert',
        'relation'  => 'Beziehung',
        'target'    => 'Ziel',
        'two_way'   => 'Gespiegelte Beziehung erstellen',
    ],
    'helper'        => 'Richten Sie Beziehungen zwischen Objekten mit Einstellungen und Sichtbarkeit ein. Beziehungen können auch an das Menü der Berechtigung angeheftet werden.',
    'hints'         => [
        'attitude'  => 'In diesem optionalen Feld können Sie die Standardordnungsbeziehungen definieren, sie wird in absteigender Reihenfolge angezeigt.',
        'mirrored'  => [
            'text'  => 'Diese Beziehung ist gespiegelt mit :link.',
            'title' => 'Gespiegelt',
        ],
        'two_way'   => 'Wenn du eine gespiegelte Beziehung erstellst, wird die gleiche Beziehung auch auf dem Ziel erstellt. Wenn du diese später editierst, wird die gespiegelte Beziehung nicht aktualisiert.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 bis 100, 100 ist maximal positiv.',
        'relation'  => 'Art der Beziehung',
        'target'    => 'Wähle ein Objekt',
    ],
    'show'          => [
        'title' => 'Beziehungen für :name',
    ],
    'teaser'        => 'Boosten Sie die Kampagne, um Zugriff auf den Relations Visualizer zu erhalten. Klicken Sie hier, um mehr über geboostete Kampagnen zu erfahren.',
    'types'         => [
        'family_member'         => 'Familienmitglied',
        'organisation_member'   => 'Organisationsmitlgied',
    ],
    'update'        => [
        'success'   => 'Beziehung für :name aktualisiert',
        'title'     => 'Beziehungen aktualisieren',
    ],
];
