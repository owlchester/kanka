<?php

return [
    'actions'       => [
        'add_appearance'    => 'Dodaj cechę wyglądu',
        'add_personality'   => 'Dodaj cechę osobowości',
    ],
    'conversations' => [],
    'create'        => [
        'title' => 'Nowa postać',
    ],
    'destroy'       => [],
    'dice_rolls'    => [],
    'edit'          => [],
    'families'      => [
        'helper'    => 'Pozwala zmienić kolejność i określić, które rodziny :name będą widoczne lub ukryte dla nie-administratorów.',
        'reorder'   => [
            'success'   => 'Zmieniono rodziny postaci.',
        ],
        'title2'    => 'Zarządzaj rodzinami',
    ],
    'fields'        => [
        'age'                       => 'Wiek',
        'is_appearance_pinned'      => 'Przypnij wygląd',
        'is_dead'                   => 'Nie żyje',
        'is_personality_pinned'     => 'Przypnij osobowość',
        'is_personality_visible'    => 'Osobowość jawna',
        'life'                      => 'Życie',
        'physical'                  => 'Powierzchowność',
        'pronouns'                  => 'Rodzaj gramatyczny',
        'sex'                       => 'Płeć',
        'title'                     => 'Tytuł',
        'traits'                    => 'Opis',
    ],
    'helpers'       => [
        'age'                   => 'Możesz też połączyć ten element z kalendarzem kampanii, by automatycznie obliczyć wiek. :more',
        'personality_visible'   => 'Po zaznaczeniu cechy osobowości będą widoczne dla każdego. W przeciwnym razie widzieć je będą tylko posiadacze roli :admin.',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Zaznacz, by cechy wyglądu postaci wyświetlane były w widoku podstawowym.',
        'is_dead'                   => 'Ta postać jest martwa',
        'is_personality_pinned'     => 'Zaznacz, by cechy osobowości postaci wyświetlane były w widoku podstawowym.',
        'is_personality_visible'    => 'Odznacz by ukryć cały opis osobowości przed użytkownikami niebędących administratorami.',
        'personality_not_visible'   => 'Opis osobowości widoczny wyłącznie dla administratorów.',
        'personality_visible'       => 'Opis osobowości widoczny dla wszystkich.',
    ],
    'index'         => [],
    'items'         => [],
    'journals'      => [],
    'labels'        => [
        'appearance'    => [
            'entry' => 'Opis cechy wyglądu',
            'name'  => 'Nazwa cechy wyglądu',
        ],
        'personality'   => [
            'entry' => 'Opis cechy osobowości',
            'name'  => 'Nazwa cechy osobowości',
        ],
    ],
    'lists'         => [
        'empty' => 'Stwórz pierwszego bohatera, łotra albo szarego mieszkańca powstającego świata.',
    ],
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => 'Postać dodana do organizacji',
            'title'     => 'Nowa organizacja dla :name',
        ],
        'destroy'   => [
            'success'   => 'Postać usunięta z organizacji',
        ],
        'edit'      => [
            'success'   => 'Zaktualizowano organizacje postaci.',
            'title'     => 'Aktualizuj organizacje dla :name',
        ],
        'fields'    => [
            'role'  => 'Rola',
        ],
    ],
    'placeholders'  => [
        'age'               => 'Wiek',
        'appearance_entry'  => 'Opis',
        'appearance_name'   => 'Włosy, oczy, kolor skóry, wzrost',
        'name'              => 'Imię postaci',
        'personality_entry' => 'Szczegóły',
        'personality_name'  => 'Pragnienia, manieryzmy, obawy, więzi',
        'physical'          => 'Fizyczne',
        'pronouns'          => 'On/Jego, Ona/Jej, Ono/Jego',
        'sex'               => 'Płeć',
        'title'             => 'Tytuł',
        'traits'            => 'Opis',
        'type'              => 'Bohater Niezależny, Postać Gracza, bóstwo',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Zadania, które postać zleciła.',
            'quest_member'  => 'Zadania, w których postać się pojawia.',
        ],
    ],
    'races'         => [
        'helper'    => 'Pozwala zmienić kolejność i określić, które rasy :name będą widoczne lub ukryte dla nie-administratorów.',
        'reorder'   => [
            'success'   => 'Zmieniono rasy postaci.',
        ],
        'title2'    => 'Zarządzaj rasami',
    ],
    'sections'      => [
        'appearance'    => 'Wygląd',
        'personality'   => 'Osobowość',
    ],
    'show'          => [],
    'warnings'      => [
        'personality_hidden'    => 'Nie masz uprawnień do edycji osobowości tej postaci.',
    ],
];
