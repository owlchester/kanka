<?php

return [
    'app_backup'            => [
        'answer'    => 'Izvodimo dvije sigurnosne kopije dnevno kako bismo spriječili gubitak podataka. Naše se vlastite kampanje nalaze na poslužitelju, tako da ne želimo riskirati!',
        'question'  => 'Koliko često se obavlja sigurnosno kopiranje podataka u Kanki?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Najbolji način na koji možemo objasniti Predloške atributa je primjerom. Zamislimo da tvoj svijet ima puno lokacija, a na mnogim od tih lokacija želiš se sjetiti stvoriti prilagođeni atribut za "Stanovništvo", "Klima" i "Razina kriminala".

Možeš to lako postići na svakoj lokaciji, ali može postati zamorno i ponekad možeš zaboraviti stvoriti atribut "Razina zločina". Ovdje Predlošci atributa ulaze u igru.

Možeš  stvoriti Predložak atributa s tim atributima (stanovništvo, klima, razina kriminala), a kasnije taj predložak primijeniti na svoje lokacije. Ovo će stvoriti atribute iz predloška na lokacijama, tako da sve što moraš učiniti je promijeniti vrijednosti, a ne moraš se prisjećati atributa!
TEXT
,
        'question'  => 'Predlošci atributa, što su oni?',
    ],
    'backup'                => [
        'answer'    => 'Jednom dnevno možeš sve podatke svoje kampanje izvesti kao ZIP datoteku. U aplikaciji klikni na "Kampanja" na lijevom izborniku i klikni na "Izvoz". Tako će se stvoriti datoteka koja je dostupna 30 minuta. Ne možeš prenijeti ovaj izvoz na Kanku, on je namijenjen samo vlastitom miru ili ako više ne planiraš koristiti aplikaciju.',
        'question'  => 'Kako mogu sigurnosno kopirati ili izvoziti kampanju?',
    ],
    'bugs'                  => [
        'answer'    => 'Jednostavno se pridruži našem :discord poslužitelju i prijavi svoju pogrešku u kanalu #error-and-bugs.',
        'question'  => 'Kako mogu prijaviti pogrešku?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka nema tu značajku. Međutim, ako pokušavaš imati više grupa za igru u istom svijetu, razmisli o upotrebi iste kampanje i razdvajanju grupa kombinacijom zadataka, oznaka i dopuštenja.',
        'question'  => 'Mogu li sinkronizirati entitete u više kampanja?',
    ],
    'conversations'         => [
        'answer'    => 'Razgovori se mogu postaviti kao razgovori između likova ili između članova kampanje. Ako na primjer želiš dokumentirati važan razgovor između likova igrača i likova s kojima upravlja voditelj kampanje, to možeš učiniti pomoću ovog modula. Možeš ih koristiti i za kampanje koje se igraju putem slanja poruka.',
        'question'  => 'Što su razgovori?',
    ],
    'custom'                => [
        'answer'    => 'Kanka dolazi s nizom unaprijed definiranih tipova entiteta koji međusobno djeluju. Dopuštanje proizvoljnih tipova entiteta zahtijeva rekonstrukciju aplikacije ispočetka i kosi se sa svrhom alata s unaprijed definiranim tipovima kako bi se ljudima pomoglo u izgradnji svijeta, a ne da se smišlja kako organizirati stvari. Nadalje, Kanka je fleksibilna s oznakama koje mogu predstavljati većinu proizvoljnih tipova entiteta.',
        'question'  => 'Mogu li stvoriti proizvoljne vrste entiteta?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Idi na naslovnu ploču kampanje i klikni na "Kampanja" na lijevom izborniku. Gumb "Izbriši" pojavit će se ako si posljednji član kampanje. Brisanje kampanje trajna je akcija kojom ćeš izbrisati sve podatke pohranjene na našim poslužiteljima, uključujući slike.',
        'question'  => 'Kako mogu izbrisati kampanju?',
    ],
    'early-access'          => [
        'answer'    => 'Rani pristup način je da nagradimo naše nevjerojatne pretplatnike dajući im ekskluzivno razdoblje od 30 dana gdje mogu isprobati najnovije module prije bilo koga drugog.',
        'question'  => 'Što je Rani pristup?',
    ],
    'entity-notes'          => [
        'answer'    => 'Svi entiteti imaju karticu "Bilješke entiteta" koja sadrži male isječke teksta koje možeš postaviti da su vidljivi samo tebi (odlično prilikom zajedničkog vođenja kampanje), samo članovima administratorske uloge ili vidljive svima. Također, možeš dati igračima dopuštenje za kreiranje i uređivanje bilješki o entitetima bez ovlaštenja za uređivanjem čitavog entiteta.',
        'question'  => 'Kako Kanka postupa s djelomično skrivenim informacijama?',
    ],
    'fields'                => [
        'answer'    => 'Odgovor',
        'category'  => 'Kategorija',
        'locale'    => 'Jezik',
        'order'     => 'Poredak',
        'question'  => 'Pitanje',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Da! Čvrsto vjerujemo da tvoja financijska situacija ne bi trebala utjecati na tvoje uživanje u RPG-ovima ili izgradnji svijeta te ćemo osnovnu aplikaciju uvijek držati besplatnom. Ako želiš preuzeti aktivniju ulogu na ovom putovanju, podrži nas i glasaj o funkcionalnostima koje su ti najvažnije, što možeš učiniti putem naše web stranice ili na :patreon.

Osim glasanja o pravcu kojim će Kanka napredovati, podržavanje nas omogućava tebi pristup :boosters, povećanju ograničenja za prijenos veličine datoteke, dodavanju tvog imena u kuću slavnih, ljepše zadate ikone i još mnogo toga!
TEXT
,
        'question'  => 'Hoće li aplikacija ostati besplatna?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Preporučujemo stvaranje bogova kao likova i religija kao organizacija. Ako želite brzo pronaći svoja božanstva, preporučujemo da ih označite odgovarajućom oznakom ili vrstom.',
        'question'  => 'Gdje stvoriti bogove i religije?',
    ],
    'help'                  => [
        'answer'    => 'Kao prvo, hvala ti što želiš pomoći! Uvijek smo zainteresirani za ljude koji mogu pomoći u prijevodima, testiranju novih značajki ili koji mogu pomoći novim korisnicima. Također volimo kad ljudi promoviraju Kanku da dosegne nove korisnike na mjestima o kojima nismo razmišljali. Tvoj je najbolji način djelovanja da nam se pridružiš na :discord koji sadrži kanal posvećen pomoći. Također volimo i naše pokrovitelje na :patreon ako nas želiš podržati i dobiti pristup nekim povlasticama!',
        'question'  => 'Želim pomoći! Što mogu učiniti?',
    ],
    'map'                   => [
        'answer'    => 'Svaka lokacija može sadržavati kartu (png, jpg ili svg) koja na sebi ima "točke karte" koje se mogu staviti uz kontrolu veličine, oblika, ikone i boje te kao veze do entiteta ili jednostavnih oznaka.',
        'question'  => 'Mogu li učitati karte na Kanku?',
    ],
    'mobile'                => [
        'answer'    => 'Trenutačno nema posvećene mobilne aplikacije za Kanku, ali većina aplikacije radi na mobilnom uređaju. Jedno ograničenje je alat spominjanja koji ne radi u uređivaču teksta. Nadamo se da nam podrška na :patreon omogućiti da nekome platimo izradu mobilne aplikaciju, ali ne predviđamo da će se to dogoditi u skoroj budućnosti.',
        'question'  => 'Postoji li mobilna aplikacija? Planira li se?',
    ],
    'monsters'              => [
        'answer'    => 'Preporučujemo korištenje modula Rase za ljude, vrste, čudovišta i sve živo što nije lik.',
        'question'  => 'Gdje stvoriti čudovišta?',
    ],
    'multiworld'            => [
        'answer'    => 'Možeš biti dio onoliko kampanja koliko želiš, uključujući i one koje si kreirao/la. Za promjenu ili stvaranje nove kampanje, idi na preglednu ploču kampanje i u gornjem desnom kutu klikni na trenutnu kampanju za prikaz sučelja prebacivanja kampanje.',
        'question'  => 'Mogu li imati više kampanja?',
    ],
    'nested'                => [
        'answer'    => 'Ako više voliš svoje entitete gledati u ugnježđenom prikazu prema zadanim postavkama (na primjeru gumb Uneseni prikaz na popisu lokacija), to možeš učiniti tako da otvoriš opcije profila i izgleda. Tamo možeš provjeriti mogućnost ugniježđenog pogleda. To se odnosi samo na tvoj račun, a ne i za tvoje kampanje.',
        'question'  => 'Mogu li postaviti ugniježđene popise kao zadane?',
    ],
    'organise_play'         => [
        'answer'    => 'U partnerstvu smo s :lfgm koji omogućuje organiziranje sesija sa svojom grupom. Možeš sinkronizirati Kanka kampanju sa svojom LGFM kampanjom da bi svoju sljedeću dostupnost pokazali izravno na naslovnoj ploči kampanje.',
        'question'  => 'Kako mogu upravljati kada vodim seanse?',
    ],
    'permissions'           => [
        'answer'    => 'Apsolutno, zato smo izgradili Kanku! Možete pozvati sve svoje igrače u svoje kampanje i dodijeliti im uloge i dopuštenja. Izgradili smo sustav da bude izuzetno fleksibilan (možete koristiti i konfiguraciju za prijavu i isključivanje) kako bismo pokrili što više potreba i situacija.',
        'question'  => 'Mogu li ograničiti podatke koje moji igrači vide u kampanji?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Dugoročni planovi za Kanku su izgraditi svestrani alat za upravljanje izgradnje svijeta i upravljanjem kampanjama, koji je agnostičan na sustav, ali uz sadržaj specifičan za sustav koji kreira zajednica u obliku "predložaka zajednice". Duži cilj je izgradnja alata koji se integrira s drugim platformama poput Virtual Table Top aplikacija koje će ih povezati sa svjetovima Kanka.

Što se tiče drugog dijela, većina hobi projekata završava izgaranjem, a autor ih napušta. :patreon je postavljen s ciljem da budemo u mogućnosti raditi puno radno vrijeme na Kanki bez žrtvovanja financijske sigurnosti naših obitelji, kao i pokrivanja troškova poslužitelja. Projekt je također otvorenog koda i zajednica ga može nastaviti ako se nama ikada nešto dogodi.
TEXT
,
        'question'  => 'Koji su dugoročni planovi?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Možeš pregledavati stranicu :public-campaigns da vidiš kako drugi koriste Kanku za svoje kampanje.',
        'question'  => 'Kako drugi koriste Kanka?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Iako bi to bilo lako učiniti za engleski i druge jezike koji ne koriste rodovna imena, mogućnost promjene naziva modula narušila bi gramatičku ispravnost i korisničko iskustvo za većinu jezika na kojima je Kanka dostupna.',
        'question'  => 'Mogu li preimenovati module? Na primjer Obitelji u Klanove ili Organizacije u Frakcije?',
    ],
    'sections'              => [
        'community'     => 'Zajednica',
        'general'       => 'Općenito',
        'other'         => 'Drugo',
        'permissions'   => 'Ovlasti',
        'pricing'       => 'Cijena',
        'worldbuilding' => 'Izgradnja svijeta',
    ],
    'show'                  => [
        'return'    => 'Povratak na često postavljanja pitanja',
        'timestamp' => 'Posljednji put ažurirano :date',
        'title'     => 'Često postavljana pitanja :name',
    ],
    'unboost'               => [
        'answer'    => 'Poništavanjem pojačavanja kampanje ne brišu se podaci koji su stvoreni tijekom pojačavanja, već se jednostavno sakrivaju podaci i značajke. Ako ponovno pojačate kampanju, podaci i značajke bit će ponovno dostupni s istim postavkama kao i prije opoziva kampanje.',
        'question'  => 'Što se događa ako se prestane pojačavati kampanju?',
    ],
    'user-switch'           => [
        'answer'    => 'Dopuštenja mogu postati škakljiva, osobito kod velikih kampanja. Kao administrator kampanje, možeš doći do stranice članova kampanje i kliknuti gumb "Imitiraj" koji će se pojaviti pored članova koji nisu administratori. Tako ćeš se prijaviti kao korisnik, što će ti omogućiti pregled kampanje kakvu taj korisnik vidi. To je najlakši način za provjeru dopuštenja tvoje kampanje.',
        'question'  => 'Ovlasti u mojoj kampanji su postavljene, kako ih mogu testirati?',
    ],
    'visibility'            => [
        'answer'    => 'Samo ljudi koje pozoveš u kampanju mogu vidjeti i koristiti što je stvoreno. Tvoji su podaci privatni i uvijek u tvojoj kontroli. Također, možeš postaviti kampanju kao javnu kako bi tvoju kampanju mogli vidjeti i neregistrirani korisnici.',
        'question'  => 'Može li itko vidjeti moj svijet?',
    ],
];
