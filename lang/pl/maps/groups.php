<?php

return [
    'actions'       => [
        'add'   => 'Dodaj nową kategorię',
    ],
    'bulks'         => [
        'delete'    => '{1} Usunięto :count kategorię.|[2,3,4] Usunięto :count kategorie.|[5,*] Usunięto :count kategorii.',
        'patch'     => '{1} Zmieniono :count kategorię.|[2,3,4] Zmieniono :count kategorie.|[5,*] Zmieniono :count kategorii.',
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
        'amount_v3' => 'Znaczniki można włączyć w kategorie. Podczas eksploracji mapy można potem zaznaczyć kategorię znaczników, by wyświetlić albo ukryć wszystkie należące do niej elementy.',
    ],
    'hints'         => [
        'is_shown'  => 'Zaznacz, by ta kategoria znaczników wyświetlała się na mapie domyślnie.',
    ],
    'index'         => [
        'title' => 'Kategorie mapy :name',
    ],
    'pitch'         => [],
    'placeholders'  => [
        'name'          => 'Sklepy, skarby, BNi.',
        'position'      => 'Pole opcjonalne, pozwala ustalić kolejność w której pojawiają się kategorie.',
        'position_list' => 'Po :name',
    ],
    'reorder'       => [
        'save'      => 'Zapisz nową kolejność',
        'success'   => '{1} Przesunięto :count kategorię.|[2,3,4] Przesunięto :count kategorie.|[5,*] Przesunięto :count kategorii.',
        'title'     => 'Zmień kolejność kategorii',
    ],
];
