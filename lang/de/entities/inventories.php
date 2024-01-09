<?php

return [
    'actions'       => [
        'add'   => 'Gegenstand hinzufügen',
    ],
    'create'        => [
        'success'   => 'Gegenstand :item zu :entity hinzugefügt',
        'title'     => 'Füge einen Gegenstand zu :name hinzu',
    ],
    'destroy'       => [
        'success'   => 'Gegenstand :item wurde von :entity entfernt',
    ],
    'fields'        => [
        'amount'            => 'Menge',
        'copy_entity_entry' => 'Benutze Gegenstand Eintrag',
        'description'       => 'Beschreibung',
        'is_equipped'       => 'Ausgestattet',
        'name'              => 'Name',
        'position'          => 'Position',
        'qty'               => 'ANZ',
    ],
    'helpers'       => [
        'copy_entity_entry' => 'Zeige den Eintrag des Objekts statt der benutzerdefinierten Beschreibung an.',
        'is_equipped'       => 'Markiere diese Gegenstände als ausgerüstet.',
    ],
    'placeholders'  => [
        'amount'        => 'Die Menge',
        'description'   => 'Benutzt, Beschädigt, usw.',
        'name'          => 'Erforderlich, wenn kein Element ausgewählt ist',
        'position'      => 'Ausgerüstet, Rucksack, Lager, Bank',
    ],
    'show'          => [
        'helper'    => 'Objekten können Gegenstände zugeordnet werden um ein Inventar zu generieren.',
        'title'     => 'Objekt :name: Inventar',
        'unsorted'  => 'Unsortiert',
    ],
    'tutorial'      => 'Verfolge, wie sich ein Objekt entwickelt, indem du Artikel zu seinem Inventar hinzufügst.',
    'update'        => [
        'success'   => 'Gegenstand \':name\' für :entity aktualisiert',
        'title'     => 'Aktualisiere Gegenstand von :name',
    ],
];
