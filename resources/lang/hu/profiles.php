<?php

return [
    'avatar'        => [
        'success'   => 'A profilképet frissítettük.',
    ],
    'edit'          => [
        'success'   => 'A profilodat frissítettük.',
    ],
    'editors'       => [
        'legacy'        => 'Örökség (TinyMCE 4)',
        'summernote'    => 'Summernote',
    ],
    'fields'        => [
        'avatar'                    => 'Profilkép',
        'email'                     => 'Email',
        'hide_subscription'         => 'Rejtsd el a nevemet innen: :hall_of_fame',
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
        'helpers'   => [
            'community-vote'    => 'Értesítst mindig, amikor új : community-vote van.',
            'header'            => 'Íratkozz fel a következő email-hírlevélre, hogy képben legyél, mi történik a Kanka háza táján.',
            'monthly'           => 'Havi összesítő a Kanka eseményeiről.',
            'release'           => 'Légy képben, amikor a Kankát frissítjük, hogy mi változott.',
        ],
        'links'     => [
            'community-vote'    => 'Közösségi szavazás',
            'news'              => 'Hírek',
            'updates'           => 'Kanka frissítések',
        ],
        'options'   => [
            'monthly'   => 'Kanka hírlevél',
            'release'   => 'Új frissítés',
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
            'helper'    => 'Ha törlöd a fiókodat, az töröl minden kampányt, ahol csak te vagy tag. Ez végleges, nem lehet visszacsinálni.',
            'title'     => 'A fiókod törlése',
            'warning'   => 'A fiókod törlésével minden adatod elvész. Biztos vagy benne?',
        ],
        'password'  => [
            'title' => 'A jelszavad megváltoztatása',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions'     => 'Haladó Említések',
            'date_format'           => 'Dátumformátum',
            'default_nested'        => 'Alapértelmezetten hierarchikus nézet',
            'editor'                => 'Szövegszerkesztő',
            'new_entity_workflow'   => 'Új entitás munkafolyamat',
            'pagination'            => 'Lapméret (elemek száma egy lapon)',
        ],
        'helpers'   => [
            'editor'    => 'Az alapértelmezett szerkesztő (TinyMCE 4) régi, jól működik desktop környezetben, de a mobil eszközökön nem. A Summernote egy újabb szerkesztő, amely minden eszközön egyaránt működik, de egyelőre még próbafázisban van.',
            'editor_v2' => 'Az örökölt szövegszerkesztő (TinyMCE) használatát nem támogatjuk mobil eszközökn, és néhány lehetőséggel nem rendelkezik, mint például a kampánygaléria.',
        ],
        'hints'     => [
            'advanced_mentions'     => 'Kapcsold be, ha szeretnéd, hogy az említések minden esetben [entity:123] formában jelenjenek meg az entitás szerkesztése közben.',
            'default_nested'        => 'Kapcsold be, ha alapértelmezetten Hierarchikus Nézetben szeretnéd látni az entitásaidat (amikor lehetséges)',
            'new_entity_workflow'   => 'Amikor új entitás hozol létre, az alapértelmezett munkafolymat az entitások listájára ugrás. Ezt megváltoztathatod, hogy az újonnan létrehozott entitást mutassa.',
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
    'workflows'     => [
        'created'   => 'A létrehozott entitásra ugrás',
        'default'   => 'Entitások listája',
    ],
];
