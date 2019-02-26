<?php

return [
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
A legjobban egy példán keresztül mutathatjuk be. Tegyük fel, hogy a világodban rengeteg helyszín van, és a városoknál szeretnéd a népességet, az éghajlatot és a bűnözési szintet egyedi tulajdonságokban nyilvántartani.

Ezt természetesen egyenként végrehajthatod minden érintett helyszínen, de ez hamar monotonná válhat, és néha előfordulhat az is, hogy elfelejted hozzáadni némelyikhez mondjuk a “Bűnözési szintet”. Itt jönnek képbe a tulajdonságsablonok.

Létrehozhatsz egy tulajdonságsablont ezekkel a tulajdonságokkal (Népesség, Éghajlat, Bűnözési szint), elnevezed mondjuk “Város”-nak, és ezt hozzáadhatod minden városodhoz, amikor elkészíted a bejegyzésüket. Ez létrehozza bennük a megfelelő tulajdonságokat, így neked csak a feltöltésüket kell megcsinálnod, nem kell észben tartanod a létrehozásukat is.
TEXT
,
        'question'  => 'Mik azok a tulajdonságsablonok?',
    ],
    'fields'                => [
        'answer'    => 'Válasz',
        'category'  => 'Kategória',
        'locale'    => 'Nyelv',
        'order'     => 'Rendezés',
        'question'  => 'Kérdés',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Igen! Úgy hisszük, hogy az anyagi helyzeted nem kell, hogy hatással legyen arra, hogy mennyire élvezed a szerepjátékokat vagy a világépítést, így mindig ingyenesen fogjuk tartani az alkalmazást. A nagylelkű Patreonos támogatóinknak köszönhetően fedezhetjük a havi szerverköltségeket, így az alkalmazás ingyenes maradhat!

A Patreonos támogatás előnyei: nagyobb fájlokat tölthetsz fel, a neved bekerül a Patreon dicsőségcsarnokunkba, szebb alapértelmezett ikonokat kapsz, szavazhatsz arra, hogy milyen fejlesztések kapjanak prioritást és még sok más.
TEXT
,
        'question'  => 'Később is ingyenesek maradtok?',
    ],
    'help'                  => [
        'answer'    => 'Először is, köszönjük, hogy segíteni szeretnél! Mindig szükségünk van emberekre, akik segítenek nekünk a fordításokkal, az új funkciók kipróbálásával vagy az új felhasználók útbaigazításával. Örülünk annak is, ha meséltek másoknak a Kankáról, elősegítve, hogy új felhasználókat érjünk el ott, ahol nem is gondoltuk volna. A legjobb első lépés az, hogy csatlakozol a közösésgünkhöz a Discordon, ahol egy csatorna kifejezetten a segítőknek van fenntartva. Ha szeretnéd, támogass minket a Patreonon is, hogy hozzáférhess annak bónuszaihoz is!',
        'question'  => 'Szeretnék segíteni! Mit tehetek?',
    ],
    'multiworld'            => [
        'answer'    => 'Nem! Annyi “kampányt” hozhatsz létre az alkalmazásban amennyit szeretnél, mindegyik jelképezhet egy önálló világot, környezetet vagy amit szeretnél. A kampányaid között egyazon fiókon belül könnyűszerrel váltogathatsz.',
        'question'  => 'Több világot építek több különböző környezetben. Külön fiókra van szükségem mindegyikükhöz?',
    ],
    'permissions'           => [
        'answer'    => 'Teljességgel, ezért hoztuk létre a Kankát! Minden játékosodat meghívhatod a kampányaidba, és szerepeket és jogosultságokat adhatsz neki. Rendkívül rugalmasra építettük a rendszert (egyaránt használhatsz kizáró és megengedő jogosultságrendszereket), hogy lefedhessünk annyiféle helyzetet, amennyit csak lehet.',
        'question'  => 'A szerepjátékos világom építésére akarom használni a Kankát, de szeretném, hogy a játékosaim hozzáférhessenek néhány entitáshoz, és szerkeszthessék a karakterüket. Lehetséges ez?',
    ],
    'show'                  => [
        'return'    => 'Vissza a GYIK-hez',
        'timestamp' => 'Utolsó frissítés: :date',
        'title'     => 'GYIK :name',
    ],
    'visibility'            => [
        'answer'    => 'Csak az általad meghívott személyek láthatják az alkotásod és léphetnek vele bármilyen interakcióba. Az adataid privátok, és mindig te rendelkezel velük.',
        'question'  => 'Bárki láthatja a világomat?',
    ],
];
