<?php

return [
    'actions'       => [
        'back'      => 'Povratak na :name',
        'edit'      => 'Uredi kartu',
        'explore'   => 'Istraži',
    ],
    'create'        => [
        'success'   => 'Kreirana karta :name.',
        'title'     => 'Nova karta',
    ],
    'destroy'       => [
        'success'   => 'Uklonjena karta :name.',
    ],
    'edit'          => [
        'success'   => 'Ažurirana karta :name.',
        'title'     => 'Uredi kartu :name',
    ],
    'errors'        => [
        'dashboard' => [
            'missing'   => 'Ova karta treba sliku kako bi se mogla prikazati na naslovnoj ploči.',
        ],
        'explore'   => [
            'missing'   => 'Dodaj sliku na kartu prije nego što ju možeš istraživati.',
        ],
    ],
    'fields'        => [
        'center_marker'     => 'Marker',
        'center_x'          => 'Zadana pozicija zemljopisne dužine',
        'center_y'          => 'Zadana pozicija zemljopisne širine',
        'centering'         => 'Centriranje',
        'distance_measure'  => 'Mjera udaljenosti',
        'distance_name'     => 'Jedinica udaljenosti',
        'grid'              => 'Mreža',
        'initial_zoom'      => 'Početno povećanje',
        'map'               => 'Karta roditelj',
        'maps'              => 'Karte',
        'max_zoom'          => 'Maksimalno povećanje',
        'min_zoom'          => 'Minimalno povećanje',
        'name'              => 'Ime',
        'tabs'              => [
            'coordinates'   => 'Koordinate',
            'marker'        => 'Marker',
        ],
        'type'              => 'Tip',
    ],
    'helpers'       => [
        'center'            => 'Promjena sljedećih vrijednosti kontrolira na koje područje je karta fokusirana. Ostavljanje ovih vrijednosti praznima rezultirat će se fokusom na središte karte.',
        'centering'         => 'Centriranje na markeru imat će prioritet nad zadanim koordinatama.',
        'descendants'       => 'Ovaj popis sadrži sve karte koje su potomci ove karte, a ne samo one koje se nalaze neposredno ispod nje.',
        'distance_measure'  => 'Davanjem karte mjere udaljenosti omogućit će se alat za mjerenje u načinu istraživanja.',
        'grid'              => 'Definiraj veličinu mreže koja će biti prikazana u načinu istraživanja.',
        'initial_zoom'      => 'Početna razina povećanja na koju se učitava karta. Zadana vrijednost je :default, dok je najveća dopuštena vrijednost :max, a najniža dopuštena vrijednost je :min.',
        'max_zoom'          => 'Najviše što se karta može povećati. Zadana vrijednost je :default, dok je najviša dozvoljena vrijednost :max.',
        'min_zoom'          => 'Najviše što se karta može udaljiti. Zadana vrijednost je :default, dok je najniža dozvoljena vrijednost :min.',
        'missing_image'     => 'Spremi kartu sa slikom prije nego što možeš dodavati slojeve i markere.',
        'nested_parent'     => 'Prikaz mapa od :parent.',
        'nested_without'    => 'Prikazuju se sve mape koje nemaju mapu roditelj. Klikni redak da bi vidio/la mapu djecu.',
    ],
    'index'         => [
        'title' => 'Karte',
    ],
    'maps'          => [
        'title' => 'Karte od :name',
    ],
    'panels'        => [
        'groups'    => 'Grupe',
        'layers'    => 'Slojevi',
        'markers'   => 'Markeri',
        'settings'  => 'Postavke',
    ],
    'placeholders'  => [
        'center_marker'     => 'Ostavi prazno za učitavanje karte u sredini',
        'center_x'          => 'Ostavi prazno za učitavanje karte u sredini',
        'center_y'          => 'Ostavi prazno za učitavanje karte u sredini',
        'distance_measure'  => 'Jedinica po pikselu',
        'distance_name'     => 'Naziv jedinice udaljenosti (kilometar, milja)',
        'grid'              => 'Udaljenost u pikselima između elemenata mreže. Ostavi prazno da se sakrije mreža.',
        'name'              => 'Naziv karte',
        'type'              => 'Tamnica, Grad, Galaksija',
    ],
    'show'          => [
        'tabs'  => [
            'maps'  => 'Karte',
        ],
    ],
];
