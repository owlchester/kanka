<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Prebaci se na prijavu u Kanku',
            'update_email'      => 'Ažuriraj email',
            'update_password'   => 'Ažuriraj lozinku',
        ],
        'email'             => 'Promjena emaila',
        'email_success'     => 'Email ažuriran.',
        'password'          => 'Promjena lozinke',
        'password_success'  => 'Lozinka promijenjena.',
        'social'            => [
            'error'     => 'Već koristiš prijavu u Kanku za ovaj račun.',
            'helper'    => 'Tvojim računom trenutno upravlja :provider. Možeš ga prestati koristiti i prebaciti se na standardnu ​​prijavu u Kanku postavljanjem lozinke.',
            'success'   => 'Tvoj račun sad koristi Kanka prijavu.',
            'title'     => 'Društveno prema Kanki',
        ],
        'title'             => 'Račun',
    ],
    'api'           => [
        'helper'    => 'Dobrodošli u Kanka API-je! Generiraj osobni pristupni žeton koji ćeš koristiti u svom API zahtjevu za prikupljanje podataka o kampanjama čijih si član.',
        'link'      => 'Pročitaj dokumentaciju API-ja',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Poveži',
            'remove'    => 'Ukloni',
        ],
        'benefits'  => 'Kanka pruža nekoliko integracija na usluge trećih strana. U budućnosti se planira više integracija trećih strana.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Došlo je do pogreške u povezivanju tvog Discord računa s Kankom. Molim te pokušaj ponovno.',
            ],
            'success'   => [
                'add'       => 'Tvoj Discord račun je povezan.',
                'remove'    => 'Veza s tvojim Discord računom je uklonjena.',
            ],
            'text'      => 'Pristupi svojim ulogama za pretplatu automatski.',
        ],
        'title'     => 'Integracija s aplikacijom',
    ],
    'boost'         => [
        'benefits'      => [
            'campaign_gallery'  => 'Galerija slika u koju možeš učitati slike za ponovo korištenje kroz kampanju.',
            'entity_files'      => 'Učitaj do 10 slika po entitetu.',
            'entity_logs'       => 'Cjeloviti zapisnici entiteta onoga što je promijenjeno na entitetu sa svakim ažuriranjem.',
            'first'             => 'Kako bi osigurali kontinuirani napredak na Kanki, pojedine značajke kampanje otključavaju se pojačavanjem kampanje. Pojačanja se otključavaju putem pretplate. Svatko tko može pogledati kampanju može ju pojačati tako da ne mora uvijek ista osoba plaćati račun. Kampanja ostaje pojačana sve dok korisnik pojačava kampanju i oni nastave podržavati Kanku. Ako se kampanja više ne pojačava, podaci se ne gube već su samo skriveni dok se kampanja ponovno ne pojača.',
            'header'            => 'Slike zaglavlja entiteta.',
            'headers'           => [
                'boosted'       => 'Prednosti pojačane kampanje',
                'superboosted'  => 'Prednosti super pojačane kampanje',
            ],
            'helpers'           => [
                'boosted'       => 'Pojačanje kampanje dodjeljuje jedno pojačanje kampanji.',
                'superboosted'  => 'Super pojačanje kampanje dodjeljuje tri pojačanja kampanji.',
            ],
            'images'            => 'Proizvoljne zadane slike entiteta.',
            'more'              => [
                'boosted'       => 'Sve funkcionalnosti pojačane kampanje',
                'superboosted'  => 'Sve funkcionalnosti super pojačane kampanje',
            ],
            'recovery'          => 'Povrati obrisane entitete do :amount dana.',
            'superboost'        => 'Super pojačanje kampanja koristi tvoja 3 pojačanja i otključava dodatne značajke povrh onih za pojačane kampanje.',
            'theme'             => 'Tema na razini kampanje i proizvoljno stiliziranje.',
            'third'             => 'Da biste pojačali kampanju, idite na stranicu kampanje i kliknite gumb ":boost_button" iznad gumba ":edit_button".',
            'tooltip'           => 'Proizvoljni kratki opisi entiteta.',
            'upload'            => 'Povećana veličina prijenosa za svakog člana u kampanji.',
        ],
        'buttons'       => [
            'boost'         => 'Pojačaj',
            'superboost'    => 'Super pojačanje',
            'tooltips'      => [
                'boost'         => 'Pojačanje kampanje troši {1} tvoje :amount pojačanje.|{2,4} tvoja :amount pojačanja.|{5,*} tvojih :amount pojačanja.',
                'superboost'    => 'Super pojačanje kampanje troši {1} tvoje :amount pojačanje.|{2,4} tvoja :amount pojačanja.|{5,*} tvojih :amount pojačanja.',
            ],
        ],
        'campaigns'     => 'Pojačane kampanje :count / :max',
        'exceptions'    => [
            'already_boosted'       => 'Kampanja :name je već pojačana.',
            'exhausted_boosts'      => 'Nemaš više pojačanja za pokloniti. Ukloni svoje pojačanje iz neke kampanje prije nego što ga daš drugoj.',
            'exhausted_superboosts' => 'Nemaš više pojačanja. Trebaš 3 pojačanja da bi super pojačao kampanju.',
        ],
        'success'       => [
            'boost'         => 'Kampanja :name pojačana.',
            'delete'        => 'Tvoje pojačanje je uklonjeno s :name.',
            'superboost'    => 'Super pojačana kampanja :name',
        ],
        'title'         => 'Pojačanje',
        'unboost'       => [
            'description'   => 'Sigurno želiš prestati pojačavati kampanju :tag?',
            'title'         => 'Poništavanje pojačavanja kampanje',
        ],
    ],
    'countries'     => [
        'austria'       => 'Austrija',
        'belgium'       => 'Belgija',
        'france'        => 'Francuska',
        'germany'       => 'Njemačka',
        'italy'         => 'Italija',
        'netherlands'   => 'Nizozemska',
        'spain'         => 'Španjolska',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Preuzmi PDF',
            'view_all'  => 'Pogledaj sve',
        ],
        'empty'     => 'Nema fakture',
        'fields'    => [
            'amount'    => 'Količina',
            'date'      => 'Datum',
            'invoice'   => 'Faktura',
            'status'    => 'Status',
        ],
        'header'    => 'Ispod je popis zadnje 24 fakture koje možete preuzeti.',
        'status'    => [
            'paid'      => 'Plaćeno',
            'pending'   => 'U tijeku',
        ],
        'title'     => 'Fakture',
    ],
    'layout'        => [
        'success'   => 'Ažurirane opcije rasporeda.',
        'title'     => 'Izgled',
    ],
    'marketplace'   => [
        'fields'    => [
            'name'  => 'Naziv Tržnice',
        ],
        'helper'    => 'Prema zadanim postavkama tvoje korisničko se prikazuje na :marketplace. Možeš to promijeniti ovim poljem.',
        'title'     => 'Postavke Tržnice',
        'update'    => 'Postavke Tržnice spremljene.',
    ],
    'menu'          => [
        'account'               => 'Račun',
        'api'                   => 'API',
        'apps'                  => 'Aplikacije',
        'billing'               => 'Način plaćanja',
        'boost'                 => 'Pojačanje',
        'invoices'              => 'Fakture',
        'layout'                => 'Raspored',
        'marketplace'           => 'Tržnica',
        'other'                 => 'Ostalo',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Mogućnosti plaćanja',
        'personal_settings'     => 'Osobne postavke',
        'profile'               => 'Profil',
        'settings'              => 'Postavke',
        'subscription'          => 'Pretplata',
        'subscription_status'   => 'Status pretplate',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Poveži račun',
            'view'  => 'Posjeti Kanku na Patreonu',
        ],
        'benefits'          => 'Podržavajući nas na :patreon otključavaš svakakve :features za tebe i tvoje kampanje, a pomažeš nam i da provedemo više vremena radeći na poboljšanju Kanke.',
        'benefits_features' => 'nevjerojatne funkcionalnosti',
        'deprecated'        => 'Zastarjela značajka - ako želite podržati Kanku, učinite to putem :subscription. Patreon povezivanje je i dalje aktivno za one koji su povezali svoj račun prije našeg odlaska iz Patreona.',
        'description'       => 'Sinkroniziranje s Patreonom',
        'linked'            => 'Hvala ti što podržavaš Kanku na Patreonu! Tvoj račun je povezan.',
        'pledge'            => 'Zalog: :name',
        'remove'            => [
            'button'    => 'Prekini vezu s Patreon računom',
            'success'   => 'Uklonjena je poveznica na tvoj Patreon račun.',
            'text'      => 'Ako prekineš vezu tvog računa s Patreonom, Kanka će ukloniti tvoje bonuse, ime u kući slavnih, pojačanja kampanje, te druge značajke povezane s podrškom Kanke. Nijedan tvoj pojačani sadržaj neće biti izgubljen (npr. zaglavlja entiteta). Ako se ponovo pretplatiš, imat ćeš pristup svim svojim prethodnim podacima, uključujući mogućnost pojačanja prijašnjih pojačanih kampanja.',
            'title'     => 'Prekini vezu Patreon računa s Kankom',
        ],
        'success'           => 'Hvala što podržavaš Kanku u Patreonu!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Razinu tvog zaloga smo postavili ručno pa nam dopusti do nekoliko dana da je pravilno postavimo. Ako neko vrijeme ostane krivo, obrati nam se.',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Ažuriraj profil',
        ],
        'avatar'    => 'Profilna slika',
        'success'   => 'Profil ažuriran.',
        'title'     => 'Osobni profil',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Otkaži pretplatu',
            'subscribe'         => 'Pretplata',
            'update_currency'   => 'Spremite preferiranu valutu',
        ],
        'benefits'              => 'Podržavajući nas možete otključati neke nove :features i pomoći nam da uložimo više vremena u poboljšanje Kanke. Podaci kreditne kartice se ne pohranjuju ili ne prolaze kroz naše poslužitelje. Koristimo :stripe za obradu svih računa.',
        'billing'               => [
            'helper'    => 'Podaci o naplati obrađuju se i pohranjuju na sigurno putem :stripe. Ovaj način plaćanja koristi se za sve tvoje pretplate.',
            'saved'     => 'Spremljen način plaćanja',
            'title'     => 'Uredi način plaćanja',
        ],
        'cancel'                => [
            'text'  => 'Žao nam je što odlaziš! Ako otkažeš pretplatu, bit će aktivna do sljedećeg ciklusa naplate, nakon čega ćeš izgubiti pojačanja kampanje i druge pogodnosti povezane s podrškom Kanke. Slobodno ispuni sljedeći obrazac i obavijesti nas što možemo učiniti boljim ili što je dovelo do tvoje odluke.',
        ],
        'cancelled'             => 'Tvoja pretplata je otkazana. Pretplatu možete obnoviti nakon završetka tvoje trenutne pretplate.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Pretplaćuješ se na sloj :tier koji se naplaćuje mjesečno :amount.',
                'yearly'    => 'Pretplaćuješ se na sloj :tier koji se naplaćuje godišnje :amount.',
            ],
            'title' => 'Promijenite razinu pretplate',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Promijenite željenu valutu naplate',
        ],
        'errors'                => [
            'callback'      => 'Naš pružatelj plaćanja prijavio je pogrešku. Molimo pokušaj ponovo ili nam se obrati ako se problem nastavi.',
            'subscribed'    => 'Tvoju pretplatu nije moguće obraditi. Stripe je pružio sljedeći savjet.',
        ],
        'fields'                => [
            'active_since'      => 'Aktivno od',
            'active_until'      => 'Aktivno do',
            'billing'           => 'Naplata',
            'currency'          => 'Valuta naplate',
            'payment_method'    => 'Način plaćanja',
            'plan'              => 'Trenutni plan',
            'reason'            => 'Razlog',
        ],
        'helpers'               => [
            'alternatives'          => 'Plati svoju pretplatu pomoću :method. Na kraju pretplate ovaj se način plaćanja neće automatski obnoviti. :metoda je dostupna samo u eurima.',
            'alternatives_warning'  => 'Nadogradnja pretplate prilikom korištenja ove metode nije moguća. Stvori novu pretplatu kada se završi trenutna.',
            'alternatives_yearly'   => 'Zbog ograničenja koja se odnose na ponavljajuća plaćanja, metoda :method je dostupna samo za godišnje pretplate',
        ],
        'manage_subscription'   => 'Upravljanje pretplatom',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Dodajte novi način plaćanja',
                'change'            => 'Promjena načina plaćanja',
                'save'              => 'Spremi način plaćanja',
                'show_alternatives' => 'Alternativni načini plaćanja',
            ],
            'add_one'       => 'Trenutno nema spremljenog načina plaćanja.',
            'alternatives'  => 'Možeš se pretplatiti pomoću ovih alternativnih načina plaćanja. Ova radnja će teretiti tvoj račun jednom i neće automatski obnavljati pretplatu svaki mjesec.',
            'card'          => 'Kartica',
            'card_name'     => 'Ime na kartici',
            'country'       => 'Zemlja prebivališta',
            'ending'        => 'Završava za',
            'helper'        => 'Ova će se kartica koristiti za sve tvoje pretplate.',
            'new_card'      => 'Dodaj novi način plaćanja',
            'saved'         => ':brand završava s :last4',
        ],
        'placeholders'          => [
            'reason'    => 'Po želji nam možeš reći zašto više ne podržavaš Kanku. Nedostajala je funkcionalnost? Je li se promijenila tvoja financijska situacija?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount naplaćeno mjesečno',
            'cost_yearly'   => ':currency :amount naplaćeno godišnje',
        ],
        'sub_status'            => 'Informacije o pretplati',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Molimo kontaktiraj nas radi smanjenja za nižu razinu',
                'rollback'          => 'Promjena u Kobold',
                'subscribe'         => 'Promjena u :tier mjesečno',
                'subscribe_annual'  => 'Promjeni na :tier godišnje',
            ],
        ],
        'success'               => [
            'alternative'   => 'Tvoja uplata je registrirana. Primit ćeš obavijest čim se obradi i tvoja pretplata postane aktivna.',
            'callback'      => 'Tvoja pretplata je uspješna. Tvoj račun će biti ažuriran čim nas naš pružatelj plaćanja informira o promjeni (ovo može potrajati nekoliko minuta).',
            'cancel'        => 'Tvoja pretplata je otkazana. I dalje će biti aktivna do kraja tvog trenutnog razdoblja naplate.',
            'currency'      => 'Tvoja željena postavka valute je ažurirana.',
            'subscribed'    => 'Tvoja pretplata je bila uspješna. Ne zaboravi se pretplatiti na bilten glasanja zajednice kako bi te obavijestili kada započne novo glasanje. Postavke biltena možeš promijeniti na stranici profila.',
        ],
        'tiers'                 => 'Razina pretplate',
        'trial_period'          => 'Godišnje pretplate imaju pravo otkaza 14 dana. Kontaktiraj nas na :email ako želiš otkazati godišnju pretplatu i dobiti povrat novca.',
        'upgrade_downgrade'     => [
            'button'    => 'Informacije o promjeni razine',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Tvoji bonusi ostaju omogućeni do kraja razdoblja plaćanja.',
                    'boosts'    => 'Isto se događa i s tvojim pojačanim kampanjama. Pojačane funkcionalnosti postaju nevidljive, ali se ne brišu kad se kampanja više ne pojačava.',
                    'kobold'    => 'Za otkazivanje svoje pretplate, prijeđi na razinu Kobold.',
                ],
                'title'     => 'Prilikom otkazivanja pretplate',
            ],
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'Tvoja trenutna razina ostat će aktivna do kraja tvog trenutnog ciklusa naplate, nakon čega ćeš biti nadograđen na svoju novu razinu.',
                ],
                'title'     => 'Pri prelasku na niži nivo',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Tvoj način plaćanja bit će naplaćen odmah i imat ćeš pristup svom novom sloju.',
                    'prorate'   => 'Kada nadogradiš s Owlbear na Elemental, samo će ti se naplatiti ​​razlika do tvoje nove razine.',
                ],
                'title'     => 'Pri nadogradnji na viši sloj',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Nismo mogli naplatiti tvoju kreditnu karticu. Ažuriraj podatke o svojoj kreditnoj kartici, a mi ćemo je pokušati ponovo naplatiti u narednih nekoliko dana. Ako opet ne uspije, pretplata će se otkazati.',
            'patreon'       => 'Tvoj račun je trenutno povezan s Patreonom. Prekini vezu s računom u tvojim postavkama :patreon prije prelaska na Kanka pretplatu.',
        ],
    ],
];
