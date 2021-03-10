<?php

return [
    'create'        => [
        'description'   => 'Kreiraj novi događaj',
        'success'       => 'Kreiran događaj ":name"',
        'title'         => 'Novi događaj',
    ],
    'destroy'       => [
        'success'   => 'Uklonjen događaj ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažuriran događaj ":name".',
        'title'     => 'Uredi događaj :name',
    ],
    'events'        => [
        'title' => 'Događaji događaja :name',
    ],
    'fields'        => [
        'date'      => 'Datum',
        'event'     => 'Roditeljski događaj',
        'events'    => 'Događaji',
        'image'     => 'Slika',
        'location'  => 'Lokacija',
        'name'      => 'Naziv',
        'type'      => 'Tip',
    ],
    'helpers'       => [
        'date'      => 'Ovo polje može sadržavati bilo što i nije povezano s kalendarima kampanje. Da bi ovaj događaj bio povezan s kalendarom, dodaj ga u kalendar ili na karticu podsjetnika ovog događaja.',
        'nested'    => 'Prikazani su događaji bez roditeljskog događaja prema zadanim postavkama. Kliknite redak događaja za prikaz njegovog potomstva.',
    ],
    'index'         => [
        'add'           => 'Novi događaj',
        'description'   => 'Upravljanje događajima u :name',
        'header'        => 'Događaji :name',
        'title'         => 'Događaji',
    ],
    'placeholders'  => [
        'date'      => 'Datum za događaj',
        'location'  => 'Odaberi lokaciju',
        'name'      => 'Naziv događaja',
        'type'      => 'Ceremonija, Festival, Nesreća, Bitka, Rođenje',
    ],
    'show'          => [
        'description'   => 'Detaljan opis događaja',
        'tabs'          => [
            'information'   => 'Informacije',
        ],
        'title'         => 'Događaj :name',
    ],
    'tabs'          => [
        'calendars' => 'Unosi kalendara',
    ],
];
