<?php

return [
    'age'           => [
        'description'   => 'Môžeš prepojiť postavu s kalendárom v kampani v karte Pripomienky danej postavy. Tam vieš pridať novú pripomienku a nastaviť typ na Narodenie alebo Smrť pre automatické prepočítavanie veku postavy. Ak sú obe vyplnené, budú zobrazené oba dátumy a zároveň konečný vek postavy. Ak je nastavené len narodenie, zobrazí sa tento dátum a aktuálny vek. Ak je zadaný len dátum smrti, zobrazí sa tento a počet rokov od smrti.',
        'title'         => 'Vek postavy a Smrť',
    ],
    'attributes'    => [
        'con'           => 'Con',
        'description'   => 'Použi atribúty na zobrazenie hodnôt daného objektu, ktoré nie sú text. Iné objekty môžeš v atribútoch použiť cez syntax rozšíreného referencovania :mention. Taktiež môžeš použiť iné atribúty pomocou :attribute syntaxe.',
        'level'         => 'Úroveň',
        'link'          => 'Možnosti atribútu',
        'math'          => 'Použiť môžeš tiež základné matematické operácie. Napr. :example vynásobí :level a :con atribúty tohto objektu. Ak by mal byť výsledok zaokrúhlený hore alebo dole, použi :ceil alebo :floor.',
        'title'         => 'Atribúty',
    ],
    'dice'          => [
        'description'               => 'Základné hody kockou sú možné pomocou "d20", "4d4+4", "d%" (percentuálny hod) alebo "df" (Fudge kocka).',
        'description_attributes'    => 'Tiež je možné použiť obsah atribútov postavy pomocou {character.attribute_name}. Napr. {character.level}d6+{character.wisdom}.',
        'more'                      => 'Ďalšie možnosti sú dostupné a vysvetlené na stránke pluginu pre hody kockou.',
        'title'                     => 'Hody kockami',
    ],
    'filters'       => [
        'description'   => 'Na obmedzenie počtu zobrazených výsledkov môžeš použiť filtre. Textové polia dovoľujú použiť rozličné možnosti na kontrolu filtrov.',
        'empty'         => 'Ak vpíšeš :tag do poľa, systém nájde všetky objekty, ktoré majú toto pole prázdne.',
        'ending_with'   => 'Ak zadáš :tag na konci tvojho textu, nájdeš všetky objekty, ktoré majú v tomto poli presne tento text.',
        'session'       => 'Nastavenie filtrov a poradia stĺpcov pre zoznamy objektov sú uložené v rámci tvojho pripojenia. Počas pripojenia ich nemusíš nastavovať na každej stránke.',
        'starting_with' => 'Ak zadáš :tag na začiatok tvojho textu, nájdeš všetko, čo nemá v tomto poli tento text.',
        'title'         => 'Ako používať filtre',
    ],
    'link'          => [
        'attributes'        => 'Atribúty objektu môžeš referencovať pomocou vpísania :code. Toto funguje len pre existujúce atribúty objektu.',
        'auto_update'       => 'Prepojenia na iné objekty budú automaticky aktualizované, keď sa zmení názov alebo popis cieľa.',
        'description'       => 'Prepojenia medzi objektami tvojej kampane môžeš vytvoriť jednoducho pomocou nasledujúcich skratiek.',
        'formatting'        => [
            'text'  => 'Zoznam povolených HTML tagov a atribútov nájdeš na našom :github.',
            'title' => 'Formátovanie',
        ],
        'friendly_mentions' => 'Prepojenie k iných objektom vytvoríš napísaním :code a potom prvých písmen názvu, čo spustí hľadanie tohto objektu. Toto vloží :example do textového editoru a vytvorí link k objektu, keď tento objekt zobrazíš.',
        'limitations'       => 'Prosím, nezabudni, že kvôli technickým obmedzeniam, tieto skratky nebudú fungovať na mobilných zariadeniach s Androidom, dokiaľ nebudeš používať nový Summernote editor. Editor textu si môžeš vybrať v tvojich Nastaveniach > Preferencie schémy.',
        'mentions'          => 'Prepojenie k iných objektom vytvoríš napísaním :code a potom prvých písmen názvu, čo spustí hľadanie daného objektu. Toto vloží :example do textového editoru. Ak chceš upraviť názov zobrazeného objektu, môžeš vpísať :example_name. Na zobrazenie podstránky objektu, použi :example_page. Na zobrazenie karty objektu, použi :example_tab.',
        'months'            => 'Vpíš :code, aby sa zobrazil zoznam mesiacov tvojho kalendára.',
        'title'             => 'Prepojenie iných objektov a skratky',
    ],
    'map'           => [
        'description'   => 'Keď k miestu nahráš mapu, objaví sa na stránke miesta menu mapy a tiež link na mapu priamo zo stránky miesta vašej kampane. V zobrazení mapy môžu užívatelia s oprávnením úpravy miest aktivovať Modus úprav, ktorý im umožní umiestniť na mapu značky. Tieto môžu byť prepojené s existujúcimi objektami alebo mať len názov, rozličnú veľkosť a tvar.',
        'private'       => 'Členovia kampane s rolou Admin môžu mapu nastaviť ako súkromnú. Toto umožní užívateľom zobraziť miesto, ale mapa ostane tajomstvom.',
        'title'         => 'Mapy miest',
    ],
    'public'        => 'Pozri si video, ktoré vysvetľuje verejné kampane, na YouTube.',
    'title'         => 'Pomocník',
];
