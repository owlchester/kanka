<?php

return [
    'create'        => [
        'success'       => 'Händelse \':name\' skapad.',
        'title'         => 'Ny Händelse',
    ],
    'destroy'       => [
        'success'   => 'Händelse \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Händelse \':name\' uppdaterad.',
        'title'     => 'Redigera Händelse :name',
    ],
    'fields'        => [
        'date'      => 'Datum',
        'image'     => 'Bild',
        'location'  => 'Plats',
        'name'      => 'Namn',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'date'  => 'Detta fält kan innehålla vad som helst och är inte länkat till kampanjens kalender. För att länka denna händelse med en kalender, gå och lägg till den på kalendern eller på påminnelser fliken för denna händelse.',
    ],
    'index'         => [
        'add'           => 'Ny Händelse',
        'header'        => 'Händelser för :name',
        'title'         => 'Händelser',
    ],
    'placeholders'  => [
        'date'      => 'Ett datum för din händelse',
        'location'  => 'Välj en plats',
        'name'      => 'Namn på händelsen',
        'type'      => 'Ceremoni, Festival, Katastrof, Strid, Födelse',
    ],
    'show'          => [
        'tabs'          => [
        ],
        'title'         => 'Händelse :name',
    ],
    'tabs'          => [
        'calendars' => 'Kalender Noteringar',
    ],
];
