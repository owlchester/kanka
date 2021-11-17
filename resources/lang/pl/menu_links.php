<?php

return [
    'create'            => [
        'success'   => 'Stworzono skrót \':name\'.',
        'title'     => 'Nowy skrót',
    ],
    'destroy'           => [
        'success'   => 'Usunięto skrót menu \':name\'.',
    ],
    'edit'              => [
        'success'   => 'Zmieniono skrót \':name\'.',
        'title'     => 'Skrót :name',
    ],
    'fields'            => [
        'dashboard'     => 'Pulpit',
        'entity'        => 'Element',
        'filters'       => 'Filtry',
        'is_nested'     => 'Hierarchia',
        'menu'          => 'Menu',
        'name'          => 'Nazwa',
        'position'      => 'Kolejność',
        'random'        => 'Losowy',
        'random_type'   => 'Losowy typ elementu',
        'selector'      => 'Konfiguracja skrótu',
        'tab'           => 'Zakładka',
        'type'          => 'Typ elementu',
    ],
    'helpers'           => [
        'dashboard' => 'Skrót prowadzący do jednego z własnych pulpitów kampanii. Ta opcja dostępna jest tylko w :boosted kampanii.',
        'entity'    => 'Stwórz skrót prowadzący wprost do jakiegoś elementu. Pole :tab pozwala decydować, która zakładka się wyświetli. Pole :menu pozwala określić, która podstrona zostanie otwarta.',
        'position'  => 'To pole pozwala ustalać kolejność (rosnącą) wyświetlania skrótów.',
        'random'    => 'Użyj tego pola by stworzyć skrót do losowego elementu. Możesz ustawić filtry, by skrót prowadził do losowego elementu danego typu.',
        'selector'  => 'Ustal dokąd skrót przeniesie użytkownika, który na niego kliknie',
        'type'      => 'Stwórz skrót prowadzący do listy elementów. By filtrować rezultaty, skopuj część adresu filtrowanej listy elementów po znaku :? w pole :filter.',
    ],
    'index'             => [
        'add'   => 'Nowy skrót',
        'title' => 'Skróty',
    ],
    'placeholders'      => [
        'entity'    => 'Wybierz element',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Podstrona menu (użyj ostatniego tekstu adresu)',
        'name'      => 'Nazwa skrótu',
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
    'show'              => [
        'tabs'  => [
            'information'   => 'Informacje',
        ],
        'title' => 'Skrót :name',
    ],
];
