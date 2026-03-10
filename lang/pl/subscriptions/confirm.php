<?php

return [
    'actions'   => [
        'pay'       => 'Zapłać teraz :amount :currency',
        'paypal'    => 'Zapłać :amount :currency PayPalem',
        'subscribe' => 'Subskrybujesz za :currency:amount',
    ],
    'helpers'   => [
        'auto-renew'    => [
            'monthly'   => 'Subskrybcja odnawia się automatycznie co miesiąc. Opłatę pobierzemy w dniu :date.',
            'none'      => 'PayPal umożliwia zapłatę jednorazową i nie odnawia się automatycznie. Twoja subskrybcja wygaśnie po :date i trzeba ją będzie odnowić.',
            'yearly'    => 'Subskrypcja odnawia się automatycznie co 12 miesięcy. Opłatę pobierzemy w dniu :date.',
        ],
        'paypal'        => 'Przeniesiesz się na stronę PayPal by dokończyć płatność.',
        'refund'        => 'Oferujemy 14-dniowy okres rezygnacji z każdej subskrypcji rocznej. Nie musisz się tłumaczyć, wystarczy napisać maila na adres :email, by wszcząć procedurę zwrotu kosztów.',
        'tiny'          => 'Dziękujemy za wsparcie malutkiej grupki zapalonych światotwórców.',
    ],
    'title'     => 'Subskrybcja :name',
];
