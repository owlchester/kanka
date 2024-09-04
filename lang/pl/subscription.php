<?php

return [
    'benefits'  => [
        'main'  => 'Subskrybcja pozwala dołączać większe obrazki, usuwa reklamy, zapewnia :boosters i :more. Płatności realizuje :stripe, więc nie przechowujemy na naszych serwerach informacji o kartach kredytowych.',
        'more'  => 'inne świetne opcje',
    ],
    'errors'    => [
        'grace'                 => 'Obecna subskrypcja kończy się :date, potem zostanie odnowiona.',
        'invalid_card_country'  => [
            'brl'   => 'Niestety, posiadacze brazylijskich kart kredytowych mogą płacić wyłącznie w BRL. Jeśli uważasz to za błąd, napisz do nas na adres :email.',
        ],
        'invalid_currency'      => 'Poprzednia subskrypcja w :old uniemożliwia nową w :new. Przełącz walutę na :old albo napisz do nas na adres: email, jeżeli chcesz ją zmienić.',
    ],
];
