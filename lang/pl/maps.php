<?php

return [
    'actions'       => [
        'back'      => 'Powrót do :name',
        'edit'      => 'Edytuj mapę',
        'explore'   => 'Eksploruj',
    ],
    'create'        => [
        'title' => 'Nowa mapa',
    ],
    'destroy'       => [],
    'edit'          => [],
    'errors'        => [
        'chunking'  => [
            'error'     => 'Podczas przetwarzania mapy wystąpił błąd. Skontaktuj się z nami na :discord by uzyskać wsparcie.',
            'running'   => [
                'edit'      => 'Podczas przetwarzania nie można edytować mapy',
                'explore'   => 'Podczas przetwarzania nie można wyświetlić mapy.',
                'time'      => 'Przetwarzanie mapy potrwa od kilku minut do kilku godzin, zależnie od jej wielkości.',
            ],
        ],
        'dashboard' => [
            'missing'   => 'Aby mapa mogła pojawić się na pulpicie, potrzebuje obrazu.',
        ],
        'explore'   => [
            'missing'   => 'Dodaj do tej mapy obraz by móc ją eksplorować.',
        ],
    ],
    'fields'        => [
        'center_marker'     => 'Znacznik',
        'center_x'          => 'Wyjściowa szerokość geograficzna',
        'center_y'          => 'Wyjściowa długość geograficzna',
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
        'chunked_zoom'          => 'Automatycznie grupuje znaczniki położone blisko siebie.',
        'distance_measure'      => 'Wyposażając mapę w miary odległości uruchomisz narzędzie odmierzania dystansu w trybie eksploracji.',
        'distance_measure_2'    => 'Wpisz wartość 0.0041, by 100 pikseli oznaczało 1 kilometr',
        'grid'                  => 'Określ wielkość siatki wyświetlanej w trybie eksploracji',
        'has_clustering'        => 'Automatycznie grupuje znaczniki położone blisko siebie.',
        'initial_zoom'          => 'Powiększenie, w jakim wyświetla się mapa. Domyślna wartość to :default, najwyższa dopuszczalna wartość wynosi :max, a najniższa to :min.',
        'is_real'               => 'Zaznacz tej opcji by używać autentycznych map świata zamiast załączonego obrazu. Jej użycie wyłącza warstwy.',
        'max_zoom'              => 'Większość map można przybliżać. Domyślna wartość przybliżenia to :default, a najwyższa możliwa wynosi :max.',
        'min_zoom'              => 'Większość map można oddalać. Domyślna wartość oddalenia to :default, a najwyższa możliwa wynosi :min.',
        'missing_image'         => 'Zapisz obraz mapy zanim dodasz do niego znaczniki i warstwy.',
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
        'center_marker' => 'Zostaw pusty, by mapa wyświetlała się wyśrodkowana w centrum',
        'center_x'      => 'Pozostaw puste, by mapa wyświetlała się skupiona na środku',
        'center_y'      => 'Pozostaw puste, by mapa wyświetlała się skupiona na środku',
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
        'chunking'  => [
            'running'   => 'Przetwarzamy mapę. To może potrwać od kilku minut do kilku godzin.',
        ],
    ],
];
