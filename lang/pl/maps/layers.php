<?php

return [
    'actions'       => [
        'add'   => 'Dodaj nową warstwę',
    ],
    'base'          => 'Warstwa podstawowa',
    'bulks'         => [
        'delete'    => '{1} Usunięto :count warstwę.|[2,3,4] Usunięto :count warstwy.|[5,*] Usunięto :count warstw.',
        'patch'     => '{1} Zmieniono :count warstwę.|[2,3,4] Zmieniono :count warstwy.|[5,*] Zmieniono :count warstw.',
    ],
    'create'        => [
        'success'   => 'Stworzono warstwę :name.',
        'title'     => 'Nowa warstwa',
    ],
    'delete'        => [
        'success'   => 'Usunięto warstwę :name.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono warstwę :name.',
        'title'     => 'Edycja warstwy :name',
    ],
    'fields'        => [
        'position'  => 'Kolejność',
        'type'      => 'Rodzaj warstwy',
    ],
    'helper'        => [
        'amount_v2' => 'Dodawaj do mapy warstwy by zmieniać ilustrację wyświetlaną pod znacznikami.',
        'is_real'   => 'Podczas używania OpenStreetMaps warstwy są niedostępne.',
    ],
    'index'         => [
        'title' => 'Warstwy mapy :name',
    ],
    'pitch'         => [],
    'placeholders'  => [
        'name'          => 'Podziemia, poziom 2, wrak statku',
        'position'      => 'Pole opcjonalne, pozwala ustalić kolejność wyświetlania warstw.',
        'position_list' => 'Po :name',
    ],
    'reorder'       => [
        'save'      => 'Zapisz nową koleność',
        'success'   => '{1} Przesunięto :count warstwę.|[2,3,4] Przesunięto :count warstwy.|[5,*] Przesunięto :count warstw.',
        'title'     => 'Zmień kolejność warstw',
    ],
    'short_types'   => [
        'overlay'       => 'Nakładka',
        'overlay_shown' => 'Nakładka (pokazuj domyślnie)',
        'standard'      => 'Standardowa',
    ],
    'types'         => [
        'overlay'       => 'Nakładka (wyświetlaj nad aktywną warstwą)',
        'overlay_shown' => 'Nakładka wyświetlana domyślnie',
        'standard'      => 'Warstwa standardowa (do przełączania)',
    ],
];
