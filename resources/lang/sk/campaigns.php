<?php

return [
    'create'                            => [
        'description'           => 'Vytvoriť novú kampaň',
        'helper'                => [
            'title'     => 'Vitaj v :name!',
            'welcome'   => <<<'TEXT'
Predtým, než budeš pokračovať, musíš zvoliť názov kampane. Je to meno tvojho sveta. Ak ešte nemáš žiadne vymyslené, nič sa nedeje, môžeš ho stále zmeniť neskôr alebo vytvoriť ďalšiu kampaň.

Vďaka za to, že používaš Kanku a vitaj v našej rozkvitajúcej komunite!
TEXT
,
        ],
        'success'               => 'Kampaň vytvorená.',
        'success_first_time'    => 'Tvoja kampaň bola vytvorená! Keďže je to tvoja prvá kampaň, vytvorili sme v nej pár vecí, ktoré ti pomôžu začať a dúfame, že ti poskytnú inšpiráciu, čo všetko je možné.',
        'title'                 => 'Vytvoriť novú kampaň',
    ],
    'destroy'                           => [
        'action'    => 'Odstrániť kampaň',
        'helper'    => 'Kampaň môžeš odstrániť iba ak si jediný člen v nej.',
        'success'   => 'Kampaň odstránená.',
    ],
    'edit'                              => [
        'success'   => 'Kampaň upravená.',
        'title'     => 'Upraviť kampaň :campaign',
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
        'superboosted'  => 'Táto funkcionalita je dostupná len pre superboostnuté kampane.',
        'unknown_id'    => 'Neznáma kampaň.',
    ],
    'export'                            => [
        'errors'            => [
            'limit' => 'Maximum jeden export za deň bol dosiahnutý. Prosím, skús to opäť zajtra.',
        ],
        'helper'            => 'Exportuj svoju kampaň. Zobrazí sa notifikácia s linkom na stiahnutie.',
        'helper_secondary'  => 'Budú vytvorené dva súbory - jeden s objektami ako JSON a druhý s obrázkami nahratými k objektom. Pri veľkých kampaniach je možné, že export obrázkov zlyhá a bude ho možné obnoviť len pomocou :api.',
        'helper_third'      => 'JSON súbory môžeš otvoriť v hociktorom textovom editore. Reprezentujú dáta z databázy Kanky uložené v textovom formáte. Tento export nie je možné použiť pre spätný import do Kanky.',
        'success'           => 'Export tvojej kampane sa pripravuje. Kanka ti zašle správu, akonáhle bude zozipovaný súbor pripravený na stiahnutie.',
        'title'             => 'Export kampane :name',
    ],
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
        'header_image'                      => 'Titulný obrázok',
        'image'                             => 'Obrázok',
        'locale'                            => 'Jazyk',
        'name'                              => 'Názov',
        'nested'                            => 'Vnorené zobrazenie zoznamov objektov, ak možné',
        'open'                              => 'Otvorená pre prihlášky',
        'post_collapsed'                    => 'Nové príspevky k objektom sú štandardne minimalizované.',
        'public'                            => 'Viditeľnosť kampane',
        'public_campaign_filters'           => 'Filter verejných kampaní',
        'related_visibility'                => 'Viditeľnosť príbuzných prvkov',
        'rpg_system'                        => 'RPG systémy',
        'superboosted'                      => 'Superboostnutie od',
        'system'                            => 'Systém',
        'theme'                             => 'Téma',
        'visibility'                        => 'Viditeľnosť',
    ],
    'following'                         => 'Odber aktívny',
    'helpers'                           => [
        'boost_required'                    => 'Táto funkcia vyžaduje boostnutú kampaň. Viac informácií nájdeš v :settings.',
        'boost_required_multi'              => 'Tieto funkcie vyžadujú boostnutú kampaň. Viac informácií nájdeš v :settings.',
        'boosted'                           => 'Niektoré funkcie sú odomknuté, pretože táto kampaň je boostnutá. Viac nájdeš v :settings.',
        'character_personality_visibility'  => 'Keď vytváraš ako admin novú postavu, tu môžeš zvoliť štandardné nastavenie pre jej osobnostné črty.',
        'css'                               => 'Napíš svoj vlastný CSS, ktorý sa nahrá do stránok tvojej kampane. Prosím, uvedom si, že hociktoré zneužitie tejto funkcionality môže viesť k odstráneniu tvojho užívateľského CSS kódu. Opakované alebo závažné porušenia môžu viesť k odstráneniu tvojej kampane.',
        'dashboard'                         => 'Prispôsob zobrazenie widgetu na nástenke vyplnením týchto údajov.',
        'entity_count'                      => 'Toto číslo sa aktualizuje každých 6 hodín.',
        'entity_privacy'                    => 'Keď vytváraš ako admin nový objekt, tu môžeš zvoliť jeho štandardné nastavenie súkromia.',
        'excerpt'                           => 'Krátky popis kampane sa zobrazí na nástenke, napíš teda pár pár viet ako úvod do tvojho sveta. Nemusíš sa rozpisovať, stačí pár slov.',
        'header_image'                      => 'Obrázok, ktorý sa bude zobrazovať na pozadí widgetu pre záhlavie kampane na nástenke.',
        'hide_history'                      => 'Aktivuj toto nastavenie, ak chceš skryť prehľad minulých zmien objektov pre neadministrátorov.',
        'hide_members'                      => 'Aktivuj toto nastavenie, ak chceš skryť zoznam členov kampane pre neadministrátorov.',
        'locale'                            => 'Regionálne nastavenie, ktoré sa vzťahuje na tvoju kampaň. Používa sa na vytváranie obsahu a filtrovanie verejných kampaní.',
        'name'                              => 'Tvoja kampaň / svet môže mať ľubovoľné meno, pokiaľ sa skladá z min. 4 písmen alebo čísel.',
        'permissions_tab'                   => 'Kontroluj štandardné nastavenia súkromia a viditeľnosti nových objektov s nasledujúcimi možnosťami.',
        'public_campaign_filters'           => 'Pomôž iným nájsť tvoju kampaň medzi ostatnými verejnými doplnením týchto informácií.',
        'public_no_visibility'              => 'Hlavu hore! Tvoja kampaň je verejná, ale rola pre verejnosť nemá k ničomu prístup. :fix',
        'related_visibility'                => 'Štandardná hodnota viditeľnosti, keď vytváraš nový prvok s týmto poľom (poznámky objektov, vlastností, schopností, atď.)',
        'system'                            => 'Ak je tvoja kampaň verejne viditeľná, systém sa zobrazuje na stránke :link.',
        'systems'                           => 'Aby sme užívateľov nezahltili nespočetnými možnosťami, niektoré funkcionality Kanky sú prístupné len pre špecifické RPG systémy (napr. štatistický popis príšer pre D&D 5e). Priradením systému na tomto mieste aktivuješ dané funkcionality.',
        'theme'                             => 'Nastav tému pevne pre kampaň a prepíš nastavenie užívateľov.',
        'view_public'                       => 'Ak si chceš pozrieť tvoju kampaň ako verejnú, otvor tento :link v novom inkognito okne.',
        'visibility'                        => 'Ak nastavíte kampaň ako verejnú, bude ju vidieť každý, kto k nej bude mať link.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nová kampaň',
            ],
        ],
        'title'     => 'Kampane',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Pozvať',
            'copy'  => 'Kopírovať link do schránky',
            'link'  => 'Nový link',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Vytvoriť pozvánku',
                'send'      => 'Zaslať pozvánku',
            ],
            'success'       => 'Pozvánka zaslaná.',
            'success_link'  => 'Link vytvorený: :link',
            'title'         => 'Pozvať niekoho k tvojej kampani',
        ],
        'destroy'               => [
            'success'   => 'Pozvánka odstránená.',
        ],
        'email'                 => [
            'link_text' => 'Pridať sa do kampane :name',
            'subject'   => ':name ťa pozval/a, aby si sa pridal/a do jeho kampane :campaign na kanka.io! Pozvánku môžeš akceptovať kliknutím na nasledujúci link.',
            'title'     => 'Pozvánka od :name',
        ],
        'error'                 => [
            'already_member'    => 'Už si súčasťou tejto kampane.',
            'inactive_token'    => 'Táto pozvánka už bola použitá alebo daná kampaň už neexistuje.',
            'invalid_token'     => 'Platnosť tejto pozvánky už vypršala.',
            'login'             => 'Prosím, prihlás alebo registruj sa, aby si sa pridal/a do kampane.',
        ],
        'fields'                => [
            'created'   => 'Zaslať',
            'email'     => 'E-mail',
            'role'      => 'Rola',
            'type'      => 'Typ',
            'usage'     => 'Max. počet použití',
        ],
        'helpers'               => [
            'email'     => 'Naše e-maily sú často označované ako spam a môže sa stať, že sa v tvojej doručenej pošte objavia až o pár hodín neskôr.',
            'validity'  => 'Koľko používateľov môže použiť tento link, dokiaľ mu nevyprší platnosť.',
        ],
        'placeholders'          => [
            'email' => 'E-mailová adresa osoby, ktorú chceš pozvať',
        ],
        'types'                 => [
            'email' => 'E-mail',
            'link'  => 'Link',
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
        'confirm'   => 'Naozaj chceš opustiť kampaň :name? Už ku nej nebudeš mať prístup, ibaže by ťa do nej opäť pozval jej administrátor.',
        'error'     => 'Nemôže opustiť kampaň.',
        'success'   => 'Opustil/a si kampaň.',
    ],
    'members'                           => [
        'actions'               => [
            'help'          => 'Pomoc',
            'remove'        => 'Odstrániť z kampane',
            'switch'        => 'Prepnúť',
            'switch-back'   => 'Prepnúť späť',
        ],
        'create'                => [
            'title' => 'Pridať člena do tvojej kampane',
        ],
        'edit'                  => [
            'title' => 'Upraviť člena :name',
        ],
        'fields'                => [
            'joined'        => 'Súčasťou od',
            'last_login'    => 'Posledné prihlásenie',
            'name'          => 'Užívateľ',
            'role'          => 'Rola',
            'roles'         => 'Roly',
        ],
        'help'                  => 'Kampane môžu mať nekonečný počet členov. Ako administrátor vieš odstrániť členov, ktorí už nie sú aktívni.',
        'helpers'               => [
            'admin' => 'Ako člen kampane s rolou administrátora môžeš pozývať nových užívateľov, odstraňovať neaktívnych a meniť ich oprávnenia. Otestovať oprávnenia člena môžeš cez tlačidlo Prepnúť. Viac o tejto funkcionalite si môžeš prečítať na: :link.',
            'switch'=> 'Prepnúť na tohto užívateľa',
        ],
        'impersonating'         => [
            'message'   => 'Kampaň teraz vidíš ako iný užívateľ. Niektoré funkcionality boli deaktivované, ale ostatok vyzerá rovnako, ako by to videl daný užívateľ. Aby si sa prepol/a späť na tvojho užívateľa, použi tlačidlo Prepnúť, ktoré sa nachádza na mieste, kde je bežne tlačidlo Logout.',
            'title'     => 'Náhľad ako :name',
        ],
        'invite'                => [
            'description'   => 'Do tvojej kampane môžeš pozvať priateľa/ku tým, že zadáš ich e-mailovú adresu. Po akceptovaní pozvánky bude pridaný/á ako člen s danou rolou. Zaslaná pozvánka môže byť hocikedy zrušená.',
            'more'          => 'Nové role môžeš pridať cez :link.',
            'roles_page'    => 'Stránka s rolami',
            'title'         => 'Pozvať',
        ],
        'manage_roles'          => 'Spravovať roly užívateľov',
        'roles'                 => [
            'member'    => 'Člen',
            'owner'     => 'Administrátor',
            'player'    => 'Hráč',
            'public'    => 'Verejný',
            'viewer'    => 'Divák',
        ],
        'switch_back_success'   => 'Teraz si späť ako tvoj vlastný užívateľ.',
        'title'                 => 'Členovia kampane :name',
        'updates'               => [
            'added'     => 'Rola :role pridaná užívateľovi :user.',
            'removed'   => 'Rola :role odňatá užívateľovi :user.',
        ],
        'your_role'             => 'Tvoja rola: <i>:role</i>',
    ],
    'open_campaign'                     => [
        'helper'    => 'Verejná kampaň nastavená ako otvorená umožní ostatným zaslať prihlášky na vstup do nej. Zoznam prihlášok nájdeš na stránke :link.',
        'link'      => 'Prihlášky do kampane',
        'statuses'  => [
            'closed'    => 'Ukončený',
            'open'      => 'Príjem prihlášok otvorený',
        ],
        'title'     => 'Otvorená kampaň',
    ],
    'options'                           => [],
    'panels'                            => [
        'boosted'   => 'Boostovaná',
        'dashboard' => 'Nástenka',
        'permission'=> 'Oprávnenie',
        'setup'     => 'Nastavenia',
        'sharing'   => 'Zdieľanie',
        'systems'   => 'Systémy',
        'ui'        => 'Rozhranie',
    ],
    'placeholders'                      => [
        'description'   => 'Krátky popis tvojej kampane',
        'locale'        => 'Jazyk',
        'name'          => 'Názov tvojej kampane',
        'system'        => 'D&D, Pathfinder, Fate, Dračí Doupě',
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
            'permissions'   => 'Spravovať oprávnenia',
            'rename'        => 'Premenovať rolu',
            'save'          => 'Uložiť rolu',
        ],
        'admin_role'    => 'Rola administrátora',
        'create'        => [
            'success'   => 'Rola vytvorená.',
            'title'     => 'Vytvoriť novú rolu pre :name',
        ],
        'destroy'       => [
            'success'   => 'Rola odstránená.',
        ],
        'edit'          => [
            'success'   => 'Rola upravená.',
            'title'     => 'Upraviť rolu :name',
        ],
        'fields'        => [
            'name'          => 'Názov',
            'permissions'   => 'Oprávnenia',
            'type'          => 'Typ',
            'users'         => 'Užívateľ',
        ],
        'helper'        => [
            '1' => 'Kampani môže byť priradených viacero rolí. Rola "Admin" má automaticky prístup ku všetkému v kampani, ale každej inej roli môžu byť pridelené špecifické oprávnenia na rôzne typy objektov (postavy, miesta, atď.)',
            '2' => 'Objekty môžu mať oveľa detailnejšie nastavenie oprávnení, ktoré vieš nastaviť v karte "Oprávnenia" objektu. Táto karta sa zobrazí, ak máš v kampani viacero rolí alebo členov.',
            '3' => 'Môžeš použiť "opt-out" systém, v ktorom všetky roly dostanú práva na čítanie na všetky objekty a niektoré objekty potom nastavíš ako "Súkromné", čím ich skryješ. Alebo rolám nedáš veľa oprávnení a následne ich nastavíš individuálne pre každý objekt.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'Verejná rola má oprávnenia, ale kampaň je súkromná. Tieto nastavenia počas úpravy kampane nájdeš na karte Zdieľanie.',
            'public'                => 'Rola "Verejný" sa používa, keď niekto zobrazuje tvoju verejnú kampaň. :more',
            'role_permissions'      => 'Umožniť role :name nasledujúce akcie pre všetky objekty.',
        ],
        'members'       => 'Členovia',
        'modals'        => [
            'details'   => [
                'button'    => 'Potrebujem pomoc',
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
                'gallery'       => 'Galéria',
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
                'gallery'       => 'Povolí spravovať galériu superboostnutej kampane.',
                'manage'        => 'Povolí úpravu kampane ako ju má admin kampane, no bez možnosti zmazať kampaň.',
                'members'       => 'Povolí zasielať pozvánky pre nových členov do kampane.',
                'permission'    => 'Povolí nastaviť oprávnenia na objektoch typu, ktoré môže upravovať.',
                'read'          => 'Povolí zobrazenie všetkých objektov tohto typu, ktoré nie sú súkromné.',
            ],
            'hint'      => 'Táto rola má automaticky prístup ku všetkému.',
        ],
        'placeholders'  => [
            'name'  => 'Názov role',
        ],
        'show'          => [
            'title' => 'Rola :role kampane :campaign',
        ],
        'title'         => 'Roly kampane :name',
        'types'         => [
            'owner'     => 'Admin',
            'public'    => 'Verejný',
            'standard'  => 'Štandard',
        ],
        'users'         => [
            'actions'   => [
                'add'       => 'Pridať',
                'remove'    => ':user z role :role',
            ],
            'create'    => [
                'success'   => 'Užívateľ bol priradený k roli.',
                'title'     => 'Pridať člena k roli :name',
            ],
            'destroy'   => [
                'success'   => 'Užívateľ bol odstránený z role.',
            ],
            'fields'    => [
                'name'  => 'Meno',
            ],
        ],
    ],
    'settings'                          => [
        'actions'   => [
            'enable'    => 'Aktivovať',
        ],
        'boosted'   => 'Táto funkcia je aktuálne v beta verzii a dostupná iba pre :boosted.',
        'edit'      => [
            'success'   => 'Nastavenia kampane boli upravené.',
        ],
        'errors'    => [
            'module-disabled'   => 'Požadovaný modul je aktuálne v nastaveniach kampane deaktivovaný. :fix.',
        ],
        'helper'    => 'Všetky moduly kampane môžu byť aktivované alebo deaktivované. Ak deaktivuješ modul, prepojené prvky rozhrania zmiznú, ale ostávajú existovať v pozadí, ak by si ich v budúcnosti potreboval/a. Tieto zmeny ovplyvňujú všetkých užívateľov kampane, vrátane s rolou Admin.',
        'helpers'   => [
            'abilities'     => 'Vytvor schopnosti ako kúzla alebo sily, ktoré priradíš iným objektom.',
            'calendars'     => 'Miesto, na ktorom vieš vytvoriť kalendáre tvojho sveta.',
            'characters'    => 'Postavy, ktoré obývajú svoj svet.',
            'conversations' => 'Fiktívne diskusie medzi postavami v tvojom svete alebo užívateľmi kampane.',
            'dice_rolls'    => 'Ak používaš Kanku na hranie, môžeš tu spravovať tvoje hody kockami.',
            'events'        => 'Sviatky, festivaly, katastrofy, narodeniny, vojny.',
            'families'      => 'Klany a rody, ich vzťahy a členovia.',
            'inventories'   => 'Spravuj inventáre v tvojich objektoch.',
            'items'         => 'Zbrane, vozidlá, relikvie, elixíry.',
            'journals'      => 'Zistenia a pozorovania spísané postavami alebo príprava na hry pre Rozprávača.',
            'locations'     => 'Planéty, sféry, kontinenty, rieky, štáty, osídlia, chrámy, hostince.',
            'maps'          => 'Nahraj mapy s úrovňami a značkami, ktoré sú prelinkované s inými objektami tvojej kampane.',
            'menu_links'    => 'Vlastné linky v menu.',
            'notes'         => 'Báje, náboženstvá, dejiny, mágia, rasy.',
            'organisations' => 'Kulty, vojenské jednotky, frakcie, cechy.',
            'quests'        => 'Aby si vedel/a sledovať plnenie úloh a cieľov postáv.',
            'races'         => 'Ak má kampaň viac ako jednu rasu, pomôže sa ti v nich vyznať táto funkcia.',
            'tags'          => 'Každý objekt môže byť priradený viacerým kategóriám. Kategórie môžu patriť pod iné kategórie a objekty môžu byť podľa kategórií filtrované.',
            'timelines'     => 'Zobraz dejiny tvojho sveta pomocou časových osí.',
        ],
        'title'     => 'Moduly kampane :name',
    ],
    'show'                              => [
        'actions'   => [
            'boost' => 'Boostnuť kampaň',
            'edit'  => 'Upraviť kampaň',
            'leave' => 'Opustiť kampaň',
        ],
        'menus'     => [
            'configuration'     => 'Konfigurácia',
            'overview'          => 'Prehľad',
            'user_management'   => 'Správa užívateľov',
        ],
        'tabs'      => [
            'achievements'      => 'Úspechy',
            'applications'      => 'Prihlášky',
            'campaign'          => 'Kampaň',
            'default-images'    => 'Prednastavené obrázky',
            'export'            => 'Export',
            'information'       => 'Informácie',
            'members'           => 'Členovia',
            'plugins'           => 'Pluginy',
            'recovery'          => 'Obnovenie',
            'roles'             => 'Roly',
            'settings'          => 'Moduly',
            'styles'            => 'Témy',
        ],
        'title'     => 'Kampaň :name',
    ],
    'superboosted'                      => [
        'gallery'   => [
            'error' => [
                'text'  => 'Nahrávanie obrázkov v textovom editore je dostupné len pre :superboosted.',
                'title' => 'Nahrávanie obrázkov do galérie kampane',
            ],
        ],
    ],
    'themes'                            => [
        'none'  => 'Žiadna (štandardné nastavenie)',
    ],
    'ui'                                => [
        'boosted'           => 'Boostnutá',
        'collapsed'         => [
            'collapsed' => 'Zbalená',
            'default'   => 'Štandardná',
        ],
        'connections'       => [
            'explorer'  => 'Prehliadač vzťahov (ak dostupný, pre boostnuté kampane)',
            'list'      => 'Rozhranie zoznamu',
        ],
        'entity_history'    => [
            'hidden'    => 'Viditeľné len pre adminov kampane',
            'visible'   => 'Viditeľné pre členov',
        ],
        'fields'            => [
            'connections'       => 'Štandardné rozhranie vzťahov objektu',
            'entity_history'    => 'Protokol histórie objektu',
            'entity_image'      => 'Obrázok objektu',
            'family_toolip'     => 'Rod postavy',
            'member_list'       => 'Zoznam členov kampane',
            'nested'            => 'Štandardné zobrazenie zoznamov',
            'post_collapsed'    => 'Štandardná nová hodnota zbalenej poznámky',
        ],
        'helpers'           => [
            'connections'       => 'Ak klikneš na podstránku so vzťahmi objektu, vyber si štandardné zobrazené rozhranie.',
            'other'             => 'Ďalšie možnosti zobrazenia kampane.',
            'post_collapsed'    => 'Keď vytváraš novú poznámku k objektu, zvoľ štandardnú hodnotu pre zbalené pole.',
            'tooltip'           => 'Kontroluj, ktoré informácie budú viditeľné v bubline, ak sa kurzorom postavíš na názov objektu.',
        ],
        'members'           => [
            'hidden'    => 'Viditeľné len pre adminov kampane',
            'visible'   => 'Viditeľné pre členov',
        ],
        'nested'            => [
            'default'   => 'Klasické',
            'nested'    => 'Vnorené',
        ],
        'other'             => 'Ostatné',
    ],
    'visibilities'                      => [
        'private'   => 'Súkromný',
        'public'    => 'Verejný',
        'review'    => 'Čaká na schválenie',
    ],
];
