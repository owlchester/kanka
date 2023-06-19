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
        'duration'  => 'Kampanie premium zachowują status, póki go nie usuniesz ręcznie albo do zakończenia subskrypcji.',
        'pitch'     => 'Subskrybuj, by odblokować wersję premium.',
        'success'   => 'Kampania :campaign ma teraz wersję premium. Korzystaj z wielu świetnych opcji!',
    ],
    'exceptions'    => [
        'already'       => 'W tej kampanii używasz już opcji premium.',
        'out-of-stock'  => 'Nie masz wolnych rozwinięć do wersji premium. Usuń status premium innej kampanii albo :upgrade.',
    ],
    'pitch'         => [
        'description'   => 'Używaj wersji premium kampanii, by odblokować wspaniałe opcje dla wszystkich uczestników.',
        'more'          => 'Pełna lista korzyści znajduje się na stronie :premium.',
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
        'success'   => 'Z :campaign usunięto wersję premium. Możesz teraz odblokować ten status w innej kampanii.',
        'title'     => 'Usuwanie opcji premium',
        'warning'   => 'Czy na pewno usunąć wersję premium kampanii :campaign? Pozwoli ci to nadać status premium innej kampanii, a cała zawartość premium zostanie ukryta do ponownej aktywacji wersji premium.',
    ],
];
