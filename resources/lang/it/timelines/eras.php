<?php

return [
    'actions'       => [
        'add'   => 'Aggiungi una nuova era',
    ],
    'create'        => [
        'success'   => 'Era :name creata.',
        'title'     => 'Nuova era',
    ],
    'delete'        => [
        'success'   => 'Era :name rimossa.',
    ],
    'edit'          => [
        'success'   => 'Era :name aggiornata.',
        'title'     => 'Modifica Era :name',
    ],
    'fields'        => [
        'abbreviation'  => 'Abbreviazione',
        'end_year'      => 'Anno finale',
        'is_collapsed'  => 'Ridotta',
        'start_year'    => 'Anno iniziale',
    ],
    'helpers'       => [
        'eras'          => 'La linea temporale deve essere creata prima delle ere.',
        'is_collapsed'  => 'L\'era è ridotta per impostazione predefinita.',
        'primary'       => 'Separa la tua linea temporale in ere. Una liena temporale deve avere almeno una era per funzionare correttamente.',
    ],
    'placeholders'  => [
        'abbreviation'  => 'a.C., d.C., BCE',
        'end_year'      => 'Anno in cui l\'era finisce. Lasciare vuoto se l\'era è in corso.',
        'name'          => 'Età Moderna, Età del Bronzo, Guerre Galattiche',
        'start_year'    => 'Anno in cui l\'era comincia. Lasciare vuoto se questa è la prima era.',
    ],
    'reorder'       => [
        'success'   => 'Elementi dell\'era :era riordinati.',
    ],
];
