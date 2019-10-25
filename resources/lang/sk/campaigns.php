<?php

return [
    'create'                            => [
        'description'           => 'Vytvoriť novú kampaň',
        'helper'                => [
            'first' => 'Ďakujeme, že ste vyskúšali našu apku! Predtým, aby než sa pohneme ďalej, budeme potrebovať jednu maličkosť - <b>názov tvojej kampane</b>. Je to názov, ktorý ju odlišuje od ostatných. Ak ešte nemáš vymyslený dobrý názov, žiadne starosti, môžeš ho <b>hocikedy zmeniť</b> alebo vytvoriť ďalšie kampane.',
            'second'=> 'Dosť bolo kecania! Čo to teda bude?',
            'title' => 'Vitaj v :name!',
        ],
        'success'               => 'Kampaň vytvorená.',
        'success_first_time'    => 'Tvoja kampaň bola vytvorená! Keďže je to tvoja prvá kampaň, vytvorili sme v nej pár vecí, ktoré ti pomôžu začať a dúfame, že ti poskytnú inšpiráciu, čo všetko je možné.',
        'title'                 => 'Vytvoriť novú kampaň',
    ],
    'destroy'                           => [
        'success'   => 'Kampaň odstránená.',
    ],
    'edit'                              => [
        'description'   => 'Upraviť kampaň',
        'success'       => 'Kampaň upravená.',
        'title'         => 'Upraviť kampaň :campaign',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'Nové postavy majú popis osobnosti nastavený štandardne ako súkromný.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nové objekty sú súkromné',
    ],
    'errors'                            => [
        'access'        => 'K tejto kampani nemáš prístup.',
        'unknown_id'    => 'Neznáma kampaň.',
    ],
    'export'                            => [
        'description'   => 'Exportovať kampaň.',
        'errors'        => [
            'limit' => 'Maximum jeden export za deň bol dosiahnutý. Prosím, skús to opäť zajtra.',
        ],
        'helper'        => 'Exportuj svoju kampaň. Vytvorená bude notifikácia s linkom na stiahnutie.',
        'success'       => 'Export tvojej kampane sa pripravuje. Kanka ti zašle správu, akonáhle bude zozipovaný súbor pripravený na stiahnutie.',
        'title'         => 'Export kampane :name',
    ],
    'fields'                            => [
        'description'                   => 'Popis',
        'entity_count'                  => 'Počet objektov',
        'entity_personality_visibility' => 'Viditeľnosť osobností postáv',
        'entity_visibility'             => 'Viditeľnosť objektov',
        'excerpt'                       => 'Krátky popis',
        'followers'                     => 'Odberatelia',
        'header_image'                  => 'Titulný obrázok',
        'image'                         => 'Obrázok',
        'locale'                        => 'Jazyk',
        'name'                          => 'Názov',
        'rpg_system'                    => 'RPG systémy',
        'system'                        => 'Systém',
        'visibility'                    => 'Viditeľnosť',
    ],
    'following'                         => 'Odber aktívny',
    'helpers'                           => [
        'entity_personality_visibility' => 'Keď vytvoríš novú postavu, nebude nastavenie "Viditeľnosť osobnosti" automaticky aktivované.',
        'entity_visibility'             => 'Keď vytvoríš nový objekt, bude nastavenie "Súkromný" automaticky aktivované.',
        'excerpt'                       => 'Krátky popis kampane sa zobrazí na nástenke, napíš teda pár pár viet ako úvod do tvojho sveta. Nemusíš sa rozpisovať, stačí pár slov.',
        'locale'                        => 'Regionálne nastavenie, ktoré sa vzťahuje na tvoju kampaň. Používa sa na vytváranie obsahu a filtrovanie verejných kampaní.',
        'name'                          => 'Tvoja kampaň / svet môže mať ľubovoľné meno, pokiaľ sa skladá z min. 4 písmen alebo čísel.',
        'system'                        => 'Ak je tvoja kampaň verejne viditeľná, systém sa zobrazuje na stránke :link.',
        'systems'                       => 'Aby sme užívateľov nezahltili nespočetnými možnosťami, niektoré funkcionality Kanky sú prístupné len pre špecifické RPG systémy (napr. štatistický popis príšer pre D&D 5e). Priradením systému na tomto mieste aktivuješ dané funkcionality.',
        'visibility'                    => 'Ak nastavíte kampaň ako verejnú, bude ju vidieť každý, kto k nej bude mať link.',
    ],
    'index'                             => [
        'actions'       => [
            'new'   => [
                'description'   => 'Vytvoriť novú kampaň',
                'title'         => 'Nová kampaň',
            ],
        ],
        'add'           => 'Nová kampaň',
        'description'   => 'Spravovať tvoje kampane.',
        'list'          => 'Tvoje kampane',
        'select'        => 'Vybrať kampaň',
        'title'         => 'Kampane',
    ],
    'invites'                           => [
        'actions'       => [
            'add'   => 'Pozvať',
            'link'  => 'Nový link',
        ],
        'create'        => [
            'button'        => 'Pozvať',
            'description'   => 'Pozvi priateľa do svojej kampane',
            'link'          => 'Link vytvorený: <a href=":url" target="_blank">:url</a>',
            'success'       => 'Pozvánka zaslaná.',
            'title'         => 'Pozvať niekoho k tvojej kampani',
        ],
        'destroy'       => [
            'success'   => 'Pozvánka odstránená.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Pridať sa do kampane od :name</a>',
            'subject'   => ':name ťa pozval/a, aby si sa pridal/a do jeho kampane :campaign na kanka.io! Pozvánku môžeš akceptovať kliknutím na nasledujúci link.',
            'title'     => 'Pozvánka od :name',
        ],
        'error'         => [
            'already_member'    => 'Už si súčasťou tejto kampane.',
            'inactive_token'    => 'Táto pozvánka už bola použitá alebo daná kampaň už neexistuje.',
            'invalid_token'     => 'Platnosť tejto pozvánky už vypršala.',
            'login'             => 'Prosím, prihlás alebo registruj sa, aby si sa pridal/a do kampane.',
        ],
        'fields'        => [
            'created'   => 'Zaslať',
            'email'     => 'E-mail',
            'role'      => 'Rola',
            'type'      => 'Typ',
            'validity'  => 'Platnosť',
        ],
        'helpers'       => [
            'validity'  => 'Koľko používateľov môže použiť tento link, dokiaľ mu nevyprší platnosť.',
        ],
        'placeholders'  => [
            'email' => 'E-mailová adresa osoby, ktorú chceš pozvať',
        ],
        'types'         => [
            'email' => 'E-mail',
            'link'  => 'Link',
        ],
    ],
    'leave'                             => [
        'confirm'   => 'Si si istý/á, že chceš opustiť kampaň :name? Už ku nej nebudeš mať prístup, ibaže by ťa do nej opäť pozval jej vlastník.',
        'error'     => 'Nemôže opustiť kampaň.',
        'success'   => 'Opustil/a si kampaň.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Prepnúť',
            'switch-back'   => 'Prepnúť späť',
        ],
        'create'                => [
            'title' => 'Pridať člena do tvojej kampane',
        ],
        'description'           => 'Spravovať členov kampane',
        'edit'                  => [
            'description'   => 'Upraviť člena kampane',
            'title'         => 'Upraviť člena :name',
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
        'roles'                 => [
            'member'    => 'Člen',
            'owner'     => 'Vlastník',
            'player'    => 'Hráč',
            'public'    => 'Verejný',
            'viewer'    => 'Divák',
        ],
        'switch_back_success'   => 'Teraz si späť ako tvoj vlastný užívateľ.',
        'title'                 => 'Členovia kampane :name',
        'your_role'             => 'Tvoja rola: <i>:role</i>',
    ],
    'panels'                            => [
        'dashboard' => 'Nástenka',
        'permission'=> 'Oprávnenie',
        'sharing'   => 'Zdieľať',
        'systems'   => 'Systémy',
    ],
    'placeholders'                      => [
        'description'   => 'Krátky popis tvojej kampane',
        'locale'        => 'Jazyk',
        'name'          => 'Názov tvojej kampane',
        'system'        => 'D&D, Pathfinder, Fate, Dračí Doupě',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Pridať rolu',
        ],
        'create'        => [
            'success'   => 'Rola vytvorená.',
            'title'     => 'Vytvoriť novú rolu pre :name',
        ],
        'description'   => 'Spravovať roly kampane',
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
            'public'            => 'Rola "Verejný" sa používa, keď niekto zobrazuje tvoju verejnú kampaň. :more',
            'role_permissions'  => 'Umožniť role :name nasledujúce akcie pre všetky objekty.',
        ],
        'members'       => 'Členovia',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Vytvoriť',
                'delete'        => 'Odstrániť',
                'edit'          => 'Upraviť',
                'entity-note'   => 'Poznámky',
                'permission'    => 'Spravovať oprávnenia',
                'read'          => 'Zobraziť',
            ],
            'hint'      => 'Táto rola má automaticky prístup ku všetkému.',
        ],
        'placeholders'  => [
            'name'  => 'Názov role',
        ],
        'show'          => [
            'description'   => 'Členovia a oprávnenia role v kampani',
            'title'         => 'Rola :role kampane :campaign',
        ],
        'title'         => 'Roly kampane :name',
        'types'         => [
            'owner'     => 'Vlastník',
            'public'    => 'Verejný',
            'standard'  => 'Štandard',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Pridať',
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
        'description'   => 'Aktivovať alebo deaktivovať moduly v kampani.',
        'edit'          => [
            'success'   => 'Nastavenia kampane boli upravené.',
        ],
        'helper'        => 'Všetky moduly kampane môžu byť aktivované alebo deaktivované. Ak deaktivuješ modul, prepojené prvky rozhrania zmiznú, ale ostávajú existovať v pozadí, ak by si ich v budúcnosti potreboval/a. Tieto zmeny ovplyvňujú všetkých užívateľov kampane, vrátane s rolou Admin.',
        'helpers'       => [
            'calendars'     => 'Miesto, na ktorom vieš vytvoriť kalendáre tvojho sveta.',
            'characters'    => 'Postavy, ktoré obývajú svoj svet.',
            'conversations' => 'Fiktívne diskusie medzi postavami v tvojom svete alebo užívateľmi kampane.',
            'dice_rolls'    => 'Ak používaš Kanku na hranie, môžeš tu spravovať tvoje hody kockami.',
            'events'        => 'Sviatky, festivaly, katastrofy, narodeniny, vojny.',
            'families'      => 'Klany a rody, ich vzťahy a členovia.',
            'items'         => 'Zbrane, vozidlá, relikvie, elixíry.',
            'journals'      => 'Zistenia a pozorovania spísané postavami alebo príprava na hry pre Pána hry / jaskyne.',
            'locations'     => 'Planéty, sféry, kontinenty, rieky, štáty, osídlia, chrámy, hostince.',
            'menu_links'    => 'Vlastné linky v menu.',
            'notes'         => 'Báje, náboženstvá, dejiny, mágia, rasy.',
            'organisations' => 'Kulty, vojenské jednotky, frakcie, cechy.',
            'quests'        => 'Aby si vedel/a sledovať plnenie úloh a cieľov postáv.',
            'races'         => 'Ak má kampaň viac ako jednu rasu, pomôže sa ti v nich vyznať táto funkcia.',
            'tags'          => 'Každý objekt môže mať viacero nálepiek. Nálepky môžu patriť pod iné nálepky a objekty môžu byť podľa nálepiek filtrované.',
        ],
        'title'         => 'Moduly kampane :name',
    ],
    'show'                              => [
        'actions'       => [
            'leave' => 'Opustiť kampaň',
        ],
        'description'   => 'Detailné zobrazenie kampane',
        'tabs'          => [
            'export'        => 'Export',
            'information'   => 'Informácie',
            'members'       => 'Členovia',
            'menu'          => 'Menu',
            'roles'         => 'Roly',
            'settings'      => 'Moduly',
        ],
        'title'         => 'Kampaň :name',
    ],
    'visibilities'                      => [
        'private'   => 'Súkromný',
        'public'    => 'Verejný',
        'review'    => 'Čaká na schválenie',
    ],
];
