<?php

return [
    'actions'           => [
        'add'               => 'Pridaj Predmet',
        'copy_from'         => 'Kopírovať z',
        'copy_inventory'    => 'Kopírovať inventár',
    ],
    'copy'              => [
        'title' => 'Kopírovať inventár do :name',
    ],
    'create'            => [
        'success'       => 'Predmet :item pridaný do :entity.',
        'success_bulk'  => '{0} Žiaden predmet nebol pridaný do :entity.|{1} Bol pridaný :count predmet do :entity.|[2,4] Boli pridané :count predmety do :entity.|[5,*] Bolo pridaných :count predmetov do :entity.',
        'title'         => 'Pridaj Predmet ku :name',
    ],
    'default_position'  => 'Bez zoradenia',
    'destroy'           => [
        'success'           => 'Predmet :name odstránený z :entity.',
        'success_position'  => 'Predmet na :position odstránený z :entity.',
    ],
    'fields'            => [
        'amount'                => 'Počet',
        'copy_entity_entry_v2'  => 'Použiť záznam objektu',
        'description'           => 'Popis',
        'is_equipped'           => 'Vybavený',
        'name'                  => 'Názov',
        'position'              => 'Umiestnenie',
        'qty'                   => 'Množ.',
    ],
    'helpers'           => [
        'amount'                => 'Počet predmetov',
        'copy_entity_entry_v2'  => 'Zobraziť záznam objektu namiesto vlastného popisu.',
        'description'           => 'Pridať vlastný popis k predmetu',
        'is_equipped'           => 'Označiť predmety ako vybavené.',
        'name'                  => 'Zadaj názov predmetu. Názov je povinný, ak nie je zvolený žiaden objekt.',
    ],
    'placeholders'      => [
        'amount'        => 'Hocijaké množstvo',
        'description'   => 'Použitý, Zničený, Zžitý',
        'name'          => 'Potrebný, ak nie je zvolený žiaden objekt',
        'position'      => 'V rukách, V ruksaku, V sklade, V banke',
    ],
    'show'              => [
        'helper'    => 'Objekty môžu mať priradené Predmety, čím sa vytvára ich Inventár.',
        'title'     => 'Objekt :name Inventár',
        'unsorted'  => 'Nezoradené',
    ],
    'tooltips'          => [
        'equipped'  => 'Predmet je vo vybavení.',
    ],
    'tutorials'         => [
        'character' => 'Sleduj, čo :name vlastní alebo má na predaj tak, že predmety pridáš do inventára.',
        'location'  => 'Sleduj, čo môže :name predať alebo niekto ulúpiť tak, že predmety pridáš do inventára.',
        'other'     => 'Sleduj, čo všetko vlastní :name tak, že predmety pridáš do inventára.',
    ],
    'update'            => [
        'success'   => 'Predmet :item pre :entity upravený.',
        'title'     => 'Uprav Predmet :name',
    ],
];
