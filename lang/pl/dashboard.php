<?php

return [
    'actions'       => [
        'customise' => 'Dostosuj pulpit',
        'follow'    => 'Śledź',
        'join'      => 'Dołącz',
        'unfollow'  => 'Przestań śledzić',
    ],
    'campaigns'     => [],
    'dashboards'    => [
        'actions'       => [
            'edit'  => 'Zmień nazwę i uprawnienia',
            'new'   => 'Nowy pulpit',
        ],
        'create'        => [
            'helper'    => 'Tworzy nowy pulpit dla :name i określa role dla których jest widoczny albo domyślny.',
            'success'   => 'Stworzono nowy pulpit :name.',
            'title'     => 'Nowy pulpit',
        ],
        'custom'        => [
            'text'  => 'Edytujesz obecnie pulpit :name.',
        ],
        'default'       => [
            'text'  => 'Edytujesz podstawowy pulpit :campaign.',
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
            'title'     => 'Edycja pulpitu',
        ],
        'visibility'    => [
            'default'   => 'Podstawowy',
            'none'      => 'Brak',
            'visible'   => 'Widoczny',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Śledzenie kampanii spowoduje pojawienie przełącznika pod twoimi kampaniami.',
        'join'      => 'Kampania jest otwarta na nowych uczestników. Kliknij, by do niej dołączyć.',
    ],
    'notifications' => [],
    'recent'        => [],
    'settings'      => [],
    'setup'         => [
        'actions'   => [
            'add'               => 'Widżet',
            'back_to_dashboard' => 'Powrót do pulpitu',
            'edit'              => 'Edytuj widżet',
            'new'               => 'Nowy widżet :type',
        ],
        'reorder'   => [
            'helper'    => 'Przeciągnij, by przesunąć',
            'success'   => 'Zmieniono kolejność widżetów',
        ],
        'title'     => 'Konfiguracja pulpitu kampanii',
        'tutorial'  => [
            'blog'  => 'ten wpis',
            'text'  => 'Potrzebujesz pomocy w przygotowaniu pulpitu kampanii? Sprawdź :blog, znajdziesz w nim porady i inspiracje.',
        ],
    ],
    'title'         => 'Pulpit',
    'widgets'       => [
        'advanced_options_boosted'  => 'Więcej opcji, na przykład wyświetlanie przypięć, zapewnia :boosted_campaing.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Zmień datę na kolejny dzień',
                'previous'  => 'Zmień datę na poprzedni dzień',
            ],
            'previous_events'   => 'Minione',
            'upcoming_events'   => 'Nadchodzące',
        ],
        'campaign'                  => [
            'helper'    => 'Ten widżet wyświetla nagłówek kampanii. Jest zawsze widoczny na podstawowym pulpicie.',
        ],
        'create'                    => [
            'helper'            => 'Wybór rodzaju widżetu dodawanego do :name.',
            'helper-default'    => 'Wybór rodzaju widżetu na pulpit domyślny.',
            'success'           => 'Dodano widżet do pulpitu.',
            'title'             => 'Nowy widżet',
        ],
        'delete'                    => [
            'success'   => 'Usunięto widżet z pulpitu.',
        ],
        'edit'                      => [
            'title' => 'Edycja widżetu',
        ],
        'fields'                    => [
            'class'             => 'Klasa CSS',
            'dashboard'         => 'Pulpit',
            'name'              => 'Nazwa widżetu',
            'optional-entity'   => 'Link do elementu',
            'order'             => 'Kolejność',
            'size'              => 'Rozmiar',
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
            'recent'    => 'Zmienione ostatnio',
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
            'help'              => 'Pokaż tylko pierwszy element jako podgląd',
            'helpers'           => [
                'entity-header'     => 'Jeżeli element ma obraz w nagłówku (w doładowanej kampanii), widżet będzie wyświetlał nagłówek zamiast obrazu samego elementu.',
                'show_attributes'   => 'Wyświetla przypięte cechy elementu pod jego opisem.',
                'show_members'      => 'Jeżeli element jest rodziną albo organizacją, wyświetla członków pod opisem.',
                'show_relations'    => 'Wyświetla przypięte relacje pod opisem elementu',
            ],
            'show_attributes'   => 'Pokaż przypięte cechy',
            'show_members'      => 'Pokaż członków',
            'show_relations'    => 'Pokaż przypięte relacje',
            'singular'          => 'Podgląd',
            'tags'              => 'Filtruj listę elementów według konkretnych etykiet.',
            'title'             => 'Lista elementów',
        ],
        'tabs'                      => [
            'advanced'  => 'Zaawanowane',
            'setup'     => 'Ustawienia',
        ],
        'unmentioned'               => [
            'title' => 'Elementy niewzmiankowane',
        ],
        'update'                    => [
            'success'   => 'Zmieniono widżet.',
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
