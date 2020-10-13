<?php

return [
    'app_backup'            => [
        'answer'    => 'Denne vytvárame dve zálohy, aby sme zabezpečili ochranu proti strate dát. Naše vlastné kampane sa nachádzajú na tomto serveri, takže nechceme podstupovať žiadne riziko!',
        'question'  => 'Ako často sa zálohujú dáta v Kanke?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Najlepší spôsob, ako vysvetliť podstatu Šablón atribútov, bude pomocou príkladu. Predstavme si, že tvoj svet má veľké množstvo miest. Pre mnohé z nich chceš zadať základné atribúty ako "Počet obyvateľov", "Podnebie", "Úroveň kriminality".

Môžeš tieto atribúty pre každé miesto nastaviť jednotlivo, to sa však čoskoro stane zdĺhavým, popr. zabudneš niekde zadať atribút "Úroveň kriminality". V takom prípade sa ti zíde Šablóna atribútov.

Vytvoríš jednu Šablónu atribútov s atribútmi "Počet obyvateľov", "Podnebie" a "Úroveň kriminality" a neskôr uplatníš túto pri tvojich miestach. Šablóna bude automaticky pridelená každému miestu a ty už len vyplníš dané hodnoty!
TEXT
,
        'question'  => 'Čo sú šablóny atribútov?',
    ],
    'backup'                => [
        'answer'    => 'Raz za deň si môžeš všetky dáta tvojej kampane exportovať v podobe ZIP súboru. Klikni v aplikácii v ľavom menu na "Kampaň" a potom na "Exportovať". Tým sa vytvorí export, ktorý bude dostupný 30 minút. Tento export nemôžeš nahrať späť do Kanky, je len pre pokoj v tvojej duši, ak už aplikáciu nebudeš používať.',
        'question'  => 'Ako môžem zálohovať alebo exportovať moju kampaň?',
    ],
    'bugs'                  => [
        'answer'    => 'Pridaj sa jednoducho do nášho :discord servera a ohlás danú chybu v #error-and-bugs kanáli.',
        'question'  => 'Kde môžem nahlásiť chyby v aplikácii?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Túto funkcionalitu Kanka nepodporuje. Môžeš ale manažovať viacero herných skupín v rovnakom svete. Ak používajú rovnakú kampaň, vieš ich prístupy kontrolovať cez kombináciu Úloh, Kategórií a Oprávnení.',
        'question'  => 'Môžem synchronizovať objekty vo viacerých kampaniach naraz?',
    ],
    'conversations'         => [
        'answer'    => 'Diskusie môžu byť využívané pre rozhovory medzi postavami alebo členmi kampane. Ak napr. chceš zdokumentovať nejaký dôležitý rozhovor medzie NPC-čkami a postavami hráčov a hráčiek, môžeš tak urobiť v tomto module. Tiež ich môžeš použiť na play-by-post kampane.',
        'question'  => 'Čo sú Diskusie?',
    ],
    'custom'                => [
        'answer'    => 'Kanka ponúka preddefinované typy navzájom integrovaných objektov. Ak by sme povolili vytváranie vlastných typov objektov, museli by sme aplikáciu úplne prerobiť a zároveň by sme prišli o zjednodušenie práce a namiesto tvorby svetov by sme riešili, ako ich organizovať. Okrem toho je Kanka dostatočne flexibilná pomocou objektu kategórií.',
        'question'  => 'Môžem vytvoriť mnou definované typy objektov?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Na nástenke tvojej kampane klikni na "Kampaň" v ľavom menu. Ak si posledným členom kampane, objaví sa tlačidlo "Zmazať". Zmazanie kampane je nevratná akcia, ktorá zmaže z našich serverov všetky údaje, vrátane obrázkov.',
        'question'  => 'Ako môžem kampaň zmazať?',
    ],
    'early-access'          => [
        'answer'    => 'Early Access (Skorý prístup) je spôsob, akým môžeme odmeniť našich prispievateľov. Počas 30 dní môžu exkluzívne vyskúšať všetky najnovšie moduly predtým, než sú dostupné pre všetkých.',
        'question'  => 'Čo je Early Access?',
    ],
    'entity-notes'          => [
        'answer'    => 'Všetky objekty majú kartu pre Poznámky objektu, čo sú krátke textové poznámky, ktoré môžu byť nastavené viditeľné pre teba (aj keď napr. spolu-GM-uješ), len pre členov s rolou Admin alebo pre všetkých. Hráčom a hráčkam vieš poskytnúť oprávnenie pridávať objektom poznámky bez toho, aby vedeli upravovať daný objekt.',
        'question'  => 'Ako zaobchádza Kanka s informáciami, ktoré by nemali byť všeobecne viditeľné?',
    ],
    'fields'                => [
        'answer'    => 'Odpoveď',
        'category'  => 'Kategória',
        'locale'    => 'Jazyk',
        'order'     => 'Poradie',
        'question'  => 'Otázka',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Áno! Sme toho názoru, že naša finančná situácia nemá mať dopad na pôžitok z hrania RPG hier alebo tvorby svetov, preto základné funkcie aplikácie budú stále dostupné zadarmo. Ale ak sa chceš aktívne zapojiť a podporiť naše ciele, zároveň hlasovať za funkcie, ktoré by ti najviac vyhovovali, môžeš si nás predplatiť.

Popri hlasovaní za smer, ktorým chceš, aby sa Kanka vyvíjala, podporou získaš prístup k :boosters, vyššiemu limitu pre nahrané súbory, tvoje meno bude pridané do siene slávy, krajšie ikonky a oveľa viac!
TEXT
,
        'question'  => 'Ostane Kanka dostupná zadarmo?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Odporúčame bohov vytvoriť ako postavy a náboženstvá ako organizácie. Ak chceš rýchlo nájsť nejaké božstvá, odporúčame ich vytvoriť zároveň so zodpovedajúcou kategóriou.',
        'question'  => 'Kde mám vytvoriť bohov a náboženstvá?',
    ],
    'help'                  => [
        'answer'    => 'Za prvé, vďaka, že nám chceš pomôcť! Stále radi vidíme, ak sa prihlásia ľudia, ktorí by nám chceli pomôcť s prekladmi, testovaním nových funkcionalít alebo by chceli pomáhať novým užívateľom. Tiež máme radi, ak Kanku odporúčajú ďalej na miestach, na ktoré sme doteraz nemysleli. Najlepší spôsob, ako nám pomôcť, je pridať sa k nám na našom :discord serveri, kde máme dedikovaný kanál pre výpomoc.',
        'question'  => 'Ako vám môžem pomôcť?',
    ],
    'map'                   => [
        'answer'    => 'Modul Mapy podporuje súbory vo formátoch PNG, JPG a SVG. Mapy môžu mať vrstvy, značky a skupiny značiek v rôznych tvaroch a veľkostiach, ktoré môžu referencovať ďalšie objekty v kampani.',
        'question'  => 'Môžem do Kanky nahrať mapy?',
    ],
    'mobile'                => [
        'answer'    => 'Aktuálne neexistuje mobilná aplikácia pre Kanku, ale väčšina funkcionalít funguje aj na telefóne. Dúfame, že pomocou podpory cez predplatné sa nám niekedy v budúcnosti podarí zaplatiť niekoho, kto jedného dňa vytvorí mobilnú aplikáciu, ale v blízkej budúcnosti to nemáme v pláne.',
        'question'  => 'Existuje mobilná aplikácia? Plánujete nejakú?',
    ],
    'monsters'              => [
        'answer'    => 'Pre vytvorenie hocijakej entity ako národy, rasy, príšery alebo hocičo iné, čo je živé (alebo nemŕtve) odporúčame modul Rasy.',
        'question'  => 'Kde môžem vytvoriť príšery?',
    ],
    'multiworld'            => [
        'answer'    => 'Môžeš byť súčasťou toľkých kampaní, koľkých chceš, vrátane tých, ktoré vytvoríš. Ak chceš prepnúť alebo vytvoriť novú kampaň, prejdi do nástenky kampane a hore vpravo klikni na svoju aktuálnu kampaň, čím zobrazíš prepínač medzi kampaňami.',
        'question'  => 'Môžem mať viac ako jednu kampaň?',
    ],
    'nested'                => [
        'answer'    => 'Ak preferuješ vnorené zobrazenie ako štandardné (napr. po kliknutí na Vnorené zobrazenie v zozname miest), môžeš si ho nastaviť v tvojom profile a nastaveniach zobrazenia. Tam môžeš zaškrtnúť možnosť pre vnorené zobrazenie. Toto je len pre tvoje konto, nie štandardne pre všetky kampane.',
        'question'  => 'Môžem nastaviť, aby sa zoznamy zobrazovali štandardne ako vnorené?',
    ],
    'organise_play'         => [
        'answer'    => 'Spojili sme sa s :lfgm, kde máš možnosť organizovať tvoje hracie sedenia s tvojou skupinou. Môžeš synchronizovať tvoju kampaň na Kanke s tvojou kampaňou na LFGM k zobrazeniu voľných termínov na nástenke kampane.',
        'question'  => 'Kde môžem spravovať termíny mojich hracích sedení?',
    ],
    'permissions'           => [
        'answer'    => 'Samozrejme, preto sme Kanku vytvorili! Môžeš do kampane pozvať všetkých hráčov a hráčky a zadať im role a oprávnenia. Systém sme vytvorili ako extrémne flexibilný (môžeš sa rozhodnúť pre stratégiu opt-in alebo opt-out), aby pokryl veľké množstvo požiadavok a situácií.',
        'question'  => 'Môžem nejak obmedziť informácie, ktoré hráči a hráčky vidia v mojej kampani?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Dlhodobý plán je z Kanky vytvoriť všestranný nástroj pre tvorbu svetov a správu kampaní, ktorý sa neviaže na žiaden systém a jeho obsah vytvára komunita formou "Komunitných šablón". Ďalší náš cieľ je vytvoriť nástroje, ktorými by bola Kanka prepojená s inými platformami, napr. virtuálnymi aplikáciami pre hranie stolových RPG.

Kanku používame aj my, takže nemáme v pláne prestať ju ďalej vyvíjať a zlepšovať. Projekt ale vedieme zároveň ako open source, takže ho komunita môže prevziať a pokračovať v ňom, ak by sa nám niečo prihodilo.
TEXT
,
        'question'  => 'Aké dlhodobé plány máte?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Môžeš si pozrieť stránku s :public-campaigns, kde môžeš sledovať, ako Kanku používajú ostatní užívatelia.',
        'question'  => 'Akým spôsobom používajú Kanku iní užívatelia?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Aj keby toto bolo jednoduché pre názvy v angličtine alebo iných jazykoch, ktoré nepoužívajú rodovo rozdielne názvy, možnosť zmeniť názvy modulov by porušilo gramatickú správnosť a užívateľskú skúsenosť pre väčšinu jazykov, v ktorých je Kanka dostupná.',
        'question'  => 'Môžem moduly premenovať? Napr. Rody na Klany, alebo Organizácie na Frakcie?',
    ],
    'sections'              => [
        'community'     => 'Komunita',
        'general'       => 'Všeobecné',
        'other'         => 'Iné',
        'permissions'   => 'Oprávnenia',
        'pricing'       => 'Cenník',
        'worldbuilding' => 'Tvorba svetov',
    ],
    'show'                  => [
        'return'    => 'Späť na FAQ',
        'timestamp' => 'Posledná úprava dňa :date',
        'title'     => 'FAQ :name',
    ],
    'user-switch'           => [
        'answer'    => 'Oprávnenia môžu byť trochu zložitejšie, najmä vo väčších kampaniach. Ako administrátor kampane môžeš na stránke členov kampane kliknúť na "Prepnúť", ktorý sa zobrazí vedľa mena člena kampane. Po kliknutí ťa systém prihlási ako daného užívateľa a povolí ti vidieť kampaň cez jeho oči. Toto je najjednoduchší spôsob, akým môžeš skontrolovať nastavenie oprávnení tvojej kampane.',
        'question'  => 'Mám nastavené oprávnenia v mojej kampani. Ako ich otestujem?',
    ],
    'visibility'            => [
        'answer'    => 'Iba ľudia, ktorých pozveš do kampane, ju môžu vidieť a pracovať s tvojím dielom. Tvoje údaje sú súkromné a ostávajú pod tvojou kontrolou. Kampaň ale môžeš nastaviť aj ako verejnú, aby ju mohli vidieť aj neregistrovaní užívatelia.',
        'question'  => 'Môže niekto vidieť mnou vytvorený svet?',
    ],
];
