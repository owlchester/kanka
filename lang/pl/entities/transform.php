<?php

return [
    'actions'       => [
        'convert'   => 'Zmień kategorię',
    ],
    'bulk'          => [
        'errors'    => [
            'unknown_type'  => 'Nieznana lub niewłaściwa kategoria.',
        ],
        'success'   => '{1} zmieniono kategorię :count elementu.|[2,*] zmieniono kategorię :count elementów.',
    ],
    'confirm'       => [
        'checkbox'  => 'Rozumiem, że po zmianie kategorii elementu :entity stracę następujące dane:',
        'label'     => 'Potwierdzenie utraty danych',
    ],
    'documentation' => 'Dokumentacja: zmiana kategorii elementu',
    'fields'        => [
        'current'       => 'Obecna kategoria',
        'select_one'    => 'Wybierz nową kategorię',
        'target'        => 'Nowa kategoria',
    ],
    'panel'         => [
        'bulk_description'  => 'Zmień kategorię wielu elementów na raz. Pamiętaj, możesz utracić część danych ze względu na różnice pól opisu różnych kategorii.',
        'bulk_title'        => 'Zmiana kategorii wielu elementów',
        'title'             => 'Możesz zmienić kategorię tego elementu.',
        'warning'           => 'Możesz utracić niektóre dane, jeżeli nowa kategoria używa innych pól opisu.',
    ],
    'success'       => 'Zmieniono kategorię :name.',
    'title'         => 'Zmiana kategorii elementu :name',
];
