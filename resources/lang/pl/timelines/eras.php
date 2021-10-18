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
        'is_collapsed'  => 'Zwinięta',
        'start_year'    => 'Rok rozpoczęcia',
    ],
    'helpers'       => [
        'eras'          => 'Przed dodaniem epok należy stworzyć historię.',
        'is_collapsed'  => 'Epoka domyślnie wyświetlana jest zwinięta (zminimalizowana).',
        'primary'       => 'Podziel historię na epoki. By historia działała poprawnie, musi posiadać przynajmniej jedną epokę.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'AD, PNE, 3E',
        'end_year'      => 'Rok zakończenia epoki. Pozostaw puste, jeżeli trwa obecnie.',
        'name'          => 'Nowoczesność, epoka brązu, wojny galaktyczne',
        'start_year'    => 'Rok rozpoczęcia epoki. Pozostaw puste, jeżeli to pierwsza epoka historii.',
    ],
    'reorder'       => [
        'success'   => 'Zmieniono kolejność elementów epoki :era.',
    ],
];
