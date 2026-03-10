<?php

return [
    'actions'       => [
        'back'      => 'zurück zu :name',
        'edit'      => 'Karte editieren',
        'explore'   => 'erkunden',
    ],
    'create'        => [
        'title' => 'neue Karte',
    ],
    'destroy'       => [],
    'edit'          => [],
    'errors'        => [
        'chunking'  => [
            'error'     => 'Beim Aufteilen der Karte ist ein Fehler aufgetreten. Bitte kontaktiere das Team auf :discord für Unterstützung.',
            'running'   => [
                'edit'      => 'Die Karte kann nicht bearbeitet werden, während sie aufgeteilt wird.',
                'explore'   => 'Die Karte kann nicht angezeigt werden, während sie aufgeteilt wird.',
                'time'      => 'Dies kann je nach Größe der Karte einige Minuten bis mehrere Stunden dauern.',
            ],
        ],
        'dashboard' => [
            'missing'   => 'Diese Karte benötigt ein Bild, um im Dashboard gerendert werden zu können.',
        ],
        'explore'   => [
            'missing'   => 'Bitte fügen Sie der Karte ein Bild hinzu, bevor Sie sie erkunden können.',
        ],
    ],
    'fields'        => [
        'center_marker'     => 'Marker',
        'center_x'          => 'Standard-Längengradposition',
        'center_y'          => 'Standard-Breitengradposition',
        'centering'         => 'Zentrierung',
        'distance_measure'  => 'Entfernungsmessung',
        'distance_name'     => 'Etikett für Entfernungseinheit',
        'grid'              => 'Gitter',
        'has_clustering'    => 'Cluster-Marker',
        'initial_zoom'      => 'Initial Zoom',
        'is_real'           => 'Verwenden Sie OpenStreetMaps',
        'max_zoom'          => 'Maximal Zoom',
        'min_zoom'          => 'Minimal Zoom',
        'tabs'              => [
            'coordinates'   => 'Koordinaten',
            'marker'        => 'Marker',
        ],
    ],
    'helpers'       => [
        'center'                => 'Durch Ändern der folgenden Werte wird gesteuert, auf welchen Bereich der Karte der Fokus liegt. Wenn Sie diese Werte leer lassen, wird die Mitte der Karte fokussiert.',
        'centering'             => 'Das Zentrieren auf eine Markierung hat Vorrang vor den Standardkoordinaten.',
        'chunked_zoom'          => 'Gruppiere Markierungen automatisch, wenn sie nahe beieinander liegen.',
        'distance_measure'      => 'Wenn Sie der Karte eine Entfernungsmessung geben, wird das Messwerkzeug im Erkundungsmodus aktiviert.',
        'distance_measure_2'    => 'Damit 100 Pixel 1 Kilometer entsprechen, gib einen Wert von 0,0041 ein.',
        'grid'                  => 'Definieren Sie eine Rastergröße, die im Erkundungsmodus angezeigt wird.',
        'has_clustering'        => 'Gruppiere Markierungen automatisch, wenn sie nahe beieinander liegen.',
        'initial_zoom'          => 'Die anfängliche Zoomstufe, mit der eine Karte geladen wird. Der Standardwert ist :default, während der höchste zulässige Wert :max und der niedrigste zulässige Wert :min ist.',
        'is_real'               => 'Wählen Sie diese Option, wenn Sie anstelle des hochgeladenen Bildes eine echte Weltkarte verwenden möchten. Diese Option deaktiviert Ebenen.',
        'max_zoom'              => 'Eine Karte kann bis zu diesem Wert maximal vergrößert werden. Der Standardwert ist :default, während der höchstzulässige Wert :max ist.',
        'min_zoom'              => 'Eine Karte kann bis zu diesem Wert maximal verkleinert werden. Der Standardwert ist :default, während der höchstzulässige Wert :min ist.',
        'missing_image'         => 'Speichern Sie die Karte mit einem Bild, bevor Sie Ebenen und Markierungen hinzufügen können.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Lade eine Karte hoch, um Orte zu visualisieren und die Geografie deiner Welt darzustellen.',
    ],
    'maps'          => [],
    'panels'        => [
        'groups'    => 'Gruppen',
        'layers'    => 'Ebenen',
        'legend'    => 'Legende',
        'markers'   => 'Marker',
        'settings'  => 'Einstellungen',
    ],
    'placeholders'  => [
        'center_marker' => 'Leer lassen, um die Karte in der Mitte zu laden',
        'center_x'      => 'Lassen Sie das Feld leer, um die Karte in der Mitte zu laden (X-Koordinate)',
        'center_y'      => 'Lassen Sie das Feld leer, um die Karte in der Mitte zu laden (Y-Koordinate)',
        'distance_name' => 'Km, Meilen, Fuß, Hamburger',
        'grid'          => 'Abstand in Pixel zwischen Gitterelementen. Leer lassen, um das Raster auszublenden.',
        'name'          => 'Name der Karte',
        'type'          => 'Dungeon, Stadt, Galaxie',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Karten',
        ],
    ],
    'tooltips'      => [
        'chunking'  => [
            'running'   => 'Die Karte wird aufgeteilt. Dieser Vorgang kann einige Minuten bis Stunden dauern.',
        ],
    ],
];
