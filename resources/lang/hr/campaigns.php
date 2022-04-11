<?php

return [
    'create'                            => [
        'description'           => 'Kreiraj novu kampanju',
        'helper'                => [
            'title'     => 'Dobro došli u :name!',
            'welcome'   => <<<'TEXT'
Prije nego što nastaviš dalje, moraš odabrati naziv kampanje. To je ime tvog svijeta. Ako još nemaš dobro ime, ne brini, uvijek ga možeš promijeniti kasnije ili stvoriti više kampanja.

Hvala što si se pridružio/la Kanki i dobrodošao/la u našu uspješnu zajednicu!
TEXT
,
        ],
        'success'               => 'Kampanja kreirana.',
        'success_first_time'    => 'Tvoja kampanja je kreirana! Budući da je tvoja prva kampanja, kreirali smo nekoliko stvari da ti pomognemo započeti i, po mogućnosti, pružimo malo inspiracije za što sve možeš napraviti.',
        'title'                 => 'Nova kampanja',
    ],
    'destroy'                           => [
        'action'    => 'Obriši kampanju',
        'helper'    => 'Kampanju možeš obrisati samo ako si njen jedini član.',
        'success'   => 'Kampanja uklonjena.',
    ],
    'edit'                              => [
        'success'   => 'Kampanja ažurirana.',
        'title'     => 'Uredi kampanju :campaign',
    ],
    'entity_note_visibility'            => [],
    'entity_personality_visibilities'   => [
        'private'   => 'Novi likovi imaju svoju osobnost postavljenu kao privatnu, osim ako to ne promijeniš.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Novi entiteti su privatni',
    ],
    'errors'                            => [
        'access'        => 'Nemaš pristup ovoj kampanji.',
        'superboosted'  => 'Ova je značajka dostupna samo za super pojačane kampanje.',
        'unknown_id'    => 'Nepoznata kampanja.',
    ],
    'export'                            => [
        'errors'            => [
            'limit' => 'Prekoračen vlastiti dozvoljeni broj izvoza po danu. Pokušaj ponovno sutra.',
        ],
        'helper'            => 'Izvezi svoju kampanju. Notifikacija s poveznicom za preuzimanje će biti stavljena na raspolaganje.',
        'helper_secondary'  => 'Bit će dostupne dvije datoteke, jedna tipa JSON s entitetima, a druga sa slikama iz entiteta. Napominjemo da se u većim kampanjama izvoz slika ruši i može se oporaviti samo koristeći :api.',
        'success'           => 'Izvoz tvoje kampanje je pripremljen. Dobit ćeš notifikaciju u Kanki do ZIP datoteke koju možeš preuzeti, čim bude spremna.',
        'title'             => 'Izvoz kampanje :name',
    ],
    'fields'                            => [
        'boosted'                   => 'Pojačali',
        'css'                       => 'CSS',
        'description'               => 'Opis',
        'entity_count'              => 'Broj entiteta',
        'entry'                     => 'Opis kampanje',
        'excerpt'                   => 'Isječak',
        'followers'                 => 'Pratitelji',
        'header_image'              => 'Slika zaglavlja',
        'image'                     => 'Slika',
        'locale'                    => 'Jezik',
        'name'                      => 'Naziv',
        'open'                      => 'Otvoreno za prijave',
        'public_campaign_filters'   => 'Filteri javnih kampanja',
        'related_visibility'        => 'Vidljivost povezanih elemenata',
        'rpg_system'                => 'Sustav igranja',
        'superboosted'              => 'Super pojačali',
        'system'                    => 'Sustav',
        'theme'                     => 'Tema',
        'visibility'                => 'Vidljivost',
    ],
    'following'                         => 'Praćenje',
    'helpers'                           => [
        'boost_required'            => 'Ova funkcionalnost zahtjeva pojačanu kampanju. Više informacija na stranici :settings.',
        'boosted'                   => 'Neke funkcionalnosti su otključane jer je ova kampanja pojačana. Pronađi više na stranicama :settings.',
        'css'                       => 'Napiši svoj CSS koji će biti učitan u stranice tvoje kampanje. Zlonamjerno korištenje ove funkiconalnosti će rezultirati uklanjanjem tvog CSS-a. Ponovni ili posebno teški prijestupi mogu dovesti do uklanjanja tvoje kampanje.',
        'dashboard'                 => 'Prilagodi način na koji se prikazuje programčić naslovne ploče kampanje popunjavanjem sljedećih polja.',
        'excerpt'                   => 'Isječak kampanje će biti prikazan na naslovnoj ploči pa napiši nekoliko rečenica kao uvod u svoj svijet. Za najbolje rezultate, neka bude kratko.',
        'header_image'              => 'Slika koja se prikazuje kao pozadina u programčiću naslovne ploče zaglavlja kampanje.',
        'hide_history'              => 'Omogući ovu opciju za skrivanje povijesti entiteta članovima kampanje koji nisu administratori.',
        'hide_members'              => 'Omogući ovu opciju za sakrivanje popisa članova kampanje za članove koji nisu administratori.',
        'locale'                    => 'Jezik u kojem je tvoja kampanja napisana. Ovo se koristi za generiranje sadržaja i grupiranje javnih kampanja.',
        'name'                      => 'Tvoj svijet ili kampanja može imati bilo koje ime dok god sadrži 4 slova ili broja.',
        'public_campaign_filters'   => 'Pomozi drugima da pronađu kampanju među ostalim javnim kampanjama pružanjem sljedećih informacija.',
        'public_no_visibility'      => 'Pažnja! Tvoja kampanja je javna, ali javna uloga kampanje ne može pristupiti ničemu. :fix.',
        'related_visibility'        => 'Zadana vrijednost vidljivosti prilikom stvaranja novog elementa s ovim poljem (bilješke entiteta, odnosi, sposobnosti itd.)',
        'system'                    => 'Ako je tvoja kampanja vidljiva javnosti, sustav je pokazan na stranici :link.',
        'systems'                   => 'Kako bi izbjegli zatrpavanje korisnika opcijama, neke funkcionalnosti Kanke su dostupne samo s određenim RPG sustavima (npr. D&D 5e blok sa statistikama za nemani). Dodavanje podržanih sustava na ovom mjestu će omogućiti te funkcionalnosti.',
        'theme'                     => 'Prisili korisnike da koriste ovu temu za kampanju, nadjačavajući njihov odabir.',
        'view_public'               => 'Da bi vidio/la svoju kampanju kao javni gledatelj, otvori :link u anonimnom prozoru.',
        'visibility'                => 'Proglašavanje kampanje javnom znači da će ju moći vidjeti svi koji imaju s odgovarajućom poveznicom.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nova kampanja',
            ],
        ],
        'title'     => 'Kampanja',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Pozovi',
            'copy'  => 'Kopiraj poveznicu u međuspremnik',
            'link'  => 'Nova poveznica',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Kreiraj pozivnicu',
                'send'      => 'Pošalji pozivnicu',
            ],
            'success'       => 'Pozivnica poslana.',
            'success_link'  => 'Poveznica kreirana: :link',
            'title'         => 'Pozovi nekoga u svoju kampanju',
        ],
        'destroy'               => [
            'success'   => 'Pozivnica uklonjena.',
        ],
        'email'                 => [
            'link_text' => 'Prodruži se kampanji :name.',
            'subject'   => ':name te pozvao da se priključiš kampanji ":campaign" na kanka.io! Iskoristi sljedeću poveznicu da bi prihvatio njihovu pozivnicu.',
            'title'     => 'Pozivnica od :name',
        ],
        'error'                 => [
            'already_member'    => 'Već si član te kampanje.',
            'inactive_token'    => 'Ovaj token je već iskorišten ili kampanja više ne postoji.',
            'invalid_token'     => 'Ovaj token više nije validan.',
            'login'             => 'Prijavi se ili registriraj da bi se priključio/la kampanji.',
        ],
        'fields'                => [
            'created'   => 'Poslano',
            'email'     => 'Email',
            'role'      => 'Uloga',
            'type'      => 'Tip',
        ],
        'helpers'               => [
            'email'     => 'Naše email poruke su često označene kao neželjena pošta i može im trebati i do nekoliko sati prije nego se pojave u tvojem poštanskom sandučiću.',
            'validity'  => 'Koliko korisnika može iskoristiti ovu poveznicu prije nego se deaktivira. Ostavi prazno za neograničeno',
        ],
        'placeholders'          => [
            'email' => 'Email adresa osobe koju želiš pozvati',
        ],
        'types'                 => [
            'email' => 'Email',
            'link'  => 'Pozivnica',
        ],
        'unlimited_validity'    => 'Neograničeno',
    ],
    'leave'                             => [
        'confirm'   => 'Da li sigurno da želiš napustiti kampanju :name? Nećeš još više moći pristupiti, osim ako te administrator kampanje ne pozove ponovno.',
        'error'     => 'Nemoguće napustiti kampanju.',
        'success'   => 'Napustio/la si kampanju.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Imitiraj',
            'switch-back'   => 'Povratak na mog korisnika',
        ],
        'create'                => [
            'title' => 'Dodaj člana u svoju kampanju',
        ],
        'edit'                  => [
            'title' => 'Uredi člana :name',
        ],
        'fields'                => [
            'joined'        => 'Pridružen/a',
            'last_login'    => 'Zadnja prijava',
            'name'          => 'Korisnik',
            'role'          => 'Uloga',
            'roles'         => 'Uloge',
        ],
        'help'                  => 'Kampanje mogu imati neograničeni broj članova u njima.',
        'helpers'               => [
            'admin' => 'Kao član uloge administratora kampanje, možeš pozivati nove korisnike, maknuti neaktivne, te promijeniti njihove ovlasti. Kako bi testirao dopuštenja člana, iskoristi "Imitiraj" gumb. Više o tome pročitaj na :link.',
            'switch'=> 'Imitiraj ovog korisnika',
        ],
        'impersonating'         => [
            'message'   => 'Gledaš kampanju kao drugi korisnik. Neke funkcionalnosti su onemogućene, ali ostatak se ponaša jednako onako kako bi ih taj korisnik vidio. Da se vratiš nazad na svog korisnika, iskoristi "Prekini imitaciju" gumb koji se nalazi tamo gdje se inače nalazi gumb za odjavu.',
            'title'     => 'Imitiranje :name',
        ],
        'invite'                => [
            'description'   => 'Možeš pozvati prijatelje da se priključe tvojoj kampanji tako što im daš pozivnicu za priključivanje. Kad prihate pozivnicu, bit će dodani kao članovi u zatraženoj ulozi. Također im možeš poslati zahtjev putem emaila dok god nije Hotmail adresa, jer oni uvijek odbijaju Kankine emailove.',
            'more'          => 'Možeš dodati više uloga na :link.',
            'roles_page'    => 'stranici uloga',
            'title'         => 'Pozvati',
        ],
        'manage_roles'          => 'Upravljanje korisničkim ulogama',
        'roles'                 => [
            'member'    => 'Član',
            'owner'     => 'Administrator',
            'player'    => 'Igrač',
            'public'    => 'Javnost',
            'viewer'    => 'Osmatrač',
        ],
        'switch_back_success'   => 'Vratio si se na svog korisnika.',
        'title'                 => 'Članovi kampanje :name',
        'updates'               => [
            'added'     => 'Uloga :role dodana korisniku :user.',
            'removed'   => 'Uloga :role uklonjena od korisnika :user.',
        ],
        'your_role'             => 'Tvoja uloga <i>:role</i>',
    ],
    'open_campaign'                     => [
        'helper'    => 'Javna kampanja postavljena kao otvorena omogućit će korisnicima slanje prijava da joj se pridruže. Popis prijava pronađi na stranici :link.',
        'link'      => 'prijave na kampanju',
        'title'     => 'Otvorena kampanja',
    ],
    'panels'                            => [
        'boosted'   => 'Pojačano',
        'dashboard' => 'Naslovna ploča',
        'permission'=> 'Ovlasti',
        'setup'     => 'Postavljanje',
        'sharing'   => 'Dijeljenje',
        'systems'   => 'Sustavi',
        'ui'        => 'Sučelje',
    ],
    'placeholders'                      => [
        'description'   => 'Kratki sažetak tvoje kampanje',
        'locale'        => 'Jezični kod',
        'name'          => 'Naziv tvoje kampanje',
        'system'        => 'D&D, Pathfinder, Fate, DSA',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Dodaj ulogu',
        ],
        'admin_role'    => 'uloga administratora',
        'create'        => [
            'success'   => 'Uloga kreirana.',
            'title'     => 'Kreiraj novu ulogu za: name',
        ],
        'destroy'       => [
            'success'   => 'Uloga uklonjena.',
        ],
        'edit'          => [
            'success'   => 'Uloga ažurirana.',
            'title'     => 'Uredi ulogu :name',
        ],
        'fields'        => [
            'name'          => 'Naziv',
            'permissions'   => 'Ovlasti',
            'type'          => 'Tip',
            'users'         => 'Korisnici',
        ],
        'helper'        => [
            '1' => 'Kampanja može imati koliko god uloga treba. Uloga "Administrator" automatski ima pristup svemu u kampanji, ali sve ostale uloge mogu imati određene ovlasti za različite entitete (likove, lokacije, itd).',
            '2' => 'Entitetima se mogu detaljnije podesiti ovlasti pregledom kartice "Ovlasti" na entitetu. Ova kartica se pojavljuje kad tvoja kampanja ima nekoliko uloga za članove.',
            '3' => 'Možeš ići sustavom "isključivanja", u kojem je ulogama dan pristup pregledu svih entiteta, i onda koristiti "Privatno" kućicu na entitetima da ih se sakrije. Ili možeš ne dati puno ovlasti ulogama pa postavljati vidljivost svakog entiteta zasebno.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'Javna uloga ima ovlasti, ali je kampanja privatna. Ovu postavku možeš promijeniti na kartici Dijeljenje prilikom uređivanja kampanje.',
            'public'                => 'Uloga "Javnost" se koristi kad netko pretražuje tvoju javnu kampanju. :more',
            'role_permissions'      => 'Omogući ulozi ":name" da radi sljedeće akcije nad svim entitetima.',
        ],
        'members'       => 'Članovi',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Kreiraj',
                'dashboard'     => 'Naslovna ploča',
                'delete'        => 'Obriši',
                'edit'          => 'Uredi',
                'entity-note'   => 'Bilješka entiteta',
                'manage'        => 'Upravljanje',
                'members'       => 'Članovi',
                'permission'    => 'Ovlasti',
                'read'          => 'Pregled',
                'toggle'        => 'Promijeni za sve',
            ],
            'helpers'   => [
                'entity_note'   => 'Ovo omogućava korisnicima koji nemaju dopuštenja uređivanja entiteta da dodaju Bilješke entiteta.',
            ],
            'hint'      => 'Ova uloga automatski ima pristup svemu.',
        ],
        'placeholders'  => [
            'name'  => 'Naziv uloge',
        ],
        'show'          => [
            'title' => 'Uloga kampanje ":role"',
        ],
        'title'         => 'Uloge kampanje :name',
        'types'         => [
            'owner'     => 'Administrator',
            'public'    => 'Javnost',
            'standard'  => 'Standardno',
        ],
        'users'         => [
            'actions'   => [
                'add'       => 'Dodaj člana',
                'remove'    => ':user iz uloge :role',
            ],
            'create'    => [
                'success'   => 'Korisnik dodan u ulogu.',
                'title'     => 'Dodaj člana u ulogu :name',
            ],
            'destroy'   => [
                'success'   => 'Korisnik uklonjen iz uloge.',
            ],
            'fields'    => [
                'name'  => 'Naziv',
            ],
        ],
    ],
    'settings'                          => [
        'actions'   => [
            'enable'    => 'Omogući',
        ],
        'boosted'   => 'Ova funkcionalnost je u testnoj verziji i trenutno je dostupna samo za :boosted.',
        'edit'      => [
            'success'   => 'Ažurirane postavke kampanje.',
        ],
        'helper'    => 'Svi moduli kampanje mogu se omogućiti ili onemogućiti po volji. Onemogućivanje modula će jednostavno sakriti elemente sučelja koji se na njega odnose, a postojeći entiteti bit će skriveni, ali i dalje postojati u pozadini, u slučaju da se predomislite. Te promjene utječu na sve korisnike kampanje, uključujući administratore.',
        'helpers'   => [
            'abilities'     => 'Stvori sposobnosti, bilo da su to podvizi, čarolije ili moći koje se mogu dodijeliti entitetima.',
            'calendars'     => 'Mjesto za definiranje kalendara tvog svijeta.',
            'characters'    => 'Ljudi koji nastanjuju tvoj svijet.',
            'conversations' => 'Izmišljeni razgovori između likova ili između korisnika kampanje. Ovaj modul je zastario.',
            'dice_rolls'    => 'Za one koji koriste Kanka za RPG kampanje, način za upravljanje bacanjem kockica. Ovaj modul je zastario.',
            'events'        => 'Praznici, festivali, katastrofe, rođendani, ratovi.',
            'families'      => 'Klanovi ili obitelji, njihovi odnosi i njihovi članovi.',
            'inventories'   => 'Upravljaj inventarom svojih entiteta.',
            'items'         => 'Oružje, vozila, relikvije, napitci.',
            'journals'      => 'Opažanja napisana od strane likova ili priprema za sesiju za voditelja igre.',
            'locations'     => 'Planeti, ravni postojanja, kontinenti, rijeke, države, naselja, hramovi, krčme.',
            'maps'          => 'Prenesi karte sa slojevima i markerima koji upućuju na druge entitete u kampanji.',
            'menu_links'    => 'Proizvoljne poveznice izbornika u bočnoj traci.',
            'notes'         => 'Legende, religije, povijest, magija, rase.',
            'organisations' => 'Kultovi, vojne jedinice, frakcije, cehovi.',
            'quests'        => 'Za praćenje raznih zadataka s likovima i lokacijama.',
            'races'         => 'Ako tvoja kampanja ima više od jedne rase, ovo će olakšati praćenje.',
            'tags'          => 'Svaki entitet može imati nekoliko oznaka. Oznake mogu pripadati drugim oznakama, a unosi se mogu filtrirati po oznakama.',
            'timelines'     => 'Prikaži povijest svog svijeta s kronologijama.',
        ],
        'title'     => 'Moduli kampanje :name',
    ],
    'show'                              => [
        'actions'   => [
            'boost' => 'Pojačaj kampanju',
            'edit'  => 'Uredi kampanju',
            'leave' => 'Napusti kampanju',
        ],
        'menus'     => [
            'configuration'     => 'Konfiguracija',
            'overview'          => 'Pregled',
            'user_management'   => 'Upravljanje korisnicima',
        ],
        'tabs'      => [
            'achievements'      => 'Postignuća',
            'applications'      => 'Prijave',
            'campaign'          => 'Kampanja',
            'default-images'    => 'Zadane slike',
            'export'            => 'Izvoz',
            'information'       => 'Informacije',
            'members'           => 'Članovi',
            'plugins'           => 'Dodaci',
            'recovery'          => 'Oporavak',
            'roles'             => 'Uloge',
            'settings'          => 'Moduli',
        ],
        'title'     => 'Kampanja :name',
    ],
    'superboosted'                      => [
        'gallery'   => [
            'error' => [
                'text'  => 'Učitavanje  slika u uređivač teksta je značajka dostupna samo :superboosted.',
                'title' => 'Učitavanje slike galerije kampanje',
            ],
        ],
    ],
    'ui'                                => [],
    'visibilities'                      => [
        'private'   => 'Privatna',
        'public'    => 'Javna',
        'review'    => 'Čeka na pregled',
    ],
];
