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
    'destroy'       => [
        'success'   => 'Karte :name entfernt',
    ],
    'edit'          => [
        'success'   => 'Karte :name aktualisiert',
        'title'     => 'Karte :name editieren',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'Diese Karte benötigt ein Bild, um im Dashboard gerendert werden zu können.',
        ],
        'explore'   => [
            'missing'   => 'Bitte fügen Sie der Karte ein Bild hinzu, bevor Sie sie erkunden können.',
        ],
    ],
    'fields'        => [
        'center_x'          => 'Standard-Längengradposition',
        'center_y'          => 'Standard-Breitengradposition',
        'distance_measure'  => 'Abstandsmaß',
        'distance_name'     => 'Entfernungseinheit',
        'grid'              => 'Gitter',
        'initial_zoom'      => 'Initial Zoom',
        'map'               => 'Übergeordnete Karte',
        'maps'              => 'Karten',
        'max_zoom'          => 'Maximal Zoom',
        'min_zoom'          => 'Minimal Zoom',
        'name'              => 'Name',
        'type'              => 'Typ',
    ],
    'helpers'       => [
        'center'            => 'Durch Ändern der folgenden Werte wird gesteuert, auf welchen Bereich der Karte der Fokus liegt. Wenn Sie diese Werte leer lassen, wird die Mitte der Karte fokussiert.',
        'descendants'       => 'Diese Liste enthält alle Karten, die Untergeordnete Karten dieser Karte sind, und nicht nur die direkt untergeordneten.',
        'distance_measure'  => 'Wenn Sie der Karte eine Entfernungsmessung geben, wird das Messwerkzeug im Erkundungsmodus aktiviert.',
        'grid'              => 'Definieren Sie eine Rastergröße, die im Erkundungsmodus angezeigt wird.',
        'initial_zoom'      => 'Die anfängliche Zoomstufe, mit der eine Karte geladen wird. Der Standardwert ist :default, während der höchste zulässige Wert :max und der niedrigste zulässige Wert :min ist.',
        'max_zoom'          => 'Eine Karte kann bis zu diesem Wert maximal vergrößert werden. Der Standardwert ist :default, während der höchstzulässige Wert :max ist.',
        'min_zoom'          => 'Eine Karte kann bis zu diesem Wert maximal verkleinert werden. Der Standardwert ist :default, während der höchstzulässige Wert :min ist.',
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
        'groups'    => 'Gruppen',
        'layers'    => 'Ebenen',
        'markers'   => 'Marker',
        'settings'  => 'Einstellungen',
    ],
    'placeholders'  => [
        'center_x'          => 'Lassen Sie das Feld leer, um die Karte in der Mitte zu laden (X-Koordinate)',
        'center_y'          => 'Lassen Sie das Feld leer, um die Karte in der Mitte zu laden (Y-Koordinate)',
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
