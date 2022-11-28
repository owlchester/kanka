<?php

return [
    'actions'       => [
        'entry'             => 'Dodaj opis do tego znacznika.',
        'remove'            => 'Usuń znacznik',
        'reset-polygon'     => 'Resetuj pozycje',
        'save_and_explore'  => 'Zapisz i eksploruj',
        'start-drawing'     => 'Zacznij rysować',
        'update'            => 'Edytuj znacznik',
    ],
    'bulks'         => [
        'delete'    => '{1} Usunięto :count znacznik.|[2,3,4] Usunięto :count znaczniki.|[5,*] Usunięto :count znaczników.',
        'patch'     => '{1} Zmieniono :count znacznik.|[2,3,4] Zmieniono :count znaczniki.|[5,*] Zmieniono :count znaczników.',
    ],
    'create'        => [
        'success'   => 'Stworzono znacznik :name.',
        'title'     => 'Nowy znacznik',
    ],
    'delete'        => [
        'success'   => 'Usunięto znacznik :name.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono znacznik :name.',
        'title'     => 'Edycja znacznika :name',
    ],
    'fields'        => [
        'circle_radius' => 'Promień okręgu',
        'copy_elements' => 'Kopiuj elementy',
        'custom_icon'   => 'Własna ikona',
        'custom_shape'  => 'Własny kształt',
        'font_colour'   => 'Kolor ikony',
        'group'         => 'Kategoria znaczników',
        'icon'          => 'Ikona',
        'is_draggable'  => 'Można przesuwać',
        'latitude'      => 'Szerokość',
        'longitude'     => 'Długość',
        'opacity'       => 'Nieprzejrzystość',
        'pin_size'      => 'Wielkość znacznika',
        'polygon_style' => [
            'stroke'            => 'Kolor konturu',
            'stroke-opacity'    => 'Przejrzystość konturu',
            'stroke-width'      => 'Szerokość konturu',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Dodaj znacznik, klikając w dowolnym miejscu mapy.',
        'copy_elements'             => 'Kopiuj kategorie, warstwy i znaczniki.',
        'copy_elements_to_campaign' => 'Kopiuje kategorie, warstwy i znaczniki na mapach. Znaczniki prowadzące do elementów zostaną zamienione na standardowe.',
        'custom_icon'               => 'Skopiuj HTML ikony z :fontawesome lub :rpgawesome, albo własnej ikony SVG.',
        'custom_radius'             => 'Wybierz opcję z rozwijanej listy by określić wielkość.',
        'draggable'                 => 'Pozwala przeciągać znacznik po mapie w trybie eksploracji.',
        'label'                     => '"Podpis" wyświetla na mapie nazwę tego znacznika albo elementu z którym jest związany.',
        'polygon'                   => [
            'edit'  => 'Kliknij na mapę, by dodać to miejsce do współrzędnych wielokąta.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Własna',
        'entity'        => 'Element',
        'exclamation'   => 'Wykrzyknik',
        'marker'        => 'Znacznik',
        'question'      => 'Pytajnik',
    ],
    'index'         => [
        'title' => 'Znaczniki mapy :name',
    ],
    'pitches'       => [
        'poly'  => 'Rysuj własne wielokąty, reprezentujące granice albo nieregularne obszary.',
    ],
    'placeholders'  => [
        'custom_icon'   => 'Spróbuj :example1 albo :example2',
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Wymagana, jeżeli nie powiązano z żadnym elementem',
    ],
    'shapes'        => [
        '0' => 'Okrąg',
        '1' => 'Kwadrat',
        '2' => 'Trójkąt',
        '3' => 'Własny',
    ],
    'sizes'         => [
        '0' => 'Malutki',
        '1' => 'Standardowy',
        '2' => 'Mały',
        '3' => 'Duży',
        '4' => 'Wielki',
    ],
    'tabs'          => [
        'circle'    => 'Okrąg',
        'label'     => 'Podpis',
        'marker'    => 'Znacznik',
        'polygon'   => 'Wielokąt',
    ],
];
