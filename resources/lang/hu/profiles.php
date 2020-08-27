<?php

return [
    'avatar'        => [
        'success'   => 'A profilképet frissítettük.',
    ],
    'description'   => 'A profilod részleteinek módosítása',
    'edit'          => [
        'success'   => 'A profilodat frissítettük.',
    ],
    'editors'       => [
        'default'       => 'Alapértelmezett (TinyMCE 4)',
        'summernote'    => 'Summernote (Kísérleti)',
    ],
    'fields'        => [
        'avatar'                    => 'Profilkép',
        'email'                     => 'Email',
        'last_login_share'          => 'Engedélyezd a többi kampány tag számára, hogy láthassák, hogy mikor jelentkeztem be utoljára.',
        'name'                      => 'Név',
        'new_password'              => 'Új jelszó',
        'new_password_confirmation' => 'Új jelszó megerősítése',
        'newsletter'                => 'Szeretnék hírlevelet kapni.',
        'password'                  => 'Jelenlegi jelszó',
        'settings'                  => 'Beállítások',
        'theme'                     => 'Téma',
    ],
    'newsletter'    => [
        'links'     => [
            'community-vote'    => 'Közösségi szavazás',
            'news'              => 'Hírek',
        ],
        'settings'  => [
            'news'          => 'Hírek - értesíts, amikor vannak :news.',
            'newsletter'    => 'Hírlevél - feliratkozás a Kanka hírlevelére.',
            'votes'         => 'Közösségi szavazás - értesíts amint egy új :vote elérhető.',
        ],
        'title'     => 'Hírlevelek',
    ],
    'password'      => [
        'success'   => 'A jelszavadat frissítettük.',
    ],
    'placeholders'  => [
        'email'                     => 'Az email-címed',
        'name'                      => 'A megjelenítendő neved',
        'new_password'              => 'Az új jelszavad',
        'new_password_confirmation' => 'Gépeld be ismét az új jelszavad!',
        'password'                  => 'Bármilyen változtatáshoz add meg a jelenlegi jelszavad is!',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Töröljétek a fiókomat!',
            'title'     => 'A fiókod törlése',
            'warning'   => 'A fiókod törlésével minden adatod elvész. Biztos vagy benne?',
        ],
        'password'  => [
            'title' => 'A jelszavad megváltoztatása',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions' => 'Haladó Említések',
            'date_format'       => 'Dátumformátum',
            'default_nested'    => 'Alapértelmezetten hierarchikus nézet',
            'editor'            => 'Szövegszerkesztő',
            'pagination'        => 'Lapméret (elemek száma egy lapon)',
        ],
        'helpers'   => [
            'editor'    => 'Az alapértelmezett szerkesztő (TinyMCE 4) régi, jól működik desktop környezetben, de a mobil eszközökön nem. A Summernote egy újabb szerkesztő, amely minden eszközön egyaránt működik, de egyelőre még próbafázisban van.',
        ],
        'hints'     => [
            'advanced_mentions' => 'Kapcsold be, ha szeretnéd, hogy az említések minden esetben [entity:123] formában jelenjenek meg az entitás szerkesztése közben.',
            'default_nested'    => 'Kapcsold be, ha alapértelmezetten Hierarchikus Nézetben szeretnéd látni az entitásaidat (amikor lehetséges)',
        ],
        'success'   => 'A beállításokat megváltoztattuk.',
    ],
    'theme'         => [
        'success'   => 'A témát megváltoztattuk.',
        'themes'    => [
            'dark'      => 'Sötét',
            'default'   => 'Alap',
            'future'    => 'Futurisztikus',
            'midnight'  => 'Éjféli Kék',
        ],
    ],
    'title'         => 'A profilod módosítása',
];
