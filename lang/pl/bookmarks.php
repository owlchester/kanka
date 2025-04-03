<?php

return [
    'actions'           => [
        'customise' => 'Dostosuj menu boczne',
    ],
    'create'            => [
        'title' => 'Nowy skrót',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Skrót :name',
    ],
    'fields'            => [
        'active'            => 'Aktywne',
        'dashboard'         => 'Pulpit',
        'default_dashboard' => 'Pulpit domyślny',
        'filters'           => 'Filtry',
        'menu'              => 'Menu',
        'position'          => 'Kolejność',
        'random_type'       => 'Losowy typ elementu',
        'selector'          => 'Konfiguracja skrótu',
        'target'            => 'Cel',
    ],
    'helpers'           => [
        'active'            => 'Nieaktywne skróty nie pojawią się w menu bocznym',
        'dashboard'         => 'Skrót prowadzący do jednego z własnych pulpitów kampanii. Ta opcja dostępna jest tylko w :boosted kampanii.',
        'default_dashboard' => 'Odnośnik prowadzi do pulpitu domyślnego. Pulpity własne należy dopiero wybrać.',
        'entity'            => 'Stwórz skrót prowadzący wprost do jakiegoś elementu. Pole :tab pozwala decydować, która zakładka się wyświetli. Pole :menu pozwala określić, która podstrona zostanie otwarta.',
        'position'          => 'To pole pozwala ustalać kolejność (rosnącą) wyświetlania skrótów.',
        'random'            => 'Użyj tego pola by stworzyć skrót do losowego elementu. Możesz ustawić filtry, by skrót prowadził do losowego elementu danego typu.',
        'selector'          => 'Ustal dokąd skrót przeniesie użytkownika, który na niego kliknie',
        'type'              => 'Stwórz skrót prowadzący do listy elementów. By filtrować rezultaty, skopuj część adresu filtrowanej listy elementów po znaku :? w pole :filter.',
    ],
    'index'             => [],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Podstrona menu (użyj ostatniego tekstu adresu)',
        'tab'       => 'opis, relacje, notki',
    ],
    'random_no_entity'  => 'Nie znaleziono losowego elementu.',
    'random_types'      => [
        'any'   => 'Dowolny element',
    ],
    'reorder'           => [
        'success'   => 'Zmieniono kolejność skrótów.',
        'title'     => 'Zmiana kolejności skrótów',
    ],
    'show'              => [],
    'visibilities'      => [
        'is_active' => 'Pokaż skróty w menu bocznym',
    ],
];
