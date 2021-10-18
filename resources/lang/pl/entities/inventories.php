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
        'amount'            => 'Ilość',
        'copy_entity_entry' => 'Użyj opisu elementu',
        'description'       => 'Opis',
        'is_equipped'       => 'Wyposażono',
        'name'              => 'Nazwa',
        'position'          => 'Umiejscowienie',
        'qty'               => 'Ilość',
    ],
    'helpers'       => [
        'copy_entity_entry' => 'Wyświetla ogólny opis z menu przedmiotu zamiast szczegółowego',
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
    'update'        => [
        'success'   => 'Zaktualizowano przedmiot :item elementu :entity',
        'title'     => 'Zaktualizowano przedmiot u :name',
    ],
];
