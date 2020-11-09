<?php

return [
    'create'        => [
        'description'   => 'Vytvoriť nový záznam v denníku',
        'success'       => 'Záznam :name vytvorený.',
        'title'         => 'Nový záznam v denníku',
    ],
    'destroy'       => [
        'success'   => 'Záznam :name vytvorený.',
    ],
    'edit'          => [
        'success'   => 'Záznam :name upravený.',
        'title'     => 'Upraviť záznam :name',
    ],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Dátum',
        'image'     => 'Obrázok',
        'journal'   => 'Nadradený denník',
        'journals'  => 'Podradený denník',
        'name'      => 'Názov',
        'relation'  => 'Prepojenie',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'journals'  => 'Zobrazí všetky alebo len priamo podradené denníky tohto denníka.',
        'nested'    => 'Zobrazí najprv denníky bez nadradeného denníka. Kliknutie na riadok zobrazí podradené denníky daného denníka.',
    ],
    'index'         => [
        'add'           => 'Nový záznam v denníku',
        'description'   => 'Spravuj záznamy v denníku objektu :name',
        'header'        => 'Záznamy v denníku objektu :name',
        'title'         => 'Záznamy v denníku',
    ],
    'journals'      => [
        'title' => 'Podradené denníky denníka :name',
    ],
    'placeholders'  => [
        'author'    => 'Kto napísal tento záznam',
        'date'      => 'Reálny dátum tohto záznamu',
        'journal'   => 'Vyber nadradený denník',
        'name'      => 'Názov tohto záznamu',
        'type'      => 'sedenie, one shot, návrh',
    ],
    'show'          => [
        'description'   => 'Detailný náhľad na záznam v denníku',
        'tabs'          => [
            'journals'  => 'Denníky',
        ],
        'title'         => 'Záznam :name',
    ],
];
