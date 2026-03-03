<?php

return [
    'actions'       => [
        'entry'             => 'Schreibe ein benutzerdefiniertes Eingabefeld für diesen Marker.',
        'remove'            => 'Marker entfernen',
        'reset-polygon'     => 'Position zurücksetzen',
        'save_and_explore'  => 'Speichern und Erkunden',
        'start-drawing'     => 'Zeichnen starten',
        'update'            => 'Marker editieren',
    ],
    'bulks'         => [
        'delete'    => '{1} entferne :count marker.|[2,*] entferne :count markers.',
        'patch'     => '{1} aktualisiere :count marker.|[2,*] aktualisiere :count markers.',
    ],
    'circle_sizes'  => [
        'custom'    => 'benutzerdefiniert',
        'huge'      => 'riesig',
        'large'     => 'groß',
        'small'     => 'klein',
        'standard'  => 'standard',
        'tiny'      => 'winzig',
    ],
    'create'        => [
        'success'   => 'Marker :name erstellt',
        'title'     => 'neuer Marker',
    ],
    'delete'        => [
        'success'   => 'Marker :name löschen',
    ],
    'details'       => [
        'from-entity'   => 'Vom Objekt',
    ],
    'edit'          => [
        'success'   => 'Marker :name aktualisiert',
        'title'     => 'Marker :name editieren',
    ],
    'fields'        => [
        'bg_colour'     => 'Hintergrundfarbe',
        'circle_radius' => 'Kreisradius',
        'copy_elements' => 'kopiere Elemente',
        'custom_icon'   => 'Benutzerdefiniertes Symbol',
        'custom_shape'  => 'Benutzerdefinierte Form',
        'font_colour'   => 'Icon Farbe',
        'group'         => 'Markergruppe',
        'icon'          => 'Icon',
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
        'popupless'     => 'Tooltip-Popup',
        'size'          => 'Größe',
    ],
    'helpers'       => [
        'base'                      => 'Fügen Sie der Karte Markierungen hinzu, indem Sie auf eine beliebige Stelle klicken.',
        'copy_elements'             => 'kopiere Gruppen, Layers, und Marker',
        'copy_elements_to_campaign' => 'Kopiere Gruppen, Ebenen und Markierungen der Karten. Mit einem Objekt verknüpfte Marker werden in einen Standardmarker konvertiert.',
        'css'                       => 'Definiere eine benutzerdefinierte CSS-Klasse, die der Markierung hinzugefügt wird.',
        'custom_icon_v2'            => 'Verwende Symbole von :fontawesome, :rpgawesome oder ein benutzerdefiniertes SVG-Symbol. Wie das geht, erfährst du in den :docs.',
        'custom_radius'             => 'Wählen Sie die benutzerdefinierte Größenoption aus der Dropdown-Liste aus, um eine Größe zu definieren.',
        'draggable'                 => 'Aktivieren Sie diese Option, um das Verschieben eines Markers im Erkundungsmodus zu ermöglichen.',
        'is_popupless'              => 'Deaktiviere die Anzeige des Tooltips der Markierung, wenn du mit der Maus darüber fährst.',
        'label'                     => 'Eine Beschriftung wird als Textblock auf der Karte angezeigt. Der Inhalt ist der Markername des Objektnamens.',
        'polygon'                   => [
            'edit'  => 'Klicken Sie auf die Karte, um diese Position zu den Koordinaten des Polygons hinzuzufügen.',
        ],
    ],
    'hints'         => [
        'entry' => 'Bearbeite die Markierung, um einen benutzerdefinierten Eintrag dafür zu schreiben.',
    ],
    'icons'         => [
        'custom'        => 'Benutzerdefiniert',
        'entity'        => 'Objekt',
        'exclamation'   => 'Ausruf',
        'marker'        => 'Marker',
        'question'      => 'Frage',
    ],
    'index'         => [
        'title' => 'Marker von :name',
    ],
    'pitches'       => [
        'poly'  => 'Zeichne benutzerdefinierte Polyong-Formen, um Ränder und andere ungleichmäßige Formen darzustellen.',
    ],
    'placeholders'  => [
        'custom_icon'   => 'versuchen sie :example1 or :example2',
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Name des Markers',
    ],
    'presets'       => [
        'helper'    => 'Klicke auf eine Voreinstellung, um sie zu laden, oder erstelle eine neue.',
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
        'preset'    => 'Vorlage',
    ],
];
