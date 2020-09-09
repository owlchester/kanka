<?php

return [
    'create'        => [
        'description'   => 'Kreiraj novu organizaciju',
        'success'       => 'Kreirana lokacija ":name"',
        'title'         => 'Nova organizacija',
    ],
    'destroy'       => [
        'success'   => 'Obrisana organizacija ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažurirana organizacija ":name".',
        'title'     => 'Uredi organizaciju :name',
    ],
    'fields'        => [
        'image'         => 'Slika',
        'location'      => 'Lokacija',
        'members'       => 'Članovi',
        'name'          => 'Naziv',
        'organisation'  => 'Organizacija roditelj',
        'organisations' => 'Podorganizacije',
        'relation'      => 'Odnosi',
        'type'          => 'Tip',
    ],
    'helpers'       => [
        'descendants'   => 'Popis sadrži sve organizacije koje su unutar trenutne organizacije, a ne samo one koje su direktno ispod nje.',
        'nested'        => 'U "Ugniježđenom pregledu" možeš vidjeti organizacije na ugniježđeni način. Organizacije bez organizacije roditelj će biti prikazane na osnovnom pregledu. Organizacije s podorganizacijama se mogu kliknuti kako bi se prikazale te podorganizacije. Možeš nastaviti klikati dok ima podorganizacija za prikazati.',
    ],
    'index'         => [
        'add'           => 'Nova organizacija',
        'description'   => 'Upravljanje organizacijama u :name',
        'header'        => 'Organizacije u :name',
        'title'         => 'Organizacije',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Dodaj člana',
        ],
        'create'        => [
            'description'   => 'Dodaj člana u organizaciju',
            'success'       => 'Član dodan u organizaciju.',
            'title'         => 'Novi član organizacije za :name',
        ],
        'destroy'       => [
            'success'   => 'Član uklonjen iz organizacije.',
        ],
        'edit'          => [
            'success'   => 'Član organizacije ažuriran.',
            'title'     => 'Ažuriraj člana za :name',
        ],
        'fields'        => [
            'character'     => 'Lik',
            'organisation'  => 'Organizacija',
            'role'          => 'Uloga',
        ],
        'helpers'       => [
            'all_members'   => 'Svi likovi koji su članovi ove organizacije i njenih podorganizacija.',
            'members'       => 'Sljedeća lista prikazuje sve likove koji su u ovoj organizaciji i svim njenim podorganizacijama. Možeš filtrirati stranicu da prikaže samo direktne članove.',
        ],
        'placeholders'  => [
            'character' => 'Izaberi lika',
            'role'      => 'Voditelj, Član, Visoki Svećenik, Majstor Špijun',
        ],
        'title'         => 'Članovi organizacije :name',
    ],
    'organisations' => [
        'title' => 'Organizacije u organizaciji :name',
    ],
    'placeholders'  => [
        'location'  => 'Izaberi lokaciju',
        'name'      => 'Naziv organizacije',
        'type'      => 'Kult, Banda, Pobuna, Klub obožavatelja',
    ],
    'quests'        => [
        'description'   => 'Zadaci kojih je organizacija dio.',
        'title'         => 'Zadaci organizacije :name',
    ],
    'show'          => [
        'description'   => 'Detaljan pregled organizacije',
        'tabs'          => [
            'organisations' => 'Organizacije',
            'quests'        => 'Zadaci',
            'relations'     => 'Odnosi',
        ],
        'title'         => 'Organizacija :name',
    ],
];
