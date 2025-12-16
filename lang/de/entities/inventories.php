<?php

return [
    'actions'           => [
        'copy_inventory'    => 'Inventar kopieren',
    ],
    'copy'              => [],
    'create'            => [
        'success'       => 'Gegenstand :item zu :entity hinzugefügt',
        'success_bulk'  => '{0} Kein Element zu :entity.|{1} hinzugefügt Element :count wurde zu :entity.|[2,*] hinzugefügt Elemente :count wurden zu :entity.',
        'title'         => 'Füge einen Gegenstand zu :name hinzu',
    ],
    'default_position'  => 'Unorganisiert',
    'destroy'           => [
        'success'           => 'Gegenstand :item wurde von :entity entfernt',
        'success_position'  => 'Elemente in :position werden aus :entity entfernt.',
    ],
    'fields'            => [
        'amount'                => 'Menge',
        'copy_entity_entry_v2'  => 'Objekteintrag verwenden',
        'description'           => 'Beschreibung',
        'is_equipped'           => 'Ausgestattet',
        'name'                  => 'Name',
        'position'              => 'Position',
        'qty'                   => 'ANZ',
    ],
    'helpers'           => [
        'amount'                => 'Anzahl der Artikel',
        'copy_entity_entry_v2'  => 'Zeigt den Eintrag des Objekts anstelle der benutzerdefinierten Beschreibung an.',
        'description'           => 'Hinzufügen einer benutzerdefinierten Beschreibung für den Artikel',
        'is_equipped'           => 'Markiere diese Gegenstände als ausgerüstet.',
        'name'                  => 'Gebe dem Objekt einen Namen. Ein Name ist erforderlich, wenn kein Objekt ausgewählt ist.',
    ],
    'placeholders'      => [
        'amount'        => 'Die Menge',
        'description'   => 'Benutzt, Beschädigt, usw.',
        'name'          => 'Erforderlich, wenn kein Element ausgewählt ist',
        'position'      => 'Ausgerüstet, Rucksack, Lager, Bank',
    ],
    'show'              => [
        'helper'    => 'Objekten können Gegenstände zugeordnet werden um ein Inventar zu generieren.',
        'title'     => 'Objekt :name: Inventar',
        'unsorted'  => 'Unsortiert',
    ],
    'tooltips'          => [
        'equipped'  => 'Dieser Artikel ist ausgestattet mit',
    ],
    'tutorials'         => [],
    'update'            => [
        'success'   => 'Gegenstand \':name\' für :entity aktualisiert',
        'title'     => 'Aktualisiere Gegenstand von :name',
    ],
];
