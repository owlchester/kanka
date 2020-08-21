<?php

return [
    'create'                            => [
        'description'           => 'Új kampány létrehozása',
        'helper'                => [
            'first'     => 'Köszi, hogy kipróbálod az alkalmazást! Mielőtt bármit csinálhatnál, egy egyszerű dologra szükségünk van tőled: a <b>kampányod nevére</b>. Ez a világod neve, ami megkülönbözteti a többitől. Ha most nem tudsz egy jó nevet kitalálni, ne aggódj, <b>később megváltoztathatod</b>, vagy több kampányt is létrehozhatsz.',
            'second'    => 'De elég a dumából, mihez kezdjünk?',
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
        'success'   => 'A kampányt eltávolítottuk.',
    ],
    'edit'                              => [
        'description'   => 'A kampányod szerkesztése',
        'success'       => 'A kampányt frissítettük.',
        'title'         => ':campaign kampány szerkesztése',
    ],
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
    'export'                            => [
        'description'   => 'Kampány exportálása.',
        'errors'        => [
            'limit' => 'Elérted a napi exportálási lehetőségeid számát. Kérjük, holnap próbáld meg újra.',
        ],
        'helper'        => 'A kampányod exportálása. Kapsz majd egy értesítést a Kankában a letölthető zip állományról, amint az elkészül.',
        'success'       => 'A kampányod exportja előkészítés alatt áll. Kapsz majd egy értesítést a Kankában a letölthető zip állományról, amint az elkészül.',
        'title'         => ':name kampány exportálása',
    ],
    'fields'                            => [
        'boosted'                       => 'A kampány boost-olója:',
        'css'                           => 'CSS',
        'description'                   => 'Leírás',
        'entity_count'                  => 'Entitások száma',
        'entity_personality_visibility' => 'Karakter személyiségének láthatósága',
        'entity_visibility'             => 'Entitás láthatósága',
        'excerpt'                       => 'Kivonat',
        'followers'                     => 'Követők',
        'header_image'                  => 'Fejléc képe',
        'hide_history'                  => 'Az entitások változási naplójának elrejtése',
        'hide_members'                  => 'A kampányban résztvevő tagok elrejtése',
        'image'                         => 'Kép',
        'locale'                        => 'Nyelv',
        'name'                          => 'Név',
        'public_campaign_filters'       => 'Publikus kampány szűrők',
        'rpg_system'                    => 'Szerepjáték rendszerek',
        'system'                        => 'Rendszer',
        'theme'                         => 'Téma',
        'tooltip_family'                => 'Családnevek elrejtése a tooltip-ekből',
        'tooltip_image'                 => 'Entitás képének mutatása a tooltip-ben.',
        'visibility'                    => 'Láthatóság',
    ],
    'following'                         => 'Követve',
    'helpers'                           => [
        'boost_required'                => 'Ez a funkció a kampány boost-olását igényli. További információ a :settings oldalon.',
        'boosted'                       => 'Néhány funkció elérhetővé vált, mivel a kampány boost-olva van. További információk a :settings oldalon olvashatóak.',
        'css'                           => 'Írj saját CSS kódot, amely a kampányod oldalaira applikálódik majd. Kérlek vedd figyelembe, hogy az ezzel a funkcióval kapcsolatos bármiféle visszaélés az egyedi CSS törléséhez vezethet! Többszöri, vagy súlyos visszaélés esetén a teljes kampányod törlésre kerülhet.',
        'entity_personality_visibility' => 'Amikor új karaktert hozol létre, a "személyiség látható" opciót automatikusan kikapcsoljuk.',
        'entity_visibility'             => 'Amikor új entitást hozol létre, a "Privát" opciót automatikusan kiválasztjuk.',
        'excerpt'                       => 'A kampány kivonata a főoldalon jelenik meg, írj hát pár mondatot, világod bemutatására! Fogalmazz tömören a legjobb eredmény érdekében.',
        'hide_history'                  => 'Az entitások változás naplójának elrejtése minden nem admin szerepű felhasználó számára.',
        'hide_members'                  => 'A kampány résztvevőinek listája elrejtésre kerül minden nem admin szerepű felhasználó elől.',
        'locale'                        => 'Amilyen nyelven írod a kampányodat. Ezt a tartalom-generáláshoz és a nyilvános kampányok csoportosításához használjuk.',
        'name'                          => 'A kampányod/világod neve bármi lehet, ami legalább 4 számot vagy betűt tartalmaz.',
        'public_campaign_filters'       => 'Segíts másoknak a kampány könnyebb megtalálásában az alábbi adatok kitöltésével.',
        'system'                        => 'Ha a kampányod nyilvánosan látható, a rendszer a :link oldalon látható.',
        'systems'                       => 'Hogy elkerüljük a felhasználók elárasztását szükségtelen opciókkal, néhány funkció csak adott szerepjáték rendszerek esetén érhető el (ilyen például a D&D 5e szörny harcérték blokk, a tulajdonságblokkok között). Támogatott rendszerek hozzáadásával engedélyezheted ezeket a funkciókat.',
        'theme'                         => 'Adott téma rögzítése a kampányhoz, amely minden esetben felülbírálja a felhasználók saját preferenciáját.',
        'view_public'                   => 'Hogy lásd, hogy mi mindent látszik a kampányodból egy olvasó számára, nyisd meg az alábbi linket: :link a böngésződ Inkognitó módjában.',
        'visibility'                    => 'Ha egy kampányt nyilvánossá teszel, bárki egy link segítségével meg tudja nézni.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Új kampány',
            ],
        ],
        'title'     => 'Kampányok',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Meghívó',
            'copy'  => 'Másold ki ezt a linket a vágólapra!',
            'link'  => 'Új link',
        ],
        'create'                => [
            'button'        => 'Meghívó',
            'description'   => 'Hívd meg egy barátodat a kampányodba!',
            'link'          => 'A linket létrehoztuk: : <a href=":url" target="_blank">:url</a>',
            'success'       => 'A meghívót elküldtük.',
            'title'         => 'Hívj meg valakit a kampányodba!',
        ],
        'destroy'               => [
            'success'   => 'A meghívót eltávolítottuk.',
        ],
        'email'                 => [
            'link'      => '<a href=":link">Csatlakozás :name kampányhoz</a>',
            'subject'   => ':name meghívott, hogy csatlakozz a \':campaign\' nevű kampányához a kanka.io oldalon! Használd az alábbi linket a csatlakozkáshoz!',
            'title'     => 'Meghívó :name nevű felhasználótól',
        ],
        'error'                 => [
            'already_member'    => 'Már tagja vagy annak a kampánynak.',
            'inactive_token'    => 'Ezt a tokent már felhasználták, vagy a kampány már nem létezik.',
            'invalid_token'     => 'Ez a token már nem érvényes.',
            'login'             => 'Kérjük, lépj be vagy regisztrálj, hogy csatlakozni tudj a kampányhoz!',
        ],
        'fields'                => [
            'created'   => 'Küldés',
            'email'     => 'Email',
            'role'      => 'Szerep',
            'type'      => 'Típus',
            'validity'  => 'Érvényesség',
        ],
        'helpers'               => [
            'email'     => 'A leveleinket gyakran spamként (szemétként) azonosítják, és eltelhet pár óra, amíg megjelenik a bejövő üzenetek között.',
            'validity'  => 'Hány felhasználó tudja használni ezt a linket, mielőtt deaktviálódik.',
        ],
        'placeholders'          => [
            'email' => 'Az illető email-címe, aki meg szeretnél hívni.',
        ],
        'types'                 => [
            'email' => 'Email',
            'link'  => 'Link',
        ],
        'unlimited_validity'    => 'Korlátlan',
    ],
    'leave'                             => [
        'confirm'   => 'Biztos vagy benne, hogy el akarod hagyni az :name nevű kampányt? Nem tudsz majd többé hozzáférni, kivéve, ha a kampány tulajdonosa újra meghív téged.',
        'error'     => 'Nem tudod elhagyni a kampányt.',
        'success'   => 'Elhagytad a kampányt.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Váltás',
            'switch-back'   => 'Vissza a saját felhasználómhoz',
        ],
        'create'                => [
            'title' => 'Új tag hozzáadása a kapmányhoz.',
        ],
        'description'           => 'A kapmány tagjainak kezelése',
        'edit'                  => [
            'description'   => 'A kampányod tagjainak kezelése',
            'title'         => ':name nevű tag kezelése',
        ],
        'fields'                => [
            'joined'        => 'Csalatkozott',
            'last_login'    => 'Utoljára bejelentkezve',
            'name'          => 'Felhasználó',
            'role'          => 'Szerep',
            'roles'         => 'Szerep',
        ],
        'help'                  => 'Nincs korlátozva, hogy hány tagja lehet egy kampánynak, és mint a kampány Adminja, el is távolíthatod azokat a tagokat, akik már nem aktívak.',
        'helpers'               => [
            'admin' => 'A kampány Adminjaként lehetőséged van meghívni új felhasználókat, eltávolítani inaktívakat, valamint a jogosultságaikat szerkeszteni. Hogy letesztelhesd egy tag jogosultságait, használd a Váltás gombot. További információt erről a funkcióról az alábbi linken olvashatsz :link',
            'switch'=> 'Válts erre a felhasználóra',
        ],
        'impersonating'         => [
            'message'   => 'Jelenleg úgy látod ezt a kampányt, mintha egy másik felhasználó lennél. Néhány funkció nem elérhető, de a többi pontosan úgy viselkedik, ahogy a felhasználó látná. A visszalépéshez kattints a "Vissza a saját felhasználómhoz" gombra, ami a Kijelentkezés gomb helyén található.',
            'title'     => ':name megszemélyesítése',
        ],
        'invite'                => [
            'description'   => 'Meghívhatod a barátaidat az email-címük megadásával, hogy csatlakozzanak a kampányodhoz. Ha elfogadják a meghívást, tagok lesznek az igénylet szerepben. A kiküldött meghívókat bármikor visszavonhatod.',
            'more'          => 'További szerepeket adhatsz hozzá itt :link',
            'roles_page'    => 'Szerepek oldal',
            'title'         => 'Meghívó',
        ],
        'roles'                 => [
            'member'    => 'Tag',
            'owner'     => 'Tulajdonos',
            'player'    => 'Játékos',
            'public'    => 'Nyilvános',
            'viewer'    => 'Megjelenítés',
        ],
        'switch_back_success'   => 'Visszatértél az eredeti felhasználódhoz.',
        'title'                 => ':name kampány tagjai',
        'your_role'             => 'A szereped: <i>:role</i>',
    ],
    'panels'                            => [
        'boosted'   => 'Boost-olva',
        'dashboard' => 'Főoldal',
        'permission'=> 'Jogosultság',
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
            'campaign_not_public'   => 'A publikus szerep adna jogosultságokat, de a kampány privát láthatóságú. Megváltoztathatod ezt a beállítást a Megosztás fülön, a kampány szerkesztése közben.',
            'public'                => 'A Nyilvános szerepet akkor használjuk, amikor valaki a nyilvános kampányodat böngészi. :more',
            'role_permissions'      => ':name szerep számára engedélyezni az alábbi tevékenységeket minden etnitás esetében.',
        ],
        'members'       => 'Tagok',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Létrehozás',
                'delete'        => 'Törlés',
                'edit'          => 'Szerkesztés',
                'entity-note'   => 'Entitás jegyzet',
                'permission'    => 'Engedélyek kezelése',
                'read'          => 'Megtekintés',
                'toggle'        => 'Váltás mindnél',
            ],
            'helpers'   => [
                'entity_note'   => 'Ez lehetővé teszi Entitás jegyzetek hozzáadását olyan felhasználók számára is, akiknek nincs szerkesztési joguk az adott Entitásra.',
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
    'settings'                          => [
        'actions'       => [
            'enable'    => 'Engedélyezés',
        ],
        'boosted'       => 'Ez a lehetőség egyelőre béta állapotban van, így csak :boosted számára elérhető.',
        'description'   => 'A kampány moduljainak ki- és bekapcsolása.',
        'edit'          => [
            'success'   => 'A kampány beállításait frissítettük.',
        ],
        'helper'        => 'A kampány minden modulját lehet ki-be kapcsolgatni. Ha kikapcsolod, egyszerűen csak eltűnik a hozzátartozó felület, de a létrehozott entitások megmaradnak a háttérben, ha esetleg meggondolnád magadat. Ez a változás a kampány minden felhasználóját érinti, beleértve az Admin felhasználókat is.',
        'helpers'       => [
            'abilities'     => 'Entitásokhoz kapcsolható képességek létrehozása, legyen akár különleges képesség, varázslat vagy varázsaltos erő.',
            'calendars'     => 'Egy hely, ahol a világod naptárát alkothatod meg.',
            'characters'    => 'Az emberek, akik benépesítik a világodat.',
            'conversations' => 'Kitalált beszélgetések a karakterek vagy a felhasználók között.',
            'dice_rolls'    => 'Egy hasznos eszköz a dobások kezelésére azok számára, akik szerepjátékhoz használják a Kankát',
            'events'        => 'Ünnepnapok, fesztiválok, katasztrófák, születésnapok, háborúk.',
            'families'      => 'Klánok vagy családok, kapcsolataik és tagjaik.',
            'items'         => 'Fegyverek, járművek, relikviák, italok.',
            'journals'      => 'A karakterek által írt hozzászólások vagy a játékülésre való előkészület a mesélő részéről.',
            'locations'     => 'Bolygók, síkok, kontinensek, folyók, államok, települések, templomok, kocsmák.',
            'maps'          => 'Tölts fel több rétegű térképeket, melyek különböző entitásokra mutatnak a kampányodban.',
            'menu_links'    => 'Egyedi menülinkek az oldalsó sávban.',
            'notes'         => 'Ismeretek, egyházak, történelem, mágia, fajok.',
            'organisations' => 'Kultuszok, katonai egységek, frakciók, céhek.',
            'quests'        => 'Számon tudod tartani a különböző küldetéseket a karakterekhez és a helyszínekhez kapcsolódóan.',
            'races'         => 'Ha a kampányodban több mint egy faj található, itt könnyen számon tarthatod azokat.',
            'tags'          => 'Minden entitásnak lehet több címkéje is. A címkék más címkékhez is tartozhatnak, és az entitásokat szűrni lehet a címkék alapján.',
            'timelines'     => 'Mutasd be a világod történelmét idővonalak segítségével.',
        ],
        'title'         => ':name kampány moduljai',
    ],
    'show'                              => [
        'actions'       => [
            'boost' => 'Kampány boost-olása',
            'edit'  => 'Kampány szerkesztése',
            'leave' => 'Kilépés a kampányból',
        ],
        'description'   => 'Egy kampány részleteinek megjelenítése',
        'tabs'          => [
            'default-images'    => 'Alapértelmezett képek',
            'export'            => 'Export',
            'information'       => 'Információ',
            'members'           => 'Tagok',
            'menu'              => 'Menü',
            'recovery'          => 'Visszaállítás',
            'roles'             => 'Szerepek',
            'settings'          => 'Modulok',
        ],
        'title'         => ':name kampány',
    ],
    'ui'                                => [
        'helper'    => 'Használd ezeket a beállításokat, hogy meg meghatározd, hogy bizonyos elemek hogyan jelenjenek meg a kampányodban.',
    ],
    'visibilities'                      => [
        'private'   => 'Privát',
        'public'    => 'Nyilvános',
        'review'    => 'Felülvizsgálatra váró',
    ],
];
