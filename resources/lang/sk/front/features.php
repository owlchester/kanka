<?php

return [
    'abilities'     => [
        'description'   => 'Podobne ako pri inventároch, každý objekt môže mať schopnosti. Vytvor schopnosti v tvojej kampani a následne ich priraď tvojim objektom. Tieto môžu predstavovať schopnosti postáv, efekty miest (napr. dračieho brlohu), špeciálne moci vzhľadom na príslušnosť k istému rodu alebo prekliatia kvôli zjedeniu ježibabinho perníka. Schopnosti môžu mať nabitia, aby bolo možné sledovať ich používanie a môžu byť prepojené s atribútmi.',
        'title'         => 'Schopnosti',
    ],
    'attributes'    => [
        'description'   => 'Asi najzložitejšou a najkomplexnejšou funkcionalitou sú atribúty objektov. Tieto môžu sledovať čiastkové informácie, napr. HP určitej postavy, populáciu miesta či počet chrámov nejakej náboženskej organizácie. V atribútoch objektu je možné referencovať iné atribúty a použiť ich na automatické prepočty, napr. HP postavy = Level * Constitution.',
        'secondary'     => 'Atribúty postavy môžu byť štýlované do podoby denníka postavy tvojho systému prostredníctvom šablón na našom :marketplace.',
        'title'         => 'Atribúty',
    ],
    'boosters'      => [
        'description'   => 'Niektoré funkcionality sú dostupné iba pre boostnuté kampane. Keď si užívateľ predplatí Kanku, získa niekoľko boostov, ktoré môže rozdeliť medzi kampane. Tieto boosty môžu byť presunuté z jednej kampane do druhej, napr. ak kampaň skončí. Boosty trvajú tak dlho, ako dlho je aktívne dané predplatné.',
        'link'          => 'Prehľad všetkých boostnutých funkcionalít nájdeš na stránke s cenníkom.',
        'title'         => 'Boosty kampaní',
    ],
    'calendars'     => [
        'description'   => 'Do tvojho sveta môžeš pridať jeden alebo viacero kalendárov s plnou kontrolou nad počtom dní v roku, mesiacoch, dĺžkou týždňov, ročných období, družíc a ich fáz, atď. Pridaj do nich následne udalosti prepojené s objektami, ako napr. automaticky kalkulovaný vek postáv podľa kalendára.',
    ],
    'collaborative' => [
        'description'   => 'Kanka bola vytvorená tak, aby podporovala viacero svetov s viacerými členmi a kampaňami. Pripoj do kampane tvojich priateľov a priateľky, pridaj im jednu z rolí a maj dohľad nad funkciami a informáciami, ktoré sú pre nich takto dostupné. Tvoju kampaň si môžeš hocikedy pozrieť ako člen, pre istotu, že žiaden citlivý obsah nie je viditeľný.',
    ],
    'dashboards'    => [
        'description'   => 'Nástenka je centrálnym miestom, z ktorého môžeš mať prehľad o tvojej kampani. Každá kampaň môže mať plnohodnotne vlastnú nástenku, pridané widgety z dlhého zoznamu dostupných možností. Pre veľké kampane s rôznymi skupinami je pomocou boostnutia možné vytvoriť vlastné nástenky pre jednotlivé role.',
        'title'         => 'Nástenky kampaní',
    ],
    'discover-all'  => 'Objav naše úžasné funkcionality',
    'editor'        => [
        'description'   => 'Nepotrebuješ sa naučiť programovať na vytváranie štrukturovaných a pekných textov. Vďaka :summernote môžeš používať formáty vo všetkých textoch. A to najlepšie - pridali sme doň podporu pre referencovanie ďalších objektov v kampani pomocou :at-code symbolu.',
        'title'         => 'Editor',
    ],
    'entity'        => [
        'description'   => 'Kanka bola vytvorená okolo zoznamu 20 rôznych typov objektov. Sú to preddefinované typy hlavných stavebných kameňov kampane: postavy, miesta, rody, predmety, úlohy, denníky, kalendáre, časové osy a ďalšie. Niektoré funkcie zdieľajú medzi sebou, ale sú jedinečné samé o sebe a ako interagujú s ostatnými prvkami kampane.',
        'title'         => 'Objekty v Kanke',
    ],
    'free'          => [
        'description'   => 'Už ťa prestalo baviť platiť za základné funkcionality ako neobmedzené kampane, mať limit na počet hráčov a hráčok v kampani alebo nevedieť kontrolovať, kto vidí čo? Nás tiež, preto sú základné funkcionality v Kanke dostupné úplne zadarmo. Zároveň máme pár :bonuses, ktoré sú pekné, ale nie nutné.',
    ],
    'gm'            => [
        'title' => 'Rozprávači a rozprávačky príbehov (GMs)',
    ],
    'inventory'     => [
        'description'   => 'Každý objekt môže mať vlastný inventár. Táto funkcia umožňuje manažment predmetov vo vlastníctve postáv, predajný zoznam v obchodíkoch (miesta), odmeny za splnenie úlohy, majetok rodu alebo iné konštelácie, ktoré si môžeš vymyslieť. Inventár je možné prepojiť s predmetmi v tvojej kampani, ale je flexibilný a môže byť používaný bez nutnosti vytvoriť každý predmet samostatne.',
        'title'         => 'Inventár',
    ],
    'journals'      => [
        'description'   => 'Naplánuj svoje herné sedenia, alebo spíš záznamy z pohľadu tvojej postavy pomocou modulu denníka. Záznamy v denníku môžeš pripnúť do kalendára s možnosťou sledovať zároveň reálny čas hrania a dátum v hernom kalendári.',
        'title'         => 'Denníky',
    ],
    'links'         => [
        'description'   => 'Objekty v boostnutých kampaniach majú nový typ vstupov, ktoré k nim môžu byť pripnuté: linky. Zobrazujú sa v prehľade objektu a umožňujú pridať externé linky, napr. prepojenie so stránkou postavy v DNDBeyond.',
        'title'         => 'Linky',
    ],
    'maps'          => [
        'description'   => 'Nahraj tvoje nádherné mapy do tvojej kampane v Kanke a pridaj do nich vrstvy a označenia. Máš možnosť nastaviť, kto uvidí ktoré značky na nich, aby bolo zamedzené, že tvoje postavy zistia, kde nachádza tajná chodba k stratenému mestu.',
    ],
    'marketplace'   => [
        'description'   => 'Boostnuté kampane majú možnosť inštalácie pluginov z :marketplace. Sú to napr. témy, šablóny atribútov alebo balíky obsahu, ktoré vytvára naša komunita pre celé členstvo.',
        'title'         => 'Trhovisko',
    ],
    'modular'       => [
        'description'   => 'Sústredili sme naše úsilie, aby sme v Kanke vytvorili ca. 20 rôznych modulov, ktoré sa všetky zameriavajú na určitý aspekt hrania stolových RPG alebo tvorby svetov vo všeobecnosti. V každej kampani máš možnosť vytvoriť postavy, miesta, rody, organizácie, predmety, úlohy, denníky, kalendáre, udalosti, schopnosti a ďalšie. Nepotrebuješ schopnosti? Bez problému, môžeš deaktivovať moduly podľa tvojej vôle v každej kampani, čím si uľahčíš nastavenia podľa toho, čo považuješ za dôležité.',
    ],
    'other_features'=> 'Ďalšie funkcionality',
    'quests'        => [
        'description'   => 'Priprav si a maj prehľad o úlohách v tvojej hre, kam zavedú hráčstvo, postavy do nich zapojené, alebo organizácie, ktoré ich tajne ovplyvňujú. Akonáhle je úloha splnená, označ ju týmto spôsobom a môžeš prejsť na ďalšiu.',
        'title'         => 'Úlohy',
    ],
    'register'      => 'Páči sa ti, čo vidíš? Vytvor si zadarmo konto hoci aj hneď teraz',
    'relations'     => [
        'description'   => 'Potrebuješ si zapísať, že Svynna je rivalkou Mykela, alebo že Kyle sa narodil vo Washingtone? Použi na to náš nástroj pre manažment vzťahov medzi rôznymi objektami v tvojom svete. Že o niektorých vzťahoch by hráčstvo nemalo vedieť? Jednoducho ich označ ako súkromné!',
        'secondary'     => ':boosted-campaigns majú prístup k vizuálnemu prehliadaču vzťahov daného objektu.',
    ],
    'sections'      => [
        'boosted'       => 'Boostnuté funkcionality',
        'general'       => 'Všeobecné',
        'rpg'           => 'RPG hry',
        'worldbuilding' => 'Tvorba svetov',
    ],
    'theming'       => [
        'description'   => 'Boostnuté kampane môžu nastaviť pre hráčsky tím tému, ktorú uvidia, keď sú v Kanke, ale taktiež napísať vlastné CSS a plne upraviť, ako Kanka vyzerá.',
        'title'         => 'Štýly',
    ],
    'timelines'     => [
        'description'   => 'Časové osy umožňujú vizualizovať a plánovať históriu krajiny, vzostup rodu k moci, dejový oblúk hráčskej postavy a iné. Časové osy je možné rozdeliť na obdobia, pričom každé z nich môže obsahovať textové prvky, ktoré je možné priradiť iným objektom v tvojej kampani.',
    ],
    'updates'       => [
        'description'   => 'Kanka nie je len :small-team pozostávajúci z dvoch vášnivých tvorcov svetov. Je to tiež veľká komunita dedikovaných osôb, ktorá nám pomáha rozhodovať sa a prinášať stále nové aktualizácie. Sme hrdí na to, že sa zameriavame na funkcionality, ktoré naša komunita požaduje a obľubuje. Priemerne aktualizujeme Kanku dvakrát mesačne pre všetkých, niekedy našich užívateľov rozmaznávame aj častejšie. Pravidelne hovoríme detailne o týchto pripravovaných zmenách a zbierame spätnú väzbu na Discorde.',
        'small-team'    => 'tím',
        'title'         => 'Časté aktualizácie',
    ],
    'worldbuilding' => [
        'title' => 'Tvorcovia a tvorkyne svetov',
    ],
];
