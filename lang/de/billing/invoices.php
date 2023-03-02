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
    'status'        => [
        'paid'      => 'bezahlt',
        'pending'   => 'Ausstehend',
    ],
    'title'         => 'Rechnungsverlauf',
];
