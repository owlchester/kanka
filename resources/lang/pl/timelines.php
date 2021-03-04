<?php

return [
    'actions'       => [
        'add_element'   => 'Dodaj do epoki :era',
        'back'          => 'Powrót do :name',
        'edit'          => 'Edytuj historię',
        'reorder'       => 'Zmień kolejność',
        'save_order'    => 'Zapisz nową kolejność',
    ],
    'create'        => [
        'success'   => 'Stworzono historię \':name\'.',
        'title'     => 'Nowa historia',
    ],
    'destroy'       => [
        'success'   => 'Usunięto historię \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono historię \':name\'.',
        'title'     => 'Edycja historii :name',
    ],
    'fields'        => [
        'copy_eras'     => 'Kopiuj epoki',
        'eras'          => 'Epoki',
        'name'          => 'Nazwa',
        'reverse_order' => 'Odwróć kolejność epok',
        'timeline'      => 'Historia źródłowa',
        'timelines'     => 'Historie pochodne',
        'type'          => 'Rodzaj',
    ],
    'helpers'       => [
        'nested'            => 'W widoku hierarchii najpierw wyświetlane są historie, które nie mają źródła. Po kliknięciu na wiersz historii zobaczysz jej pochodne. Możesz schodzić niżej, póki nie skończą się poziomy hierarchii.',
        'reorder'           => 'Przeciągaj elementy epoki by zmieniać ich kolejność',
        'reorder_tooltip'   => 'Kliknij by włączyć ręczną zmianę kolejności poprzez przeciąganie elementów.',
        'reverse_order'     => 'Zaznacz by wyświetlać epoki w odwróconym porządku chronologicznym (od najdawniejszej)',
    ],
    'index'         => [
        'add'   => 'Nowa historia',
        'title' => 'Historie',
    ],
    'placeholders'  => [
        'name'  => 'Nazwa historii',
        'type'  => 'Główna, kronika dziejów świata, historia królestwa',
    ],
    'show'          => [
        'title' => 'Historia :name',
    ],
    'timelines'     => [
        'title' => 'Historie historii :name',
    ],
];
