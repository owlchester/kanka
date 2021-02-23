<?php

return [
    'actions'       => [
        'add'   => 'Dodaj nową epokę',
    ],
    'create'        => [
        'success'   => 'Stworzono epokę \':name\'.',
        'title'     => 'Nowa epoka',
    ],
    'delete'        => [
        'success'   => 'Usunięto epokę \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zmieniono epokę \':name\'.',
        'title'     => 'Edycja epoki :name',
    ],
    'fields'        => [
        'abbreviation'  => 'Skrót',
        'end_year'      => 'Rok zakończenia',
        'start_year'    => 'Rok rozpoczęcia',
    ],
    'helpers'       => [
        'eras'      => 'Przed dodaniem epok należy stworzyć chronologię.',
        'primary'   => 'Podziel chronologię na epoki. By chronologia działała poprawnie, musi posiadać przynajmniej jedną epokę.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'AD, PNE, 3E',
        'end_year'      => 'Rok zakończenia epoki. Pozostaw puste, jeżeli trwa obecnie.',
        'name'          => 'Nowoczesność, epoka brązu, wojny galaktyczne',
        'start_year'    => 'Rok rozpoczęcia epoki. Pozostaw puste, jeżeli to pierwsza epoka chronologii.',
    ],
    'reorder'       => [
        'success'   => 'Zmieniono kolejność elementów epoki :era.',
    ],
];
