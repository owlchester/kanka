<?php

return [
    'actions'       => [
        'download'  => 'Download PDF',
    ],
    'description'   => 'Rechnungen der letzten 24 Monate anzeigen.',
    'empty'         => 'Keine Rechnungen gefunden',
    'fields'        => [
        'amount'    => 'Menge',
        'date'      => 'Datum',
        'invoice'   => 'Rechnung',
        'status'    => 'Status',
    ],
    'paypal'        => 'Bitte beachte , dass nur Zahlungen, die über Stripe und nicht über PayPal getätigt wurden, hier sichtbar sind.',
    'status'        => [
        'paid'      => 'bezahlt',
        'pending'   => 'Ausstehend',
    ],
    'title'         => 'Rechnungsverlauf',
];
