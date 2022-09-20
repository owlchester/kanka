<?php

return [
    'actions'       => [
        'boost_name'    => 'Doładuj :name',
    ],
    'benefits'      => [
        'boosted'       => 'Użycie :one doładowania zapewnia dostęp do następujących funkcji: :marketplace, zmiana motywu, możliwość załączania większych plików, odzyskiwanie usuniętych elementów i :more.',
        'more'          => 'inne świetne opcje.',
        'superboosted'  => 'Turbodoładowanie kampanii z pomocą :amount doładowań odblokowuje wszystkie opcje kampanii doładowanej oraz galerię, pełny dziennik zmian każdego elementu i :more.',
    ],
    'boost'         => [
        'actions'   => [
            'confirm'   => 'Doładuj!',
            'remove'    => 'Wycofaj doładowanie :campaign',
            'subscribe' => 'Zasubskrybuj Kankę',
            'upgrade'   => 'Zwiększ poziom subskrybcji',
        ],
        'confirm'   => 'Wspaniale, zamierzasz doładować :campaign. To działanie wykorzysta jedno (:cost) z doładowań, których możesz użyć.',
        'duration'  => 'Doładowania pozostają przypisane do kampanii póki ich nie wycofasz ręcznie albo nie zakończysz sybskrypcji.',
        'errors'    => [
            'boosted'           => 'O nie! Najwyraźniej :campaign jest już doładowana!',
            'out-of-boosters'   => 'O nie! Brakuje ci doładowań. Masz ich :available, a potrzebujesz :cost. Możesz albo wycofać doładowanie innej kampanii albo :upgrade.',
        ],
        'pitch'     => 'Zasubskrybuj, aby otrzymać doładowania.',
        'success'   => 'Kampania :campaign jest od teraz doładowana. Ciesz się nowymi możliwościami!',
        'title'     => 'Doładuj :campaign',
        'upgrade'   => 'zwiększyć poziom subskrypcji',
    ],
    'campaign'      => [
        'boosted'       => 'Doładowana przez :user od :time',
        'superboosted'  => 'Turbodoładowana przez :user od :time',
        'unboosted'     => 'Niedoładowana',
    ],
    'intro'         => [
        'anyone'    => 'Możesz doładowywać kampanie, które stworzył ktoś inny, o ile jesteś ich uczestnikiem albo możesz je zobaczyć. To znaczy, kampanie w które grasz albo które możesz przeglądać, gdyż są :public.',
        'data'      => 'Po usunięciu doładowań kampanii dostęp do dodatkowych opcji zostaje usunięty. Aby go odzyskać należy doładować kampanię ponownie.',
        'first'     => 'Przydzielając kampaniom doładowania zyskujesz dostęp do funkcji zaawansowanych. Liczba dostępnych doładowań zależy od :subsription - pozostaje do twojej dyspozycji, póki subskrybujesz Kankę. By doładować kampanię wystarczy przydzielić jej jedno doładowanie. Turbodoładowanie kampanii wymaga trzech doładowań.',
    ],
    'pitch'         => [
        'benefits'      => [
            'backup'        => 'Możliwość odzyskania usuniętych elementów do :days wstecz',
            'customisable'  => 'Pełną kontrolę nad wyglądem kampanii',
            'entities'      => 'Większy wpływ na zachowanie i wygląd elementów',
            'icons'         => 'Dostęp do tysięcy ikon, które można umieszczać na mapie i w historii',
            'relations'     => 'Narzędzie wizualizacji relacji między elementami',
            'title'         => 'W doładowanych kampaniach otrzymujesz',
            'upload'        => 'Możliwość dodawania większych plików (dla wszystkich)',
        ],
        'description'   => 'Doładowanie kampanii zapewnia dostęp do świetnych możliwości, i to dla wszystkich uczestników. Mało ci? Spróbuj turbodoładowania.',
        'more'          => 'Pełną listę udogodnień znajdziesz na stronie :booster.',
        'title'         => 'Wznieś kampanię na nowym poziom, zapewniając wszystkim uczestnikom dostęp do licznych udogodnień',
    ],
    'ready'         => [
        'available'         => 'Dostępne doładowania kampanii.',
        'pricing'           => 'Każdy poziom subskrypcji zawiera przynajmniej jedno doładowanie kampanii. Ceny zaczynają się od :amount miesięcznie.',
        'pricing-amount'    => ':currency:amount',
        'title'             => 'Doładuj kampanię',
    ],
    'superboost'    => [
        'actions'   => [
            'confirm'   => 'Turbodoładuj!',
            'remove'    => 'Wycofaj turbodoładnie :campaign',
        ],
        'confirm'   => 'Wspaniale, zamierzasz turbodoładować :campaign. To działanie wymaga wykorzystania trzech (:cost) spośród twoich dostępnych doładowań.',
        'errors'    => [
            'boosted'   => 'O nie! Najwyraźniej :campaign jest już turbodoładowana!',
        ],
        'success'   => 'Kampania :campaign jest od teraz turbodoładowana. Ciesz się nowymi możliwościami!',
        'title'     => 'Turbodoładuj :campaign',
        'upgrade'   => 'Masz chrapkę na ostateczną wersję Kanki? Turbodoładuj :campaign za pomocą :cost dodatkowych doładowań.',
    ],
    'title'         => 'Doładowania kampanii',
    'unboost'       => [
        'confirm'   => 'Tak, na pewno',
        'status'    => [
            'boosting'      => 'doładowanie',
            'superboosting' => 'turbodoładowanie',
        ],
        'success'   => 'Kampania :campaign nie jest już turbodoładowana, odzyskujesz swoje doładowania.',
        'title'     => 'Usuwanie doładowania',
        'warning'   => 'Czy na pewno chcesz zakończyć :action : campaign? Odzyskasz w ten sposób wydane doładowania, a elementy kampanii związane z doładowaniem zostaną ukryte aż do ponownego doładowania.',
    ],
];
