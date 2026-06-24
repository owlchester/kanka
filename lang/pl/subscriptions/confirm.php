<?php

return [
    'actions'   => [
        'pay'       => 'Zapłać teraz :amount :currency',
        'subscribe' => 'Subskrybujesz za :currency:amount',
    ],
    'helpers'   => [
        'auto-renew'    => [
            'monthly'   => 'Subskrybcja odnawia się automatycznie co miesiąc. Opłatę pobierzemy w dniu :date.',
            'yearly'    => 'Subskrypcja odnawia się automatycznie co 12 miesięcy. Opłatę pobierzemy w dniu :date.',
        ],
        'refund'        => 'Oferujemy 14-dniowy okres rezygnacji z każdej subskrypcji rocznej. Nie musisz się tłumaczyć, wystarczy napisać maila na adres :email, by wszcząć procedurę zwrotu kosztów.',
        'tiny'          => 'Dziękujemy za wsparcie malutkiej grupki zapalonych światotwórców.',
    ],
    'title'     => 'Subskrybcja :name',
];
