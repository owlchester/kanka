<?php

return [
    'actions'   => [
        'add'                       => 'Dodaj sposobnost',
        'import_from_race'          => 'Dodajte sposobnosti rase',
        'import_from_race_mobile'   => 'Rasne sposobnosti',
        'reset'                     => 'Poništi korištenje sposobnosti',
    ],
    'create'    => [
        'success'           => 'Sposobnost :ability dodana na :entity.',
        'success_multiple'  => 'Sposobnosti :abilities dodane na :entity.',
        'title'             => 'Dodaj sposobnost za :name',
    ],
    'fields'    => [
        'note'      => 'Bilješka',
        'position'  => 'Pozicija',
    ],
    'helpers'   => [
        'note'  => 'U ovom polju se možeš referencirati na entitete koristeći napredno spominjanje (npr. :code) i atribute entiteta (npr :attr).',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Lik nema rasu.',
            'not_character' => 'Entitet nije lik.',
        ],
        'success'   => '{1} :count sposobnost uvezena.|[2,4] :count sposobnosti uvezene.|[5,*] :count sposobnosti uvezeno.',
    ],
    'show'      => [
        'helper'    => 'Dodaj sposobnosti za ovaj entitet. Uvijek možeš promijeniti vidljivost ili ukloniti sposobnost. Sposobnosti koje pripadaju istoj sposobnosti roditelju će se prikazati kao filter kutije.',
        'title'     => 'Sposobnosti entiteta u :name',
    ],
    'update'    => [
        'title' => 'Sposobnost entiteta za :name',
    ],
];
