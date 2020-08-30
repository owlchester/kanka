<?php

return [
    'create'        => [
        'success'   => 'Poveznica ":name" kreirana u izborniku.',
        'title'     => 'Nova poveznica izbornika',
    ],
    'destroy'       => [
        'success'   => 'Poveznica ":name" uklonjena iz izbornika.',
    ],
    'edit'          => [
        'success'   => 'Poveznica ":name" ažurirana u izborniku.',
        'title'     => 'Poveznica izbornika :name',
    ],
    'fields'        => [
        'entity'    => 'Entitet',
        'filters'   => 'Filteri',
        'menu'      => 'Izbornik',
        'name'      => 'Naziv',
        'position'  => 'Pozicija',
        'tab'       => 'Kartica',
        'type'      => 'Tip entiteta',
    ],
    'helpers'       => [
        'entity'    => 'Postavi ovu poveznicu izbornika tako da ide direktno na entitet. Polje :tab kontrolira koja kartica je fokusirana. Polje :menu kontrolira koja podstranica entiteta se otvara.',
        'position'  => 'Pomoću ovog polja možeš upravljati redoslijedom kojim se poveznice pojavljuju na izborniku.',
        'type'      => 'Postavi ovu poveznicu izbornika tako da vodi direktno na listu entiteta. Za filtriranje rezultata, kopiraj dijelove URL s filtrirane liste entiteta nakon znaka :? u polje :filter',
    ],
    'index'         => [
        'add'   => 'Nova poveznica izbornika',
        'title' => 'Poveznice izbornika',
    ],
    'placeholders'  => [
        'entity'    => 'Odaberite entitet',
        'filters'   => 'location_id=15&type=grad',
        'menu'      => 'Podstranica izbornika (koristite posljednji tekst URL-a)',
        'name'      => 'Naziv poveznice izbornika',
        'tab'       => 'unos, odnosi, bilješke',
    ],
    'show'          => [
        'tabs'  => [
            'information'   => 'Informacije',
        ],
        'title' => 'Poveznica izbornika :name',
    ],
];
