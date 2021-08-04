<?php

return [
    'create'                            => [
        'description'           => 'Vytvořit nové tažení',
        'helper'                => [
            'title'     => 'Vítej v :name',
            'welcome'   => <<<'TEXT'
Než budeme pokračovat, je třeba zvolit název tažení, který odpovídá prostředí a situaci tvého světa. Pokud zatím vhodný název nemáš, nevadí. Později je možné jej změnit nebo vytvořit další tažení.

Děkujeme, že jsi se rozhodl pro systém Kanka a vítáme tě do naší rostoucí komunity.
TEXT
,
        ],
        'success'               => 'Vytvořeno tažení',
        'success_first_time'    => 'Nové tažení je připraveno. Protože jde o tvé první tažení, přidali jsme do něj několik objektů, které ti pomohou v začátcích a poskytnou určitou inspiraci, jak systém používat.',
        'title'                 => 'Vytvořit nové tažení',
    ],
    'destroy'                           => [
        'action'    => 'Odstratnit tažení',
        'helper'    => 'Tažení lze odstranit pouze, pokud zůstáváš jeho jediným členem.',
        'success'   => 'Tažení odstraněno',
    ],
    'edit'                              => [
        'description'   => 'Upravit tažení',
        'success'       => 'Tažení upraveno',
        'title'         => 'Upravit tažení :campaign',
    ],
    'entity_note_visibility'            => [
        'pinned'    => 'Připnout nové poznámky objektů',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'Ve výchozím nastavení se popis osobností nových postav nastaví jako soukromý.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nové objekty jsou soukromé',
    ],
    'errors'                            => [
        'access'        => 'K tomuto tažení nemáš přístup',
        'superboosted'  => 'Tato funkce je dostupná pouze pro tažení se "superboosted" výhodou.',
        'unknown_id'    => 'Neznámé tažení',
    ],
    'export'                            => [
        'description'       => 'Exportovat tažení',
        'errors'            => [
            'limit' => 'Export lze provést pouze jednou denně. Zkus to, prosím, znovu zítra.',
        ],
        'helper'            => 'Exportuje tažení formou odkazu na soubor archivu ke stažení.',
        'helper_secondary'  => <<<'TEXT'
Vytvoří se dva soubory: Jeden soubor s objekty ve formátu JSON. A druhý soubor s uloženými obrázky.
Pozor, u větších tažení může pokus o export obrázků skončit chybou. V tom případě je třeba použít :api
TEXT
,
        'success'           => 'Export tvého tažení se připravuje. Jakmile bude soubor archivu ke stažení k dispozici, zašleme ti upozornění.',
        'title'             => 'Export tažení :name',
    ],
    'fields'                            => [
        'boosted'                       => '"Boost" výhoda od',
        'css'                           => 'CSS',
        'description'                   => 'Popis',
        'entity_count'                  => 'Počet objektů',
        'entity_note_visibility'        => 'Připnuté poznámky objektů',
        'entity_personality_visibility' => 'Viditelnost popisu osobnosti postavy',
        'entity_visibility'             => 'Viditelnost objektu',
        'entry'                         => 'Popis tažení',
        'excerpt'                       => 'Stručný popis tažení',
        'followers'                     => 'Sledující',
        'header_image'                  => 'Obrázek pozadí nástěnky tažení',
        'hide_history'                  => 'Skrýt historii objektu',
        'hide_members'                  => 'Skrýt členy tažení',
        'image'                         => 'Obrázek',
        'locale'                        => 'Jazyk',
        'name'                          => 'Název',
        'open'                          => 'Otevřené pro přihlášky',
        'public_campaign_filters'       => 'Filtr veřejných tažení',
        'related_visibility'            => 'Viditelnost příbuzných prvků',
        'rpg_system'                    => 'Systémy her na hrdiny',
        'superboosted'                  => '"Superboost" výhoda od',
        'system'                        => 'Systém',
        'theme'                         => 'Téma',
        'tooltip_family'                => 'Nezobrazovat jména rodin v informačních bublinách',
        'tooltip_image'                 => 'Zobrazovat obrázky objektů v informačních bublinách',
        'visibility'                    => 'Viditelnost',
    ],
    'following'                         => 'Sledující',
    'helpers'                           => [
        'boost_required'                => 'Tato funkce vyžaduje zvýhodněné tažení pomocí "Boost". Další informace najdeš na stránce :settings',
        'boosted'                       => 'Jsou dostupné některé bonusové funkce, protože tažení je zvýhodněné pomocí "Boost". Další informace najdeš na stránce :settings',
        'css'                           => 'Pro své tažení můžeš vytvořit vlastní CSS definici. Jakékoli zneužití této funkce povede k odstranění CSS definice. Opakované nebo závažné porušení mohou vést k odstranění tvého tažení.',
        'dashboard'                     => 'Vyplněním následujících polí ovlivníš vzhled nástěnky tažení.',
        'entity_note_visibility'        => 'Při vytváření nové poznámky objektu se u ní automaticky zaškrtne políčko "Připnutá".',
        'entity_personality_visibility' => 'Při vytváření nové postavy nebude pole "Viditelný popis osobnosti" automaticky zaškrtnuté.',
        'entity_visibility'             => 'Při vytváření nového objektu bude automaticky zaškrtnuté políčko "Soukromý"',
        'excerpt'                       => <<<'TEXT'
Obsah tohoto pole se zobrazí v záhlaví nástěnky. Můžeš sem tedy napsat pár vět o svém světu.
Necháš-li toto pole prázdné, použije se prvních až 1000 znaků popisu tažení.
TEXT
,
        'header_image'                  => 'Obrázek na pozadí záhlaví nástěnky',
        'hide_history'                  => 'Tato možnost skryje historii změn objektů před běžnými uživateli (bez administrátorských oprávnění).',
        'hide_members'                  => 'Tato možnost skryje seznam členů kampaně před běžnými uživateli (bez administrátorských oprávnění).',
        'locale'                        => 'Jazyk, používaný v textech tažení. Používá se pro vytváření obsahu a seskupení veřejných tažení.',
        'name'                          => 'Název tvého tažení a světa musí obsahovat alespoň 4 písmena či slova. Maximální délka není omezena.',
        'public_campaign_filters'       => 'Zadáš-li následující informace, usnadníš vyhledání tvé veřejné kampaně mezi ostatními.',
        'public_no_visibility'          => 'Pozor! Vaše tažení je veřejné, ale veřejná role kampaně nemá k ničemu přístup. :fix',
        'related_visibility'            => 'Výchozí nastavení viditelnosti při vytváření nového objektu s tímto polem (poznámky objektů, vztahy, schopnosti, atd.)',
        'system'                        => 'Pokud je tvé tažení viditelné, systém se zobrazuje na stránce :link',
        'systems'                       => 'Protože nechceme uživatele zahltit příliš mnoha funkcemi, jsou některé prvky systému dostupné jen pro vybraná pravidla Her na hrdiny (např. tabulka vlastností nestvůr dle pravidel D&D apod.). Pokud přidáš podporované systémy, zobrazí se i související funkce.',
        'theme'                         => 'Vynutí téma tažení a přepíše předvolby uživatelů.',
        'view_public'                   => 'Chceš-li si prohlédnout své tažení, jak jej vidí uživatelé, coby veřejné tažení, otevři následující odkaz v soukromém / privátním zobrazení prohlížeče: :link',
        'visibility'                    => 'Zveřejnění tažení znamená, že kdokoli, kdo získá odkaz na toto tažení, si jej bude moci prohlédnout.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nové tažení',
            ],
        ],
        'title'     => 'Tažení',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'E-mailová pozvánka',
            'copy'  => 'Kopírovat odkaz do schánky',
            'link'  => 'Nový odkaz',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Vytvořit pozvánku',
                'send'      => 'Zaslat pozvánku',
            ],
            'description'   => 'Pozvat přítele ke tvému tažení',
            'success'       => 'Pozvánka odeslána',
            'success_link'  => 'Vytvořen odkaz: :link',
            'title'         => 'Pozvat někoho ke tvému tažení',
        ],
        'destroy'               => [
            'success'   => 'Pozvánka odstraněna',
        ],
        'email'                 => [
            'link_text' => 'Připojit se k tažení uživatele :name',
            'subject'   => 'Uživatel :name ti posílá pozvánku, aby ses připojil k jeho tažení s názvem ":campaign", které vytváří v systému https://kanka.io . Chceš-li se k němu připojit, klepni na následující odkaz.',
            'title'     => 'Pozvánka od uživatele :name',
        ],
        'error'                 => [
            'already_member'    => 'Už jsi členem tohoto tažení.',
            'inactive_token'    => 'Tato pozvánka už byla využita nebo toto tažení již neexistuje.',
            'invalid_token'     => 'Tato pozvánka již není platná.',
            'login'             => 'Chceš-li se připojit k tažení, musíš se nejdříve přihlásit nebo zaregistrovat.',
        ],
        'fields'                => [
            'created'   => 'Odesláno',
            'email'     => 'E-mail',
            'role'      => 'Role',
            'type'      => 'Typ',
            'validity'  => 'Platnost',
        ],
        'helpers'               => [
            'email'     => 'Naše emailové zprávy často padají do spamu a někdy může jejich doručení trvat až několik hodin.',
            'validity'  => 'Počet uživatelů, kteří mohou tento odkaz použít před jeho zneplatněním. Pokud pole ponecháte prázdné, bude mít pozvánka neomezenou platnost.',
        ],
        'placeholders'          => [
            'email' => 'E-mailová adresa uživatele, kterého chceš pozvat',
        ],
        'types'                 => [
            'email' => 'E-mail',
            'link'  => 'Odkaz',
        ],
        'unlimited_validity'    => 'Neomezené použití',
    ],
    'leave'                             => [
        'confirm'   => 'Určitě chceš opustit toto tažení? Tím k němu natrvalo ztratíš přístup - pokud ti správce tažení nepošle znovu pozvánku.',
        'error'     => 'Nelze opustit tažení.',
        'success'   => 'Opustil jsi tažení.',
    ],
    'members'                           => [
        'actions'       => [
            'switch'        => 'Zobrazit jako',
            'switch-back'   => 'Zpět k mému zobrazení',
        ],
        'create'        => [
            'title' => 'Přidat člena kampaně',
        ],
        'description'   => 'Spravovat členy kampaně',
        'edit'          => [
            'description'   => 'Upravit člena kampaně',
            'title'         => 'Upravit člena :name',
        ],
        'fields'        => [
            'joined'        => 'Připojil se',
            'last_login'    => 'Poslední přihlášení',
            'name'          => 'Uživatel',
            'role'          => 'Role',
            'roles'         => 'Role',
        ],
        'help'          => 'Počet členů tažení není omezen',
        'helpers'       => [
            'admin' => 'Jako člen role správce tažení můžeš zvát nové uživatele, odstraňovat neaktivní uživatele a měnit jejich přístupová práva. Chceš-li prověřit přístupová práva uživatele, klepni na tlačítko :button. O této funkci nalezneš více informací zde: :link',
            'switch'=> 'Zobrazit tažení jako tento uživatel',
        ],
        'impersonating' => [
            'message'   => 'Nyní kampaň vidíš jako zvolený uživatel. Některé funkce nemusí být nyní dostupné, ale jinak se vše zobrazuje přesně tak, jak by to viděl daný uživatel.',
            'title'     => 'Zobrazuje se z pohledu uživatele :name',
        ],
    ],
];
