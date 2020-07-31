<?php

return [
    'actions'       => [
        'back'      => 'zurück zu :name',
        'edit'      => 'Karte editieren',
        'explore'   => 'erkunden',
    ],
    'create'        => [
        'success'   => 'Karte :name erstellt',
        'title'     => 'neue Karte',
    ],
    'edit'          => [
        'success'   => 'Karte :name aktualisiert',
        'title'     => 'Karte :name editieren',
    ],
    'fields'        => [
        'distance_measure'  => 'Abstandsmaß',
        'distance_name'     => 'Entfernungseinheit',
        'grid'              => 'Gitter',
        'map'               => 'Übergeordnete Karte',
        'maps'              => 'Karten',
        'name'              => 'Name',
        'type'              => 'Typ',
    ],
    'helpers'       => [
        'descendants'       => 'Diese Liste enthält alle Karten, die Untergeordnete Karten dieser Karte sind, und nicht nur die direkt untergeordneten.',
        'distance_measure'  => 'Wenn Sie der Karte eine Entfernungsmessung geben, wird das Messwerkzeug im Erkundungsmodus aktiviert.',
        'grid'              => 'Definieren Sie eine Rastergröße, die im Erkundungsmodus angezeigt wird.',
        'missing_image'     => 'Speichern Sie die Karte mit einem Bild, bevor Sie Ebenen und Markierungen hinzufügen können.',
        'nested'            => 'In der verschachtelten Ansicht können Sie Ihre Karten verschachtelt anzeigen. Karten ohne übergeordnete Karte werden standardmäßig angezeigt. Karten mit untergeordneten Tags können angeklickt werden, um diese untergeordneten Elemente anzuzeigen. Sie können so lange klicken, bis keine untergeordneten Elemente mehr angezeigt werden.',
    ],
    'index'         => [
        'add'   => 'neue Karte',
        'title' => 'Karten',
    ],
    'maps'          => [
        'title' => 'Karte von :name',
    ],
    'panels'        => [
        'layers'    => 'Ebenen',
        'markers'   => 'Marker',
        'settings'  => 'Einstellungen',
    ],
    'placeholders'  => [
        'distance_measure'  => 'Einheiten pro Pixel',
        'distance_name'     => 'Name der Entfernungseinheit (Kilometer, Meile)',
        'grid'              => 'Abstand in Pixel zwischen Gitterelementen. Leer lassen, um das Raster auszublenden.',
        'name'              => 'Name der Karte',
        'type'              => 'Dungeon, Stadt, Galaxie',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Karten',
        ],
        'title' => 'Karte :name',
    ],
];
