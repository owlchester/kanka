<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Przejdź na Logowanie Kanki',
            'update_email'      => 'Zmień email',
            'update_password'   => 'Zmień hasło',
        ],
        'email'             => 'Zmiana emaila',
        'email_success'     => 'Zmieniono email.',
        'password'          => 'Zmiana hasła',
        'password_success'  => 'Zmieniono hasło.',
        'social'            => [
            'error'     => 'To konto używa już Logowania Kanki',
            'helper'    => 'Twoim kontem zarządza obecnie :provider. Możesz przejść na system logowania, którym zarządza Kanka, ustawiając hasło.',
            'success'   => 'Konto używa od teraz logowania Kanki.',
            'title'     => 'Kanka przez serwis społecznościowy',
        ],
        'title'             => 'Konto',
    ],
    'api'           => [
        'helper'    => 'Witaj w Kanka API. Generuj Osobiste Żetony Dostępu, by używać wywołań API do gromadzenia informacji o kampaniach, w których uczestniczysz.',
        'link'      => 'Przeczytaj dokumentację API',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Połącz',
            'remove'    => 'Usuń',
        ],
        'benefits'  => 'Kanka posiada możliwość integracji z kilkoma narzędziami zewnętrznymi. Kolejne dostępne będą w przyszłości.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Podczas łączenia konta Kanki z Discordem nastąpił błąd. Spróbuj jeszcze raz.',
            ],
            'success'   => [
                'add'       => 'Połączono z kontem Discord.',
                'remove'    => 'Odłączono konto Discord.',
            ],
            'text'      => 'Automatyczny dostęp do poziomu subskrypcji.',
        ],
        'title'     => 'Integracja z aplikacjami',
    ],
    'boost'         => [
        'benefits'      => [
            'campaign_gallery'  => 'Galeria kampanii, do której możesz dodawać obrazy dostępne w całej kampanii.',
            'entity_files'      => 'Dodaj do 10 plików do elementu.',
            'entity_logs'       => 'Pełen dziennik wszystkich zmian i aktualizacji elementów.',
            'first'             => 'By zapewnić Kance możliwość rozwoju, niektóre funkcje dostępne są wyłącznie w doładowanych kampaniach. Doładowania z kolei związane są z subskrypcją. Każda osoba posiadająca dostęp do kampanii może ją doładować, więc płacenie rachunków nie spada zawsze na MG. Doładowanie jest aktywne, póki użytkownik go nie wyłączy i opłaca subskrypcję. Jeżeli kampania traci doładowanie, dane nie są usuwane, lecz ukrywane i stają się dostępne po ponownym doładowaniu.',
            'header'            => 'Obrazy w nagłówkach elementów.',
            'headers'           => [
                'boosted'       => 'Korzyści doładowanej kampanii',
                'superboosted'  => 'Korzyści turbodoładowanej kampanii',
            ],
            'helpers'           => [
                'boosted'       => 'Gdy doładowujesz kampanię, zużywasz jedno doładowanie.',
                'superboosted'  => 'Gdy turbodoładowujesz kampanię, zużywasz trzy doładowania.',
            ],
            'images'            => 'Własne obrazy domyślne elementów.',
            'more'              => [
                'boosted'       => 'Wszystkie funkcje doładowanej kampanii',
                'superboosted'  => 'Wszystkie funkcje turbodoładowanej kampanii',
            ],
            'recovery'          => 'Odzyskaj elementy usunięte do :amount dni temu',
            'second'            => 'Doładowanie kampanii zapewnia następujące korzyści:',
            'superboost'        => 'Turbodoładowanie kampanii zużywa 3 doładowania i odblokowuje kolejne funkcje, w dodatku do wynikających z doładowania.',
            'theme'             => 'Inny motyw i styl dla każdej kampanii.',
            'third'             => 'By doładować kampanię, idź na jej stronę i kliknij ":boost_button" tuż nad ":edit_button".',
            'tooltip'           => 'Własne dymki z poradami.',
            'upload'            => 'Zwiększona wielkość plików dodawanych przez wszystkich uczestników kampanii.',
        ],
        'buttons'       => [
            'boost'         => 'Doładuj',
            'superboost'    => 'Turbodoładuj',
            'tooltips'      => [
                'boost'         => 'Doładowanie kampanii zużyje do :amount twoich doładowań',
                'superboost'    => 'Turbodoładowanie kampanii zużyje :amount twoich doładowań',
            ],
        ],
        'campaigns'     => 'Doładowane kampanie :count/:max',
        'exceptions'    => [
            'already_boosted'       => 'Kampania :name jest już doładowana.',
            'exhausted_boosts'      => 'Nie masz już doładowań. Musisz usunąć doładowanie z którejś kampanii, by je ponownie wykorzystać.',
            'exhausted_superboosts' => 'Nie masz doładowań. Potrzebujesz 3, by turbodoładować kampanię.',
        ],
        'success'       => [
            'boost'         => 'Doładowano kampanię :name.',
            'delete'        => 'Usunięto doładowanie kampanii :name.',
            'superboost'    => 'Turbodoładowano kampanię :name',
        ],
        'title'         => 'Doładowanie',
        'unboost'       => [
            'description'   => 'Czy na pewno usunąć doładowanie kampanii :tag?',
            'title'         => 'Usunięcie doładowania',
        ],
    ],
    'countries'     => [
        'austria'       => 'Austria',
        'belgium'       => 'Belgia',
        'france'        => 'Francja',
        'germany'       => 'Niemcy',
        'italy'         => 'Włochy',
        'netherlands'   => 'Holandia',
        'spain'         => 'Hiszpania',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Pobierz PDF',
            'view_all'  => 'Wszystkie',
        ],
        'empty'     => 'Brak rachunków',
        'fields'    => [
            'amount'    => 'Kwota',
            'date'      => 'Data',
            'invoice'   => 'Rachunek',
            'status'    => 'Status',
        ],
        'header'    => 'Na liście znajdują się ostatnie 24 rachunki. Możesz je pobrać.',
        'status'    => [
            'paid'      => 'Opłacony',
            'pending'   => 'Oczekuje',
        ],
        'title'     => 'Rachunki',
    ],
    'layout'        => [
        'success'   => 'Zmieniono opcje układu',
        'title'     => 'Układ',
    ],
    'marketplace'   => [
        'fields'    => [
            'name'  => 'Nazwa na Targowisku',
        ],
        'helper'    => 'Domyślnie :marketplace używa twojej nazwy użytkownika. Tu możesz ją zastąpić.',
        'title'     => 'Ustawienia Targowiska',
        'update'    => 'Zapisano ustawienia Targowiska.',
    ],
    'menu'          => [
        'account'               => 'Konto',
        'api'                   => 'API',
        'apps'                  => 'Aplikacje',
        'billing'               => 'Metoda płatności',
        'boost'                 => 'Doładowanie',
        'invoices'              => 'Rachunki',
        'layout'                => 'Układ',
        'marketplace'           => 'Targowisko',
        'other'                 => 'Inne',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Opcje płatności',
        'personal_settings'     => 'Ustawienia osobiste',
        'profile'               => 'Profil',
        'settings'              => 'Ustawienia',
        'subscription'          => 'Subskrypcja',
        'subscription_status'   => 'Status subskrypcji',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Połącz konto',
            'view'  => 'Przejdź do Kanki na Patreonie',
        ],
        'benefits'          => 'Wspierając nas na :parteon pomagasz w tworzeniu :features dla swojej kampanii i pozwalasz nam spędzać więcej czasu na ulepszaniu Kanki.',
        'benefits_features' => 'świetnych funkcji',
        'deprecated'        => 'Przestarzała funkcja. Jeżeli chcesz wspierać Kankę, rozważ subskrypcję. Integracja z Patreonem jest dostępna tylko dla osób, które połączyły swoje konta Patren z Kanką zanim wycofaliśmy się z tego serwisu.',
        'description'       => 'Sybchronizacja z Patreonem',
        'linked'            => 'Dziękujmy za wspieranie Kanki na Patreonie! Twoje konto zostało dodane.',
        'pledge'            => 'Deklaracja :name',
        'remove'            => [
            'button'    => 'Odłącz konto Patreon',
            'success'   => 'Odłązcono twoje konto Patreon',
            'text'      => 'Dołączenie kontra Patreon spowoduje usunięcie z listy wspierających, utratę doładować kampanii i innych korzyści dostępnych dla wspierających. Treści związane z doładowaniem (na przykład nagłówki) nie zostają usunięte. Odnawiając subskrypcje odzyskasz dostęp do danych oraz możliwość ponownego doładowywania kampanii.',
            'title'     => 'Odłącz swoje konto Patreon od Kanki',
        ],
        'success'           => 'Dziękujemy za wspierane Kanki na Patreonie!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Twój poziom wsparcia jest przez nas ustawiany ręcznie, więc daj mu kilka dni na reakcję. Jeżeli nie zmieni się przez dłuższy czas, daj nam znać.',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Aktualizuj profil',
        ],
        'avatar'    => 'Zdjęcie profilowe',
        'success'   => 'Zmieniono profil.',
        'title'     => 'Profil osobisty',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Usuń subskrypcję',
            'subscribe'         => 'Subskrybuj',
            'update_currency'   => 'Zapisz preferowaną walutę',
        ],
        'benefits'              => 'Wspierając nas pomagasz w tworzeniu :features i pozwalasz nam spędzać więcej czasu na ulepszaniu Kanki. Żadne informacje dotyczące kart kredytowych nie są przechowywane ani przetwarzane na naszych serwerach. Płatności obsługuje serwis :stripe.',
        'billing'               => [
            'helper'    => 'Informacje o płatnościach bezpiecznie przetwarza i przechowuje :stripe. To metoda płatności stosowana we wszystkich subskrypcjach.',
            'saved'     => 'Zapisz metodę płatności',
            'title'     => 'Edycja metody płatności',
        ],
        'cancel'                => [
            'text'  => 'Szkoda, że rezygnujesz! Po zaniechaniu subskrypcji konto pozostanie aktywne do końca okresu rozliczeniowego. Potem stracisz doładowania i inne korzyści wynikające ze wspierania Kanki. Wypełniając poniższy formularz nasz nam znać, co możemy poprawić i dlaczego rezygnujesz.',
        ],
        'cancelled'             => 'Anulowano subskrypcję. Możesz ją odnowić, gdy tylko ta wygaśnie.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Subskrybujesz na poziomie :tier, płacąc miesięcznie :amount.',
                'yearly'    => 'Subskrybujesz na poziomie :tier, płacąc rocznie :amount.',
            ],
            'title' => 'Zmiana poziomu subskrypcji',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Zmień preferowaną walutę rozliczenia',
        ],
        'errors'                => [
            'callback'      => 'Nasz dostawca płatności zgłosił błąd. Spróbuj ponownie i skontaktuj się z nami, jeżeli się powtórzy.',
            'subscribed'    => 'Nie można przetworzyć subskrypcji. Stripe sugeruje następującą radę.',
        ],
        'fields'                => [
            'active_since'      => 'Aktywna od',
            'active_until'      => 'Aktywna do',
            'billing'           => 'Płatność',
            'currency'          => 'Waluta płatności',
            'payment_method'    => 'Metoda płatności',
            'plan'              => 'Obecny plan',
            'reason'            => 'Powód',
        ],
        'helpers'               => [
            'alternatives'          => 'Opłać subskrypcję używając :method. Ten sposób płatności nie odnawia się automatycznie na koniec cyklu. :method jest dostępna tylko w Euro.',
            'alternatives_warning'  => 'Jeżeli używasz tej metody, nie możesz zmienić poziomu subskrypcji. Zasubskrybuj ponownie, gdy ta subskrypcja wygaśnie.',
            'alternatives_yearly'   => 'Z powodu ograniczeń cyklu płatniczego, :method jest dostępna tylko dla subskrypcji rocznych.',
        ],
        'manage_subscription'   => 'Zarządzaj subskrypcją',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Dodaj metodę płatności',
                'change'            => 'Zmień metodę płatności',
                'save'              => 'Zapisz metodę płatności',
                'show_alternatives' => 'Alternatywne sposoby płatności',
            ],
            'add_one'       => 'Nie masz zapisanych metod płatności.',
            'alternatives'  => 'Możesz subskrybować Kankę przy pomocy tych alternatyw. Twoje konto zostanie obciążone raz i subskrypcja nie odnowi się automatycznie.',
            'card'          => 'Karta',
            'card_name'     => 'Nazwisko na karcie',
            'country'       => 'Kraj pobytu',
            'ending'        => 'Ważność do',
            'helper'        => 'Karta zostanie użyta do wszystkich twoich subskrypcji',
            'new_card'      => 'Dodaj metodę płatności',
            'saved'         => ':brand o numerze kończącym się na :last4',
        ],
        'placeholders'          => [
            'reason'    => 'Jeżeli chcesz, powiedz nam dlaczego rezygnujesz ze wspierania Kanki. Czy brakuje ci jakichś funkcji, czy też zmieniła się twoja sytuacja finansowa?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount rozliczane miesięcznie',
            'cost_yearly'   => ':currency :amount rozliczane rocznie',
        ],
        'sub_status'            => 'Informacje o subskrypcji',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Skontaktuj się z nami by zmniejszyć poziom subskrypcji',
                'rollback'          => 'Zmień na Kobolda',
                'subscribe'         => 'Zmień na poziom :tier miesięcznie',
                'subscribe_annual'  => 'Zmień na poziom :tier rocznie',
            ],
        ],
        'success'               => [
            'alternative'   => 'Zarejestrowaliśmy płatność. Otrzymasz powiadomienie kiedy tylko zostanie przetworzona i aktywujemy subskrypcję.',
            'callback'      => 'Subskrypcja udana. Zaktualizujemy twoje konto gdy tylko obsługujący płatności powiadomi nas o zmianie (to może potrwać kilka minut).',
            'cancel'        => 'Anulowano subskrypcję. Pozostanie aktywna do końca okresu rozliczeniowego.',
            'currency'      => 'Zmieniono walutę rozliczenia.',
            'subscribed'    => 'Subskrypcja udana. Nie zapomnij o newsletterze głosowań społeczności, by zawsze wiedzieć kiedy rozpoczyna się głosowanie. Możesz zmienić ustawienia newslettera na stronie profilu.',
        ],
        'tiers'                 => 'Poziomy subskrypcji',
        'trial_period'          => 'Subskrypcje roczne mają 14-dniowy okres wypowiedzenia. Jeżeli chcesz anulować subskrypcję roczną i uzyskać zwrot pieniędzy, skontaktuj się z nami przez :email.',
        'upgrade_downgrade'     => [
            'button'    => 'Informacje o zmianie subskrypcji',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Wszystkie korzyści subskrypcji pozostaną aktywne do końca okresu rozliczeniowego.',
                    'boosts'    => 'To samo dotyczy doładowań kampanii. Po utracie doładowania, dodatkowe elementy kampanii nie zostają usunięte, jedynie ukryte.',
                    'kobold'    => 'By anulować subskrypcję, zmień jej poziom na Kobold.',
                ],
                'title'     => 'Gdy anulujesz subskrypcję',
            ],
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'Twój poziom zostanie aktywny do końca okresu rozliczeniowego, po czym zostanie odpowiednio zmniejszony.',
                ],
                'title'     => 'Gdy obniżasz subskrypcję',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Pobierzemy pieniądze od razu i natychmiast uzyskasz dostęp do nowego poziomu.',
                    'prorate'   => 'Zwiększając subskrypcję z poziomu Owlbear na poziom Elemental płacisz tylko różnicę w cenie.',
                ],
                'title'     => 'Gdy podnosisz subskrypcję',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Nie mogliśmy obciążyć karty. Zaktualizuj dane karty kredytowej - podejmiemy kolejną próbę w ciągu kilku dni. Jeżeli znów się nie uda, twoja subskrypcja zostanie anulowana.',
            'patreon'       => 'Twoje konto jest powiązane z Patreonem. Usuń swoje konto Patreon z Kanki zanim przejdziesz na bezpośrednią subskrypcję.',
        ],
    ],
];
