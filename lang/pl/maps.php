<?php

return [
    'actions'       => [
        'back'          => 'Powrót do :name',
        'edit'          => 'Edytuj mapę',
        'explore'       => 'Wyświetl',
        'explore_named' => 'Wyświetl :name',
    ],
    'create'        => [
        'title' => 'Nowa mapa',
    ],
    'destroy'       => [],
    'edit'          => [],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'Aby mapa mogła pojawić się na pulpicie, potrzebuje obrazu.',
            'tiling'    => 'Trwa dzielenie według siatki. Wróć później.',
        ],
        'explore'   => [
            'missing'   => 'Dodaj do tej mapy obraz by móc ją wyświetlić.',
        ],
        'tiling'    => [
            'error'     => 'Wystąpił błąd w czasie dzielenia według siatki. By uzyskać wsparcie, skontaktuj się z naszym zespołem na :discord.',
            'running'   => [
                'edit'      => 'Nie można edytować mapy w czasie wprowadzania siatki.',
                'explore'   => 'Nie można wyświetlić mapy w czasie wprowadzania siatki.',
                'time'      => 'Proces zajmie od kilku minut do kilku godzin, zależnie od wielkości mapy.',
            ],
        ],
    ],
    'fields'        => [
        'center_marker'     => 'Znacznik',
        'center_x'          => 'Domyślna szerokość geograficzna',
        'center_y'          => 'Domyślna długość geograficzna',
        'centering'         => 'Wyśrodkowanie',
        'distance_measure'  => 'Miara odległości',
        'distance_name'     => 'Jednostki odległości',
        'grid'              => 'Siatka',
        'has_clustering'    => 'Grupuj znaczniki',
        'initial_zoom'      => 'Wyjściowe powiększenie',
        'is_real'           => 'Użyj OpenStreetMaps',
        'max_zoom'          => 'Maksymalne powiększenie',
        'min_zoom'          => 'Maksymalne oddalenie',
        'tabs'              => [
            'coordinates'   => 'Współrzędne',
            'marker'        => 'Znacznik',
        ],
    ],
    'helpers'       => [
        'center'                => 'Zmiana tych wartości wpłynie na obszar, na którym domyślnie skupia się mapa. Jeżeli zostawisz je puste, mapa skoncentruje się na środku.',
        'centering'             => 'Środkowanie na znaczniku ma pierwszeństwo wobec domyślnych współrzędnych',
        'distance_measure'      => 'Wprowadzając miarę odległości uruchamiasz narzędzie odmierzania dystansów.',
        'distance_measure_2'    => 'By 100 pikseli oznaczało 1 kilometr, wpisz wartość 0.0041.',
        'grid'                  => 'Określ wielkość siatki wyświetlanej w trybie eksploracji. Waetość poniżej 10 spowoduje, że mapa stanie się szara.',
        'has_clustering'        => 'Automatycznie grupuje znaczniki położone blisko siebie.',
        'initial_zoom'          => 'Wyjściowe powiększenie wyświetlanej mapy. Domyślnie wynosi :default, najwyższa dopuszczalna wartość równa się :max, a najniższa to :min.',
        'is_real'               => 'Zaznacz tej opcji by używać autentycznych map świata zamiast załączonego obrazu. Jej użycie wyłącza warstwy.',
        'max_zoom'              => 'Większość map można przybliżać. Domyślna wartość przybliżenia to :default, a najwyższa możliwa wynosi :max.',
        'min_zoom'              => 'Większość map można oddalać. Domyślna wartość oddalenia to :default, a najwyższa możliwa wynosi :min.',
        'missing_image'         => 'Zapisz obraz mapy zanim dodasz do niego znaczniki i warstwy.',
        'tiled_zoom'            => 'Automatycznie grupuje znaczniki położone blisko siebie.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Dodaj mapę przedstawiającą twój świat i wskazująca położenie różnych miejsc.',
    ],
    'maps'          => [],
    'panels'        => [
        'groups'    => 'Kategorie',
        'layers'    => 'Warstwy',
        'legend'    => 'Legenda',
        'markers'   => 'Znaczniki',
        'settings'  => 'Ustawienia',
    ],
    'placeholders'  => [
        'center_marker' => 'Zostaw puste, by wyświetlać środek mapy.',
        'center_x'      => 'Zostaw puste, by wyświetlać środek mapy.',
        'center_y'      => 'Zostaw puste, by wyświetlać środek mapy.',
        'distance_name' => 'Kilometry, mile, stopy, hamburgery',
        'grid'          => 'Odległość w pikselach między elementami siatki. Pozostaw puste, by ukryć siatkę.',
        'name'          => 'Nazwa mapy',
        'type'          => 'Loch, miasto, galaktyka',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Mapy',
        ],
    ],
    'tooltips'      => [
        'tiling'    => [
            'running'   => 'Trwa dzielenie mapy według siatki. Proces może zajać od kilku minut do kilku godzin.',
        ],
    ],
];
