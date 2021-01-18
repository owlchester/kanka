<?php

return [
    'actions'       => [
        'add'   => 'Lägg till Föremål',
    ],
    'create'        => [
        'success'   => 'Föremål :item tillagt till :entity.',
        'title'     => 'Lägg till ett Föremål till :name',
    ],
    'destroy'       => [
        'success'   => 'Föremål :item borttaget från :entity.',
    ],
    'fields'        => [
        'amount'        => 'Mängd',
        'description'   => 'Beskrivning',
        'is_equipped'   => 'Använder',
        'name'          => 'Namn',
        'position'      => 'Position',
    ],
    'placeholders'  => [
        'amount'        => 'Valfri mängd',
        'description'   => 'Använd, Skadad, Van Vid',
        'name'          => 'Obligatorisk om inget föremål är valt',
        'position'      => 'Används, Ryggsäck, Förvaring, Bank',
    ],
    'show'          => [
        'helper'    => 'Entiteter lan ha föremål fästa till dem för att skapa ett inventarium.',
        'title'     => 'Entitet :name inventarier.',
        'unsorted'  => 'Osorterad',
    ],
    'update'        => [
        'success'   => 'Föremål :item uppdaterad för :entity.',
        'title'     => 'Uppdatera ett föremål på :name',
    ],
];
