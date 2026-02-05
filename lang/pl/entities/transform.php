<?php

return [
    'actions'       => [
        'convert'   => 'Zmień moduł',
    ],
    'bulk'          => [
        'errors'    => [
            'unknown_type'  => 'Nieznany lub niewłaściwy rodzaj elementu.',
        ],
        'success'   => '{1} zmieniono rodzaj :count elementu.|[2,*] zmieniono rodzaj :count elementów.',
    ],
    'confirm'       => [
        'checkbox'  => 'Rozumiem, że po przekształceniu :entity w element innego moduły stracę następujące dane:',
        'label'     => 'Potwierdzenie utraty danych',
    ],
    'documentation' => 'Dokumentacja: zmiana modułu elementu',
    'fields'        => [
        'current'       => 'Obecny moduł',
        'select_one'    => 'Wybierz',
        'target'        => 'Nowy typ elementu',
    ],
    'panel'         => [
        'bulk_description'  => 'Zmień rodzaj wielu elementów na raz. Pamiętaj, możesz utracić część danych ze względu na różnice pól opisu różnych rodzajów elementów.',
        'bulk_title'        => 'Przekształcanie wielu elementów',
        'title'             => 'Przekształć typ elementu',
        'warning'           => 'Możesz utracić niektóre dane, jeżeli nowy moduł używa innych pól opisu.',
    ],
    'success'       => 'Przekształcono element :name.',
    'title'         => 'Przekształcanie elementu :name',
];
