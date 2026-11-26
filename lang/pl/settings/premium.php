<?php

return [
    'actions'       => [
        'remove'    => 'Usuń premium',
        'unlock'    => 'Aktywuj premium',
    ],
    'create'        => [
        'actions'   => [
            'confirm'   => 'Wersja premium!',
        ],
        'confirm'   => 'Hurra! Zaraz odblokujesz wersję premium kampanii :campaign. Użyjesz w tym celu jednego z dostępnych rozszerzeń.',
        'more'      => 'Oraz własne motywy, drzewa genealogiczne, własne kategorie i tak dalej. To tylko przedsmak wszystkich nowych funkcji. Kampania premium zachowa swój status póki go nie usuniesz albo nie zakończysz subskrybcji.',
        'no-stock'  => 'O nie, najwyraźniej nie masz dość dostępnych odblokowań premium, by użyć ich w tej kampanii. Możesz usunąć status premium innej kampanii albo :upgrade.',
        'pitch'     => 'Podgląd zmian w kampanii :name po odblokowaniu funkcji premium, których jest w istocie znacznie więcej.',
        'recap'     => [
            'control'   => [
                'description'   => 'Możliwość zmiany menu, kategorii i innych',
                'title'         => 'Pełna kontrola',
            ],
            'gallery'   => 'więcej przestrzeni dyskowej na ilustracje i inne materiały',
            'icons'     => 'ikony właściwe dla tego świata',
            'instant'   => 'wszyscy człokowie natychmiast zmienią status',
            'members'   => [
                'description'   => 'role i członkowie',
                'title'         => 'Nieograniczone',
            ],
            'recovery'  => [
                'description'   => 'możliwość przywrócenia usuniętych elementów',
                'title'         => 'przez :amount dni',
            ],
            'size'      => 'limit plików na członka',
        ],
        'subtitle'  => 'Zaraz odblokujesz funkcje premium kampani :name. Oto kilka rzeczy, które od razu ulegną zmianie.',
        'success'   => 'Kampania :campaign ma status premium. Korzystaj z wielu świetnych opcji!',
    ],
    'exceptions'    => [
        'already'       => 'W tej kampanii używasz już opcji premium.',
        'out-of-stock'  => 'Nie masz wolnych rozwinięć do wersji premium. Usuń status premium innej kampanii albo :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Status premium kampanii pozwala odblokować wspaniałe opcje dla wszystkich uczestników.',
        'title'         => 'W kampaniach premium otrzymujesz',
    ],
    'ready'         => [
        'available'         => 'Dostępne kampanie premium.',
        'pricing'           => 'Każdy poziom subskrypcji oferuje co najmniej jedno rozwinięcie do wersji premium. Cena zaczyna się od :amount miesięcznie.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Aktywuj premium',
    ],
    'remove'        => [
        'confirm'   => 'Tak, na pewno',
        'cooldown'  => 'Funkcje premium kampanii :campaign można usunąć po :date.',
        'success'   => 'Z :campaign usunięto wersję premium. Możesz teraz odblokować ten status w innej kampanii.',
        'title'     => 'Usuwanie opcji premium',
        'warning'   => 'Czy na pewno usunąć wersję premium kampanii :campaign? Pozwoli ci to nadać status premium innej kampanii, a cała zawartość premium zostanie ukryta do ponownej aktywacji wersji premium.',
    ],
];
