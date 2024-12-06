<?php

return [
    'actions'       => [
        'download'  => 'Scarica PDF',
    ],
    'description'   => 'Mostra le fatture degli ultimi 24 mesi.',
    'empty'         => 'Nessuna fattura trovata',
    'fields'        => [
        'amount'    => 'Importo',
        'date'      => 'Data',
        'invoice'   => 'Fattura',
        'status'    => 'Stato',
    ],
    'paypal'        => 'Si noti che qui sono visibili solo i pagamenti effettuati tramite Stripe e non PayPal.',
    'status'        => [
        'paid'      => 'Pagato',
        'pending'   => 'In attesa',
    ],
    'title'         => 'Storico della fatturazione',
];
