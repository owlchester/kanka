<?php

return [
    'account-deletion'      => [
        'account_settings'  => 'Nastavení účtu',
        'answer'            => 'Chceš-li smazat svůj účet, jdi na stránku :account a sjeď dolů k sekci smazání účtu. Tím smažeš svůj účet a všechna tažení, kde jsi posledním členem.',
        'question'          => 'Jak smazat svůj účet?',
    ],
    'app_backup'            => [
        'answer'    => 'Zálohujeme dvakrát denně, abychom snížili riziko ztráty dat. I naše vlastní tažení udržujeme na tomto serveru, takže nechceme riskovat!',
        'question'  => 'Jak často se zálohují data v systému Kanka?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Nejlépe vysvětlíme Šablony atributů na příkladu.
Řekněme, že tvůj svět obsahuje mnoho míst a na každém z těchto míst si chceš udržovat atributy, udávající "Počet obyvatel", "Podnebí" a "Úroveň kriminality".

Samozřejmě můžeš tyto atributy přidávat zvlášť ke každému místu, ale to by bylo dosti pracné a čas od času možná na některý z těchto atributů zapomeneš. V takové situaci se hodí využití Šablony atributů.

Můžeš vytvořit šablonu s těmito atributy ("Počet obyvatel", "Podnebí" a "Úroveň kriminality" apod.) a pak ji využít při tvorbě míst. Díky tomu budou všechny místa, vytvořená s pomocí této šablony obsahovat připravené atributy a nemusíš si je už pamatovat!
TEXT
,
        'question'  => 'K čemu jsou dobré Šablony atributů?',
    ],
    'backup'                => [
        'answer'    => 'Jednou denně lze exportovat data všech svých tažení jako ZIP archiv. Klepni na "Tažení" v nabídce nalevo a poté na "Exportovat". Tím se spustí export dat, který bude dostupný po 30 minut. Tento export nelze znovu nahrát do systému Kanka - je určený pouze pro tvé vlastní potřeby, pokud systém nechceš nadále používat.',
        'question'  => 'Jak mohu zálohovat nebo exportovat svá tažení?',
    ],
    'bugs'                  => [
        'answer'    => 'Pokud můžeš, připoj se k našemu Discord serveru :discord a nahlaš chybu na kanálu #error-and-bugs.',
        'question'  => 'Jak mohu nahlásit chybu systému?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Tuto funkci systém Kanka nepodporuje. Pokud bys ale chtěl vést více skupin dobrodruhů ve stejném světě, můžeš pro ně udržovat samostatná dobrodružství, štítky a oddělovat je pomocí oprávnění.',
        'question'  => 'Mohu používat stejné objekty ve více taženích?',
    ],
    'custom'                => [
        'answer'    => <<<'TEXT'
Systém Kanka nabízí předdefinované typy objektů, které jsou spolu navzájem propojeny. Možnost používat vlastní typy objektů by vyžadovala zcela jiný přístup ke zpracování dat v systému a narušit tak funkci systému, zaměřenou na co nejsnazší budování vlastního světa, namísto na způsob organizace dat. 
Určitý kompromis nabízí možnost využívání štítků, které poskytují velmi flexibilní způsob označování objektů.
TEXT
,
        'question'  => 'Mohu vytvořit vlastní typy objektů?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Přejdi na nástěnku tažení a klepni na "Tažení" v nabídce nalevo. Tlačítko "Odstranit" se zobrazí, pokud jsi poslední člen tažení. Odstranění tažení je trvalá akce, která smaže všechna data, uložená na serverech, včetně obrázků.',
        'question'  => 'Jak mohu odstranit tažení?',
    ],
    'discord'               => [
        'answer'    => 'Chceš-li propojit své účty, klepni nejdřív na svého avatara vpravo nahoře a pak na tlačítko Profil. Poté přejdi na podstránku :apps a klepni na Propojit.',
        'question'  => 'Jak mohu propojit mé účty v systémech Kanka a Discord?',
    ],
    'early-access'          => [
        'answer'    => 'Předběžným přístupem odměňujeme naše věrné předplatitele - na 30 dní jim ve výhradním režimu zpřístupníme nejnovější moduly, takže si je mohou vyzkoušet dříve než ostatní.',
        'question'  => 'Co znamená Předběžný přístup?',
    ],
    'entity-notes'          => [
        'answer'    => 'Všem objektům lze přidávat Poznámky, což jsou textové bloky, které mohou být viditelné pouze pto tebe (hodí se pro spolupráci s PJem) nebo pro členy skupiny Správců nebo pro všechny. Můžeš také svým hráčům dát oprávnění pro vytváření a úpravu poznámek objektů aniž by měli oprávnění k úpravám celého objektu.',
        'question'  => 'Jak systém Kanka zachází s částečně skrytými informacemi?',
    ],
    'fields'                => [
        'answer'    => 'Odpověď',
        'category'  => 'Kategorie',
        'locale'    => 'Jazyk',
        'order'     => 'Pořadí',
        'question'  => 'Otázka',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Ano! Věříme, že tvá finanční situace by neměla ovlivňovat tvou možnost hrát Hry na hrdiny nebo vytvářet jejich světy a základní funkce systému budeme vždy poskytovat zdarma.
Pokud bys ale chtěl hrát o něco aktivnější roli, můžeš nás podpořit prostřednictvím předplatného a získat tak mj. možnost hlasovat o funkcích, které by se ti líbily nejvíce.

Kromě možnosti ovlivňovat směr vývoje systému Kanka, také získáš přístup ke zvýhodněním :boosters, budeš moci nahrávat větší soubory, tvé jméno se zapíše do síně slávy a mimo jiné, získáš i hezčí systémové ikonky!
TEXT
,
        'question'  => 'Zůstane Kanka použitelná zdarma?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Bohy doporučujeme vytvářet jako Postavy a náboženství jako Organizace. Chceš-li se snadno orientovat ve svých božstvech, doporučujeme je vytvářet s vhodným štítkem nebo typem.',
        'question'  => 'Kde mohu vytvářet náboženství a bohy?',
    ],
    'help'                  => [
        'answer'    => 'Především děkujeme, že nám chceš pomoci! Vždy uvítáme překladatele, testery nových funkcí nebo lektory pro naše nové uživatele. Pokud máš možnost dát vědět dalším lidem o systému Kanka, budeme také rádi. Ale nejlepší způsob, jak nám pomoci, bude připojit se na náš Discord server :discord, kde máme kanál věnovaný pro výpomoc.',
        'question'  => 'Jak vám mohu pomoci?',
    ],
    'map'                   => [
        'answer'    => 'Modul map podporuje obrázky typu PNG, JPG, WEBP a SVG. Mapy mohou obsahovat několik vrstev, skupiny a značky různých tvarů a velikostí, odkazující na další objekty v tažení.',
        'question'  => 'Mohu do systému Kanka nahrát mapy?',
    ],
    'mobile'                => [
        'answer'    => 'Aktuálně neexistuje žádná mobilní aplikace pro systém Kanka, ale velká část aplikace se bez problémů zobrazuje i na mobilních webových prohlížečích. Doufáme, že nám podpora od našich předplatitelů umožní časem zaplatit vývoj mobilní aplikace, ale není to priorita pro  nejbližší dobu.',
        'question'  => 'Existuje mobilní aplikace? Plánuje se?',
    ],
    'monsters'              => [
        'answer'    => 'Pro objekty jako národy, živočišné druhy, nestvůry a jakékoli jiné živé (či nemrtvé) bytosti mimo postavy, doporučujeme používat modul Rasy.',
        'question'  => 'Jak vytvářet nestvůry?',
    ],
];
