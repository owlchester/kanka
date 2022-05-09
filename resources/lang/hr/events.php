<?php

return [
    'create'        => [
        'success'   => 'Kreiran događaj ":name"',
        'title'     => 'Novi događaj',
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
        'date'          => 'Ovo polje može sadržavati bilo što i nije povezano s kalendarima kampanje. Da bi ovaj događaj bio povezan s kalendarom, dodaj ga u kalendar ili na karticu podsjetnika ovog događaja.',
        'nested_parent' => 'Prikaz događaja od :parent.',
        'nested_without'=> 'Prikaz svih događaja koji nemaju događaj roditelj. Klikni redak da bi vidio/la događaje djecu.',
    ],
    'index'         => [
        'title' => 'Događaji',
    ],
    'placeholders'  => [
        'date'      => 'Datum za događaj',
        'location'  => 'Odaberi lokaciju',
        'name'      => 'Naziv događaja',
        'type'      => 'Ceremonija, Festival, Nesreća, Bitka, Rođenje',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Unosi kalendara',
    ],
];
