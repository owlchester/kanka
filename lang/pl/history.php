<?php

return [
    'actions'   => [
        'show-old'  => 'Zmiany',
    ],
    'cta'       => 'Wyświetla listę ostatnich zmian w kampanii.',
    'empty'     => 'Brak',
    'fields'    => [
        'action'    => 'Działanie',
        'details'   => 'Szczegóły',
        'module'    => 'Moduł',
        'when'      => 'Kiedy',
        'who'       => 'Kto',
    ],
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
        'create'        => ':user stworzył :entity',
        'create_post'   => ':user napisał komentarz ":post" dotyczący :entity',
        'delete'        => ':user usunął :entity',
        'delete_post'   => ':user usunął komentarz dotyczący :entity',
        'reorder_post'  => ':user zmienił kolejność komentarzy dotyczących :entity',
        'restore'       => ':user przywrócił :entity',
        'update'        => ':user zmienił :entity',
        'update_post'   => ':user zmienił komentarz ":post" dotyczący :entity',
        'update_tree'   => ':user zmienił genealogię elementu :entity',
    ],
    'title'     => 'Historia',
    'unknown'   => [
        'entity'    => 'nieznany element',
    ],
];
