<?php

return [
    'create'        => [
        'description'   => 'Vytvoriť novú udalosť',
        'success'       => 'Udalosť :name vytvorená.',
        'title'         => 'Nová udalosť',
    ],
    'destroy'       => [
        'success'   => 'Udalosť :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Udalosť :name upravená.',
        'title'     => 'Upraviť udalosť :name',
    ],
    'events'        => [
        'title' => 'Udalosti podradené :name',
    ],
    'fields'        => [
        'date'      => 'Dátum',
        'event'     => 'Nadradená udalosť',
        'events'    => 'Udalosti',
        'image'     => 'Obrázok',
        'location'  => 'Miesto',
        'name'      => 'Názov',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'date'          => 'Toto pole môže obsahovať čokoľvek a nie je prepojené s kalendármi kampane. Na zobrazenie tejto udalosti v kalendári je nutné ju pridať do kalendára alebo do karty Pripomienky tejto udalosti.',
        'nested'        => 'Štandardne sa zobrazia udalosti bez nadradenej. Kliknutím na riadok udalosti zobrazíš jej podradené.',
        'nested_parent' => 'Zobraziť udalosti :parent.',
        'nested_without'=> 'Zobraziť všetky udalosti, ktoré nemajú nadradenú udalosť. Kliknutím na riadok zobrazíš podradené udalosti.',
    ],
    'index'         => [
        'add'           => 'Nová udalosť',
        'description'   => 'Spravuj udalosti objektu :name.',
        'header'        => 'Udalosti objektu :name',
        'title'         => 'Udalosti',
    ],
    'placeholders'  => [
        'date'      => 'Dátum tvojej udalosti',
        'location'  => 'Vyber si miesto',
        'name'      => 'Názov udalosti',
        'type'      => 'ceremónia, festival, katastrofa, bitva, narodenie',
    ],
    'show'          => [
        'description'   => 'Detailný popis udalosti',
        'tabs'          => [
            'information'   => 'Informácie',
        ],
        'title'         => 'Udalosť :name',
    ],
    'tabs'          => [
        'calendars' => 'Záznamy v kalendári',
    ],
];
