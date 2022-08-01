<?php

return [
    'actions'       => [
        'add'   => 'neue Ebene hinzufügen',
    ],
    'base'          => 'Basisebene',
    'create'        => [
        'success'   => 'Ebene :name erstellen',
        'title'     => 'neue Ebene',
    ],
    'delete'        => [
        'success'   => 'Ebene :name löschen',
    ],
    'edit'          => [
        'success'   => 'Ebene :name aktualisieren',
        'title'     => 'Ebene :name editieren',
    ],
    'fields'        => [
        'position'  => 'Position',
        'type'      => 'Ebenentyp',
    ],
    'helper'        => [
        'amount_v2' => 'Lade Ebenen auf eine Karte hoch, um das unter den Markierungen angezeigte Hintergrundbild zu wechseln.',
        'is_real'   => 'Ebenen sind bei Verwendung von OpenStreetMaps nicht verfügbar.',
    ],
    'pitch'         => [
        'error' => 'Maximale Anzahl an Ebenen erreicht.',
        'until' => 'Lade bis zu :max-Layer auf jede Karte hoch.',
    ],
    'placeholders'  => [
        'name'      => 'Untergrund, Ebene 2, Schiffbruch',
        'position'  => 'Optionales Feld zum Festlegen der Reihenfolge, in der die Ebenen angezeigt werden.',
    ],
    'short_types'   => [
        'overlay'       => 'Überlagerung',
        'overlay_shown' => 'Überlagerung (automatisch gezeigt)',
        'standard'      => 'Standard',
    ],
    'types'         => [
        'overlay'       => 'Überlagerung (über der aktiven Ebene angezeigt)',
        'overlay_shown' => 'Standardmäßig wird die Überlagerung angezeigt',
        'standard'      => 'Standardebene (zwischen Ebenen wechseln)',
    ],
];
