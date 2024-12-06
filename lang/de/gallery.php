<?php

return [
    'actions'   => [
        'gallery'   => 'Aus der Galerie',
        'url'       => 'Hochladen eines Bildes von einer URL',
    ],
    'browse'    => [
        'layouts'       => [
            'large' => 'Große Vorschauen',
            'small' => 'Kleine Vorschauen',
        ],
        'search'        => [
            'placeholder'   => 'Suche nach einem Bild in der Galerie',
        ],
        'title'         => 'Bildergallerie',
        'unauthorized'  => 'Keine deiner Rollen hat die Berechtigung „Galerie durchsuchen“.',
    ],
    'delete'    => [
        'success'   => '[0] Gelöschte 0 Elemente|[1] Gelöschte ein Element|{2,*} Gelöschte :count Elemente',
    ],
    'download'  => [
        'errors'    => [
            'copy_failed'           => 'Unsere Server konnten das angegebene Bild nicht herunterladen.',
            'gallery_full_free'     => 'Der Speicherplatz in der Galerie ist voll. Aktiviere Premium-Funktionen für mehr Speicherplatz.',
            'gallery_full_premium'  => 'Der Speicherplatz in der Galerie ist voll. Entferne zunächst nicht verwendete Dateien.',
            'invalid_format'        => 'Die Datei ist kein gültiges Dateiformat.',
            'too_big'               => 'Diese Datei ist zu groß',
            'unauthorized'          => 'Keine deiner Rollen hat die Berechtigung „In die Galerie hochladen“.',
        ],
    ],
    'file'      => [
        'saved' => 'gesichert',
    ],
    'filters'   => [
        'only_unused'   => 'Nur ungenutzte Dateien anzeigen',
    ],
    'move'      => [
        'success'   => '[0] 0 Elemente verschoben|[1] Ein Element verschoben|{2,*} Bewegte :count Elemente',
    ],
    'update'    => [
        'home'      => 'Ordner Startseite',
        'success'   => '[0] 0 Elemente aktualisiert|[1] Ein Element aktualisiert|{2,*} Aktualisiert :count Elemente',
    ],
];
