<?php

return [
    'description'   => 'Tippek és trükkök, amik jól jöhetnek.',
    'dice'          => [
        'description'               => 'Az általános kockadobási kódokat használjuk. Egyaránt érvényes a "d20" és a "4d4+4" képlet is, valamint használhatod a "d%"-at százalékos, a "df"-et pedig fudge kockákhoz. A [ ] zárójeleket pedig, ha nem akarod összeadni az eredményt (pl. 6[d10] Storyteller rendszerben).',
        'description_attributes'    => 'Felhasználhatod a karakterek attribútumainak értékét is a {character.attribútum_neve} szintaxis használatával. Például: {character.szint}d6+{character.bölcsesség}',
        'more'                      => 'A többi lehetőséget a kockadobó modul oldalán magyarázzuk el.',
        'title'                     => 'Kockadobások',
    ],
    'link'          => [
        'auto_update'   => 'A más entitásokra mutató hivatkozásokat automatikusan frissítjük, ha azok neve vagy leírása megváltozik.',
        'description'   => 'Könnyedén hivatkozhatsz más entitásokat a \'@\' begépelésével. A \'#\' begépelésével a naptáraid hónapjainak listája ugrik fel.',
        'title'         => 'Más entitások kapcsolása, rövidítések.',
    ],
    'public'        => 'Nézd meg az oktatóvideónkat a Youtube-on, amelyben a nyilvános kampányok működését magyarázzuk el!',
    'title'         => 'Súgók',
];
