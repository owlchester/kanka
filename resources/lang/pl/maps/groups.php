<?php

return [
    'actions'       => [
        'add'   => 'Dodaj nową kategorię',
    ],
    'create'        => [
        'success'   => 'Stworzono kategorię :name.',
        'title'     => 'Nowa kategoria',
    ],
    'delete'        => [
        'success'   => 'Usunięto kategorię :name.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono kategorię :name.',
        'title'     => 'Edycja kategorii :name',
    ],
    'fields'        => [
        'is_shown'  => 'Pokaż kategorię znaczników',
        'position'  => 'Kolejność',
    ],
    'helper'        => [
        'amount'            => 'Znacznik można przypisać do kategorii, co pozwala na przykład wyświetlić albo ukryć wszystkie sklepy w mieście. Mapa może posiadać do :amount kategorii.',
        'boosted_campaign'  => 'Mapa :boosted może zawierać do :amount kategorii.',
    ],
    'hints'         => [
        'is_shown'  => 'Zaznacz, by ta kategoria znaczników wyświetlała się na mapie domyślnie.',
    ],
    'placeholders'  => [
        'name'      => 'Sklepy, skarby, BNi.',
        'position'  => 'Pole opcjonalne, pozwala ustalić kolejność w której pojawiają się kategorie.',
    ],
];
