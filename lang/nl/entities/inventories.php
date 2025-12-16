<?php

return [
    'actions'       => [],
    'create'        => [
        'success'   => 'Voorwerp :item toegevoegd aan :entity.',
        'title'     => 'Voeg een Voorwerp toe aan :name',
    ],
    'destroy'       => [
        'success'   => 'Voorwerp :item verwijderd van :entity',
    ],
    'fields'        => [
        'amount'        => 'Aantal',
        'description'   => 'Beschrijving',
        'is_equipped'   => 'Uitgerust',
        'name'          => 'Naam',
        'position'      => 'Positie',
    ],
    'placeholders'  => [
        'amount'        => 'Elk aantal',
        'description'   => 'Gebruikt, Beschadigd, Attuned',
        'name'          => 'Vereist als er geen voorwerp is geselecteerd',
        'position'      => 'Uitgerust, Rugzak, Opslag, Bank',
    ],
    'show'          => [
        'helper'    => 'Entiteiten kunnen voorwerpen hebben die eraan zijn gekoppeld om een inventory te maken.',
        'title'     => 'Entiteit :name Inventory',
        'unsorted'  => 'Ongesorteerd',
    ],
    'update'        => [
        'success'   => 'Voorwerp :item bijgewerkt voor :entity.',
        'title'     => 'Werk een voorwerp bij op :name',
    ],
];
