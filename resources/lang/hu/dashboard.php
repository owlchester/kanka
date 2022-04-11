<?php

return [
    'actions'       => [
        'follow'    => 'Követés',
        'join'      => 'Csatlakozás',
        'unfollow'  => 'Követés visszavonása',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count modul',
            'roles'     => ':count szerep',
            'users'     => ':count felhasználó',
        ],
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Név és engedélyek szerkesztése',
            'new'       => 'Új főoldal',
            'switch'    => 'Váltás a főoldalra',
        ],
        'boosted'       => ':boosted_campaigns minden kampányszerep részére más főoldalt tudnak létrehozni.',
        'create'        => [
            'success'   => 'Az új kapmányfőoldalt :name néven létrehoztuk.',
            'title'     => 'Új kapmányfőoldal',
        ],
        'custom'        => [
            'text'  => 'Jelenleg a kampány :name nevű főoldalát szerkeszted.',
        ],
        'default'       => [
            'text'  => 'Jelenleg a kampány alapértelmezett főoldalát szerkeszted.',
            'title' => 'Alapértelmezett főoldal.',
        ],
        'delete'        => [
            'success'   => ':name főoldalt eltávolítottuk.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Widgetek másolása',
            'name'          => 'Főoldal neve',
            'visibility'    => 'Láthatóság',
        ],
        'helpers'       => [
            'copy_widgets'  => ':name főoldal widgetjeinek másolása ebbe az újba.',
        ],
        'placeholders'  => [
            'name'  => 'A főoldal neve',
        ],
        'update'        => [
            'success'   => ':name főoldalt frissítettük.',
            'title'     => ':name főoldal frissítése',
        ],
        'visibility'    => [
            'default'   => 'Alapértelmezett',
            'none'      => 'Nincs',
            'visible'   => 'Látható',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Egy kampány követése esetén megjelenik majd a kampányválasztó menüben (jobbra fent) a saját kampányaid alatt.',
        'join'      => 'A kampány nyitott az új tagok számára. Klikkelj a csatlakozás kéréséért.',
        'setup'     => 'Állítsd be a kampányod főoldalát!',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Értem',
            'title'     => 'Fontos megjegyzés',
        ],
    ],
    'recent'        => [
        'title' => 'Mostanában módosított :name',
    ],
    'settings'      => [
        'title' => 'Főoldal beállításai',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Widget hozzáadása',
            'back_to_dashboard' => 'Vissza a főoldalra',
            'edit'              => 'Widget szerkesztése',
        ],
        'title'     => 'Kampány főoldalának beállítása',
        'widgets'   => [
            'calendar'      => 'Naptár',
            'campaign'      => 'Kampányfejléc',
            'header'        => 'Fejléc',
            'preview'       => 'Entitás előnézete',
            'random'        => 'Véletlen entitás',
            'recent'        => 'Mostanában',
            'unmentioned'   => 'Nem említett entitások',
        ],
    ],
    'title'         => 'Főoldal',
    'widgets'       => [
        'actions'                   => [
            'advanced-options'  => 'Bővebb lehetőségek',
            'delete-confirm'    => 'eme widget',
        ],
        'advanced_options_boosted'  => ':boosted_campaigns részére bővebb lehetőségek állnak rendelkezésre, mint például egy család tagjainak megmutatása, vagy egy entitás tulajdonságainak megmutatása a főoldalon.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Átállítás a következő napra',
                'previous'  => 'Átállítás az előző napra',
            ],
            'events_today'      => 'Ma',
            'previous_events'   => 'Előző',
            'upcoming_events'   => 'Küszöbön álló',
        ],
        'campaign'                  => [
            'helper'    => 'Ez a widget megmutatja a kampányfejlécet. Ez a widget mindig az alapértelmezett főoldalon lesz látható.',
        ],
        'create'                    => [
            'success'   => 'Hozzáadtuk a widget-et a főoldalhoz.',
        ],
        'delete'                    => [
            'success'   => 'Eltávolítottuk a widget-et a főoldalról.',
        ],
        'fields'                    => [
            'dashboard'         => 'Főoldal',
            'name'              => 'Egyéni widget név',
            'optional-entity'   => 'Link az entitáshoz',
            'order'             => 'Rendezés',
            'text'              => 'Szöveg',
            'width'             => 'Szélesség',
        ],
        'orders'                    => [
            'name_asc'  => 'Növekvő nevek',
            'name_desc' => 'Csökkenő nevek',
            'recent'    => 'Éppen módosított',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Hivatkozhatsz a véletlen entitás nevére ezzel: {name}',
            ],
        ],
        'recent'                    => [
            'entity-header'     => 'Használd az entitás fejlécet, mint képet',
            'filters'           => 'Szűrők',
            'full'              => 'Teljes',
            'help'              => 'Csak az utoljára frissített entitást mutasd, de teljes előnézettel',
            'helpers'           => [
                'entity-header'     => 'Ha az entitásodnak van beállított entitás fejléce (boost-olt kampányok számára elérhető funkció), akkor beállíthatod ezt a widget-et, hogy használja azt a képet, az entitás képe helyett.',
                'filters'           => 'Szűrheted a feltűnő entitásokat. Tanuld meg, hogyan használd ezt a mezőt itt: :link',
                'full'              => 'Az entitás teljes bejegyzését jelenítsd meg, az előnézet helyett.',
                'show_attributes'   => 'Mutasd meg az entitás kitűzött tulajdonságait a bejegyzés alatt.',
                'show_members'      => 'Ha az entitás egy család vagy szervezet, mutasd meg a tagjait a bejegyzés alatt.',
                'show_relations'    => 'Mutasd meg az entitás kitűzött kapcsolatait az entitás alatt.',
            ],
            'show_attributes'   => 'Mutasd meg a kitűzött tulajdonságoka',
            'show_members'      => 'Mutasd meg a tagokat',
            'show_relations'    => 'Mutasd meg a kitűzött kapcsolatokat',
            'singular'          => 'Csak az utolsót',
            'tags'              => 'Szűrés a mostanában módosított widget-ek között, meghatározott címkék alapján.',
            'title'             => 'Mostanában módosított',
        ],
        'unmentioned'               => [
            'title' => 'Nem említett entitások',
        ],
        'update'                    => [
            'success'   => 'Módosítottuk a widget-et.',
        ],
        'widths'                    => [
            '0' => 'Auto',
            '12'=> 'Teljes',
            '3' => 'Apró',
            '4' => 'Kicsi',
            '6' => 'Fél',
            '8' => 'Széles',
            '9' => 'Nagy (75%)',
        ],
    ],
];
