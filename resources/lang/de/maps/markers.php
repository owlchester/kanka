<?php

return [
    'actions'       => [
        'entry'             => 'Schreibe ein benutzerdefiniertes Eingabefeld für diesen Marker.',
        'remove'            => 'Marker entfernen',
        'save_and_explore'  => 'Speichern und Erkunden',
        'update'            => 'Marker editieren',
    ],
    'create'        => [
        'success'   => 'Marker :name erstellt',
        'title'     => 'neuer Marker',
    ],
    'delete'        => [
        'success'   => 'Marker :name löschen',
    ],
    'edit'          => [
        'success'   => 'Marker :name aktualisiert',
        'title'     => 'Marker :name editieren',
    ],
    'fields'        => [
        'circle_radius' => 'Kreisradius',
        'copy_elements' => 'kopiere Elemente',
        'custom_icon'   => 'Benutzerdefiniertes Symbol',
        'custom_shape'  => 'Benutzerdefinierte Form',
        'font_colour'   => 'Icon Farbe',
        'group'         => 'Markergruppe',
        'is_draggable'  => 'Verschiebbar',
        'latitude'      => 'Breitengrad',
        'longitude'     => 'Längengrad',
        'opacity'       => 'Fügen Sie der Karte Markierungen hinzu, indem Sie auf eine beliebige Stelle klicken.',
        'pin_size'      => 'Pingröße',
        'polygon_style' => [
            'stroke'            => 'Strichfarbe',
            'stroke-opacity'    => 'Strichdeckkraft',
            'stroke-width'      => 'Strichbreite',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Fügen Sie der Karte Markierungen hinzu, indem Sie auf eine beliebige Stelle klicken.',
        'copy_elements'             => 'kopiere Gruppen, Layers, und Marker',
        'copy_elements_to_campaign' => 'Kopiere Gruppen, Ebenen und Markierungen der Karten. Mit einem Objekt verknüpfte Marker werden in einen Standardmarker konvertiert.',
        'custom_icon'               => 'Kopieren Sie den HTML-Code eines Symbols von :fontawesome oder :rpgawesome oder einem benutzerdefinierten SVG-Symbol.',
        'custom_radius'             => 'Wählen Sie die benutzerdefinierte Größenoption aus der Dropdown-Liste aus, um eine Größe zu definieren.',
        'draggable'                 => 'Aktivieren Sie diese Option, um das Verschieben eines Markers im Erkundungsmodus zu ermöglichen.',
        'label'                     => 'Eine Beschriftung wird als Textblock auf der Karte angezeigt. Der Inhalt ist der Markername des Objektnamens.',
        'polygon'                   => [
            'edit'  => 'Klicken Sie auf die Karte, um diese Position zu den Koordinaten des Polygons hinzuzufügen.',
            'new'   => 'Bewegen Sie die Markierung auf der Karte, um die Position im Polygon zu speichern.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Benutzerdefiniert',
        'entity'        => 'Objekt',
        'exclamation'   => 'Ausruf',
        'marker'        => 'Marker',
        'question'      => 'Frage',
    ],
    'placeholders'  => [
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Name des Markers',
    ],
    'shapes'        => [
        '0' => 'Kreis',
        '1' => 'Quadrat',
        '2' => 'Dreieck',
        '3' => 'Benutzerdefiniert',
    ],
    'sizes'         => [
        '0' => 'Sehr klein',
        '1' => 'Standard',
        '2' => 'Klein',
        '3' => 'Groß',
        '4' => 'Enorm',
    ],
    'tabs'          => [
        'circle'    => 'Kreis',
        'label'     => 'Etikette',
        'marker'    => 'Marker',
        'polygon'   => 'Polygon',
    ],
];
