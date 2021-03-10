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
        'dashboard'     => 'Naslovna ploča',
        'entity'        => 'Entitet',
        'filters'       => 'Filteri',
        'menu'          => 'Izbornik',
        'name'          => 'Naziv',
        'position'      => 'Pozicija',
        'random'        => 'Nasumično',
        'random_type'   => 'Nasumičan tip entiteta',
        'selector'      => 'Konfiguracija brzih poveznica',
        'tab'           => 'Kartica',
        'type'          => 'Tip entiteta',
    ],
    'helpers'       => [
        'dashboard' => 'Neka brza poveznica cilja jednu od prilagođenih naslovnih ploča kampanje.',
        'entity'    => 'Postavi ovu poveznicu izbornika tako da ide direktno na entitet. Polje :tab kontrolira koja kartica je fokusirana. Polje :menu kontrolira koja podstranica entiteta se otvara.',
        'position'  => 'Pomoću ovog polja možeš upravljati redoslijedom kojim se poveznice pojavljuju na izborniku.',
        'random'    => 'Koristi ovo polje za brzu vezu koja upućuje na slučajni entitet. Vezu možeš filtrirati tako da ide samo do određenu vrstu entiteta.',
        'selector'  => 'Konfiguriraj kamo vodi ova brza poveznica kada je korisnik klikne na bočnoj traci.',
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
    'random_types'  => [
        'any'   => 'Bilo koji entitet',
    ],
    'show'          => [
        'tabs'  => [
            'information'   => 'Informacije',
        ],
        'title' => 'Poveznica izbornika :name',
    ],
];
