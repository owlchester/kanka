<?php

return [
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Najbolji način na koji možemo objasniti Predloške atributa je primjerom. Zamislimo da Vaš svijet ima puno lokacija, a na mnogim od tih lokacija želite se sjetiti stvoriti prilagođeni atribut za "Stanovništvo", "Klima", "Razina kriminala".

Mogli biste to lako postići na svakoj lokaciji, ali može postati zamorno i ponekad možete zaboraviti stvoriti atribut "Razina zločina". Ovdje Predloške atributa ulaze u igru.

Možete stvoriti Predložak atributa s tim atributima (stanovništvo, klima, razina kriminala), a kasnije taj predložak primijenite na svoje lokacije. Ovo će stvoriti atribute iz predloška na lokacijama, tako da sve što morate učiniti je promijeniti vrijednosti, a ne morate se prisjećati atributa!
TEXT
,
        'question'  => 'Predlošci atributa, što su oni?',
    ],
    'backup'                => [
        'answer'    => 'Jednom dnevno možete sve podatke svoje kampanje izvesti kao ZIP datoteku. U aplikaciji kliknite na "Kampanja" na lijevom izborniku i kliknite na "Izvezi". Tako će se stvoriti izvoz koji je dostupan 30 minuta. Ne možete prenijeti ovaj izvoz na Kanka, on je namijenjen samo vlastitom miru ili ako više ne planirate koristiti aplikaciju.',
        'question'  => 'Kako mogu sigurnosno kopirati ili izvoziti kampanju?',
    ],
    'bugs'                  => [
        'answer'    => 'Jednostavno se pridružite našem :discord poslužitelju i prijavite svoju pogrešku u kanalu #error-and-bugs.',
        'question'  => 'Kako mogu prijaviti pogrešku?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka nema tu značajku. Međutim, ako pokušavate imati više grupa za igru u istom svijetu, razmislite o upotrebi iste kampanje i razdvajanju grupa kombinacijom zadataka, oznaka i dozvola.',
        'question'  => 'Mogu li sinkronizirati entitete u više kampanja?',
    ],
    'conversations'         => [
        'answer'    => 'Razgovori se mogu postaviti kao razgovori između likova ili između članova kampanje. Ako na primjer želite dokumentirati važan razgovor između NPC-a i likova igrača, to možete učiniti pomoću ovog modula. Možete ih koristiti i za kampanje koje se igraju preko slanja poruka.',
        'question'  => 'Što su razgovori?',
    ],
    'custom'                => [
        'answer'    => 'Kanka dolazi s nizom unaprijed definiranih tipova entiteta koji međusobno djeluju. Dopuštanje prilagođenih tipova entiteta zahtijeva rekonstrukciju aplikacije ispočetka i kosi se sa svrhom alata s unaprijed definiranim tipovima kako bi se ljudima pomoglo u izgradnji svijeta, a ne da se smišlja kako organizirati stvari. Nadalje, Kanka je fleksibilna s oznakama koje mogu predstavljati većinu prilagođenih tipova entiteta.',
        'question'  => 'Mogu li stvoriti prilagođene vrste entiteta?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Idite na preglednu ploču kampanje i kliknite na "Kampanja" na lijevom izborniku. Gumb "Izbriši" pojavit će se ako ste posljednji član kampanje. Brisanje kampanje trajna je akcija kojom ćete izbrisati sve podatke pohranjene na našim poslužiteljima, uključujući slike.',
        'question'  => 'Kako mogu izbrisati kampanju?',
    ],
    'entity-notes'          => [
        'answer'    => 'Svi entiteti imaju karticu "Bilješke entiteta" koje sadrže male isječke teksta koje možete postaviti da su vidljivi samo vama (odlično prilikom zajedničkog vođenja kampanje), samo članovima administratorske uloge ili vidljive svima. Također, možete dati igračima dozvolu za kreiranje i uređivanje bilješki o entitetima bez ovlaštenja za uređivanjem čitavog entiteta.',
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
Da! Čvrsto vjerujemo da Vaša financijska situacija ne bi trebala utjecati na Vaše uživanje u RPG-ovima ili izgradnji svijeta te ćemo osnovnu aplikaciju uvijek držati besplatnom. Ako želite preuzeti aktivniju ulogu na ovom putovanju, podržite nas i glasajte o funkcionalnostima koje su Vama najvažnije, što možete učiniti putem naše web stranice ili na :patreon.

Uz glasanje o pravcu kojim će Kanka napredovati, podržavanje nas omogućava Vam pristup :boosters, povećanju ograničenja za prijenos veličine datoteke, dodavanje Vašeg imena u kuću slavnih, ljepše zadate ikone i još mnogo toga!
TEXT
,
        'question'  => 'Hoće li aplikacija ostati besplatna?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Preporučujemo stvaranje bogova kao likova i religija kao organizacija. Ako želite brzo pronaći svoja božanstva, preporučujemo da ih označite odgovarajućom oznakom ili vrstom.',
        'question'  => 'Gdje stvoriti bogove i religije?',
    ],
    'help'                  => [
        'answer'    => 'Kao prvo, hvala Vam što želite pomoći! Uvijek smo zainteresirani za ljude koji mogu pomoći u prijevodima, testiranju novih značajki ili koji mogu pomoći novim korisnicima. Također volimo kad ljudi promoviraju Kanku da dosegne nove korisnike na mjestima o kojima nismo razmišljali. Vaš je najbolji način djelovanja da nam se pridružite na :discord koji sadrži kanal posvećen pomoći. Također volimo i naše pokrovitelje na :patreon ako nas želite podržati i dobiti pristup nekim povlasticama!',
        'question'  => 'Želim pomoći! Što mogu učiniti?',
    ],
    'map'                   => [
        'answer'    => 'Svaka lokacija može sadržavati kartu (png, jpg ili svg) koja na sebi ima "točke mape" koje se mogu staviti uz kontrolu veličine, oblika, ikone i boje te kao veze do entiteta ili jednostavnih oznaka.',
        'question'  => 'Mogu li učitati karte na Kanku?',
    ],
    'mobile'                => [
        'answer'    => 'Trenutačno nema posvećene mobilne aplikacije za Kanku, ali većina aplikacije radi na mobilnom uređaju. Jedno ograničenje je alat spominjanja koji ne radi u uređivaču teksta. Nadamo se da nam podrška na :patreon omogućiti da nekome platimo izradu mobilne aplikaciju, ali ne predviđamo da će se to dogoditi u skoroj budućnosti.',
        'question'  => 'Postoji li mobilna aplikacija? Planira li se?',
    ],
    'multiworld'            => [
        'answer'    => 'Možete biti dio onoliko kampanja koliko želite, uključujući i one koje ste kreirali. Da biste promijenili ili stvorili novu kampanju, idite na preglednu ploču kampanje i u gornjem desnom kutu možete kliknuti na trenutnu kampanju da biste prikazali sučelje prebacivanja kampanje.',
        'question'  => 'Mogu li imati više kampanja?',
    ],
    'permissions'           => [
        'answer'    => 'Apsolutno, zato smo izgradili Kanku! Možete pozvati sve svoje igrače u svoje kampanje i dodijeliti im uloge i dozvole. Izgradili smo sustav da bude izuzetno fleksibilan (možete koristiti i konfiguraciju za prijavu i isključivanje) kako bismo pokrili što više potreba i situacija.',
        'question'  => 'Mogu li ograničiti podatke koje moji igrači vide u kampanji?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Dugoročni planovi za Kanku su izgraditi svestrani alat za upravljanje izgradnje svijeta i upravljanjem kampanjama, koji je agnostičan na sustav, ali uz sadržaj specifičan za sustav koji kreira zajednica u obliku "predložaka zajednice". Duži cilj je izgradnja alata koji se integrira s drugim platformama poput Virtual Table Top aplikacija koje će ih povezati sa svjetovima Kanka.

Što se tiče drugog dijela, većina hobi projekata završava izgaranjem, a autor ih napušta. :patreon je postavljen s ciljem da budemo u mogućnosti raditi puno radno vrijeme na Kanki bez žrtvovanja financijske sigurnosti naših obitelji, kao i pokrivanja troškova poslužitelja. Projekt je također otvorenog koda i zajednica ga može pokupiti ako nam se ikada nešto dogodi.
TEXT
,
        'question'  => 'Koji su dugoročni planovi?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Možete pregledavati stranicu :public-campaigns da biste vidjeli kako drugi koriste Kanka za svoje kampanje.',
        'question'  => 'Kako drugi koriste Kanka?',
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
    'user-switch'           => [
        'answer'    => 'Dozvole mogu postati škakljive, osobito kod velikih kampanja. Kao administrator kampanje, možete doći do stranice članova kampanje i kliknuti gumb "Prebaci se" koji će se pojaviti pored članova koji nisu administratori. Tako ćete se prijaviti kao korisnik i omogućiti vam da vidite kampanju kakvu bi oni vidjeli. To je najlakši način za provjeru dozvola vaše kampanje.',
        'question'  => 'Ovlasti u mojoj kampanji su postavljene, kako ih mogu testirati?',
    ],
    'visibility'            => [
        'answer'    => 'Samo ljudi koje pozovete u kampanju mogu vidjeti i koristiti što ste stvorili. Vaši su podaci privatni i uvijek u Vašoj kontroli. Također možete postaviti javnu kampanju kako biste omogućili pregled neregistriranim korisnicima.',
        'question'  => 'Može li itko vidjeti moj svijet?',
    ],
];
