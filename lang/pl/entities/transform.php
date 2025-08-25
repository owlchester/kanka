<?php

return [
    'actions'   => [
        'transform' => 'Przekształć',
    ],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Nieznany lub niewłaściwy rodzaj elementu.',
        ],
        'success'   => '{1} zmieniono rodzaj :count elementu.|[2,*] zmieniono rodzaj :count elementów.',
    ],
    'fields'    => [
        'current'       => 'Obecny moduł',
        'select_one'    => 'Wybierz',
        'target'        => 'Nowy typ elementu',
    ],
    'panel'     => [
        'bulk_description'  => 'Zmień rodzaj wielu elementów na raz. Pamiętaj, możesz utracić część danych ze względu na różnice pól opisu różnych rodzajów elementów.',
        'bulk_title'        => 'Przekształcanie wielu elementów',
        'description'       => 'Czy po stworzeniu elementu przyszło ci do głowy, że lepiej pasowałby do innego typu? Bez obaw, możesz zmienić typ elementu w każdej chwili. Pamiętaj tylko, że możesz stracić część wpisów, ponieważ różne rodzaje elementów mają różne pola.',
        'title'             => 'Przekształć typ elementu',
    ],
    'success'   => 'Przekształcono element :name.',
    'title'     => 'Przekształcanie elementu :name',
];
