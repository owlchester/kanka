<?php

return [
    'actions'           => [
        'add'   => 'Pridať link',
    ],
    'call-to-action'    => 'Pridaj linky k externým zdrojom k tomuto objektu, napr. DnDBeyond a tieto sa objavia priamo v prehľade objektu.',
    'create'            => [
        'success'   => 'Link :name pridaný k :entity.',
        'title'     => 'Pridať link k :name',
    ],
    'destroy'           => [
        'success'   => 'Link :name odstránený z :entity.',
    ],
    'fields'            => [
        'icon'      => 'Symbol',
        'name'      => 'Názov',
        'position'  => 'Pozícia',
        'url'       => 'URL',
    ],
    'go'                => [
        'actions'       => [
            'confirm'   => 'Áno',
            'trust'     => 'Nepýtaj sa ma znova',
        ],
        'description'   => 'Tento link ťa premiestni na :link. Ozaj sa tam chceš vybrať?',
        'title'         => 'Opúšťam Kanku',
    ],
    'helpers'           => [
        'icon'      => 'Môžeš zmeniť zobrazovaný symbol linku. Použi jeden z voľne dostupných symbolov :fontawesome, alebo ponechaj pole prázdne pre štandardný symbol.',
        'parent'    => 'Zobrazí tento rýchly link po prvku v bočnom menu, namiesto v sekcii pre rýchle linky bočného menu.',
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'Boostované kampane môžu pridávať k objektom linky, ktoré smerujú na externé webstránky.',
        'title'     => 'Linky pre :name',
    ],
    'unboosted'         => [],
    'update'            => [
        'success'   => 'Link :name aktualizovaný pre :entity.',
        'title'     => 'Aktualizovať link pre :name',
    ],
];
