<?php

return [
    'campaigns'         => [
        'manage'    => 'Kampány kezelése',
        'tabs'      => [
            'modules'   => ':count modul',
            'roles'     => ':count szerep',
            'users'     => ':count felhasználó',
        ],
    ],
    'description'       => 'Otthon a kreativitásod számára',
    'helpers'           => [
        'setup' => 'Állítsd be a kampányod főoldalát!',
    ],
    'latest_release'    => 'Legutóbbi frissítések',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Értem',
            'title'     => 'Fontos megjegyzés',
        ],
    ],
    'recent'            => [
        'add'           => 'Új :name létrehozása',
        'no_entries'    => 'Jelenleg nincs ilyen tipusú entitás',
        'title'         => 'Mostanában módosított :name',
        'view'          => 'Minden :name megtekintése',
    ],
    'settings'          => [
        'description'   => 'Szabd meg, hogy mit látsz a főoldalon!',
        'edit'          => [
            'success'   => 'Elmentettük a változásokat.',
        ],
        'fields'        => [
            'helper'        => 'Könnyen megváltoztathatod, hogy mit látsz a főoldalon. Ne felejtsd el, hogy ez minden kampányodra vonatkozik a kampány világától függetlenül!',
            'recent_count'  => 'Mostanában módosított elemek száma',
        ],
        'title'         => 'Főoldal beállításai',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Widget hozzáadása',
            'back_to_dashboard' => 'Vissza a főoldalra',
            'edit'              => 'Widget szerkesztése',
        ],
        'title'     => 'Kampány főoldalának beállítása',
        'widgets'   => [
            'calendar'  => 'Naptár',
            'preview'   => 'Entitás előnézete',
            'recent'    => 'Mostanában',
        ],
    ],
    'title'             => 'Főoldal',
    'welcome'           => [
        'body'      => <<<'TEXT'
Üdvözlünk a Kankában! Létrehoztuk az első kampányodat és bedobtunk pár példa-entitást inspirációként (törölheted őket, amikor csak szeretnéd).

Valószínűleg először hozzá akarsz adni pár saját entitást. Ehhez válassz ki egy kategóriát balról. Azokat a kategóriákat, melyekre nincs szükséged, kikapcsolhatod a kampány beállításainál, elrejtve őket a menüből.

Néhány tipp az induláshoz:
- Az @entitásNeve szintaxist használva hivatkozhatsz specifikus entitásokra. A megjelenő szöveg automatikusan frissülni fog, ha átnevezed vagy módosítod a hivatkozott entitást.
- Néhány fiókspecifikus beállítás, mint például a vizuális téma vagy a laponkénti entitások száma a profilodban módosítható, melyet a jobb felső sarokból érhetsz el. További információkat - például a tulajdonságok beállításáról vagy a kampányod megosztásának lehetőségeiről - találhatsz a :faq oldalon és a :youtube csatornánkon.
- Ha további kérdéseid vannak, vagy csak csevegni szeretnél, lépj be a :discord szerverünkre!
TEXT
,
        'header'    => 'Üdvözlünk',
    ],
    'widgets'           => [
        'calendar'  => [
            'actions'           => [
                'next'      => 'Átállítás a következő napra',
                'previous'  => 'Átállítás az előző napra',
            ],
            'events_today'      => 'Ma',
            'previous_events'   => 'Előző',
            'upcoming_events'   => 'Küszöbön álló',
        ],
        'create'    => [
            'success'   => 'Hozzáadtuk a widget-et a főoldalhoz.',
        ],
        'delete'    => [
            'success'   => 'Eltávolítottuk a widget-et a főoldalról.',
        ],
        'recent'    => [
            'help'      => 'Csak az utoljára frissített entitást mutasd, de teljes előnézettel',
            'singular'  => 'Csak az utolsót',
            'title'     => 'Mostanában módosított',
        ],
        'update'    => [
            'success'   => 'Módosítottuk a widget-et.',
        ],
    ],
];
