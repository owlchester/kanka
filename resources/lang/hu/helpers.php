<?php

return [
    'age'               => [
        'description'   => 'Hivatkozhatsz egy Karakterre egy naptárban úgy, hogy az adott Karakter oldalán az Emlékeztetők fülre kattintasz. Itt hozzáadhatsz egy új emlékeztetőt, és beállíthatod a típusát Születés, vagy Halál típusúra, hogy a karakter életkora automatikusan számolódjon. Ha mind a Születés, mind a Halál események be vannak állítva, mind megjelennek, és a halál pillanatában aktuális életkora is. Amennyiben csak a születési dátum került beállításra, úgy ez a dátum, és a jelenlegi életkor kerül megjelenítésre. Ha csak a Halál ideje lett beállítva, akkor ez a dátum, és az azóta eltelt évek kerülnek kiírásra.',
        'title'         => 'Karakter életkora, és halálának ideje',
    ],
    'attributes'        => [
        'con'   => 'Áll',
        'level' => 'Szint',
        'link'  => 'Tulajdonságokkal kapcsolatos lehetőségek',
        'title' => 'Tulajdonságok',
    ],
    'dice'              => [
        'description'               => 'Az általános kockadobási kódokat használjuk. Egyaránt érvényes a "d20" és a "4d4+4" képlet is, valamint használhatod a "d%"-at százalékos, a "df"-et pedig fudge kockákhoz. A [ ] zárójeleket pedig, ha nem akarod összeadni az eredményt (pl. 6[d10] Storyteller rendszerben).',
        'description_attributes'    => 'Felhasználhatod a karakterek attribútumainak értékét is a {character.attribútum_neve} szintaxis használatával. Például: {character.szint}d6+{character.bölcsesség}',
        'more'                      => 'A többi lehetőséget a kockadobó modul oldalán magyarázzuk el.',
        'title'                     => 'Kockadobások',
    ],
    'entity_templates'  => [
        'link'  => 'Hogyan állítsuk be a sablonokat',
        'title' => 'Entitássablonok',
    ],
    'filters'           => [
        'description'   => 'A szűrőt a találati lista elemeinek szűkítésére használhatod. A szöveges mezők számos lehetőséget biztosítanak, hogy részletesen meghatározhasd mi is legyen kiszűrve.',
        'empty'         => 'A :tag parancsjelet használva egy mezőben az összes olyan entitásra keresünk, ahol ez a mező nem volt kitöltve.',
        'ending_with'   => 'Egy :tag jelet beírva a keresett kifejezésed végére megkeresheted az összes entitást, aminek pontosan ez a kifejezés szerepel ebben a mezőjében.',
        'session'       => 'A szűrők és az oszlopok rendezésének beállítása egy entitás listára vonatkozóan elmentésre kerülnek az aktuális munkamenetedbe, azaz mindaddig, amíg nem csukod be a böngészőablakod, nincs szükség rá, hogy újra beállítsd őket minden oldalon.',
        'starting_with' => 'Egy :tag jelet beírva a kifejezésed elé, megkeresheted az összes entitást, amely nem tartalmazza azt a beírt kifejezést.',
        'title'         => 'Hogyan használjuk a szűrőket',
    ],
    'link'              => [
        'auto_update'       => 'A más entitásokra mutató hivatkozásokat automatikusan frissítjük, ha azok neve vagy leírása megváltozik.',
        'description'       => 'Könnyedén hivatkozhatsz más entitásokat a \'@\' begépelésével. A \'#\' begépelésével a naptáraid hónapjainak listája ugrik fel.',
        'formatting'        => [
            'text'  => 'Az engedélyezett HTML tag listát megtalálhatod itt: :github',
            'title' => 'Formázás',
        ],
        'friendly_mentions' => 'Egy entitásra való hivatkozás létrehozásához gépeld be a :code karaktert, majd a cél entitás nevének első pár betűjét, hogy megjelenjen a szóba jöhető entitások listája. A megfelelőt kiválasztva beszúrásra kerül egy :example  mintájú bejegyzés a szövegszerkesztőbe, ami majd egy hivatkozásként jelenik meg az említett entitásra.',
        'mentions'          => 'Egy entitásra való hivatkozás létrehozásához gépeld be a :code karaktert, majd a cél entitás nevének első pár betűjét, hogy megjelenjen a szóba jöhető entitások listája. A megfelelőt kiválasztva egy ilyen formájú bejegyzés kerül beszúrásra a szövegszerkesztőbe :example. A megjelenített hivatkozás nevének beállításához, az alábbi formátumot használd: :example_name. Hogy egy entitás adott rész-oldalára szeretnél hivatkozni, ezt a formátumot használd: :example_page. Hogy az entitás egy fülének nézetére hivatkoznál, használd ezt: :example_tab.',
        'months'            => 'A :code begépelésével a naptáraid hónapjainak listája ugrik fel.',
        'options'           => 'Néhány lehetőség :options',
        'title'             => 'Más entitások kapcsolása, rövidítések.',
    ],
    'map'               => [
        'description'   => 'Ha feltöltesz egy térképet egy helyszínhez, meg fog jelenni a \'Térkép\' menü a Helyszín felületén, és egy közvetlen hivatkozás a térképre a kampány helyszínek oldaláról. A térkép nézetből a felhasználok, akik szerkeszthetik a helyszínt, aktiválhatják a \'Szerkesztő Mód\'-ot, amely lehetővé teszi számukra, hogy ún. Térkép pontokat helyezzenek el a térképen. Ezek a pontok hivatkozásként szolgálhatnak már meglévő entitásokra, vagy címkékre, valamint számos alakúak, és méretűek lehetnek.',
        'private'       => 'A kampány Admin jogú felhasználói priváttá tehetik a térképet. Ezzel a többi felhasználó továbbra is láthatja a helyszínt, azonban a térkép rejtve marad előlük.',
        'title'         => 'Helyszín térképek',
    ],
    'pins'              => [
        'title' => 'Entitáskitűzők',
    ],
    'public'            => 'Nézd meg az oktatóvideónkat a Youtube-on, amelyben a nyilvános kampányok működését magyarázzuk el!',
    'title'             => 'Súgók',
    'widget-filters'    => [
        'link'  => 'widget szűrők',
        'title' => 'Főldal widget szűrők',
    ],
];
