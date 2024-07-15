<?php

return [
    'create'                            => [
        'description'           => 'Új kampány létrehozása',
        'helper'                => [
            'title'     => 'Üdvözöllek :name világában!',
            'welcome'   => <<<'TEXT'
Mielőtt tovább lépnénk, ki kell választanod a kampányod nevét. Ez lesz a világod neve. Ha még nincs meg a tökéletes név, ne aggódj, később bármikor megváltoztathatod, vagy új kampányokat is készíthetsz.

Köszönjük, hogy a Kanka, és virágzó közösségünk tagjaként üdvözölhetünk!
TEXT
,
        ],
        'success'               => 'A kampányt létrehoztuk.',
        'success_first_time'    => 'A kampányodat létrehoztuk! Milve ez az első kampányod, csináltunk néhány dolgot, ami segít a kezdésben, és remélhetőleg némi inspirációt biztosít számodra.',
        'title'                 => 'Új kampány',
    ],
    'destroy'                           => [
        'action'    => 'Kampány törlése',
        'success'   => 'A kampányt eltávolítottuk.',
    ],
    'edit'                              => [
        'success'   => 'A kampányt frissítettük.',
        'title'     => ':campaign kampány szerkesztése',
    ],
    'entity_note_visibility'            => [],
    'entity_personality_visibilities'   => [
        'private'   => 'Az új karakterek személyisége legyen alapértelmezetten privát.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Az új entitások privát beállításúak.',
    ],
    'errors'                            => [
        'access'        => 'Nincs hozzáférésed ehhez a kampányhoz.',
        'unknown_id'    => 'Ismeretlen kampány.',
    ],
    'export'                            => [],
    'fields'                            => [
        'boosted'                   => 'A kampány megerősítője',
        'connections'               => 'Mutasd meg egy entitás kapcsolati tábláját az alapértelmezettek szerint (a megerősített kampányok viszonyfelfedezője helyett)',
        'css'                       => 'CSS',
        'description'               => 'Leírás',
        'entity_count'              => 'Entitások száma',
        'entry'                     => 'Kampány leírása',
        'excerpt'                   => 'Kivonat',
        'followers'                 => 'Követők',
        'header_image'              => 'Fejléc képe',
        'image'                     => 'Kép',
        'locale'                    => 'Nyelv',
        'name'                      => 'Név',
        'open'                      => 'Megnyitás az alkalmazások számára',
        'public_campaign_filters'   => 'Publikus kampány szűrők',
        'related_visibility'        => 'Kapcsolódó elemek láthatósága',
        'superboosted'              => 'Szupererősítette',
        'system'                    => 'Rendszer',
        'theme'                     => 'Téma',
        'visibility'                => 'Láthatóság',
    ],
    'following'                         => 'Követve',
    'helpers'                           => [
        'boosted'                   => 'Néhány funkció elérhetővé vált, mivel a kampány boost-olva van. További információk a :settings oldalon olvashatóak.',
        'css'                       => 'Írj saját CSS kódot, amely a kampányod oldalaira applikálódik majd. Kérlek vedd figyelembe, hogy az ezzel a funkcióval kapcsolatos bármiféle visszaélés az egyedi CSS törléséhez vezethet! Többszöri, vagy súlyos visszaélés esetén a teljes kampányod törlésre kerülhet.',
        'dashboard'                 => 'A következő mezők kitöltésével személyre szabhatod a kampányod főoldalán a widgeteket.',
        'excerpt'                   => 'A kampány kivonata a főoldalon jelenik meg, írj hát pár mondatot, világod bemutatására! Fogalmazz tömören a legjobb eredmény érdekében.',
        'header_image'              => 'A kampány főoldalának háttereként megjelenő kép.',
        'hide_history'              => 'Az entitások változás naplójának elrejtése minden nem admin szerepű felhasználó számára.',
        'hide_members'              => 'A kampány résztvevőinek listája elrejtésre kerül minden nem admin szerepű felhasználó elől.',
        'locale'                    => 'Amilyen nyelven írod a kampányodat. Ezt a tartalom-generáláshoz és a nyilvános kampányok csoportosításához használjuk.',
        'name'                      => 'A kampányod/világod neve bármi lehet, ami legalább 4 számot vagy betűt tartalmaz.',
        'public_campaign_filters'   => 'Segíts másoknak a kampány könnyebb megtalálásában az alábbi adatok kitöltésével.',
        'public_no_visibility'      => 'Fel a fejjel! A kampányod publikus, de a kampány public szerepe nem fér hozzá semmihez. :fix.',
        'related_visibility'        => 'Az alapértelmezett láthatóság érték, amikor új példány jön létre ezzel a mezővel (entitás jegyzet, kapcsolatok, képességek, stb.)',
        'system'                    => 'Ha a kampányod nyilvánosan látható, a rendszer a :link oldalon látható.',
        'systems'                   => 'Hogy elkerüljük a felhasználók elárasztását szükségtelen opciókkal, néhány funkció csak adott szerepjáték rendszerek esetén érhető el (ilyen például a D&D 5e szörny harcérték blokk, a tulajdonságblokkok között). Támogatott rendszerek hozzáadásával engedélyezheted ezeket a funkciókat.',
        'theme'                     => 'Adott téma rögzítése a kampányhoz, amely minden esetben felülbírálja a felhasználók saját preferenciáját.',
        'view_public'               => 'Hogy lásd, hogy mi mindent látszik a kampányodból egy olvasó számára, nyisd meg az alábbi linket: :link a böngésződ Inkognitó módjában.',
        'visibility'                => 'Ha egy kampányt nyilvánossá teszel, bárki egy link segítségével meg tudja nézni.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Új kampány',
            ],
        ],
    ],
    'invites'                           => [
        'actions'               => [
            'copy'  => 'Másold ki ezt a linket a vágólapra!',
            'link'  => 'Új link',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Meghívó létrehozása',
            ],
            'success_link'  => 'Link létrehozva: :link',
            'title'         => 'Hívj meg valakit a kampányodba!',
        ],
        'destroy'               => [
            'success'   => 'A meghívót eltávolítottuk.',
        ],
        'error'                 => [
            'already_member'    => 'Már tagja vagy annak a kampánynak.',
            'inactive_token'    => 'Ezt a tokent már felhasználták, vagy a kampány már nem létezik.',
            'invalid_token'     => 'Ez a token már nem érvényes.',
            'login'             => 'Kérjük, lépj be vagy regisztrálj, hogy csatlakozni tudj a kampányhoz!',
        ],
        'fields'                => [
            'created'   => 'Küldés',
            'role'      => 'Szerep',
            'type'      => 'Típus',
        ],
        'unlimited_validity'    => 'Korlátlan',
        'usages'                => [
            'five'      => '5 használat',
            'no_limit'  => 'Nincs limit',
            'once'      => '1 használat',
            'ten'       => '10 használat',
        ],
    ],
    'leave'                             => [
        'confirm'   => 'Biztos vagy benne, hogy el akarod hagyni az :name nevű kampányt? Nem tudsz majd többé hozzáférni, kivéve, ha a kampány tulajdonosa újra meghív téged.',
        'error'     => 'Nem tudod elhagyni a kampányt.',
        'success'   => 'Elhagytad a kampányt.',
    ],
    'members'                           => [
        'actions'               => [
            'remove'        => 'Eltávolítás a kampányból',
            'switch'        => 'Váltás',
            'switch-back'   => 'Vissza a saját felhasználómhoz',
        ],
        'create'                => [
            'title' => 'Új tag hozzáadása a kapmányhoz.',
        ],
        'edit'                  => [
            'title' => ':name nevű tag kezelése',
        ],
        'fields'                => [
            'joined'        => 'Csalatkozott',
            'last_login'    => 'Utoljára bejelentkezve',
            'name'          => 'Felhasználó',
            'role'          => 'Szerep',
            'roles'         => 'Szerep',
        ],
        'helpers'               => [
            'switch'    => 'Válts erre a felhasználóra',
        ],
        'impersonating'         => [
            'message'   => 'Jelenleg úgy látod ezt a kampányt, mintha egy másik felhasználó lennél. Néhány funkció nem elérhető, de a többi pontosan úgy viselkedik, ahogy a felhasználó látná. A visszalépéshez kattints a "Vissza a saját felhasználómhoz" gombra, ami a Kijelentkezés gomb helyén található.',
            'title'     => ':name megszemélyesítése',
        ],
        'invite'                => [
            'description'   => 'Meghívhatod a barátaidat az email-címük megadásával, hogy csatlakozzanak a kampányodhoz. Ha elfogadják a meghívást, tagok lesznek az igénylet szerepben. A kiküldött meghívókat bármikor visszavonhatod.',
            'more'          => 'További szerepeket adhatsz hozzá itt :link',
            'title'         => 'Meghívó',
        ],
        'manage_roles'          => 'Kezeld a felhasználói szerepeket',
        'roles'                 => [
            'member'    => 'Tag',
            'owner'     => 'Tulajdonos',
            'player'    => 'Játékos',
            'public'    => 'Nyilvános',
            'viewer'    => 'Megjelenítés',
        ],
        'switch_back_success'   => 'Visszatértél az eredeti felhasználódhoz.',
        'title'                 => ':name kampány tagjai',
        'updates'               => [
            'added'     => ':role szerepet hozzáadtuk :user felhasználóhoz.',
            'removed'   => ':role szerepet eltávolítottuk :user felhasználótól.',
        ],
    ],
    'open_campaign'                     => [],
    'panels'                            => [
        'dashboard' => 'Főoldal',
        'permission'=> 'Jogosultság',
        'setup'     => 'Beállítás',
        'sharing'   => 'Megosztás',
        'systems'   => 'Rendszerek',
        'ui'        => 'Felület',
    ],
    'placeholders'                      => [
        'description'   => 'A kampányod rövid összefoglalása.',
        'locale'        => 'Nyelvkód',
        'name'          => 'A kampányod neve',
        'system'        => 'D&D 5e, 3.5, Pathfinder, Kard és Mágia, M.A.G.U.S., Dungeon World',
    ],
    'roles'                             => [
        'actions'       => [
            'add'           => 'Szerep hozzáadása',
            'permissions'   => 'Engedélyek kezelése',
            'rename'        => 'Szerep átnevezése',
            'save'          => 'Szerep mentése',
        ],
        'admin_role'    => 'admin szerep',
        'create'        => [
            'success'   => 'A szerepet létrehoztuk.',
            'title'     => ':name számára új szerep létrehozása',
        ],
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
            'campaign_not_public'   => 'A publikus szerep adna jogosultságokat, de a kampány privát láthatóságú. Megváltoztathatod ezt a beállítást a Megosztás fülön, a kampány szerkesztése közben.',
            'role_permissions'      => ':name szerep számára engedélyezni az alábbi tevékenységeket minden etnitás esetében.',
        ],
        'members'       => 'Tagok',
        'modals'        => [
            'details'   => [
                'campaign'  => 'A kapmányengedélyek az alábbiakat hagyják.',
                'entities'  => 'Ez egy gyors összefoglaló, hogy a szerep tagjai mit kapnak, amikor egy engedélyt beállítunk.',
                'more'      => 'Részletekért nézd meg az oktatóvideónkat a Youtube-on.',
                'title'     => 'Engedély részletei',
            ],
        ],
        'permissions'   => [
            'actions'   => [
                'add'           => 'Létrehozás',
                'dashboard'     => 'Főoldal',
                'delete'        => 'Törlés',
                'edit'          => 'Szerkesztés',
                'entity-note'   => 'Entitás jegyzet',
                'manage'        => 'Kezelés',
                'members'       => 'Tagok',
                'permission'    => 'Engedélyek kezelése',
                'read'          => 'Megtekintés',
                'toggle'        => 'Váltás mindnél',
            ],
            'helpers'   => [
                'add'           => 'Engedi, hogy ilyen típusú entitást hozzanak létre. Automatikusan megnézhetik és szerkeszthetik az általuk létrehozott entitást, ha nincs engedélyük a megnézésre és szerkesztésre.',
                'dashboard'     => 'Szerkeszthetik a főoldalakat és a főoldal widgeteket.',
                'delete'        => 'Eltávolíthatnak minden entitást ebből a típusból.',
                'edit'          => 'Ennek az entitástípusnak minden entitását szerkeszthetik.',
                'entity_note'   => 'Ez lehetővé teszi Entitás jegyzetek hozzáadását olyan felhasználók számára is, akiknek nincs szerkesztési joguk az adott Entitásra.',
                'manage'        => 'Szerkeszthetik a kampányt, mint az admin, de persze nem törölhetik azt.',
                'members'       => 'Meghívhatnak tagokat a kampányba.',
                'permission'    => 'Állítgathatják az engedélyeit az ilyen típusú entitásokból azokét, amit szerkeszthetnek.',
                'read'          => 'Megnézhetik mindegyik entitást ebből a típusból, ami nem privát.',
            ],
        ],
        'placeholders'  => [
            'name'  => 'A szerep neve.',
        ],
        'show'          => [
            'title' => '\':role\' kampányszerep',
        ],
        'title'         => ':name kampány szerepei',
        'types'         => [
            'owner'     => 'Tulajdonos',
            'public'    => 'Nyilvános',
            'standard'  => 'Sztenderd',
        ],
        'users'         => [
            'actions'   => [
                'add'       => 'Hozzáadás',
                'remove'    => ':user a :role szerepből',
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
    'settings'                          => [
        'actions'   => [
            'enable'    => 'Engedélyezés',
        ],
        'boosted'   => 'Ez a lehetőség egyelőre béta állapotban van, így csak :boosted számára elérhető.',
        'helpers'   => [
            'abilities'     => 'Entitásokhoz kapcsolható képességek létrehozása, legyen akár különleges képesség, varázslat vagy varázsaltos erő.',
            'calendars'     => 'Egy hely, ahol a világod naptárát alkothatod meg.',
            'characters'    => 'Az emberek, akik benépesítik a világodat.',
            'conversations' => 'Kitalált beszélgetések a karakterek vagy a felhasználók között.',
            'dice_rolls'    => 'Egy hasznos eszköz a dobások kezelésére azok számára, akik szerepjátékhoz használják a Kankát',
            'events'        => 'Ünnepnapok, fesztiválok, katasztrófák, születésnapok, háborúk.',
            'families'      => 'Klánok vagy családok, kapcsolataik és tagjaik.',
            'inventories'   => 'Az entitásaid tartalmának kezelése',
            'items'         => 'Fegyverek, járművek, relikviák, italok.',
            'journals'      => 'A karakterek által írt hozzászólások vagy a játékülésre való előkészület a mesélő részéről.',
            'locations'     => 'Bolygók, síkok, kontinensek, folyók, államok, települések, templomok, kocsmák.',
            'maps'          => 'Tölts fel több rétegű térképeket, melyek különböző entitásokra mutatnak a kampányodban.',
            'notes'         => 'Ismeretek, egyházak, történelem, mágia, fajok.',
            'organisations' => 'Kultuszok, katonai egységek, frakciók, céhek.',
            'quests'        => 'Számon tudod tartani a különböző küldetéseket a karakterekhez és a helyszínekhez kapcsolódóan.',
            'races'         => 'Ha a kampányodban több mint egy faj található, itt könnyen számon tarthatod azokat.',
            'tags'          => 'Minden entitásnak lehet több címkéje is. A címkék más címkékhez is tartozhatnak, és az entitásokat szűrni lehet a címkék alapján.',
            'timelines'     => 'Mutasd be a világod történelmét idővonalak segítségével.',
        ],
    ],
    'show'                              => [
        'actions'   => [
            'edit'  => 'Kampány szerkesztése',
            'leave' => 'Kilépés a kampányból',
        ],
        'menus'     => [
            'configuration'     => 'Konfiguráció',
            'overview'          => 'Áttekintés',
            'user_management'   => 'Felhasználók kezelése',
        ],
        'tabs'      => [
            'achievements'      => 'Teljesítmények',
            'applications'      => 'Alkalmazások',
            'campaign'          => 'Kampány',
            'default-images'    => 'Alapértelmezett képek',
            'export'            => 'Export',
            'information'       => 'Információ',
            'members'           => 'Tagok',
            'plugins'           => 'Pluginok',
            'recovery'          => 'Visszaállítás',
            'roles'             => 'Szerepek',
            'styles'            => 'Témázás',
        ],
        'title'     => ':name kampány',
    ],
    'superboosted'                      => [],
    'ui'                                => [
        'other' => 'Egyéb',
    ],
    'visibilities'                      => [
        'private'   => 'Privát',
        'public'    => 'Nyilvános',
        'review'    => 'Felülvizsgálatra váró',
    ],
];
