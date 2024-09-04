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
    'paypal'        => 'Pamiętaj, że w tym miejscu wyświetlane są wyłącznie wpłaty dokonane z pomocą Stripe, nie  PayPal.',
    'status'        => [
        'paid'      => 'Opłacony',
        'pending'   => 'Oczekujący',
    ],
    'title'         => 'Historia opłat',
];
