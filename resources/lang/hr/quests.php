<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Postavi lika na zadatak',
            'success'       => 'Lik dodan na :name.',
            'title'         => 'Novi lik za :name',
        ],
        'destroy'   => [
            'success'   => 'Uklonjen lik sa zadatka :name.',
        ],
        'edit'      => [
            'description'   => 'Ažuriraj lika na zadatku',
            'success'       => 'Ažuriran lik na zadatku :name.',
            'title'         => 'Ažuriraj lika za :name',
        ],
        'fields'    => [
            'character'     => 'Lik',
            'description'   => 'Opis',
        ],
        'title'     => 'Likovi u :name',
    ],
    'create'        => [
        'description'   => 'Kreiraj novi zadatak',
        'success'       => 'Kreiran zadatak ":name".',
        'title'         => 'Novi zadatak',
    ],
    'destroy'       => [
        'success'   => 'Uklonjen zadatak ":name".',
    ],
    'edit'          => [
        'description'   => 'Uredi zadatak',
        'success'       => 'Ažuriran zadatak ":name".',
        'title'         => 'Uredi zadatak :name',
    ],
    'fields'        => [
        'character'     => 'Inicijator',
        'characters'    => 'Likovi',
        'copy_elements' => 'Kopirajte elemente pridružene zadatku',
        'date'          => 'Datum',
        'description'   => 'Opis',
        'image'         => 'Slika',
        'is_completed'  => 'Izvršen',
        'items'         => 'Predmeti',
        'locations'     => 'Lokacije',
        'name'          => 'Naziv',
        'organisations' => 'Organizacije',
        'quest'         => 'Zadatak roditelj',
        'quests'        => 'Podzadatak',
        'role'          => 'Uloga',
        'type'          => 'Tip',
    ],
    'helpers'       => [
        'nested'    => 'U "Ugniježđenom pregledu" možeš vidjeti zadatke na ugniježđeni način. Zadaci bez zadatka roditelj će biti prikazani na osnovnom pregledu. Zadaci s podzadacima se mogu kliknuti kako bi se prikazali ti podzadaci. Možeš nastaviti klikati dok ima podzadataka za prikazati.',
    ],
    'hints'         => [
        'quests'    => 'Mreža isprepletenih zadataka se može napraviti korištenjem Zadatak roditelj polja.',
    ],
    'index'         => [
        'add'           => 'Novi zadatak',
        'description'   => 'Upravljanje zadacima u :name.',
        'header'        => 'Zadaci od :name',
        'title'         => 'Zadaci',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Postavi predmet na zadatak',
            'success'       => 'Dodan predmet na :name.',
            'title'         => 'Novi predmet za :name',
        ],
        'destroy'   => [
            'success'   => 'Uklonjen predmet zadatka za :name.',
        ],
        'edit'      => [
            'description'   => 'Ažuriraj predmet zadatka',
            'success'       => 'Ažuriran predmet zadatka za :name.',
            'title'         => 'Ažuriraj predmet za :name',
        ],
        'fields'    => [
            'description'   => 'Opis',
            'item'          => 'Predmet',
        ],
        'title'     => 'Predmeti u :name',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Postavi lokaciju na zadatak',
            'success'       => 'Dodana lokacija na :name.',
            'title'         => 'Nova lokacija za :name',
        ],
        'destroy'   => [
            'success'   => 'Uklonjena lokacija zadatka za :name.',
        ],
        'edit'      => [
            'description'   => 'Ažuriraj lokaciju zadatka',
            'success'       => 'Ažurirana lokacija zadatka za :name.',
            'title'         => 'Ažuriraj lokaciju za :name',
        ],
        'fields'    => [
            'description'   => 'Opis',
            'location'      => 'Lokacija',
        ],
        'title'     => 'Lokacije u :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Postavi organizaciju za zadatak',
            'success'       => 'Organizacije dodane na :name',
            'title'         => 'Nova organizacija za: name',
        ],
        'destroy'   => [
            'success'   => 'Uklonjena organizacija zadatka za :name.',
        ],
        'edit'      => [
            'description'   => 'Ažuriraj organizaciju zadatka',
            'success'       => 'Ažurirana organizacija zadatka za :name.',
            'title'         => 'Ažuriraj organizaciju za :name',
        ],
        'fields'    => [
            'description'   => 'Opis',
            'organisation'  => 'Organizacija',
        ],
        'title'     => 'Organizacije u :name',
    ],
    'placeholders'  => [
        'date'  => 'Stvarni datum zadatka',
        'name'  => 'Naziv zadatka',
        'quest' => 'Zadatak roditelj',
        'role'  => 'Uloga ovog entieta u zadatku',
        'type'  => 'Priča o liku, Sporedni zadatak, Glavni zadatak',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Dodaj lika',
            'add_item'          => 'Dodaj predmet',
            'add_location'      => 'Dodaj lokaciju',
            'add_organisation'  => 'Dodaj organizaciju',
        ],
        'description'   => 'Detaljan pregled zadatka',
        'tabs'          => [
            'characters'    => 'Likovi',
            'information'   => 'Informacije',
            'items'         => 'Predmeti',
            'locations'     => 'Lokacije',
            'organisations' => 'Organizacije',
            'quests'        => 'Zadaci',
        ],
        'title'         => 'Zadatak :name',
    ],
];
