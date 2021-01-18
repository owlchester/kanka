<?php

return [
    'actions'       => [
        'add'   => 'Lägg till ny era',
    ],
    'create'        => [
        'success'   => 'Era :name skapad.',
        'title'     => 'Ny Era',
    ],
    'delete'        => [
        'success'   => 'Era :name borttagen.',
    ],
    'edit'          => [
        'success'   => 'Era :name uppdaterad.',
        'title'     => 'Redigera Era :name',
    ],
    'fields'        => [
        'abbreviation'  => 'Förkortning',
        'end_year'      => 'Slut år',
        'start_year'    => 'Start år',
    ],
    'helpers'       => [
        'eras'      => 'Tidslinjen behöver vara skapad före eror kan läggas till till den.',
        'primary'   => 'Separera din tidslinje i eror. En tidslinje behöver åtminstone en era för att fungera ordentligt.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'AD, BC, BCE',
        'end_year'      => 'År som eran slutar. Lämna blank om detta är nuvarande era.',
        'name'          => 'Moderna Eran, Bronsåldern, Galaktiska Krigen',
        'start_year'    => 'År eran startar. Lämna blank om detta är första eran.',
    ],
    'reorder'       => [
        'success'   => 'Element av :era erans ordning ändrad.',
    ],
];
