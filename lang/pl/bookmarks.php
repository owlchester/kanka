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
        'menu'              => 'Podstrona',
        'position'          => 'Kolejność',
        'random_type'       => 'Losowa kategoria',
        'selector'          => 'Konfiguracja skrótu',
        'target'            => 'Cel',
    ],
    'helpers'           => [
        'active'            => 'Nieaktywne skróty nie pojawią się w menu bocznym',
        'css'               => 'Określa klasę CSS, która zostanie dodana do skrótu umieszczonego w menu bocznym.',
        'dashboard'         => 'Tworzy skrót do własnych pulpitów kampanii.',
        'default_dashboard' => 'Link do pulpitu domyślnego. Pulpity własne należy dopiero wybrać.',
        'entity'            => 'Stwórz skrót do konkrentego elementu. Pole :menu określa, która podstrona się wyświetli.',
        'position'          => 'To pole pozwala ustalać kolejność (rosnącą) wyświetlania skrótów.',
        'random'            => 'To pole tworzy skrót do losowego elementu. Możesz ustawić filtr określający jego kategorię.',
        'selector'          => 'Ustal dokąd skrót przeniesie użytkownika, który na niego kliknie',
        'type'              => 'Stwórz skrót prowadzący do listy elementów. By filtrować rezultaty, skopuj część adresu filtrowanej listy elementów po znaku :? w pole :filter.',
    ],
    'index'             => [],
    'lists'             => [
        'empty' => 'Zapisz skróty do najczęściej używanych elementów albo filtrów, ułatwiające dostęp.',
    ],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Podstrona menu (użyj ostatniego tekstu adresu)',
        'tab'       => '(nieużywane)',
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
    'targets'           => [
        'dashboard' => 'Któryś pulpit kampanii',
        'entity'    => 'Konkretny element',
        'random'    => 'Losowy element',
        'select'    => 'Wybierz opcję',
        'type'      => 'Elementy kategorii',
    ],
    'visibilities'      => [
        'is_active' => 'Pokaż skrót w menu bocznym',
    ],
];
