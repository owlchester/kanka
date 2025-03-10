<?php

return [
    'actions'       => [
        'customise' => 'Dostosuj pulpit',
        'follow'    => 'Śledź',
        'join'      => 'Dołącz',
        'unfollow'  => 'Przestań śledzić',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count modułów',
            'roles'     => ':count ról',
            'users'     => '"count użytkowników',
        ],
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Edytuj',
            'new'       => 'Nowy pulpit',
            'switch'    => 'Przełącz na pulpit',
        ],
        'create'        => [
            'success'   => 'Stworzono w kampanii nowy pulpit :name.',
            'title'     => 'Nowy pulpit kampanii',
        ],
        'custom'        => [
            'text'  => 'Edytujesz obecnie pulpit :name kampanii.',
        ],
        'default'       => [
            'text'  => 'Edytujesz podstawowy pulpit kampanii.',
            'title' => 'Pulpit podstawowy',
        ],
        'delete'        => [
            'success'   => 'Usunięto pulpit :name',
        ],
        'fields'        => [
            'copy_widgets'  => 'Kopiuj widżety',
            'name'          => 'Nazwa pulpitu',
            'visibility'    => 'Widoczność',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Skopiuj widżety z pulpitu :name na ten nowy pulpit.',
        ],
        'pitch'         => 'Konfiguruj wiele pulpitów, z uprawnieniami dla różnych ról kampanii.',
        'placeholders'  => [
            'name'  => 'Nazwa pulpitu',
        ],
        'update'        => [
            'success'   => 'Zaktualizowano pulpit :name.',
            'title'     => 'Aktualizuj pulpit :name',
        ],
        'visibility'    => [
            'default'   => 'Podstawowy',
            'none'      => 'Brak',
            'visible'   => 'Widoczny',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Śledzenie kampanii sprawi, że pojawi się w menu przełączania kampanii (lewy górny róg), pod twoimi własnymi kampaniami.',
        'join'      => 'Kampania jest otwarta na nowych członków. Kliknij, by do niej dołączyć.',
        'setup'     => 'Skonfiguruj pulpit kampanii.',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Rozumiem',
            'title'     => 'Ważne ogłoszenia',
        ],
    ],
    'recent'        => [
        'title' => 'Ostatnio zmieniany element :name',
    ],
    'settings'      => [
        'title' => 'Ustawienia pulpitu',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Dodaj widżet',
            'back_to_dashboard' => 'Powrót do pulpitu',
            'edit'              => 'Edytuj widżet',
            'new'               => 'Nowy widżet :type',
        ],
        'reorder'   => [
            'helper'    => 'Przeciągnij, by mnie przesunąć',
            'success'   => 'Zmieniono kolejność widżetów',
        ],
        'title'     => 'Konfiguracja pulpitu kampanii',
        'tutorial'  => [
            'blog'  => 'ten wpis',
            'text'  => 'Potrzebujesz pomocy w przygotowaniu pulpitu kampanii? Sprawdź :blog, znajdziesz w nim porady i inspiracje.',
        ],
        'widgets'   => [
            'calendar'      => 'Kalendarz',
            'campaign'      => 'Nagłówek kampanii',
            'header'        => 'Nagłówek',
            'preview'       => 'Skrót elementu',
            'random'        => 'Losowy element',
            'recent'        => 'Ostatnie zmiany',
            'unmentioned'   => 'Elementy bez wzmianki',
            'welcome'       => 'Witaj',
        ],
    ],
    'title'         => 'Pulpit',
    'widgets'       => [
        'actions'                   => [
            'advanced-options'  => 'Opcje zaawansowane',
        ],
        'advanced_options_boosted'  => 'Więcej opcji, na przykład wyświetlanie przypięć, zapewnia :boosted_campaing.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Zmień datę na kolejny dzień',
                'previous'  => 'Zmień datę na poprzedni dzień',
            ],
            'events_today'      => 'Dzisiaj',
            'previous_events'   => 'Poprzedni',
            'upcoming_events'   => 'Nadchodzące',
        ],
        'campaign'                  => [
            'helper'    => 'Ten widżet wyświetla nagłówek kampanii. Jest zawsze widoczny na podstawowym pulpicie.',
        ],
        'create'                    => [
            'success'   => 'Dodano widżet do pulpitu.',
            'title'     => 'Nowy widżet',
        ],
        'delete'                    => [
            'success'   => 'Usunięto widżet z pulpitu.',
        ],
        'fields'                    => [
            'class'             => 'Klasa CSS',
            'dashboard'         => 'Pulpit',
            'name'              => 'Własna nazwa widżetu',
            'optional-entity'   => 'Odnośnik do elementu',
            'order'             => 'Kolejność',
            'size'              => 'Rozmiar',
            'text'              => 'Tekst',
            'width'             => 'Szerokość',
        ],
        'helpers'                   => [
            'class'     => 'Określ własną klasę css dodaną do widżetu',
            'filters'   => 'Kliknij by poznać dostępne opcje filtrowania.',
        ],
        'orders'                    => [
            'name_asc'  => 'Nazwa rosnąco',
            'name_desc' => 'Nazwa malejąco',
            'oldest'    => 'Zmienione najdawniej',
            'recent'    => 'Ostatnie zmiany',
        ],
        'preview'                   => [
            'displays'  => [
                'expand'    => 'Wpis do rozwinięcia',
                'full'      => 'Cały wpis',
            ],
            'fields'    => [
                'display'   => 'Wyświetlanie',
            ],
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Możesz wskazać nazwę losowego elementu przy pomocy {name}.',
            ],
            'type'      => [
                'all'   => 'Wszystkie',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Filtry zaawansowane',
            'advanced_filters'  => [
                'mentionless'   => 'Niewzmiankujące (elementy, które nie wzmiankują żadnych innych elementów)',
                'unmentioned'   => 'Niewzmiankowane (elementy, których nie wzmiankuje żadnej inny element)',
            ],
            'all-entities'      => 'Wszystkie elementy',
            'entity-header'     => 'Używaj nagłówka elementu jako obrazu widżetu',
            'filters'           => 'Filtry',
            'help'              => 'Pokazuj tylko ostatni zmodyfikowany element, ale publikuj cały skrót',
            'helpers'           => [
                'entity-header'     => 'Jeżeli element ma obraz w nagłówku (w doładowanej kampanii), widżet będzie wyświetlał nagłówek zamiast obrazu samego elementu.',
                'show_attributes'   => 'Wyświetla cechy elementu pod jego opisem.',
                'show_members'      => 'Jeżeli element jest rodziną albo organizacją, wyświetla jej członków pod opisem.',
                'show_relations'    => 'Wyświetla przypięte relacje pod opisem elementu',
            ],
            'show_attributes'   => 'Pokaż cechy',
            'show_members'      => 'Pokaż członków',
            'show_relations'    => 'Pokaż przypięte relacje',
            'singular'          => 'Pojedynczy',
            'tags'              => 'Filtruj listę niedawno zmienianych elementów według konkretnych etykiet.',
            'title'             => 'Ostatnie zmiany',
        ],
        'tabs'                      => [
            'advanced'  => 'Zaawanowane',
            'setup'     => 'Ustawienia',
        ],
        'unmentioned'               => [
            'title' => 'Elementy bez wzmianki',
        ],
        'update'                    => [
            'success'   => 'Zmodyfikowano widżet.',
        ],
        'welcome'                   => [
            'helper'    => 'Ten widżet zawiera komunikat powitalny oraz szereg odnośników, które przydadzą się nowym użytkownikom Kanki.',
        ],
        'widths'                    => [
            '0' => 'Automatyczna',
            '12'=> 'Pełny (100%)',
            '3' => 'Malutki (25%)',
            '4' => 'Mały (33%)',
            '6' => 'Połowa (50%)',
            '8' => 'Szeroki (66%)',
            '9' => 'Duży (75%)',
        ],
    ],
];
