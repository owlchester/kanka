<?php

return [
    'actions'           => [
        'copy_from_entity'  => 'Von einem anderen Objekt kopieren',
        'copy_inventory'    => 'Inventar kopieren',
        'generate'          => 'Generieren',
        'multiple'          => 'Elemente hinzufügen',
    ],
    'copy'              => [
        'helper'    => 'Kopiere das gesamte Inventar eines Objekts nach :name.',
    ],
    'create'            => [
        'helper'        => 'Füge einen Gegenstand zum Inventar von :name hinzu. Er kann optional mit einem vorhandenen Objekt aus der Kampagne verknüpft werden.',
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
        'item_amount'           => 'Anzahl der Artikel',
        'match_all'             => 'Alle Tags abgleichen',
        'name'                  => 'Name',
        'position'              => 'Position',
        'qty'                   => 'ANZ',
        'replace'               => 'Inventar ersetzen',
    ],
    'generate'          => [
        'helper'    => 'Erstelle eine Inventarliste für :name basierend auf den vorhandenen Elementen in der Kampagne.',
        'title'     => 'Inventar generieren',
    ],
    'helpers'           => [
        'amount'                => 'Anzahl der Artikel',
        'copy_entity_entry_v2'  => 'Zeigt den Eintrag des Objekts anstelle der benutzerdefinierten Beschreibung an.',
        'description'           => 'Hinzufügen einer benutzerdefinierten Beschreibung für den Artikel',
        'is_equipped'           => 'Markiere diese Gegenstände als ausgerüstet.',
        'name'                  => 'Gebe dem Objekt einen Namen. Ein Name ist erforderlich, wenn kein Objekt ausgewählt ist.',
        'replace'               => 'Ersetzt das aktuelle Inventar durch deas generierte Inventar.',
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
    'togglers'          => [
        'hide'  => [
            'price'     => 'Preis ausblenden',
            'quantity'  => 'Menge ausblenden',
            'size'      => 'Größe ausblenden',
            'weight'    => 'Gewicht ausblenden',
        ],
        'show'  => [
            'price'     => 'zeige Preis',
            'quantity'  => 'zeige Menge',
            'size'      => 'zeige Größe',
            'weight'    => 'zeige Gewicht',
        ],
    ],
    'tooltips'          => [
        'equipped'  => 'Dieser Artikel ist ausgestattet mit',
    ],
    'tutorials'         => [
        'all'   => 'Verfolge, was :name besitzt, lagert oder anbietet, indem du diesem Inventar Artikel hinzufügst.',
    ],
    'update'            => [
        'success'   => 'Gegenstand \':name\' für :entity aktualisiert',
        'title'     => 'Aktualisiere Gegenstand von :name',
    ],
];
