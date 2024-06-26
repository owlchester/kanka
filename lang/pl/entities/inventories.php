<?php

return [
    'actions'       => [
        'add'   => 'Dodaj przedmiot',
    ],
    'create'        => [
        'success'   => 'Dodano :item do elementu :entity.',
        'title'     => 'Dodaj przedmiot dla :name',
    ],
    'destroy'       => [
        'success'   => 'Usunięto przedmiot :item elementu :entity.',
    ],
    'fields'        => [
        'amount'        => 'Ilość',
        'description'   => 'Opis',
        'is_equipped'   => 'Wyposażono',
        'name'          => 'Nazwa',
        'position'      => 'Umiejscowienie',
        'qty'           => 'Ilość',
    ],
    'helpers'       => [
        'is_equipped'   => 'Zaznacza przedmiot jako wyposażony.',
    ],
    'placeholders'  => [
        'amount'        => 'Dowolna ilość',
        'description'   => 'Używany, uszkodzony, przystosowany',
        'name'          => 'Wymagana jeżeli nie wybrano przedmiotu z listy',
        'position'      => 'Pod ręką, w plecaku, w skrzyni, w banku',
    ],
    'show'          => [
        'helper'    => 'Elementom można przypisywać przedmioty, tworząc ich ekwipunek.',
        'title'     => 'Ekwipunek elementu :name',
        'unsorted'  => 'Nieposortowanie',
    ],
    'tutorial'      => 'Kontroluj stan posiadania elementu, dodając przedmioty do jego wyposażenia.',
    'update'        => [
        'success'   => 'Zaktualizowano przedmiot :item elementu :entity',
        'title'     => 'Zaktualizowano przedmiot u :name',
    ],
];
