<?php

return [
    'app_backup'            => [
        'answer'    => 'Napi két biztonsági mentést hajtunk végre az adatvesztés elkerülése érdekében. A saját kampányunkat is a szerveren tároljuk, így semmilyen kockázatot nem akarunk vállalni.',
        'question'  => 'Milyen gyakran történik biztonsági mentés a Kankáról?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
A legjobban egy példán keresztül mutathatjuk be. Tegyük fel, hogy a világodban rengeteg helyszín van, és a városoknál szeretnéd a népességet, az éghajlatot és a bűnözési szintet egyedi tulajdonságokban nyilvántartani.

Ezt természetesen egyenként végrehajthatod minden érintett helyszínen, de ez hamar monotonná válhat, és néha előfordulhat az is, hogy elfelejted hozzáadni némelyikhez mondjuk a “Bűnözési szintet”. Itt jönnek képbe a tulajdonságsablonok.

Létrehozhatsz egy tulajdonságsablont ezekkel a tulajdonságokkal (Népesség, Éghajlat, Bűnözési szint), elnevezed mondjuk “Város”-nak, és ezt hozzáadhatod minden városodhoz, amikor elkészíted a bejegyzésüket. Ez létrehozza bennük a megfelelő tulajdonságokat, így neked csak a feltöltésüket kell megcsinálnod, nem kell észben tartanod a létrehozásukat is.
TEXT
,
        'question'  => 'Mik azok a tulajdonságsablonok?',
    ],
    'backup'                => [
        'answer'    => 'Napi egy alkalommal, kiexportálhatod a kampányod összes adatát egy ZIP fájlba. Kattints a "Kampány" linkre a bal menüsoron, majd az "Export" gombra. Ezzel létrehozol egy exportálási lehetőséget, amely 30 percen belül indíthatsz meg. Ezt a lementett csomagot nem tudod visszatölteni a Kankára, a célja, hogy megőrizhesd az adataid, ha már nem tervezed tovább használni a Kankát a jövőben.',
        'question'  => 'Hogyan hozhatok létre biztonsági másolatot, vagy hogyan exportálhatom a kampányomat?',
    ],
    'bugs'                  => [
        'answer'    => 'Egyszerűen csatlakozz :discord szerverünkhöz, és jelentsd be a hibát a #error-and-bugs csatornában.',
        'question'  => 'Hogyan jelenthetek be egy hibát?',
    ],
    'campaign-sync'         => [
        'answer'    => 'A Kanka nem rendelkezik ezzel a funkcionalitással. Ha azonban több különböző csapattal is szeretnéd megosztani a világod, érdemes lehet a csapatokat küldetések, címkék, és felhasználói jogosultságok beállításával elszeparálni egymástól.',
        'question'  => 'Tudom-e szinkronizálni az entitásaim több különböző kampány között?',
    ],
    'conversations'         => [
        'answer'    => 'A Beszélgetések modulban párbeszéd bejegyzéseket jegyezhetsz fel Karakterek vagy a kampány Tagjai között. Amennyiben szeretnél egy fontos beszélgetést rögzíteni NJK-k, és JK-k között, akkor használd ezt a modult. Szükség esetén akár "Fórumos szerepjátékra" is használhatod a funkciót, ahol a mesélő és játékosok csak írásban játszanak.',
        'question'  => 'Mi a Beszélgetések?',
    ],
    'custom'                => [
        'answer'    => <<<'TEXT'
A Kanka számos előre definiált entitás típussal rendelkezik, amelyek kapcsolatban vannak egymással. Egyedi entitások engedélyezéséhez újra kellene írni az appot az alapjairól. Az egyedi entitások szervezésének bonyolítása pedig éppen ellentétes lenne azzal a céllal, hogy egy egyszerű megoldást nyújtsunk a világépítéshez.
Emellett a Kanka rendelkezik egy rugalmas Címke-rendszerrel is, amely képes lehet kielégíteni az egyedi entitástípus igényeket.
TEXT
,
        'question'  => 'Hozhatok létre egyedi entitás típusokat?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Navigálj a kampány főoldalára, majd kattints a "Kampány" gombra a baloldali menüsoron. Egy "Eltávolítás" gomb jelenik meg amennyiben te vagy az egyetlen tagja az adott kampánynak. A kampány törlése végleges, amely a kampány minden tárolt adatát is törli, beleértve a képeket is!',
        'question'  => 'Hogyan tudom törölni a kampányomat?',
    ],
    'early-access'          => [
        'answer'    => 'A korai hozzáférés egyfajta jutalom a fantasztikus előfizetőink számára, amellyel egy exkluzív, 30 napos periódust nyújtunk számukra, amely alatt kipróbálhatják a legújabb modulokat, még a nagyközönség előtt.',
        'question'  => 'Mi a korai hozzáférés?',
    ],
    'entity-notes'          => [
        'answer'    => 'Minden entitás rendelkezik egy \'Entitás jegyzet\' füllel, amelyek aprócska szöveges bejegyzések, amelyek egyenként beállíthatóak, hogy csak Te lásd őket, (praktikus, amikor több mesélős játékról van szó) vagy csak az Admin jogú felhasználók, eset bárki láthassa ezeket. Ezen felül beállítható, hogy a játékosok létrehozhassanak, és módosíthassanak ilyen Entitás jegyzeteket anélkül, hogy joguk lenne a teljes entitás szerkesztéséhez.',
        'question'  => 'Hogyan kezeli a Kanka a részlegesen rejtett információkat?',
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
    'gods-and-religions'    => [
        'answer'    => 'Ajánljuk, hogy hozd létre az isteneket mint karakterek, és alkosd meg az egyházakat mint szervezetek. Ha gyorsan meg szeretnéd találni az istenségeidet, ajánljuk, hogy használj címkét vagy típust.',
        'question'  => 'Hol lehet létrehozni az isteneket és az egyházakat?',
    ],
    'help'                  => [
        'answer'    => 'Először is, köszönjük, hogy segíteni szeretnél! Mindig szükségünk van emberekre, akik segítenek nekünk a fordításokkal, az új funkciók kipróbálásával vagy az új felhasználók útbaigazításával. Örülünk annak is, ha meséltek másoknak a Kankáról, elősegítve, hogy új felhasználókat érjünk el ott, ahol nem is gondoltuk volna. A legjobb első lépés az, hogy csatlakozol a közösésgünkhöz a Discordon, ahol egy csatorna kifejezetten a segítőknek van fenntartva. Ha szeretnéd, támogass minket a Patreonon is, hogy hozzáférhess annak bónuszaihoz is!',
        'question'  => 'Szeretnék segíteni! Mit tehetek?',
    ],
    'map'                   => [
        'answer'    => <<<'TEXT'
Minden helyszín tartalmazhat egy térképet (amely png, jpg vagy svg kiterjesztésű lehet) a térkép pedig rendelkezhet "Térkép pontokkal", amelyeknek a mérete, formája, ikonja, és színe állítható. A térkép pontok egy entitásra, vagy egy egyszerű címkére mutathatnak.

Kérlek vedd figyelembe, hogy a térképek a népszerű Azgaar vagy Mediveal Fantasy Town Generator készítőitől tömörítve vannak, így sajnos inkompatibilisek a Kankával. Megoldást jelenthet erre a problémára, ha Inkscape vagy Photoshopban megnyitod, és újra lemented az SVG fájlokat, mielőtt feltöltenéd őket a Kankára.
TEXT
,
        'question'  => 'Tölthetek fel térképeket a Kankára?',
    ],
    'mobile'                => [
        'answer'    => 'Jelenleg nincs dedikált mobilos applikáció a Kankára, de a honlap legtöbb funkciója mobil eszközön is működik. Az egyetlen limitáció az Említések funkció, amely nem működik a mobilos szövegszerkesztőben. Ha a Patreon-os támogatások megengedik majd, remélem meg tudok bízni egy szakembert az app elkészítésével, de nem hinném, hogy a közeli jövőben sor kerülne erre.',
        'question'  => 'Létezik mobil app a Kankához? Tervben van esetleg?',
    ],
    'monsters'              => [
        'answer'    => 'A Fajok modult javasoljuk a népcsoportok, fajok, szörnyek, és minden olyan lény számára, amelyek nem indokolják, hogy külön Karakterként legyenek létrehozva.',
        'question'  => 'Hol lenne érdemes szörnyeket létrehozni?',
    ],
    'multiworld'            => [
        'answer'    => 'Nem! Annyi “kampányt” hozhatsz létre az alkalmazásban amennyit szeretnél, mindegyik jelképezhet egy önálló világot, környezetet vagy amit szeretnél. A kampányaid között egyazon fiókon belül könnyűszerrel váltogathatsz.',
        'question'  => 'Több világot építek több különböző környezetben. Külön fiókra van szükségem mindegyikükhöz?',
    ],
    'nested'                => [
        'answer'    => 'Amennyiben kényelmesebb neked, hogy hierarchikusan jelenjenek meg az entitások (például a Hierarchikus nézet gomb a Helyszínek listás nézetén), ezt beállíthatod a Profilod \'Elrendezés\' menüpontjában a Alapértelmezetten hierarchikus nézet opciót kiválasztva. Érdemes megjegyezni, hogy ez a beállítás felhasználó-függő, nem pedig a kampány tulajdonsága.',
        'question'  => 'Beállíthatom, hogy alapértelmezetten Hierarchikus nézetben jelenjenek meg az entitások a lista felületeken?',
    ],
    'organise_play'         => [
        'answer'    => 'Összefogtunk az :lfgmmel, amely segít a játékülések szervezetésében a csapatoddal. Össze tudod szinkronizálni a Kanka kampányod az LFGM kampányoddal, hogy megjelenítsd a következő alkalmas időpontokat a kampányod főoldalán.',
        'question'  => 'Hol menedzselhetem, hogy mikor meséljek?',
    ],
    'permissions'           => [
        'answer'    => 'Teljességgel, ezért hoztuk létre a Kankát! Minden játékosodat meghívhatod a kampányaidba, és szerepeket és jogosultságokat adhatsz neki. Rendkívül rugalmasra építettük a rendszert (egyaránt használhatsz kizáró és megengedő jogosultságrendszereket), hogy lefedhessünk annyiféle helyzetet, amennyit csak lehet.',
        'question'  => 'A szerepjátékos világom építésére akarom használni a Kankát, de szeretném, hogy a játékosaim hozzáférhessenek néhány entitáshoz, és szerkeszthessék a karakterüket. Lehetséges ez?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
A hosszútávú terv, hogy egy létrejöjjön egy sokoldalú világépítő, és kampánymenedzsment eszköz, amely rendszerfüggetlen, olyan rendszerfüggő tartalmakkal, amelyet a közösség kezel a "Közösségi Sablonok" létrehozásával. Egy távoli cél, hogy olyan eszközök készüljenek el, amelyek beépülnek olyan platformokba, mint például a Virtuális Szerepjátékfelület appok (Virtual Table Top, VTT) hogy ezek a felületek összekapcsolódhassanak a Kanka világaival.

A második kérdésre reflektálva jellemző, hogy a legtöbb hobby projekt általában kiég, az alkotói magára hagyják őket. A Patreon pont azzal a céllal lett létrehozva, hogy csökkentse a céges munkaóráim számát, így több időt tudok szentelni a Kanka fejlesztésére anélkül, hogy kockára tenném a családom anyagi biztonságát, illetve, hogy fedezze a szerverek költségeit. A projekt emellett nyílt forráskódú, és a közösség tovább is fejlesztheti, ha történne velem valami. Emellett minden egyes kampány adata ki is exportálható naponta egyszer a kampány adminjai által, ha esetleg aggódnál ezek elvesztése miatt.
TEXT
,
        'question'  => 'Mik a hosszútávú tervek? Mi lesz, ha Ilestis ráun dolgozni a Kankán?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Böngészd a :public-campaigns oldalt ötletekért, hogy mások hogyan használják a Kankát a kampányukhoz.',
        'question'  => 'Hogyan használják a Kankát mások?',
    ],
    'sections'              => [
        'community'     => 'Közösség',
        'general'       => 'Általános',
        'other'         => 'Egyebek',
        'permissions'   => 'Jogosultságok',
        'pricing'       => 'Árak',
        'worldbuilding' => 'Világépítés',
    ],
    'show'                  => [
        'return'    => 'Vissza a GYIK-hez',
        'timestamp' => 'Utolsó frissítés: :date',
        'title'     => 'GYIK :name',
    ],
    'user-switch'           => [
        'answer'    => 'A jogosultságok trükkösek tudnak lenni, főleg a nagy kampányok esetén. Kampány adminként felkeresheted a kampány Tagjainak felületét, és rákattinthatsz a "Váltás" gombra, amelyek minden nem-admin szerepű felhasználó mellett megjelenik. Ekkor, annak a felhasználónak a nevében jelentkezel be, és úgy látod a kampányod részeit, ahogy az a felhasználó látná. Ez a legegyszerűbb módja a felhasználói jogosultságok ellenőrzésének.',
        'question'  => 'Beállítottam a kampányomra vonatkozó jogosultságokat. Hogyan tesztelhetném őket?',
    ],
    'visibility'            => [
        'answer'    => 'Csak az általad meghívott személyek láthatják az alkotásod és léphetnek vele bármilyen interakcióba. Az adataid privátok, és mindig te rendelkezel velük.',
        'question'  => 'Bárki láthatja a világomat?',
    ],
];
