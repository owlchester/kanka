<?php

return [
    'actions'       => [
        'add'   => 'Pridať link',
    ],
    'create'        => [
        'success'   => 'Link :name pridaný k :entity.',
        'title'     => 'Pridať link k :name',
    ],
    'destroy'       => [
        'success'   => 'Link :name odstránený z :entity.',
    ],
    'fields'        => [
        'icon'      => 'Symbol',
        'name'      => 'Názov',
        'position'  => 'Pozícia',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'goto'      => 'Prejsť na :name',
        'icon'      => 'Môžeš zmeniť zobrazovaný symbol linku. Použi jeden z voľne dostupných symbolov :fontawesome, alebo ponechaj pole prázdne pre štandardný symbol.',
        'leaving'   => 'Opúšťaš Kanku a smeruješ na inú doménu. Stránka, na ktorú smeruješ, bola poskytnutá užívateľom a nie je nami overovaná.',
        'url'       => 'URL, na ktorú smerujete, je :url.',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'Boostované kampane môžu pridávať k objektom linky, ktoré smerujú na externé webstránky.',
        'title'     => 'Linky pre :name',
    ],
    'unboosted'     => [
        'text'  => 'Pridávať linky na externé zdroje, ktoré budú zobrazené priamo v objekte, je rezervované pre :boosted-campaigns.',
        'title' => 'Funkcionalita boostnutej kampane',
    ],
    'update'        => [
        'success'   => 'Link :name aktualizovaný pre :entity.',
        'title'     => 'Aktualizovať link pre :name',
    ],
];
