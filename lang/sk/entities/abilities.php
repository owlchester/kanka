<?php

return [
    'actions'   => [
        'add'   => 'Pridať schopnosť',
        'reset' => 'Resetovať vyčerpania schopností',
        'sync'  => 'Pridať z rás',
    ],
    'create'    => [
        'success'           => 'Schopnosť :ability pridaná k :entity.',
        'success_multiple'  => 'Schopnosti :abilities boli pridané k :entity.',
        'title'             => 'Pridať schopnosť k :name',
    ],
    'fields'    => [
        'note'      => 'Poznámka',
        'position'  => 'Pozícia',
    ],
    'helpers'   => [
        'note'      => 'Referencie na iné objekty môžeš vytvoriť pomocou rozšírených referencií (ex :code) a atribútov objektov (ex :attr) v tomto poli.',
        'recharge'  => 'Resetuje všetky zmeny schopností, ktoré boli použité.',
        'sync'      => 'Importuje schopnosti, ktoré sú definované pri rase postavy.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Táto postava je bez rasy.',
            'not_character' => 'Tento objekt nie je postava.',
        ],
        'success'   => '{1} :count schopnosť importovaná.|[2,4] :count schopnosti importované.|[5,*] :count schopností importovaných.',
    ],
    'recharge'  => [
        'success'   => 'Všetky zmeny boli resetované.',
    ],
    'reorder'   => [
        'parentless'    => 'Bez nadradenej',
        'success'       => 'Schopnosti úspešne preskupené.',
    ],
    'show'      => [
        'helper'    => 'Pridaj schopnosti k tomuto objektu. Môžeš upraviť ich viditeľnosť alebo ich odstrániť. Schopnosti patriace pod nadradenú schopnosť sa zobrazia pod spoločným tlačidlom.',
        'reorder'   => 'Preskupiť schopnosti',
        'title'     => 'Schopnosti objektu :name',
    ],
    'update'    => [
        'success'   => 'Objektová schopnosť :ability bola aktualizovaná.',
        'title'     => 'Schopnosť objektu :name',
    ],
];
