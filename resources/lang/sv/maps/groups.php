<?php

return [
    'actions'       => [
        'add'   => 'Lägg till en ny grupp',
    ],
    'create'        => [
        'success'   => 'Grupp :name skapad.',
        'title'     => 'Ny Grupp',
    ],
    'delete'        => [
        'success'   => 'Grupp :name borttagen.',
    ],
    'edit'          => [
        'success'   => 'Grupp :name uppdaterad.',
        'title'     => 'Redigera Grupp :name',
    ],
    'fields'        => [
        'is_shown'  => 'Visa gruppmarkörer',
        'position'  => 'Position',
    ],
    'helper'        => [
        'amount'            => 'En markör kan läggas till i en grupp, vilket t.ex. låter dig visa eller dölja alla Butiker i en stad. En karta kan ha upp till :amount grupper.',
        'boosted_campaign'  => ':boosted kan ha upp till :amount grupper.',
    ],
    'hints'         => [
        'is_shown'  => 'Om ikryssad, gruppen visas som standard på kartan.',
    ],
    'placeholders'  => [
        'name'      => 'Butiker, Skatter, SLPer',
        'position'  => 'Valfritt fält för att bestämma ordningen som grupperna visas i.',
    ],
];
