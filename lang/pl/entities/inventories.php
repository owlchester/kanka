<?php

return [
    'actions'           => [
        'copy_from_entity'  => 'Kopiuj z innego elementu',
        'copy_inventory'    => 'Kopiuj wyposażenie',
        'generate'          => 'Generuj',
        'multiple'          => 'Dodaj przedmioty',
    ],
    'copy'              => [
        'helper'    => 'Kopiuje całe wyposażenie elementu do :name.',
    ],
    'create'            => [
        'helper'        => 'Dodaje przedmiot do wyposażenia :name. Można też użyć przedmiotu już istniejącego w kampanii.',
        'success'       => 'Dodano :item do elementu :entity.',
        'success_bulk'  => '{0} Nie dodano przedmiotów do wyposażenia :entity.|{1} Dodano :count przedmiot do wyposażenia :entity.|[2,4] Dodano :count przedmioty do wyposażenia :entity.|5,] Dodano :count przedmiotów do wyposażenia :entity.',
        'title'         => 'Dodaj przedmiot dla :name',
    ],
    'default_position'  => 'Nieprzypisane',
    'destroy'           => [
        'success'           => 'Usunięto przedmiot :item elementu :entity.',
        'success_position'  => 'Usunięto przedmioty umieszczone w :position elementu :entity.',
    ],
    'fields'            => [
        'amount'                => 'Ilość',
        'copy_entity_entry_v2'  => 'Użyj opisu elementu',
        'description'           => 'Opis',
        'is_equipped'           => 'W użyciu',
        'item_amount'           => 'Liczba przedmiotów',
        'match_all'             => 'Użyj wszystkich etykiet',
        'name'                  => 'Nazwa',
        'position'              => 'Umiejscowienie',
        'qty'                   => 'Ilość',
        'replace'               => 'Zastąp wyposażenie',
    ],
    'generate'          => [
        'helper'    => 'Generuje wyposażenie dla :name w oparciu o przedmioty już używane w kampanii.',
        'title'     => 'Generowanie wyposażenia',
    ],
    'helpers'           => [
        'amount'                => 'Liczba przedmiotów',
        'copy_entity_entry_v2'  => 'Wyświetla główny opis elementu zamiast lokalnego.',
        'description'           => 'Dodaj lokalny opis przedmiotu',
        'is_equipped'           => 'Oznacza przedmioty, których element używa.',
        'name'                  => 'Nazwij przedmiot. To konieczne, jeśli nie wybrano istniejącego obiektu.',
        'replace'               => 'Zastępuje obecne wyposażenie wygenerowanym',
    ],
    'placeholders'      => [
        'amount'        => 'Dowolna ilość',
        'description'   => 'Używany, uszkodzony, przystosowany',
        'name'          => 'Wymagana jeżeli nie wybrano przedmiotu z listy',
        'position'      => 'Pod ręką, w plecaku, w skrzyni, w banku',
    ],
    'show'              => [
        'helper'    => 'Elementom można przypisywać przedmioty, tworząc ich wyposażenie.',
        'title'     => 'Wyposażenie elementu :name',
        'unsorted'  => 'Nieposortowanie',
    ],
    'togglers'          => [
        'hide'  => [
            'price'     => 'Ukryj cenę',
            'quantity'  => 'Ukryj ilość',
            'size'      => 'Ukryj rozmiar',
            'weight'    => 'Ukryj wagę',
        ],
        'show'  => [
            'price'     => 'Pokaż cenę',
            'quantity'  => 'Pokaż ilość',
            'size'      => 'Pokaż rozmiar',
            'weight'    => 'Pokaż wagę',
        ],
    ],
    'tooltips'          => [
        'equipped'  => 'Przedmiot jest w użyciu.',
    ],
    'tutorials'         => [
        'all'   => 'Śledzi, co :name posiada, przechowuje albo sprzedaje, dodając to do jego wyposażenia.',
    ],
    'update'            => [
        'success'   => 'Zaktualizowano przedmiot :item elementu :entity',
        'title'     => 'Zaktualizowano przedmiot u :name',
    ],
];
