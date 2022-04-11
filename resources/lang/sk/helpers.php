<?php

return [
    'age'               => [
        'description'   => 'Môžeš prepojiť postavu s kalendárom v kampani v karte Pripomienky danej postavy. Tam vieš pridať novú pripomienku a nastaviť typ na Narodenie alebo Smrť pre automatické prepočítavanie veku postavy. Ak sú obe vyplnené, budú zobrazené oba dátumy a zároveň konečný vek postavy. Ak je nastavené len narodenie, zobrazí sa tento dátum a aktuálny vek. Ak je zadaný len dátum smrti, zobrazí sa tento a počet rokov od smrti.',
        'title'         => 'Vek postavy a Smrť',
    ],
    'api-filters'       => [
        'description'   => 'Nasledujúce filtre sú dostupné pre koncový bod API :name.',
        'title'         => 'API filtre',
    ],
    'attributes'        => [
        'con'               => 'Con',
        'description'       => 'Použi atribúty na zobrazenie hodnôt daného objektu, ktoré nie sú text. Iné objekty môžeš v atribútoch použiť cez syntax rozšíreného referencovania :mention. Taktiež môžeš použiť iné atribúty pomocou :attribute syntaxe.',
        'level'             => 'Úroveň',
        'link'              => 'Možnosti atribútu',
        'math'              => 'Použiť môžeš tiež základné matematické operácie. Napr. :example vynásobí :level a :con atribúty tohto objektu. Ak by mal byť výsledok zaokrúhlený hore alebo dole, použi :ceil alebo :floor.',
        'name'              => 'Názov objektu vieš referencovať použitím :name. Ak existuje atribút s týmto názvom, bude použitý namiesto objektu.',
        'pinned'            => 'Ak pripneš atribút pomocou :icon ikonky, zobrazí sa tento v menu objektu pod obrázkom.',
        'private'           => 'Súkromné atribúty pomocou :icon zobrazíš len pre členov kampane s administrátorskou rolou.',
        'random'            => 'Ak vytváraš alebo upravuješ šablónu atribútov, môžeš v nej nastaviť náhodné atribúty. Môže to byť buď náhodná hodnota medzi dvoma číslami oddelenými :dash alebo náhodná hodnota zo zoznamu hodnôt oddelených :comma. Hodnota pre daný atribút sa stanoví, keď je šablóna použitá, alebo keď je objekt uložený.',
        'random_examples'   => 'Napr. ak chceš číslo medzi 1 a 100, použi :number. Ak chceš hodnotu zo zoznamu možností, použí :list.',
        'title'             => 'Atribúty',
    ],
    'dice'              => [
        'description'               => 'Základné hody kockou sú možné pomocou "d20", "4d4+4", "d%" (percentuálny hod) alebo "df" (Fudge kocka).',
        'description_attributes'    => 'Tiež je možné použiť obsah atribútov postavy pomocou {character.attribute_name}. Napr. {character.level}d6+{character.wisdom}.',
        'more'                      => 'Ďalšie možnosti sú dostupné a vysvetlené na stránke pluginu pre hody kockou.',
        'title'                     => 'Hody kockami',
    ],
    'entity_templates'  => [
        'description'   => 'Ak vytváraš nové objekty, môžeš pre nich použiť existujúcu šablónu a nezačínať stále od nuly. Nastaviť objekt ako šablónu môžeš tak, že v jeho zobrazení klikneš na :link v ponuke akcií :action hore vpravo. Ak sa zobrazuje zoznam objektov, šablóny tohto typu budú dostupné vedľa tlačidla :new. Každý typ objektu môžeš mať viacero šablón.',
        'link'          => 'Ako nastaviť šablóny',
        'remove'        => 'Ak chceš zrušiť nastavenie objektu ako šablóny, klikni na tlačidlo :remove, ktoré je namiesto :link akcie uvedenej hore.',
        'title'         => 'Šablóny objektov',
    ],
    'filters'           => [
        'attributes'    => [
            'exclude'   => '!Úroveň',
            'first'     => 'Môžeš filtrovať objekty podľa ich atribútov. Polia hľadania sú korešpondujú s názvom a hodnotou. Ak ponecháš pole hodnoty prázdne, budú vyhľadané objekty, ktorých atribút má daný názov. Môžeš vpísať :exclude, aby napr. neboli zohľadnené objekty s názvom atribútu Úroveň.',
            'second'    => 'Filter nezohľadňuje prepočty v atribútoch. Ak atribút má hodnotu :code, nie je možné ho vyhľadať.',
        ],
        'clipboard'     => 'Ak sú filtre aktívne, je aktívne aj tlačidlo na kopírovanie do schránky. Toto skopíruje filtre do tvojej schránky a následne ich môžeš použiť ako filtre pre nástenkové widgety alebo pre rýchle linky.',
        'description'   => 'Na obmedzenie počtu zobrazených výsledkov môžeš použiť filtre. Textové polia dovoľujú použiť rozličné možnosti na kontrolu filtrov.',
        'empty'         => 'Ak vpíšeš :tag do poľa, systém nájde všetky objekty, ktoré majú toto pole prázdne.',
        'ending_with'   => 'Ak zadáš :tag na konci tvojho textu, nájdeš všetky objekty, ktoré majú v tomto poli presne tento text.',
        'multiple'      => 'Môžeš kombinovať možnosti hľadania v textových poliach pomocou :syntax. Napr. :example.',
        'session'       => 'Nastavenie filtrov a poradia stĺpcov pre zoznamy objektov sú uložené v rámci tvojho pripojenia. Počas pripojenia ich nemusíš nastavovať na každej stránke.',
        'starting_with' => 'Ak zadáš :tag na začiatok tvojho textu, nájdeš všetko, čo nemá v tomto poli tento text.',
        'title'         => 'Ako používať filtre',
    ],
    'link'              => [
        'advanced'          => [
            'title' => 'Rozšírené referencie',
        ],
        'anchor'            => 'Rozšírené referencie môžu tiež špecifikovať ukotvenie v HTML, kam daný link má smerovať pomocou :example.',
        'attribute'         => [
            'description'   => 'Taktiež je možné referencovať aj atribúty objektu. Jednoducho zadaj :code a tri alebo viac písmen, aby sa začali zobrazovať zodpovedajúce atribúty objektu.',
            'title'         => 'Atribúty',
        ],
        'auto_update'       => 'Prepojenia na iné objekty budú automaticky aktualizované, keď sa zmení názov alebo popis cieľa.',
        'description'       => 'Prepojenia medzi objektami tvojej kampane môžeš vytvoriť jednoducho pomocou nasledujúcich skratiek.',
        'filtering'         => [
            'description'   => 'Filtrovanie presne daného objektu je jednoduché.',
            'exact'         => 'Zadaj :code, aby sa našli objekty s rovnakým názvom.',
            'space'         => 'Zadaj :code, aby sa našli objekty s medzerou v názve.',
            'title'         => 'Filtrovanie',
        ],
        'formatting'        => [
            'text'  => 'Zoznam povolených HTML tagov a atribútov nájdeš na našom :github.',
            'title' => 'Formátovanie',
        ],
        'friendly_mentions' => 'Prepojenie k iných objektom vytvoríš napísaním :code a potom prvých písmen názvu, čo spustí hľadanie tohto objektu. Toto vloží :example do textového editoru a vytvorí link k objektu, keď tento objekt zobrazíš.',
        'mention_helpers'   => 'Ak je v názve objektu medzera, použi :example namiesto medzery. Ak chceš hľadať objekt presne podľa zadaného mena, použi :exact.',
        'mentions'          => 'Prepojenie k iných objektom vytvoríš napísaním :code a potom prvých písmen názvu, čo spustí hľadanie daného objektu. Toto vloží :example do textového editoru. Ak chceš upraviť názov zobrazeného objektu, môžeš vpísať :example_name. Na zobrazenie podstránky objektu, použi :example_page. Na zobrazenie karty objektu, použi :example_tab.',
        'mentions_field'    => 'Taktiež môžeš zobraziť aj pole objektu namiesto názvu v linke pomocou :code.',
        'month'             => [
            'title' => 'Kalendárne mesiace',
        ],
        'months'            => 'Vpíš :code, aby sa zobrazil zoznam mesiacov tvojho kalendára.',
        'options'           => 'Niektoré možnosti sú :options.',
        'overview'          => 'Jednoducho vytvor prepojenie s existujúcimi objektami kampane zadaním :code a troch a viac písmen.',
        'title'             => 'Prepojenie iných objektov a skratky',
    ],
    'map'               => [
        'description'   => 'Keď k miestu nahráš mapu, objaví sa na stránke miesta menu mapy a tiež link na mapu priamo zo stránky miesta vašej kampane. V zobrazení mapy môžu užívatelia s oprávnením úpravy miest aktivovať Modus úprav, ktorý im umožní umiestniť na mapu značky. Tieto môžu byť prepojené s existujúcimi objektami alebo mať len názov, rozličnú veľkosť a tvar.',
        'private'       => 'Členovia kampane s rolou Admin môžu mapu nastaviť ako súkromnú. Toto umožní užívateľom zobraziť miesto, ale mapa ostane tajomstvom.',
        'title'         => 'Mapy miest',
    ],
    'pins'              => [
        'description'   => 'Objekty môžu mať vzťahy a atribúty pripnuté vpravo v prehľade. Úpravou vzťahu alebo atribútu a nastavením pripináčika, ich na toto miesto pripneš.',
        'title'         => 'Pripnutia objektu',
    ],
    'public'            => 'Pozri si video, ktoré vysvetľuje verejné kampane, na YouTube.',
    'title'             => 'Pomocník',
    'troubleshooting'   => [
        'description'       => 'Člen tímu Kanky ťa poslal na túto stránku. Vyber si kampaň zo zoznamu a vygeneruj token, aby sme vedeli dočasne pristúpiť do tvojej kampane s rolou Admin.',
        'errors'            => [
            'token_exists'  => 'Token pre :campaign už existuje.',
        ],
        'save_btn'          => 'Vygenerovať token',
        'select_campaign'   => 'Zvoľ kampaň',
        'subtitle'          => 'Prosím, pošlite pomoc!',
        'success'           => 'Prosím, skopíruj nasledujúci token a zašli ho niekomu z tímu Kanky.',
        'title'             => 'Riešenie problémov',
    ],
    'widget-filters'    => [
        'description'   => 'Filtrovať zobrazované objekty vo widgete nedávno upravených je možné použitím zoznamu polí v objektoch a ich hodnôt. Napr. môžeš použiť :example na vyfiltrovanie mŕtvych postáv typu NPC.',
        'link'          => 'filter widgetu',
        'more'          => 'Možné je kopírovanie hodnôt z URL pre zoznamy objektov. Napr. ak zobrazuješ postavy kampane, vyfiltruj si tie, ktoré chceš zobraziť a následne skopíruj hodnoty za :question v URL.',
        'title'         => 'Filtre pre nástenkové widgety',
    ],
];
