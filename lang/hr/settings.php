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
        'exceptions'    => [
            'already_boosted'       => 'Kampanja :name je već pojačana.',
            'exhausted_boosts'      => 'Nemaš više pojačanja za pokloniti. Ukloni svoje pojačanje iz neke kampanje prije nego što ga daš drugoj.',
            'exhausted_superboosts' => 'Nemaš više pojačanja. Trebaš 3 pojačanja da bi super pojačao kampanju.',
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
    'invoices'      => [],
    'layout'        => [
        'title' => 'Izgled',
    ],
    'marketplace'   => [],
    'menu'          => [
        'account'               => 'Račun',
        'api'                   => 'API',
        'apps'                  => 'Aplikacije',
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
        'deprecated'    => 'Zastarjela značajka - ako želite podržati Kanku, učinite to putem :subscription. Patreon povezivanje je i dalje aktivno za one koji su povezali svoj račun prije našeg odlaska iz Patreona.',
        'pledge'        => 'Zalog: :name',
        'remove'        => [
            'button'    => 'Prekini vezu s Patreon računom',
            'success'   => 'Uklonjena je poveznica na tvoj Patreon račun.',
            'text'      => 'Ako prekineš vezu tvog računa s Patreonom, Kanka će ukloniti tvoje bonuse, ime u kući slavnih, pojačanja kampanje, te druge značajke povezane s podrškom Kanke. Nijedan tvoj pojačani sadržaj neće biti izgubljen (npr. zaglavlja entiteta). Ako se ponovo pretplatiš, imat ćeš pristup svim svojim prethodnim podacima, uključujući mogućnost pojačanja prijašnjih pojačanih kampanja.',
            'title'     => 'Prekini vezu Patreon računa s Kankom',
        ],
        'title'         => 'Patreon',
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
        'billing'               => [
            'helper'    => 'Podaci o naplati obrađuju se i pohranjuju na sigurno putem :stripe. Ovaj način plaćanja koristi se za sve tvoje pretplate.',
            'saved'     => 'Spremljen način plaćanja',
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
