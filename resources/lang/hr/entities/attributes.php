<?php

return [
    'actions'       => [
        'apply_template'    => 'Primjeni predložak atributa',
        'manage'            => 'Upravljanje',
        'more'              => 'Više opcija',
        'remove_all'        => 'Izbriši sve',
    ],
    'errors'        => [
        'loop'  => 'U ovom izračunu atributa postoji beskonačna petlja!',
    ],
    'fields'        => [
        'attribute'             => 'Atribut',
        'community_templates'   => 'Predlošci zajednice',
        'is_private'            => 'Privatni atributi',
        'is_star'               => 'Prikvačeno',
        'template'              => 'Predložak',
        'value'                 => 'Vrijednost',
    ],
    'helpers'       => [
        'delete_all'    => 'Jesi li siguran/a da želiš izbrisati sve atribute ovog entiteta?',
    ],
    'hints'         => [
        'is_private'    => 'Možeš sakriti sve atribute entiteta od svih članova koji nisu administratori tako što ćeš ga učiniti privatnim.',
    ],
    'index'         => [
        'success'   => 'Ažurirani atributi za :entity.',
        'title'     => 'Atributi za :name',
    ],
    'placeholders'  => [
        'attribute' => 'Broj osvajanja, Razina izazova, Inicijativa, Stanovništvo',
        'block'     => 'Naziv bloka',
        'checkbox'  => 'Naziv potvrdnog okvira',
        'icon'      => [
            'class' => 'Klase FontAwesome ili RPG Awesome: fas fa-users',
            'name'  => 'Naziv ikone',
        ],
        'random'    => [
            'name'  => 'Naziv atributa',
            'value' => '1-100 ili popis vrijednosti odvojenih zarezom',
        ],
        'section'   => 'Naziv odjeljka',
        'template'  => 'Odaberi predložak',
        'value'     => 'Vrijednost atributa',
    ],
    'template'      => [
        'success'   => 'Predložak atributa :name primijenjen na :entity',
        'title'     => 'Primijeni predložak atributa za :name',
    ],
    'types'         => [
        'attribute' => 'Atribut',
        'block'     => 'Blok',
        'checkbox'  => 'Potvrdni okvir',
        'icon'      => 'Ikona',
        'random'    => 'Nasumično',
        'section'   => 'Odjeljak',
        'text'      => 'Tekst u više redova',
    ],
    'visibility'    => [
        'entry'     => 'Atribut je prikazan u izborniku entiteta.',
        'private'   => 'Atribut vidljiv samo članovima uloge "Administrator".',
        'public'    => 'Atribut vidljiv svim članovima.',
        'tab'       => 'Atribut se prikazuje samo na kartici Atributi.',
    ],
];
