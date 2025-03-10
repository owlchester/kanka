<?php

return [
    'actions'       => [
        'create'    => 'Vytvoriť modul',
        'customise' => 'Prispôsobiť',
    ],
    'create'        => [
        'helper'    => 'Vytvor nový vlastný modul na uloženie objektov, ktoré nepasujú do ostatných modulov.',
        'success'   => 'Nový modul vytvorený.',
        'title'     => 'Nový modul',
    ],
    'delete'        => [
        'confirm'   => 'Napíš :code, ak máš istotu, že chceš permanentne zmazať :name vlastného modulu.',
        'helper'    => 'Naozaj chceš odstrániť vlastný modul :name? Automaticky to odstráni aj všetky objekty, záložky a widgety prepojené s týmto modulom.',
        'success'   => 'Modul :name odstránený.',
        'title'     => 'Odstrániť modul',
    ],
    'errors'        => [
        'disabled'  => 'Modul :name nastavený ako neaktívny. :fix',
        'limit'     => 'Kampane môžu mať aktuálne :max vlastných modulov, kým táto funkcionalita prejde testom.',
    ],
    'fields'        => [
        'icon'      => 'Ikona modulu',
        'plural'    => 'Množné meno modulu',
        'singular'  => 'Jednotné meno modulu',
    ],
    'helpers'       => [
        'custom'    => 'Toto je vlastný modul.',
        'icon'      => 'Ikona :fontawesome, napr. :example.',
        'info'      => 'Kampaň je rozdelená do niekoľkých modulov, ktoré sú navzájom prepojené. Aktivuj alebo deaktivuj tie, ktoré ne/potrebuješ. Deaktivácia modulu nezmaže údaje v ňom, iba sa prestanú zobrazovať.',
        'plural'    => 'Množné číslo mena objektu nového modulu, napr. elixíry',
        'roles'     => 'Zvoľ role, ktoré budú mať prístup na zobrazenie objektov nového modulu. Toto môže byť neskôr zmenené v nastavení rolí.',
        'singular'  => 'Jednotné číslo mena objektu nového modulu, napr. elixír',
    ],
    'pitch'         => 'Zmeň názov a ikonu asociovanú s týmto modulom pre celú kampaň.',
    'pitch-custom'  => 'Vytvor vlastné moduly na uloženie jedinečných objektov.',
    'rename'        => [
        'helper'    => 'Zmeň názov a ikonu modulu v celej kampani. Ponechaj prázdne, ak chce používať pôvodné nastavenie Kanky.',
        'success'   => 'Modul prispôsobený.',
        'title'     => 'Prispôsobenie modulu :module',
    ],
    'reset'         => [
        'default'   => 'Toto zresetuje iba štandardné moduly, nie vlastné.',
        'success'   => 'Moduly kampane boli resetované.',
        'title'     => 'Resetovať vlastné názvy a ikony modulov',
        'warning'   => 'Naozaj chceš resetovať moduly kampane na ich pôvodné názvy a ikony?',
    ],
    'sections'      => [
        'custom'    => 'Vlastné moduly',
        'default'   => 'Štandardné moduly',
        'features'  => 'Funkcionality',
    ],
    'states'        => [
        'disable'   => 'Deaktivovať',
        'enable'    => 'Aktivovať',
    ],
];
