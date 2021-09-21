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
        'question'  => 'Mohu synchronizovat objekty napříč taženími?',
    ],
    'custom'                => [
        'answer'    => <<<'TEXT'
Systém Kanka nabízí předdefinované typy objektů, které jsou spolu navzájem propojeny. Možnost používat vlastní typy objektů by vyžadovala zcela jiný přístup ke zpracování dat v systému a narušit tak funkci systému, zaměřenou na co nejsnazší budování vlastního světa, namísto na způsob organizace dat. 
Určitý kompromis nabízí možnost využívání štítků, které poskytují velmi flexibilní způsob označování objektů.
TEXT
,
        'question'  => 'Mohu vytvořit vlastní typy objektů?',
    ],
];
