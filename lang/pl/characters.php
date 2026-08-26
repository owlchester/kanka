<?php

return [
    'actions'                   => [
        'add_appearance'    => 'Dodaj właściwość wyglądu',
        'add_personality'   => 'Dodaj właściwość osobowości',
    ],
    'conversations'             => [],
    'create'                    => [
        'title' => 'Nowa postać',
    ],
    'destroy'                   => [],
    'dice_rolls'                => [],
    'edit'                      => [],
    'families'                  => [
        'helper'    => 'Pozwala zmienić kolejność i określić, które rodziny :name będą widoczne lub ukryte dla nie-administratorów.',
        'reorder'   => [
            'success'   => 'Zmieniono rodziny postaci.',
        ],
        'title2'    => 'Zarządzaj rodzinami',
    ],
    'fields'                    => [
        'age'                       => 'Wiek',
        'is_appearance_pinned'      => 'Prezentacja wyglądu',
        'is_dead'                   => 'Nie żyje',
        'is_personality_pinned'     => 'Prezentacja osobowości',
        'is_personality_visible'    => 'Dostęp do osobowości',
        'life'                      => 'Życie',
        'physical'                  => 'Powierzchowność',
        'pronouns'                  => 'Rodzaj gramatyczny',
        'sex'                       => 'Płeć',
        'status'                    => 'Status',
        'title'                     => 'Tytuł',
        'traits'                    => 'Właściwości',
    ],
    'helpers'                   => [
        'age'   => 'Możesz połączyć ten element z kalendarzem, by automatycznie obliczyć wiek. :more',
    ],
    'hints'                     => [
        'is_appearance_pinned'      => 'Wyświetlaj w widoku podstawowym.',
        'is_dead'                   => 'Ta postać jest martwa',
        'is_missing'                => 'Ta postać zaginęła.',
        'is_personality_visible'    => 'Osobowość postaci widoczna dla wszytkich, nie tylko posiadaczy roli :admin.',
        'personality_not_visible'   => 'Osobowość postaci widoczna wyłącznie dla administratorów.',
        'personality_visible'       => 'Osobowość postaci widoczna dla wszystkich.',
    ],
    'index'                     => [],
    'items'                     => [],
    'journals'                  => [],
    'labels'                    => [
        'appearance'    => [
            'entry' => 'Opis właściwości wyglądu',
            'name'  => 'Nazwa właściwości wyglądu',
        ],
        'personality'   => [
            'entry' => 'Opis właściwości osobowości',
            'name'  => 'Nazwa właściwości osobowości',
        ],
    ],
    'lists'                     => [
        'empty' => 'Stwórz pierwszego bohatera, łotra albo szarego mieszkańca powstającego świata.',
    ],
    'maps'                      => [],
    'organisations'             => [
        'create'    => [
            'success'   => ':character dodano do :organization.',
            'title'     => 'Członkostwo',
        ],
        'destroy'   => [
            'success'   => 'Usunięto członkostwo.',
        ],
        'edit'      => [
            'success'   => 'Zmieniono członkostwo.',
            'title'     => 'Aktualizuj organizacje dla :name',
        ],
        'fields'    => [
            'role'  => 'Rola',
        ],
    ],
    'personality_visibility'    => [
        'admin' => 'Tylko rola :admin',
        'all'   => 'Każdy może zobaczyć',
    ],
    'placeholders'              => [
        'age'               => 'Wiek',
        'appearance_entry'  => 'Szczegóły',
        'appearance_name'   => 'Włosy, oczy, kolor skóry, wzrost',
        'name'              => 'Imię postaci',
        'personality_entry' => 'Szczegóły',
        'personality_name'  => 'Pragnienia, manieryzmy, obawy, więzi',
        'physical'          => 'Fizyczne',
        'pronouns'          => 'On/Jego, Ona/Jej, Ono/Jego',
        'sex'               => 'Płeć',
        'title'             => 'Tytuł',
        'traits'            => 'Właściwości',
        'type'              => 'Bohater Niezależny, Postać Gracza, bóstwo',
    ],
    'quests'                    => [
        'helpers'   => [
            'quest_giver'   => 'Zadania, które postać zleciła.',
            'quest_member'  => 'Zadania, w których postać się pojawia.',
        ],
    ],
    'races'                     => [
        'helper'    => 'Pozwala zmienić kolejność i określić, które rasy :name będą widoczne lub ukryte dla nie-administratorów.',
        'reorder'   => [
            'success'   => 'Zmieniono rasy postaci.',
        ],
        'title2'    => 'Zarządzaj rasami',
    ],
    'sections'                  => [
        'appearance'    => 'Wygląd',
        'personality'   => 'Osobowość',
    ],
    'show'                      => [],
    'status'                    => [
        'alive'     => 'Nie żyje',
        'dead'      => 'Nie żyje',
        'missing'   => 'Zaginęła',
    ],
    'warnings'                  => [
        'personality_hidden'    => 'Nie masz uprawnień do edycji osobowości tej postaci.',
    ],
];
