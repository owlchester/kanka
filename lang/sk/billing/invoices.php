<?php

return [
    'actions'       => [
        'download'  => 'Stiahnuť PDF',
    ],
    'description'   => 'Zobrazujú sa faktúry za posledných 24 mesiacov.',
    'empty'         => 'Žiadne faktúry neboli nájdené',
    'fields'        => [
        'amount'    => 'Množstvo',
        'date'      => 'Dátum',
        'invoice'   => 'Faktúra',
        'status'    => 'Stav',
    ],
    'paypal'        => 'Prosím, ber na vedomie, že sa tu zobrazujú iba platby uskutočnené cez Stripe, a nie cez PayPal.',
    'status'        => [
        'paid'      => 'Zaplatená',
        'pending'   => 'Očakáva sa platba',
    ],
    'title'         => 'História fakturácie',
];
