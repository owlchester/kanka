<?php

return [
    'actions'       => [
        'add_epoch'         => 'Dodaj epokę',
        'add_intercalary'   => 'Dodaj dni dodatkowe',
        'add_month'         => 'Dodaj miesiąc',
        'add_moon'          => 'Dodaj księżyc',
        'add_reminder'      => 'Dodaj przypomnienie',
        'add_season'        => 'Dodaj porę roku',
        'add_weather'       => 'Dodaj pogodę',
        'add_week'          => 'Dodaj tydzień specjalny',
        'add_weekday'       => 'Dodaj dzień tygodnia',
        'add_year'          => 'Dodaj nazwę roku',
        'set_today'         => 'Ustaw jako aktualną datę',
        'today'             => 'Dziś',
    ],
    'checkboxes'    => [
        'is_recurring'  => 'Coroczne',
    ],
    'colours'       => [],
    'create'        => [
        'success'   => 'Stworzono kalendarz :name.',
        'title'     => 'Nowy kalendarz',
    ],
    'destroy'       => [
        'success'   => 'Usunięto kalendarz :name',
    ],
    'edit'          => [
        'success'   => 'Zmieniono kalendarz \':nazwa\'',
        'title'     => 'Edycja kalendarza :nazwa',
        'today'     => 'Zmieniono datę kalendarza.',
    ],
    'event'         => [
        'actions'   => [
            'delete-confirm'    => 'to wydarzenie',
            'existing'          => 'Istniejący element',
            'new'               => 'Nowe wydarzenie',
            'switch'            => 'Zmień wybór',
        ],
        'create'    => [
            'success'   => 'Utworzono wydarzenie.',
            'title'     => 'Dodaj wydarzenie do :name',
        ],
        'destroy'   => 'Wydarzenie usunięto z kalendarza \':name\'.',
        'edit'      => [
            'success'   => 'Zmieniono wydarzenie w kalendarzu.',
            'title'     => 'Aktualizuj wydarzenie dla :name',
        ],
        'helpers'   => [
            'add'               => 'Dodaj istniejące wydarzenie do tego kalendarza.',
            'new'               => 'Albo stwórz nowe wydarzenie po prostu podając jego nazwę.',
            'other_calendar'    => 'Edytujesz ważną datę zapisaną w kalendarzu :calendar.',
        ],
        'modal'     => [
            'title' => 'Dodaj wydarzenie do kalendarza',
        ],
        'success'   => 'Dodano do kalendarza wydarzenie \':event\'.',
    ],
    'events'        => [
        'title' => 'Wydarzenia w kalendarzu :name',
    ],
    'fields'        => [
        'calendar'              => 'Kalendarz źródłowy',
        'calendars'             => 'Kalendarze pochodne',
        'colour'                => 'Kolor',
        'comment'               => 'Opis',
        'current_day'           => 'Obecny dzień',
        'current_month'         => 'Obecny miesiąc',
        'current_year'          => 'Obecny rok',
        'date'                  => 'Obecna data',
        'day'                   => 'Dzień',
        'has_leap_year'         => 'Ma lata przestępne',
        'intercalary'           => 'Dni dodatkowe',
        'is_incrementing'       => 'Upływ czasu',
        'is_recurring'          => 'Cykliczne',
        'leap_year_amount'      => 'Dodaj dni',
        'leap_year_month'       => 'Miesiąca',
        'leap_year_offset'      => 'Każdego',
        'leap_year_start'       => 'Rok przestępny',
        'length'                => 'Długość wydarzenia',
        'length_days'           => ':count dzień|:count dni',
        'month'                 => 'Miesiąc',
        'months'                => 'Miesiące',
        'moons'                 => 'Księżyce',
        'name'                  => 'Nazwa',
        'parameters'            => 'Paramtery',
        'recurring_periodicity' => 'Powtarzaj co',
        'recurring_until'       => 'Powtarzaj do roku',
        'reset'                 => 'Odnawianie tygodni',
        'seasons'               => 'Pory roku',
        'start_offset'          => 'Przesunięcie rozpoczęcia',
        'suffix'                => 'Oznaczenie',
        'type'                  => 'Rodzaj',
        'week_names'            => 'Tygodnie specjalne',
        'weekdays'              => 'Dni tygodnia',
        'year'                  => 'Rok',
    ],
    'helpers'       => [
        'month_type'    => 'Miesiące dodatkowe nie mają dni tygodnia, ale wpływają na pory roku czy fazy księżyca.',
        'nested_parent' => 'Wyświetlono kalendarze pochodzące od :parent.',
        'nested_without'=> 'Wyświetlono wszystkie kalendarze nie posiadające źródła. Kliknij na rząd, by wyświetlić kalendarze pochodne.',
        'start_offset'  => 'Domyślnie kalendarz zaczyna się pierwszego dnia roku 0. Liczba w tym polu zmienia położenie pierwszego dnia kalendarza.',
    ],
    'hints'         => [
        'event_length'      => 'Czas trwania wydarzenia. Nie może być dłuższy, niż dwa miesiące.',
        'intercalary'       => 'Dni, których nie wlicza się do miesięcy oraz tygodni. Wpływają jednak na fazy księżyca.',
        'is_incrementing'   => 'Kalendarze, którym zaznaczono tę opcję, automatycznie przesuwają w przód datę każdego dnia o 00:00 UTC.',
        'is_recurring'      => 'Wydarzenie może być cykliczne. Nastąpi wówczas tego samego dnia każdego kolejnego roku.',
        'months'            => 'Kalendarz powinien mieć co najmniej 2 miesiące.',
        'moons'             => 'Dodanie księżyca spowoduje, że w kalendarzu wyświetlana będzie każda pełnia i nów. Jeżeli cykl księżycowy jest dłuższy niż 10 dni, pojawią się też informacje o pierwszej i trzeciej kwadrze.',
        'parent_calendar'   => 'W kalendarzu pojawiają się wszystkie wydarzenia oraz efekty pogody z wybranego kalendarza źródłowego.',
        'reset'             => 'Każdy miesiąc lub rok zaczyna się zawsze od pierwszego dnia tygodnia.',
        'seasons'           => 'By dodać porę roku wystarczy określić, kiedy się zaczyna. Kanka obliczy resztę.',
        'weekdays'          => 'Określ nazwy dni tygodnia. Tydzień musi mieć przynajmniej 2 dni.',
        'weeks'             => 'Nadaj nazwy szczególnie ważnym tygodniom tego kalendarza.',
        'years'             => 'Niektóre lata są tak ważne, że posiadają własne nazwy.',
    ],
    'index'         => [
        'add'       => 'Nowy kalendarz',
        'header'    => 'Kalendarze elementu :name',
        'title'     => 'Kalendarze',
    ],
    'layouts'       => [
        'month' => 'Miesiąc',
        'year'  => 'Rok',
    ],
    'modals'        => [
        'switcher'  => [
            'title' => 'Przełącznik lat',
        ],
    ],
    'month_types'   => [
        'intercalary'   => 'Dodatkowy',
        'standard'      => 'Zwykły',
    ],
    'options'       => [
        'events'    => [
            'recurring_periodicity' => [
                'fullmoon'      => 'Pełnia',
                'fullmoon_name' => 'Pełnia księżyca :moon',
                'month'         => 'Co miesiąc',
                'newmoon'       => 'Nów',
                'newmoon_name'  => 'Nów księżyca :moon',
                'none'          => 'Brak',
                'unnamed_moon'  => 'Księżyc :number',
                'year'          => 'Co rok',
            ],
        ],
        'resets'    => [
            ''      => 'Nie',
            'month' => 'Miesiące',
            'year'  => 'Lata',
        ],
    ],
    'panels'        => [
        'intercalary'   => 'Dni dodatkowe',
        'leap_year'     => 'Rok przestępny',
        'months'        => 'Miesiące',
        'weeks'         => 'Tygodnie',
        'years'         => 'Lata specjalne',
    ],
    'parameters'    => [
        'intercalary'   => [
            'length'    => 'Długość w dniach',
            'month'     => 'Po którym miesiącu',
            'name'      => 'Nazwa okresu dodatkowego',
        ],
        'month'         => [
            'alias' => 'Skrót nazwy',
            'length'=> 'Dni',
            'name'  => 'Nazwa miesiąca',
            'type'  => 'Rodzaj',
        ],
        'moon'          => [
            'fullmoon'  => 'Pełnia co ile dni?',
            'name'      => 'Nazwa księżyca',
            'offset'    => 'Opóźnienie pierwszej pełni',
        ],
        'seasons'       => [
            'day'   => 'Dzień rozpoczęcia',
            'month' => 'Miesiąc rozpoczęcia',
            'name'  => 'Nazwa pory roku',
        ],
        'weeks'         => [
            'name'      => 'Nazwa tygodnia',
            'number'    => 'Numer',
        ],
        'year'          => [
            'name'      => 'Nazwa roku',
            'number'    => 'Data',
        ],
    ],
    'placeholders'  => [
        'colour'            => 'Kolor',
        'comment'           => 'Urodziny, święto, przesilenie',
        'date'              => 'Obecna data',
        'leap_year_amount'  => 'Liczba dodatkowych dni roku przestępnego',
        'leap_year_month'   => 'Miesiąc, do którego są dodane',
        'leap_year_offset'  => 'Co ile lat rok jest przestępny',
        'leap_year_start'   => 'Który rok jest przestępny jako pierwszy',
        'length'            => 'Długość wydarzenia w dniach',
        'months'            => 'Liczba miesięcy w roku',
        'name'              => 'Nazwa kalendarza',
        'recurring_until'   => 'Ostatni rok cyklu (zostaw puste, jeżeli cykl ma trwać bez końca)',
        'seasons'           => 'Liczba pór roku',
        'suffix'            => 'Skrót nazwy obecnej epoki (AD, p.n.e.)',
        'type'              => 'Rodzaj kalendarza',
        'weekdays'          => 'Liczba dni w tygodniu',
    ],
    'show'          => [
        'missing_details'   => 'Nie można wyświetlić kalendarza. Do poprawnego wyświetlania niezbędne są przynajmniej 2 miesiące posiadające po 2 dni tygodnia.',
        'moon_full_moon'    => ':moon Pełnia',
        'moon_new_moon'     => ':moon Nów',
        'moon_waning_moon'  => ':moon Ubywa',
        'moon_waxing_moon'  => ':moon Przybywa',
        'tabs'              => [
            'events'        => 'Wydarzenia w kalendarzu',
            'information'   => 'Informacje',
            'weather'       => 'Pogoda',
        ],
        'title'             => 'Kalendarz :name',
    ],
    'sorters'       => [
        'after' => 'Dziś i wcześniej',
        'before'=> 'Dziś i później',
    ],
];
