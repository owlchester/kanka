<?php

return [
    'create'                => [
        'description'           => 'Új kampány létrehozása',
        'helper'                => [
            'first' => 'Köszi, hogy kipróbálod az alkalmazást! Mielőtt bármit csinálhatnál, egy egyszerű dologra szükségünk van tőled: a <b>kampányod nevére</b>. Ez a világod neve, ami megkülönbözteti a többitől. Ha most nem tudsz egy jó nevet kitalálni, ne aggódj, <b>később megváltoztathatod</b>, vagy több kampányt is létrehozhatsz.',
            'second'=> 'De elég a dumából, mihez kezdjünk?',
            'title' => 'Üdvözöllek :name világában!',
        ],
        'success'               => 'A kampányt létrehoztuk.',
        'success_first_time'    => 'A kampányodat létrehoztuk! Milve ez az első kampányod, csináltunk néhány dolgot, ami segít a kezdésben, és remélhetőleg némi inspirációt biztosít számodra.',
        'title'                 => 'Új kampány',
    ],
    'destroy'               => [
        'success'   => 'A kampányt eltávolítottuk.',
    ],
    'edit'                  => [
        'description'   => 'A kampányod szerkesztése',
        'success'       => 'A kampányt frissítettük.',
        'title'         => ':campaign kampány szerkesztése',
    ],
    'entity_visibilities'   => [
        'private'   => 'Az új entitások privát beállításúak.',
    ],
    'errors'                => [
        'access'        => 'Nincs hozzáférésed ehhez a kampányhoz.',
        'unknown_id'    => 'Ismeretlen kampány.',
    ],
    'export'                => [
        'description'   => 'Kampány exportálása.',
        'errors'        => [
            'limit' => 'Elérted a napi exportálási lehetőségeid számát. Kérjük, holnap próbáld meg újra.',
        ],
        'helper'        => 'A kampányod exportálása. Kapsz majd egy értesítést a Kankában a letölthető zip állományról, amint az elkészül.',
        'success'       => 'A kampányod exportja előkészítés alatt áll. Kapsz majd egy értesítést a Kankában a letölthető zip állományról, amint az elkészül.',
        'title'         => ':name kampány exportálása',
    ],
    'fields'                => [
        'description'       => 'Leírás',
        'entity_visibility' => 'Entitás láthatósága',
        'header_image'      => 'Fejléc képe',
        'image'             => 'Kép',
        'locale'            => 'Hely',
        'name'              => 'Név',
        'system'            => 'Rendszer',
        'visibility'        => 'Láthatóság',
    ],
    'helpers'               => [
        'entity_visibility' => 'Amikor új entitást hozol létre, a "Privát" opciót automatikusan kiválasztjuk.',
        'locale'            => 'Amilyen nyelven írod a kampányodat. Ezt a tartalom-generáláshoz és a nyilvános kampányok csoportosításához használjuk.',
        'name'              => 'A kampányod/világod neve bármi lehet, ami legalább 4 számot vagy betűt tartalmaz.',
        'visibility'        => 'Ha egy kampányt nyilvánossá teszel, bárki egy link segítségével meg tudja nézni.',
    ],
    'index'                 => [
        'actions'       => [
            'new'   => [
                'description'   => 'Új kapmány létrehozása',
                'title'         => 'Új kampány',
            ],
        ],
        'add'           => 'Új kampány',
        'description'   => 'A kampányaid kezelése.',
        'list'          => 'Kampányaid',
        'select'        => 'Válassz egy kampányt!',
        'title'         => 'Kampányok',
    ],
    'invites'               => [
        'actions'       => [
            'add'   => 'Meghívó',
            'link'  => 'Új link',
        ],
        'create'        => [
            'button'        => 'Meghívó',
            'description'   => 'Hívd meg egy barátodat a kampányodba!',
            'link'          => 'A linket létrehoztuk: : <a href=":url" target="_blank">:url</a>',
            'success'       => 'A meghívót elküldtük.',
            'title'         => 'Hívj meg valakit a kampányodba!',
        ],
        'destroy'       => [
            'success'   => 'A meghívót eltávolítottuk.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Csatlakozás :name kampányhoz</a>',
            'subject'   => ':name meghívott, hogy csatlakozz a \':campaign\' nevű kampányához a kanka.io oldalon! Használd az alábbi linket a csatlakozkáshoz!',
            'title'     => 'Meghívó :name nevű felhasználótól',
        ],
        'error'         => [
            'already_member'    => 'Már tagja vagy annak a kampánynak.',
            'inactive_token'    => 'Ezt a tokent már felhasználták, vagy a kampány már nem létezik.',
            'invalid_token'     => 'Ez a token már nem érvényes.',
            'login'             => 'Kérjük, lépj be vagy regisztrálj, hogy csatlakozni tudj a kampányhoz!',
        ],
        'fields'        => [
            'created'   => 'Küldés',
            'email'     => 'Email',
            'role'      => 'Szerep',
            'type'      => 'Típus',
            'validity'  => 'Érvényesség',
        ],
        'helpers'       => [
            'validity'  => 'Hány felhasználó tudja használni ezt a linket, mielőtt deaktviálódik.',
        ],
        'placeholders'  => [
            'email' => 'Az illető email-címe, aki meg szeretnél hívni.',
        ],
        'types'         => [
            'email' => 'Email',
            'link'  => 'Link',
        ],
    ],
    'leave'                 => [
        'confirm'   => 'Biztos vagy benne, hogy el akarod hagyni az :name nevű kampányt? Nem tudsz majd többé hozzáférni, kivéve, ha a kampány tulajdonosa újra meghív téged.',
        'error'     => 'Nem tudod elhagyni a kampányt.',
        'success'   => 'Elhagytad a kampányt.',
    ],
    'members'               => [
        'create'        => [
            'title' => 'Új tag hozzáadása a kapmányhoz.',
        ],
        'description'   => 'A kapmány tagjainak kezelése',
        'edit'          => [
            'description'   => 'A kampányod tagjainak kezelése',
            'title'         => ':name nevű tag kezelése',
        ],
        'fields'        => [
            'joined'    => 'Csalatkozott',
            'name'      => 'Felhasználó',
            'role'      => 'Szerep',
            'roles'     => 'Szerep',
        ],
        'help'          => 'Nincs korlátozva, hogy hány tagja lehet egy kampánynak, és mint a kampány Adminja, el is távolíthatod azokat a tagokat, akik már nem aktívak.',
        'invite'        => [
            'description'   => 'Meghívhatod a barátaidat az email-címük megadásával, hogy csatlakozzanak a kampányodhoz. Ha elfogadják a meghívást, tagok lesznek az igénylet szerepben. A kiküldött meghívókat bármikor visszavonhatod.',
            'title'         => 'Meghívó',
        ],
        'roles'         => [
            'member'    => 'Tag',
            'owner'     => 'Tulajdonos',
            'public'    => 'Nyilvános',
            'viewer'    => 'Megjelenítés',
        ],
        'title'         => ':name kampány tagjai',
        'your_role'     => 'A szereped: <i>:role</i>',
    ],
    'placeholders'          => [
        'description'   => 'A kampányod rövid összefoglalása.',
        'locale'        => 'Nyelvkód',
        'name'          => 'A kampányod neve',
        'system'        => 'D&D 5e, 3.5, Pathfinder, Kard és Mágia, M.A.G.U.S., Dungeon World',
    ],
    'roles'                 => [
        'actions'       => [
            'add'   => 'Szerep hozzáadása',
        ],
        'create'        => [
            'success'   => 'A szerepet létrehoztuk.',
            'title'     => ':name számára új szerep létrehozása',
        ],
        'description'   => 'A kampány szerepeinek kezelése',
        'destroy'       => [
            'success'   => 'A szerepet eltávolítottuk.',
        ],
        'edit'          => [
            'success'   => 'A szerepet frissítettük.',
            'title'     => ':name szerep szerkesztése',
        ],
        'fields'        => [
            'name'          => 'Név',
            'permissions'   => 'Engedélyek',
            'type'          => 'Típus',
            'users'         => 'Felhasználók',
        ],
        'helper'        => [
            '1' => 'Egy kampányhoz akárhány szerep tartozhat. Az "Admin" szerep automatikusan mindenhez hozzáfér a kampányban, de minden más szerep speciális engedélyekkel bír a különböző típusú entitások (mint karakter, helyszín stb.) esetében.',
            '2' => 'Az entitásoknak még több finomhangolható engedélyei vannak az "Engedélyek" fülön. Ez a fül akkor jelenik meg, amikor a kampányodnak már vannak szerepei vagy tagjai.',
            '3' => 'Használhatsz "opt-out" rendszert, ahol a szerepek hozzáférnek minden entitáshoz, és inkább a "Privát" jelölőt használod az entitásoknál, hogy elrejtsd őket. Vagy nem adsz túl sok engedély a szerepeknek, de minden entitást láthatóvá teszel.',
        ],
        'hints'         => [
            'public'            => 'A Nyilvános szerepet akkor használjuk, amikor valaki a nyilvános kampányodat böngészi. :more',
            'role_permissions'  => ':name szerep számára engedélyezni az alábbi tevékenységeket minden etnitás esetében.',
        ],
        'members'       => 'Tagok',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Létrehozás',
                'delete'        => 'Törlés',
                'edit'          => 'Szerkesztés',
                'permission'    => 'Engedélyek kezelése',
                'read'          => 'Megtekintés',
            ],
            'hint'      => 'Ez a szerep automatikusan hozzáférst biztosít mindenhez.',
        ],
        'placeholders'  => [
            'name'  => 'A szerep neve.',
        ],
        'show'          => [
            'description'   => 'Egy kampányszerep tagjai és engedélyei.',
            'title'         => '\':role\' kampányszerep',
        ],
        'title'         => ':name kampány szerepei',
        'types'         => [
            'owner'     => 'Tulajdonos',
            'public'    => 'Nyilvános',
            'standard'  => 'Sztenderd',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Hozzáadás',
            ],
            'create'    => [
                'success'   => 'A felhasználót hozzáadtuk a szerephez.',
                'title'     => 'Tag hozzáadása a :role szerephez',
            ],
            'destroy'   => [
                'success'   => 'A felhasználót eltávolítottuk a szerepből.',
            ],
            'fields'    => [
                'name'  => 'Név',
            ],
        ],
    ],
    'settings'              => [
        'description'   => 'A kampány moduljainak ki- és bekapcsolása.',
        'edit'          => [
            'success'   => 'A kampány beállításait frissítettük.',
        ],
        'helper'        => 'A kampány minden modulját lehet ki-be kapcsolgatni. Ha kikapcsolod, egyszerűen csak eltűnik a hozzátartozó felület, de a létrehozott entitások megmaradnak a háttérben, ha esetleg meggondolnád magadat. Ez a változás a kampány minden felhasználóját érinti, beleértve az Admin felhasználókat is.',
        'helpers'       => [
            'calendars'     => 'Egy hely, ahol a világod naptárát alkothatod meg.',
            'characters'    => 'Az emberek, akik benépesítik a világodat.',
            'conversations' => 'Kitalált beszélgetések a karakterek vagy a felhasználók között.',
            'dice_rolls'    => 'Azok számára, akik szerepjátékhoz használják a Kanakát, egy hasznos eszköz a dobások kezelésére.',
            'events'        => 'Ünnepnapok, fesztiválok, katasztrófák, születésnapok, háborúk.',
            'families'      => 'Klánok vagy családok, kapcsolataik és tagjaik.',
            'items'         => 'Fegyverek, járművek, relikviák, italok.',
            'journals'      => 'A karakterek által írt hozzászólások vagy a játékülésre való előkészület a mesélő részéről.',
            'locations'     => 'Bolygók, síkok, kontinensek, folyók, államok, települések, templomok, kocsmák.',
            'menu_links'    => 'Egyedi menülinkek az oldalsó sávban.',
            'notes'         => 'Ismeretek, egyházak, történelem, mágia, fajok.',
            'organisations' => 'Kultuszok, katonai egységek, frakciók, céhek.',
            'quests'        => 'Számon tudod tartani a különböző küldetéseket a karakterekhez és a helyszínekhez kapcsolódóan.',
            'races'         => 'Ha a kampányodban több mint egy faj található, itt könnyen számon tarthatod azokat.',
            'tags'          => 'Minden entitásnak lehet több címkéje is. A címkék más címkékhez is tartozhatnak, és az entitásokat szűrni lehet a címkék alapján.',
        ],
        'title'         => ':name kampány moduljai',
    ],
    'show'                  => [
        'actions'       => [
            'leave' => 'Kilépés a kampányból',
        ],
        'description'   => 'Egy kampány részleteinek megjelenítése',
        'tabs'          => [
            'export'        => 'Export',
            'information'   => 'Információ',
            'members'       => 'Tagok',
            'menu'          => 'Menü',
            'roles'         => 'Szerepek',
            'settings'      => 'Modulok',
        ],
        'title'         => ':name kampány',
    ],
    'visibilities'          => [
        'private'   => 'Privát',
        'public'    => 'Nyilvános',
        'review'    => 'Felülvizsgálatra váró',
    ],
];
