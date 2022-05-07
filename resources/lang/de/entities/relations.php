<?php

return [
    'actions'       => [
        'mode-map'      => 'Tool zur Beziehungsdarstellung',
        'mode-table'    => 'Tabelle der Beziehungen und Verbindungen',
    ],
    'bulk'          => [
        'delete'    => '{1} :count Beziehung gelöscht.|[2,*] :count Beziehungen gelöscht.',
        'success'   => [
            'editing'           => '{1} :count Beziehung wurde aktualisiert.|[2,*] :count Beziehungen wurden aktualisiert.',
            'editing_partial'   => '{1} :count/:total Beziehung wurde aktualisiert.|[2,*] :count/:total Beziehungen wurden aktualisiert.',
        ],
    ],
    'connections'   => [
        'map_point'         => 'Kartenpunkt',
        'mention'           => 'Erwähnung',
        'quest_element'     => 'Quest Elemente',
        'timeline_element'  => 'Zeitstrahlelement',
    ],
    'create'        => [
        'new_title' => 'Neue Beziehungen',
        'success'   => 'Beziehung für :name hinzugefügt.',
        'title'     => 'Beziehung erstellen',
    ],
    'destroy'       => [
        'success'   => 'Beziehung für :name entfernt',
    ],
    'fields'        => [
        'attitude'          => 'Einstellung',
        'connection'        => 'Verbindungen',
        'is_star'           => 'Fixiert',
        'owner'             => 'Quelle',
        'relation'          => 'Beziehung',
        'target'            => 'Ziel',
        'target_relation'   => 'Zielbeziehung',
        'two_way'           => 'Gespiegelte Beziehung erstellen',
    ],
    'helper'        => 'Richten Sie Beziehungen zwischen Objekten mit Einstellungen und Sichtbarkeit ein. Beziehungen können auch an das Menü der Berechtigung angeheftet werden.',
    'helpers'       => [
        'no_relations'  => 'Dieses Objekt hat derzeit keine Beziehungen zu anderen Objekten der Kampagne.',
        'popup'         => 'Objekte der Kampagne können über Beziehungen miteinander verknüpft werden. Diese können eine Beschreibung, eine Einstellungsbewertung, eine Sichtbarkeit haben, um zu steuern, wer eine Beziehung sieht, und mehr.',
    ],
    'hints'         => [
        'attitude'          => 'In diesem optionalen Feld können Sie die Standardordnungsbeziehungen definieren, sie wird in absteigender Reihenfolge angezeigt.',
        'mirrored'          => [
            'text'  => 'Diese Beziehung ist gespiegelt mit :link.',
            'title' => 'Gespiegelt',
        ],
        'target_relation'   => 'Die Beziehungsbeschreibung des Ziels. Lassen Sie das Feld leer, um den Text dieser Beziehung zu verwenden.',
        'two_way'           => 'Wenn du eine gespiegelte Beziehung erstellst, wird die gleiche Beziehung auch auf dem Ziel erstellt. Wenn du diese später editierst, wird die gespiegelte Beziehung nicht aktualisiert.',
    ],
    'index'         => [
        'title' => 'Beziehungen',
    ],
    'options'       => [
        'mentions'  => 'Beziehungen + verbundene + erwähnt',
        'related'   => 'Beziehungen + verbundene',
        'relations' => 'Beziehungen',
        'show'      => 'zeige',
    ],
    'panels'        => [
        'related'   => 'verbunden',
    ],
    'placeholders'  => [
        'attitude'  => '-100 bis 100, 100 ist maximal positiv.',
        'relation'  => 'Art der Beziehung',
        'target'    => 'Wähle ein Objekt',
    ],
    'show'          => [
        'title' => 'Beziehungen für :name',
    ],
    'teaser'        => 'Boosten Sie die Kampagne, um Zugriff auf den Relations Visualizer zu erhalten. Klicken Sie hier, um mehr über Boost Kampagnen zu erfahren.',
    'types'         => [
        'family_member'         => 'Familienmitglied',
        'organisation_member'   => 'Organisationsmitlgied',
    ],
    'update'        => [
        'success'   => 'Beziehung für :name aktualisiert',
        'title'     => 'Beziehungen aktualisieren',
    ],
];
