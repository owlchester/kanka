<?php

return [
    'actions'       => [
        'add_appearance'    => 'Dodaj cechę wyglądu',
        'add_organisation'  => 'Dodaj organizację',
        'add_personality'   => 'Dodaj cechę osobowości',
    ],
    'conversations' => [
        'description'   => 'Konwersacje, w których uczestniczy ta postać.',
        'title'         => 'Konwersacje postaci :name',
    ],
    'create'        => [
        'description'   => 'Dodaj nową postać',
        'success'       => 'Stworzono postać \':name\'.',
        'title'         => 'Nowa postać',
    ],
    'destroy'       => [
        'success'   => 'Usunięto postać \':name\'.',
    ],
    'dice_rolls'    => [
        'description'   => 'Rzuty kośćmi, przypisane tej postaci.',
        'hint'          => 'Postaci można przypisać rodzaj rzutów kośćmi, wykonywanych w grze.',
        'title'         => 'Rzuty kośćmi postaci :name',
    ],
    'edit'          => [
        'description'   => 'Edytuj postać',
        'success'       => 'Zmieniono postać \':name\'.',
        'title'         => 'Edycja postaci :name',
    ],
    'fields'        => [
        'age'                       => 'Wiek',
        'family'                    => 'Rodzina',
        'image'                     => 'Portret',
        'is_dead'                   => 'Nie żyje',
        'is_personality_visible'    => 'Osobowość jawna',
        'life'                      => 'Życie',
        'location'                  => 'Miejsce',
        'name'                      => 'Nazwa',
        'physical'                  => 'Powierzchowność',
        'pronouns'                  => 'Rodzaj gramatyczny',
        'race'                      => 'Rasa',
        'relation'                  => 'Relacje',
        'sex'                       => 'Płeć',
        'title'                     => 'Tytuł',
        'traits'                    => 'Opis',
        'type'                      => 'Rodzaj',
    ],
    'helpers'       => [
        'age'   => 'Możesz też połączyć ten element z kalendarzem kampanii, by automatycznie obliczyć wiek. :more',
    ],
    'hints'         => [
        'is_dead'                   => 'Ta postać jest martwa',
        'is_personality_visible'    => 'Odznacz by ukryć cały opis osobowości przed użytkownikami niebędących administratorami.',
        'personality_not_visible'   => 'Opis osobowości widoczny wyłącznie dla administratorów.',
        'personality_visible'       => 'Opis osobowości widoczny dla wszystkich.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Nowa losowa postać',
        ],
        'add'           => 'Nowa postać',
        'description'   => 'Zarządzaj postaciami elementu :name',
        'header'        => 'Postaci w :name',
        'title'         => 'Postaci',
    ],
    'items'         => [
        'description'   => 'Przedmioty w posiadaniu postaci.',
        'hint'          => 'Postaci można przypisać przedmioty - będą wyświetlane tutaj.',
        'title'         => 'Przedmioty postaci :name',
    ],
    'journals'      => [
        'description'   => 'Dzienniki autorstwa tej postaci.',
        'title'         => 'Dzienniki postaci :name',
    ],
    'maps'          => [
        'description'   => 'Mapa relacji tej postaci.',
        'title'         => 'Mapa relacji postaci :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Dodaj organizację',
        ],
        'create'        => [
            'description'   => 'Powiąż postać z organizacją',
            'success'       => 'Postać dodana do organizacji',
            'title'         => 'Nowa organizacja dla :name',
        ],
        'description'   => 'Organizacje, do których należy postać.',
        'destroy'       => [
            'success'   => 'Postać usunięta z organizacji',
        ],
        'edit'          => [
            'description'   => 'Aktualizuj przynależność do organizacji',
            'success'       => 'Zaktualizowano organizacje postaci.',
            'title'         => 'Aktualizuj organizacje dla :name',
        ],
        'fields'        => [
            'organisation'  => 'Organizacja',
            'role'          => 'Rola',
        ],
        'hint'          => 'Postaci mogą należeć do wielu organizacji. Oznaczaj w tej sposób, dla kogo pracują albo do jakich tajnych sprzysiężeń należą.',
        'placeholders'  => [
            'organisation'  => 'Wybierz organizację...',
        ],
        'title'         => 'Organizacje postaci :name',
    ],
    'placeholders'  => [
        'age'               => 'Wiek',
        'appearance_entry'  => 'Opis',
        'appearance_name'   => 'Włosy, oczy, kolor skóry, wzrost',
        'family'            => 'Wybierz postać',
        'image'             => 'Portret',
        'location'          => 'Wybierz miejsce',
        'name'              => 'Imię (i nazwisko) postaci',
        'personality_entry' => 'Szczegóły',
        'personality_name'  => 'Pragnienia, manieryzmy, obawy, więzi',
        'physical'          => 'Fizyczne',
        'pronouns'          => 'On/Jego, Ona/Jej, Ono/Jego',
        'race'              => 'Rasa',
        'sex'               => 'Płeć',
        'title'             => 'Tytuł',
        'traits'            => 'Opis',
        'type'              => 'Bohater Niezależny, Postać Gracza, bóstwo',
    ],
    'quests'        => [
        'description'   => 'Misje, które postać wykonuje.',
        'helpers'       => [
            'quest_giver'   => 'Misje, które postać zleciła.',
            'quest_member'  => 'Misje, w których postać się pojawia.',
        ],
        'title'         => 'Misje postaci :name',
    ],
    'sections'      => [
        'appearance'    => 'Wygląd',
        'general'       => 'Informacje podstawowe',
        'personality'   => 'Osobowość',
    ],
    'show'          => [
        'description'   => 'Szczegółowy opis postaci',
        'tabs'          => [
            'conversations' => 'Konwersacje',
            'dice_rolls'    => 'Rzuty kośćmi',
            'items'         => 'Przedmioty',
            'journals'      => 'Dzienniki',
            'map'           => 'Mapa relacji',
            'organisations' => 'Organizacje',
            'personality'   => 'Osobowość',
            'quests'        => 'Misje',
        ],
        'title'         => 'Postać :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Nie masz uprawnień do edycji osobowości tej postaci.',
    ],
];
