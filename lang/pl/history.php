<?php

return [
    'actions'   => [
        'show-old'  => 'Zmiany',
    ],
    'cta'       => 'Wyświetla listę ostatnich zmian w kampanii.',
    'empty'     => 'Brak',
    'filters'   => [
        'all-actions'   => 'Wszystkie działania',
        'all-users'     => 'Wszyscy uczestnicy',
        'no-results'    => 'Brak rezultatów. Użyj innego filtra albo wprowadź jakieś zmiany w elementach kampanii.',
    ],
    'helpers'   => [
        'base'      => 'Lista zawiera zmiany elementów kampanii przeprowadzone w ciągu :amount miesięcy. Najnowsze wyświetlane są jako pierwsze.',
        'changes'   => 'Poniższe pola miały poprzednio następujące wartości.',
    ],
    'log'       => [
        'create'    => ':user stworzył :entity',
        'delete'    => ':user usunął :entity',
        'restore'   => ':user przywrócił :entity',
        'update'    => ':user zmienił :entity',
    ],
    'title'     => 'Historia',
    'unknown'   => [
        'entity'    => 'nieznany element',
    ],
];
