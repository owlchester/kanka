<?php

return [
    'actions'                           => [],
    'create'                            => [
        'success'   => 'Kampaň vytvorená.',
        'title'     => 'Vytvoriť novú kampaň',
    ],
    'destroy'                           => [],
    'edit'                              => [
        'success'   => 'Kampaň upravená.',
    ],
    'entity_note_visibility'            => [],
    'entity_personality_visibilities'   => [
        'private'   => 'Nové postavy majú popis osobnosti nastavený štandardne ako súkromný.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nové objekty sú súkromné',
    ],
    'errors'                            => [
        'access'        => 'K tejto kampani nemáš prístup.',
        'premium'       => 'Táto funkcionalita je dostupná pre prémiové kampane.',
        'unknown_id'    => 'Neznáma kampaň.',
    ],
    'export'                            => [],
    'fields'                            => [
        'boosted'                           => 'Boost od',
        'character_personality_visibility'  => 'Štandardná viditeľnosť osobnostných čŕt postáv',
        'connections'                       => 'Zobraziť tabuľku vzťahov objektu štandardne (namiesto sieťovej vizualizácie pre boostnuté kampane)',
        'css'                               => 'CSS',
        'description'                       => 'Popis',
        'entity_count'                      => 'Počet objektov',
        'entity_privacy'                    => 'Štandardné nastavenie súkromia objektov',
        'entry'                             => 'Popis kampane',
        'excerpt'                           => 'Krátky popis',
        'followers'                         => 'Odberatelia',
        'gallery_visibility'                => 'Štandardná viditeľnosť obrázkov galérie',
        'genre'                             => 'Žáner',
        'header_image'                      => 'Titulný obrázok',
        'image'                             => 'Obrázok',
        'is_discreet'                       => 'Diskrétne',
        'locale'                            => 'Jazyk',
        'name'                              => 'Názov',
        'open'                              => 'Otvorená pre prihlášky',
        'post_collapsed'                    => 'Nové príspevky k objektom sú štandardne minimalizované.',
        'premium'                           => 'Prémium poskytnuté od :name',
        'private_mention_visibility'        => 'Súkromné referencie',
        'public'                            => 'Viditeľnosť kampane',
        'public_campaign_filters'           => 'Filter verejných kampaní',
        'related_visibility'                => 'Viditeľnosť príbuzných prvkov',
        'superboosted'                      => 'Superboostnutie od',
        'system'                            => 'Systém',
        'theme'                             => 'Téma',
        'vanity'                            => 'Skrátené URL',
        'visibility'                        => 'Viditeľnosť',
    ],
    'following'                         => 'Odber aktívny',
    'helpers'                           => [
        'boosted'                           => 'Niektoré funkcie sú odomknuté, pretože táto kampaň je boostnutá. Viac nájdeš v :settings.',
        'character_personality_visibility'  => 'Keď vytváraš ako admin novú postavu, tu môžeš zvoliť štandardné nastavenie pre jej osobnostné črty.',
        'css'                               => 'Napíš svoj vlastný CSS, ktorý sa nahrá do stránok tvojej kampane. Prosím, uvedom si, že hociktoré zneužitie tejto funkcionality môže viesť k odstráneniu tvojho užívateľského CSS kódu. Opakované alebo závažné porušenia môžu viesť k odstráneniu tvojej kampane.',
        'dashboard'                         => 'Prispôsob zobrazenie widgetu na nástenke vyplnením týchto údajov.',
        'entity_count_v3'                   => 'Toto číslo je prepočítavané každých :amount hod.',
        'entity_privacy'                    => 'Keď vytváraš ako admin nový objekt, tu môžeš zvoliť jeho štandardné nastavenie súkromia.',
        'excerpt'                           => 'Krátky popis kampane sa zobrazí na nástenke, napíš teda pár pár viet ako úvod do tvojho sveta. Nemusíš sa rozpisovať, stačí pár slov.',
        'gallery_visibility'                => 'Hodnota štandardnej viditeľnosti, keď sú obrázky nahrané do galérie.',
        'header_image'                      => 'Obrázok, ktorý sa bude zobrazovať na pozadí widgetu pre záhlavie kampane na nástenke.',
        'hide_history'                      => 'Aktivuj toto nastavenie, ak chceš skryť prehľad minulých zmien objektov pre neadministrátorov.',
        'hide_members'                      => 'Aktivuj toto nastavenie, ak chceš skryť zoznam členov kampane pre neadministrátorov.',
        'is_discreet'                       => 'Aktivuj toto nastavenie, ak nechceš, aby tvoja verejná kampaň bola zverejnená medzi :public-campaigns.',
        'is_discreet_locked'                => 'Prémiové kampane je možné nastaviť tak, aby boli verejne viditeľné, ale neboli zverejnené medzi :public-campaigns.',
        'locale'                            => 'Regionálne nastavenie, ktoré sa vzťahuje na tvoju kampaň. Používa sa na vytváranie obsahu a filtrovanie verejných kampaní.',
        'name'                              => 'Tvoja kampaň / svet môže mať ľubovoľné meno, pokiaľ sa skladá z min. 4 písmen alebo čísel.',
        'no_entry'                          => 'Vyzerá to tak, že kampaň ešte nemá žiaden popis! Zmeňme to.',
        'permissions_tab'                   => 'Kontroluj štandardné nastavenia súkromia a viditeľnosti nových objektov s nasledujúcimi možnosťami.',
        'premium'                           => 'Niektoré funkcionality sú dostupné, lebo boli odomknuté prémiové funkcionality. Zisti viac na stránke :settings.',
        'private_mention_visibility'        => 'Kontroluje nastavenie, či sú referencie na súkromné objekty viditeľné alebo nie.',
        'public_campaign_filters'           => 'Pomôž iným nájsť tvoju kampaň medzi ostatnými verejnými doplnením týchto informácií.',
        'public_no_visibility'              => 'Hlavu hore! Tvoja kampaň je verejná, ale rola pre verejnosť nemá k ničomu prístup. :fix',
        'related_visibility'                => 'Štandardná hodnota viditeľnosti, keď vytváraš nový prvok s týmto poľom (poznámky objektov, vlastností, schopností, atď.)',
        'system'                            => 'Ak je tvoja kampaň verejne viditeľná, systém sa zobrazuje na stránke :link.',
        'systems'                           => 'Aby sme užívateľov nezahltili nespočetnými možnosťami, niektoré funkcionality Kanky sú prístupné len pre špecifické RPG systémy (napr. štatistický popis príšer pre D&D 5e). Priradením systému na tomto mieste aktivuješ dané funkcionality.',
        'theme'                             => 'Nastav tému pevne pre kampaň a prepíš nastavenie užívateľov.',
        'view_public'                       => 'Ak si chceš pozrieť tvoju kampaň ako verejnú, otvor tento :link v novom inkognito okne.',
        'visibility'                        => 'Ak nastavíte kampaň ako verejnú, bude ju vidieť každý, kto k nej bude mať link.',
    ],
    'index'                             => [],
    'invites'                           => [
        'actions'               => [
            'copy'  => 'Kopírovať link do schránky',
            'link'  => 'Pozvať ľudí',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Vytvoriť pozvánku',
            ],
            'success_link'  => 'Link vytvorený: :link',
            'title'         => 'Pozvať niekoho k tvojej kampani',
        ],
        'destroy'               => [
            'success'   => 'Pozvánka odstránená.',
        ],
        'error'                 => [
            'inactive_token'    => 'Táto pozvánka už bola použitá alebo daná kampaň už neexistuje.',
            'invalid_token'     => 'Platnosť tejto pozvánky už vypršala.',
            'join'              => 'Prosím, prihlás sa alebo si registruj nové konto k prístupu do :campaign.',
        ],
        'fields'                => [
            'created'   => 'Zaslať',
            'role'      => 'Rola',
            'token'     => 'Žetón',
            'type'      => 'Typ',
            'usage'     => 'Max. počet použití',
        ],
        'helpers'               => [
            'role'  => 'Užívatelia musia byť súčasťou kampane, aby mohli obdržať rolu admina.',
            'usage' => 'Koľkokrát môže byť pozvánkový link použitý, než sa stane nefunkčným.',
        ],
        'unlimited_validity'    => 'Neobmedzený',
        'usages'                => [
            'five'      => '5 použití',
            'no_limit'  => 'Bez obmedzenia',
            'once'      => '1 použitie',
            'ten'       => '10 použití',
        ],
    ],
    'leave'                             => [
        'confirm'           => 'Naozaj chceš opustiť kampaň :name? Už ku nej nebudeš mať prístup, ibaže by ťa do nej opäť pozval jej administrátor.',
        'confirm-button'    => 'Áno, opustiť kampaň',
        'error'             => 'Nemôže opustiť kampaň.',
        'fix'               => 'Prejsť na členstvo kampane',
        'no-admin-left'     => 'Nie je možné opustiť kampaň, pretože by tak ostala bez adminov. Priraď najprv inému členovi alebo členke rolu admin.',
        'success'           => 'Opustil/a si kampaň.',
        'title'             => 'Opustenie kampane',
    ],
    'members'                           => [
        'actions'               => [
            'remove'        => 'Odstrániť z kampane',
            'switch'        => 'Prepnúť',
            'switch-back'   => 'Prepnúť späť',
            'switch-entity' => 'Zobraziť ako',
        ],
        'fields'                => [
            'banned'        => 'Užívateľ má zákaz',
            'joined'        => 'Súčasťou od',
            'last_login'    => 'Posledné prihlásenie',
            'name'          => 'Užívateľ',
            'role'          => 'Rola',
            'roles'         => 'Roly',
        ],
        'helpers'               => [
            'switch'    => 'Prepnúť na tohto užívateľa',
        ],
        'impersonating'         => [
            'message'   => 'Kampaň teraz vidíš ako iný užívateľ. Niektoré funkcionality boli deaktivované, ale ostatok vyzerá rovnako, ako by to videl daný užívateľ. Aby si sa prepol/a späť na tvojho užívateľa, použi tlačidlo Prepnúť, ktoré sa nachádza na mieste, kde je bežne tlačidlo Logout.',
            'title'     => 'Náhľad ako :name',
        ],
        'invite'                => [
            'description'   => 'Do tvojej kampane môžeš pozvať priateľa/ku tým, že zadáš ich e-mailovú adresu. Po akceptovaní pozvánky bude pridaný/á ako člen s danou rolou. Zaslaná pozvánka môže byť hocikedy zrušená.',
            'more'          => 'Nové role môžeš pridať cez :link.',
            'title'         => 'Pozvať',
        ],
        'removal'               => 'Odstraňuješ ":member" z kampane.',
        'roles'                 => [
            'member'    => 'Člen',
            'owner'     => 'Administrátor',
            'player'    => 'Hráč',
            'public'    => 'Verejný',
            'viewer'    => 'Divák',
        ],
        'switch_back_success'   => 'Teraz si späť ako tvoj vlastný užívateľ.',
    ],
    'mentions'                          => [
        'private'   => 'Skryť meno cieľa',
        'visible'   => 'Zobraziť meno cieľa',
    ],
    'modules'                           => [
        'permission-disabled'   => 'Tento modul je deaktivovaný.',
    ],
    'open_campaign'                     => [],
    'options'                           => [],
    'overview'                          => [
        'entity-count'      => '{0} Žiadne objekty|{1} :amount objekt|[2,4] :amount objekty|[5,*] :amount objektov',
        'follower-count'    => '{0} Žiadni sledovatelia|{1} :amount sledovateľ|[2,4] :amount sledovatelia|[5,*] :amount sledovateľov',
    ],
    'panels'                            => [
        'dashboard' => 'Nástenka',
        'permission'=> 'Oprávnenie',
        'setup'     => 'Nastavenia',
        'sharing'   => 'Zdieľanie',
        'systems'   => 'Systémy',
        'ui'        => 'Rozhranie',
    ],
    'placeholders'                      => [
        'locale'    => 'Jazyk',
        'name'      => 'Názov tvojho sveta',
        'system'    => 'D&D, Pathfinder, Fate, Dračí Doupě',
    ],
    'privacy'                           => [
        'hidden'    => 'Skryté',
        'private'   => 'Súkromné',
        'visible'   => 'Viditeľné',
    ],
    'public'                            => [
        'helpers'   => [
            'introduction'  => 'Kampane sú štandardne nastavené ako súkromné, no môžu byť zviditeľnené pre verejnosť. Hocikto si ich takto môže pozrieť a dostupné sú na stránke :public-campaigns, ak majú objekty, ktorým je pridelená rola :public-role. Verejná kampaň je viditeľná pre všetkých, ale aby bol viditeľný aj jej obsah, je nutné prideliť :public-role potrebné oprávnenia.',
        ],
    ],
    'roles'                             => [
        'actions'       => [
            'add'           => 'Pridať rolu',
            'duplicate'     => 'Duplikovať rolu',
            'permissions'   => 'Spravovať oprávnenia',
            'rename'        => 'Premenovať rolu',
            'save'          => 'Uložiť rolu',
        ],
        'admin_role'    => 'Rola administrátora',
        'bulks'         => [
            'delete'    => '{1} Odstránená :count rola.|[2,4] Odstránené :count roly.|[5,*] Odstránených :count rolí.',
            'edit'      => '{1} Aktualizovaná :count rola.|[2,4] Aktualizované :count roly.|[5,*] Aktualizovaných :count rolí.',
        ],
        'create'        => [
            'success'   => 'Rola :name vytvorená.',
            'title'     => 'Nová rola',
        ],
        'destroy'       => [
            'success'   => 'Rola odstránená.',
        ],
        'edit'          => [
            'success'   => 'Rola upravená.',
            'title'     => 'Upraviť rolu :name',
        ],
        'fields'        => [
            'copy_permissions'  => 'Kopírovať oprávnenia',
            'name'              => 'Názov',
            'permissions'       => 'Oprávnenia',
            'type'              => 'Typ',
            'users'             => 'Užívateľ',
        ],
        'helper'        => [
            '1'                     => 'Kampani môže byť priradených viacero rolí. Rola :admin má automaticky prístup ku všetkému v kampani, ale každej inej roli môžu byť pridelené špecifické oprávnenia na rôzne typy objektov (postavy, miesta, atď.)',
            '2'                     => 'Objekty môžu mať oveľa detailnejšie nastavenie oprávnení, ktoré vieš nastaviť v karte "Oprávnenia" objektu. Táto karta sa zobrazí, ak máš v kampani viacero rolí alebo členov.',
            '3'                     => 'Môžeš použiť "opt-out" systém, v ktorom všetky roly dostanú práva na čítanie na všetky objekty a niektoré objekty potom nastavíš ako "Súkromné", čím ich skryješ. Alebo rolám nedáš veľa oprávnení a následne ich nastavíš individuálne pre každý objekt.',
            '4'                     => 'Boostnuté kampane môžu mať neobmedzený počet rolí.',
            'permissions_helper'    => 'Duplikuje všetky oprávnenia danej roly v moduloch a objektoch.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'Verejná rola má oprávnenia, ale kampaň je súkromná. Tieto nastavenia počas úpravy kampane nájdeš na karte Zdieľanie.',
            'empty_role'            => 'Táto rola nemá zatiaľ žiadnych členov.',
            'role_admin'            => 'Rola :name poskytne automaticky prístup ku všetkému v kampani pre jej členstvo.',
            'role_permissions'      => 'Umožniť role :name nasledujúce akcie pre všetky objekty.',
        ],
        'members'       => 'Členovia',
        'modals'        => [
            'details'   => [
                'campaign'  => 'Oprávnenia kampane umožňujú nasledovné.',
                'entities'  => 'Rýchle info o tom, čo obdržia členovia tejto role, ak dostanú dané oprávnenie.',
                'more'      => 'Viac informácií nájdeš v našom videonávode na YouTube',
                'title'     => 'Detaily oprávnenia',
            ],
        ],
        'permissions'   => [
            'actions'   => [
                'add'           => 'Vytvoriť',
                'dashboard'     => 'Nástenka',
                'delete'        => 'Odstrániť',
                'edit'          => 'Upraviť',
                'entity-note'   => 'Poznámky',
                'gallery'       => [
                    'browse'    => 'Prehľadávať',
                    'manage'    => 'Plná kontrola',
                    'upload'    => 'Nahrať',
                ],
                'manage'        => 'Spravovať',
                'members'       => 'Členovia',
                'permission'    => 'Spravovať oprávnenia',
                'read'          => 'Zobraziť',
                'toggle'        => 'Zmeniť u všetkých',
            ],
            'helpers'   => [
                'add'           => 'Povolí vytváranie objektov tohto typu. Automaticky budú mať povolené zobraziť a upravovať objekty, ktoré vytvoria, ak nemajú oprávnenie pre zobrazenie a editáciu.',
                'dashboard'     => 'Povolí úpravy násteniek a nástenkových widgetov.',
                'delete'        => 'Povolí odstránenia všetkých objektov tohto typu.',
                'edit'          => 'Povolí úpravy všetkých objektov tohto typu.',
                'entity_note'   => 'Povolí pridať a upravovať poznámky objektov, aj keď užívateľ nemôže editovať daný objekt.',
                'gallery'       => [
                    'browse'    => 'Povoliť zobrazenie galérie a nastavení obrázku objektu z galérie.',
                    'manage'    => 'Povoliť všetko v galérii podobne ako u adminov, vrátane úprav a mazania.',
                    'upload'    => 'Povoliť nahrávanie obrázkov do galérie. Zobrazovať sa budú iba obrázky, ktorá nahrali, ak nie sú nastavené ďalšie povolenia.',
                ],
                'manage'        => 'Povolí úpravu kampane ako ju má admin kampane, no bez možnosti zmazať kampaň.',
                'members'       => 'Povolí zasielať pozvánky pre nových členov do kampane.',
                'not_public'    => 'Kampaň nie je verejná. Oprávnenia pre verejné role môžu byť nastavené, ale budú ignorované. Ak chceš kampaň zverejniť, uprav jej nastavenia.',
                'permission'    => 'Povolí nastaviť oprávnenia na objektoch typu, ktoré môže upravovať.',
                'read'          => 'Povolí zobrazenie všetkých objektov tohto typu, ktoré nie sú súkromné.',
            ],
        ],
        'placeholders'  => [
            'name'  => 'Názov role',
        ],
        'title'         => 'Roly kampane :name',
        'types'         => [
            'owner'     => 'Admin',
            'public'    => 'Verejný',
            'standard'  => 'Štandard',
        ],
        'users'         => [
            'actions'   => [
                'add'           => 'Pridať',
                'remove'        => ':user z role :role',
                'remove_user'   => 'Odstrániť užívateľa z role',
            ],
            'create'    => [
                'success'   => 'Užívateľ bol priradený k roli.',
                'title'     => 'Pridať člena k roli :name',
            ],
            'destroy'   => [
                'success'   => 'Užívateľ bol odstránený z role.',
            ],
            'errors'    => [
                'cant_kick_admins'  => 'Aby sme predišli zneužitiu, nie je možné odstrániť iných členov kampane s rolou :admin. V prípade zmien nás kontaktuj na :discord alebo cez :email.',
                'needs_more_roles'  => 'Predtým, ako odstrániš svoju rolu :admin z kampane, musíš si prideliť inú rolu v kampani.',
            ],
            'fields'    => [
                'name'  => 'Meno',
            ],
        ],
    ],
    'settings'                          => [
        'actions'       => [
            'enable'    => 'Aktivovať',
        ],
        'boosted'       => 'Táto funkcia je aktuálne v beta verzii a dostupná iba pre :boosted.',
        'deprecated'    => [
            'help'  => 'Tento modul je zastaralý, znamená to, že už nie je aktualizovaný a chyby, ktoré sa môžu vyskytnúť s novými aktualizáciami, nie sú opravované. Môžeš ho používať, ale v budúcnosti bude z Kanky odstránený.',
            'title' => 'Zastaralé',
        ],
        'disabled'      => 'Modul :module je deaktivovaný.',
        'enabled'       => 'Modul :module je aktivovaný.',
        'errors'        => [
            'module-disabled'   => 'Požadovaný modul je aktuálne v nastaveniach kampane deaktivovaný. :fix.',
        ],
        'helpers'       => [
            'abilities'         => 'Vytvor schopnosti ako kúzla alebo sily, ktoré priradíš iným objektom.',
            'assets'            => 'Nahraj súbory, nastav linky a definuj aliasy pre jednotlivé objekty.',
            'bookmarks'         => 'Vytvor záložky k objektom alebo filtrovaným zoznamom, ktoré sa zobrazia v bočnom menu.',
            'calendars'         => 'Miesto, na ktorom vieš vytvoriť kalendáre tvojho sveta.',
            'characters'        => 'Postavy, ktoré obývajú svoj svet.',
            'conversations'     => 'Fiktívne diskusie medzi postavami v tvojom svete alebo užívateľmi kampane.',
            'creatures'         => 'Obsaď tvoj svet zvermi, bytosťami a príšerami s pomocou modulu pre bytosti.',
            'dice_rolls'        => 'Ak používaš Kanku na hranie, môžeš tu spravovať tvoje hody kockami.',
            'entity_attributes' => 'Maj prehľad o atribútoch objektov kampane, napr. ich HP alebo Rýchlosti.',
            'events'            => 'Sviatky, festivaly, katastrofy, narodeniny, vojny.',
            'families'          => 'Klany a rody, ich vzťahy a členovia.',
            'inventories'       => 'Spravuj inventáre v tvojich objektoch.',
            'items'             => 'Zbrane, vozidlá, relikvie, elixíry.',
            'journals'          => 'Zistenia a pozorovania spísané postavami alebo príprava na hry pre Rozprávača.',
            'locations'         => 'Planéty, sféry, kontinenty, rieky, štáty, osídlia, chrámy, hostince.',
            'maps'              => 'Nahraj mapy s úrovňami a značkami, ktoré sú prelinkované s inými objektami tvojej kampane.',
            'notes'             => 'Báje, náboženstvá, dejiny, mágia, rasy.',
            'organisations'     => 'Kulty, vojenské jednotky, frakcie, cechy.',
            'quests'            => 'Aby si vedel/a sledovať plnenie úloh a cieľov postáv.',
            'races'             => 'Ak má kampaň viac ako jednu rasu, pomôže sa ti v nich vyznať táto funkcia.',
            'tags'              => 'Každý objekt môže byť priradený viacerým kategóriám. Kategórie môžu patriť pod iné kategórie a objekty môžu byť podľa kategórií filtrované.',
            'timelines'         => 'Zobraz dejiny tvojho sveta pomocou časových osí.',
        ],
    ],
    'sharing'                           => [
        'filters'   => 'Verejné kampane sú viditeľné na :public-campaigns stránke. Vyplnením tohto formulára umožníš ľuďom rýchlejšie nájsť tvoju kampaň.',
        'language'  => 'Jazyk, v ktorom je kampaň písaná.',
        'system'    => 'Ak hráte stolovú RPG hru, systém, ktorý používate pri hraní.',
    ],
    'show'                              => [
        'actions'   => [
            'edit'  => 'Upraviť kampaň',
        ],
        'tabs'      => [
            'achievements'      => 'Úspechy',
            'applications'      => 'Prihlášky',
            'customisation'     => 'Úprava',
            'danger'            => 'Výstrahy',
            'data'              => 'Údaje',
            'default-images'    => 'Prednastavené obrázky',
            'deletion'          => 'Odstránenie',
            'export'            => 'Export',
            'import'            => 'Import',
            'management'        => 'Manažment',
            'members'           => 'Členovia',
            'modules'           => 'Moduly',
            'plugins'           => 'Pluginy',
            'recovery'          => 'Obnovenie',
            'roles'             => 'Roly',
            'sidebar'           => 'Bočné menu',
            'stats'             => 'Štatistiky',
            'styles'            => 'Témy',
            'webhooks'          => 'Webhooky',
        ],
        'title'     => 'Kampaň :name',
    ],
    'status'                            => [
        'free'      => 'Prémiové funkcionality sú neaktívne.',
        'legacy'    => [
            'title' => 'Boostnuté funkcionality (zastaralé)',
        ],
        'premium'   => 'Vďaka :name sú prémiové funkcionality aktívne.',
        'title'     => 'Prémiové funkcionality',
    ],
    'superboosted'                      => [],
    'themes'                            => [
        'none'  => 'Žiadna (štandardné nastavenie)',
    ],
    'ui'                                => [
        'collapsed'         => [
            'collapsed' => 'Zbalená',
            'default'   => 'Štandardná',
        ],
        'connections'       => [
            'explorer'  => 'Prehliadač vzťahov (ak dostupný, pre boostnuté kampane)',
            'list'      => 'Rozhranie zoznamu',
        ],
        'descendants'       => [
            'all'       => 'Štandardne zobraziť všetky podradené objekty',
            'direct'    => 'Štandardne zobraziť len priame podradené objekty',
        ],
        'entity_history'    => [
            'hidden'    => 'Viditeľné len pre adminov kampane',
            'visible'   => 'Viditeľné pre členov',
        ],
        'fields'            => [
            'connections'       => 'Štandardné rozhranie vzťahov objektu',
            'connections_mode'  => 'Štandardný mód prehliadača vzťahov',
            'descendants'       => 'Filtrovanie podradených objektov',
            'entity_history'    => 'Protokol histórie objektu',
            'member_list'       => 'Zoznam členov kampane',
            'post_collapsed'    => 'Štandardná nová hodnota zbalenej poznámky',
        ],
        'helpers'           => [
            'connections'       => 'Ak klikneš na podstránku so vzťahmi objektu, vyber si štandardné zobrazené rozhranie.',
            'connections_mode'  => 'Keď zobrazuješ prehliadač vzťahov objektu, definuj štandardný zvolený mód.',
            'descendants'       => 'Kontroluje nastavenie filtra, ktorý zobrazuje zoznam podradených objektov, napr. postavy na danom mieste.',
            'entity-history'    => 'Kontroluj, kto vidí posledné zmeny v jednotlivých objektoch kampane.',
            'member-list'       => 'Kontroluj, kto vidí koho v kampani.',
            'other'             => 'Ďalšie možnosti zobrazenia kampane.',
            'post_collapsed'    => 'Keď vytváraš novú poznámku k objektu, zvoľ štandardnú hodnotu pre zbalené pole.',
            'theme'             => 'Zobraz kampaň v téme užívateľa alebo vynúť zobrazenie v jednej z nasledujúcich tém.',
        ],
        'members'           => [
            'hidden'    => 'Viditeľné len pre adminov kampane',
            'visible'   => 'Viditeľné pre členov',
        ],
        'other'             => 'Ostatné',
    ],
    'visibilities'                      => [
        'private'   => 'Súkromná kampaň',
        'public'    => 'Verejná kampaň',
        'review'    => 'Čaká na schválenie',
    ],
    'warning'                           => [],
];
