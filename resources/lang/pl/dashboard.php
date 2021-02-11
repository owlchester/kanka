<?php

return [
    'actions'           => [
        'follow'    => 'Śledź',
        'unfollow'  => 'Przestań śledzić',
    ],
    'campaigns'         => [
        'tabs'  => [
            'modules'   => ':count modułów',
            'roles'     => ':count ról',
            'users'     => '"count użytkowników',
        ],
    ],
    'dashboards'        => [
        'actions'       => [
            'edit'      => 'Edytuj',
            'new'       => 'Nowy pulpit',
            'switch'    => 'Przełącz na pulpit',
        ],
        'boosted'       => ':boosted_campaigns pozwalają tworzyć różne pulpity dla różnych ról w kampanii.',
        'create'        => [
            'success'   => 'Stworzono w kampanii nowy pulpit :name.',
            'title'     => 'Nowy Pulpit Kampanii',
        ],
        'custom'        => [
            'text'  => 'Edytujesz obecnie pulpit :name kampanii.',
        ],
        'default'       => [
            'text'  => 'Edytujesz podstawowy pulpit kampanii.',
            'title' => 'Podstawowy Pulpit',
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
    'description'       => 'Dowód twojej kreatywności',
    'helpers'           => [
        'follow'    => 'Śledzenie kampanii sprawi, że pojawi się w menu przełączania kampanii (lewy górny róg), pod twoimi własnymi kampaniami.',
        'setup'     => 'Skonfiguruj pulpit kampanii.',
    ],
    'latest_release'    => 'Ostatnia wersja',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Rozumiem',
            'title'     => 'Ważne ogłoszenia',
        ],
    ],
    'recent'            => [
        'title' => 'Ostatnio zmieniany element :name',
    ],
    'settings'          => [
        'title' => 'Ustawienia pulpitu',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Dodaj widżet',
            'back_to_dashboard' => 'Powrót do pulpitu',
            'edit'              => 'Edytuj widżet',
        ],
        'title'     => 'Konfiguracja Pulpitu Kampanii',
        'widgets'   => [
            'calendar'      => 'Kalendarz',
            'campaign'      => 'Nagłowek kampanii',
            'header'        => 'Nagłówek',
            'preview'       => 'Skrót elementu',
            'random'        => 'Losowy element',
            'recent'        => 'Ostatnio zmieniany',
            'unmentioned'   => 'Niewspomniane elementy',
        ],
    ],
    'title'             => 'Pulpit',
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Zmień datę na kolejny dzień',
                'previous'  => 'Zmień datę na poprzedni dzień',
            ],
            'events_today'      => 'Dzisiaj',
            'previous_events'   => 'Poprzedni',
            'upcoming_events'   => 'Nadchodzący',
        ],
        'campaign'      => [
            'helper'    => 'Ten widżet wyświetla nagłówek kampanii. Jest zawsze widoczny na podstawowym pulpicie.',
        ],
        'create'        => [
            'success'   => 'Dodano widżet do pulpitu.',
        ],
        'delete'        => [
            'success'   => 'Usunięto widżet z pulpitu.',
        ],
        'fields'        => [
            'name'  => 'Własna nazwa widżetu',
            'text'  => 'Tekst',
            'width' => 'Szerokość',
        ],
        'recent'        => [
            'entity-header' => 'Używaj nagłówka elementu jako obrazu widżetu',
            'full'          => 'Pełny',
            'help'          => 'Pokazuj tylko ostatni zmodyfikowany element, ale publikuj cały skrót',
            'helpers'       => [
                'entity-header' => 'Jeżeli ten element na obraz nagłówka (w doładowanej kampanii), ten widżet będzie wyświetlał nagłówek zamiast obrazu samego elementu.',
                'full'          => 'Zamiast skrótu elementu domyślnie wyświetla jego cały opis.',
            ],
            'singular'      => 'Pojedynczy',
            'tags'          => 'Filtruj listę niedawno zmienianych elementów według konkretnych etykiet.',
            'title'         => 'Ostatnio zmieniane',
        ],
        'unmentioned'   => [
            'title' => 'Niewspomniane elementy',
        ],
        'update'        => [
            'success'   => 'Zmodyfikowano widżet.',
        ],
        'widths'        => [
            '0' => 'Automatycznie',
            '12'=> 'Pełny (100%)',
            '3' => 'Malutki (25%)',
            '4' => 'Mały (33%)',
            '6' => 'Połowa (50%)',
            '8' => 'Szeroki (66%)',
        ],
    ],
];
