<?php

return [
    'actions'       => [
        'add'   => 'Lägg till ett nytt lager',
    ],
    'base'          => 'Grundlager',
    'create'        => [
        'success'   => 'Lager :name skapat.',
        'title'     => 'Nytt Lager',
    ],
    'delete'        => [
        'success'   => 'Lager :name borttaget.',
    ],
    'edit'          => [
        'success'   => 'Lager :name uppdaterat.',
        'title'     => 'Redigera Lager :name',
    ],
    'fields'        => [
        'position'  => 'Position',
        'type'      => 'Lager typ',
    ],
    'helper'        => [
        'amount'            => 'Du kan lägga till upp till :amount lager till en karta för att byta bakgrundsbilden som visas under dina markörer.',
        'boosted_campaign'  => ':boosted kan ha upp till :amount lager.',
    ],
    'placeholders'  => [
        'name'      => 'Underjorden, Nivå 2, Skeppsvrak',
        'position'  => 'Valfritt fält för att bestämma ordningen som lager visas i.',
    ],
    'short_types'   => [
        'overlay'       => 'Overlay',
        'overlay_shown' => 'Overlay (visa automatiskt)',
        'standard'      => 'Standard',
    ],
    'types'         => [
        'overlay'       => 'Overlay (visad över det aktiva lagret)',
        'overlay_shown' => 'Overlay att visa som standard',
        'standard'      => 'Standard lager (växla mellan lager)',
    ],
];
