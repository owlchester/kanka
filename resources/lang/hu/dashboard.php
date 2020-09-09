<?php

return [
    'actions'           => [
        'follow'    => 'Követés',
        'unfollow'  => 'Követés visszavonása',
    ],
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
        'follow'    => 'Egy kampány követése esetén megjelenik majd a kampányválasztó menüben (jobbra fent) a saját kampányaid alatt.',
        'setup'     => 'Állítsd be a kampányod főoldalát!',
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
            'calendar'      => 'Naptár',
            'preview'       => 'Entitás előnézete',
            'random'        => 'Véletlen entitás',
            'recent'        => 'Mostanában',
            'unmentioned'   => 'Nem említett entitások',
        ],
    ],
    'title'             => 'Főoldal',
    'welcome'           => [
        'body'  => <<<'TEXT'
Üdvözlünk a Kankában! Létrehoztuk az első kampányodat és bedobtunk pár példa-entitást inspirációként (törölheted őket, amikor csak szeretnéd).

Valószínűleg először hozzá akarsz adni pár saját entitást. Ehhez válassz ki egy kategóriát balról. Azokat a kategóriákat, melyekre nincs szükséged, kikapcsolhatod a kampány beállításainál, elrejtve őket a menüből.

Néhány tipp az induláshoz:
- Az @entitásNeve szintaxist használva hivatkozhatsz specifikus entitásokra. A megjelenő szöveg automatikusan frissülni fog, ha átnevezed vagy módosítod a hivatkozott entitást.
- Néhány fiókspecifikus beállítás, mint például a vizuális téma vagy a laponkénti entitások száma a profilodban módosítható, melyet a jobb felső sarokból érhetsz el. További információkat - például a tulajdonságok beállításáról vagy a kampányod megosztásának lehetőségeiről - találhatsz a :faq oldalon és a :youtube csatornánkon.
- Ha további kérdéseid vannak, vagy csak csevegni szeretnél, lépj be a :discord szerverünkre!
TEXT
,
    ],
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Átállítás a következő napra',
                'previous'  => 'Átállítás az előző napra',
            ],
            'events_today'      => 'Ma',
            'previous_events'   => 'Előző',
            'upcoming_events'   => 'Küszöbön álló',
        ],
        'create'        => [
            'success'   => 'Hozzáadtuk a widget-et a főoldalhoz.',
        ],
        'delete'        => [
            'success'   => 'Eltávolítottuk a widget-et a főoldalról.',
        ],
        'fields'        => [
            'width' => 'Szélesség',
        ],
        'recent'        => [
            'entity-header' => 'Használd az entitás fejlécet, mint képet',
            'full'          => 'Teljes',
            'help'          => 'Csak az utoljára frissített entitást mutasd, de teljes előnézettel',
            'helpers'       => [
                'entity-header' => 'Ha az entitásodnak van beállított entitás fejléce (boost-olt kampányok számára elérhető funkció), akkor beállíthatod ezt a widget-et, hogy használja azt a képet, az entitás képe helyett.',
                'full'          => 'Az entitás teljes bejegyzését jelenítsd meg, az előnézet helyett.',
            ],
            'singular'      => 'Csak az utolsót',
            'tags'          => 'Szűrés a mostanában módosított widget-ek között, meghatározott címkék alapján.',
            'title'         => 'Mostanában módosított',
        ],
        'unmentioned'   => [
            'title' => 'Nem említett entitások',
        ],
        'update'        => [
            'success'   => 'Módosítottuk a widget-et.',
        ],
        'widths'        => [
            '0' => 'Auto',
            '12'=> 'Teljes',
            '4' => 'Apró',
            '6' => 'Fél',
        ],
    ],
];
