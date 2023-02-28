<?php

return [
    'actions'       => [
        'download'  => 'Pobierz PDF',
    ],
    'description'   => 'Wyświetla rachunki z ostatnich 24 miesięcy',
    'empty'         => 'Nie znaleziono rachunków',
    'fields'        => [
        'amount'    => 'Kwota',
        'date'      => 'Data',
        'invoice'   => 'Rachunek',
        'status'    => 'Status',
    ],
    'status'        => [
        'paid'      => 'Opłacony',
        'pending'   => 'Oczekujący',
    ],
    'title'         => 'Historia opłat',
];
