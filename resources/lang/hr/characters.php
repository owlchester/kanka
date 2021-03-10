<?php

return [
    'actions'       => [
        'add_appearance'    => 'Dodaj fizički izgled',
        'add_organisation'  => 'Dodaj organizaciju',
        'add_personality'   => 'Dodaj osobnost',
    ],
    'conversations' => [
        'description'   => 'Razgovori u kojima lik sudjeluje.',
        'title'         => 'Razgovori s likom :name',
    ],
    'create'        => [
        'description'   => 'Kreiraj novog lika',
        'success'       => 'Kreiran lik ":name"',
        'title'         => 'Novi lik',
    ],
    'destroy'       => [
        'success'   => 'Uklonjen lik ":name"',
    ],
    'dice_rolls'    => [
        'description'   => 'Rezultati bacanja kockica dodijeljeni liku',
        'hint'          => 'Rezultati bacanja kockica se mogu dodijeliti liku za korištenje unutar igre.',
        'title'         => 'Rezultati bacanja kockica lika :name',
    ],
    'edit'          => [
        'description'   => 'Uredi lika',
        'success'       => 'Ažuriran lik ":name".',
        'title'         => 'Uredi lika :name',
    ],
    'fields'        => [
        'age'                       => 'Starosna dob',
        'family'                    => 'Familija',
        'image'                     => 'Slika',
        'is_dead'                   => 'Mrtav/a/o',
        'is_personality_visible'    => 'Osobnost vidljiva',
        'life'                      => 'Život',
        'location'                  => 'Lokacija',
        'name'                      => 'Ime',
        'physical'                  => 'Fizičke osobine',
        'race'                      => 'Rasa',
        'relation'                  => 'Odnos',
        'sex'                       => 'Spol',
        'title'                     => 'Titula',
        'traits'                    => 'Osobine',
        'type'                      => 'Tip',
    ],
    'helpers'       => [
        'age'   => 'Možeš povezati ovaj entitet s kalendarom kampanje kako bi umjesto toga automatski izračunali njihovu dob. :more.',
    ],
    'hints'         => [
        'is_dead'                   => 'Ovaj lik je mrtav',
        'is_personality_visible'    => 'Možeš sakriti cijelu sekciju osobnosti od korisnika koji nisu "Administratori".',
        'personality_not_visible'   => 'Osobine ličnosti ovog lika su trenutno vidljive samo administratorima.',
        'personality_visible'       => 'Osobine ličnosti ovog lika su vidljive svima.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Novi nasumički lik',
        ],
        'add'           => 'Novi lik',
        'description'   => 'Upravljanje likovima u :name',
        'header'        => 'Likovi u :name',
        'title'         => 'Likovi',
    ],
    'items'         => [
        'description'   => 'Predmeti koji lik nosi ili posjeduje.',
        'hint'          => 'Predmeti se mogu dodijeliti na likove i bit će prikazani ovdje.',
        'title'         => 'Predmeti lika :name',
    ],
    'journals'      => [
        'description'   => 'Dnevnici čiji je lik autor.',
        'title'         => 'Dnevnici lika :name',
    ],
    'maps'          => [
        'description'   => 'Mapa odnosa lika.',
        'title'         => 'Mapa odnosa za lika :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Dodaj organizaciju',
        ],
        'create'        => [
            'description'   => 'Poveži organizaciju s likom',
            'success'       => 'Lik je dodan u organizaciju.',
            'title'         => 'Nova organizacija za :name',
        ],
        'description'   => 'Organizacije kojih je lik član.',
        'destroy'       => [
            'success'   => 'Organizacija lika uklonjena.',
        ],
        'edit'          => [
            'description'   => 'Ažuriraj organizaciju lika',
            'success'       => 'Organizacija lika ažurirana.',
            'title'         => 'Ažuriraj organizaciju za :name',
        ],
        'fields'        => [
            'organisation'  => 'Organizacija',
            'role'          => 'Uloga',
        ],
        'hint'          => 'Likovi mogu biti dio više organizacija, predstavljajući za koga rade ili biti članovi tajnih društava.',
        'placeholders'  => [
            'organisation'  => 'Odaberi organizaciju...',
        ],
        'title'         => 'Organizacije lika :name',
    ],
    'placeholders'  => [
        'age'               => 'Starosna dob',
        'appearance_entry'  => 'Opis',
        'appearance_name'   => 'Kosa, Oči, Koža, Visina',
        'family'            => 'Odaberi lika',
        'image'             => 'Slika',
        'location'          => 'Odaberi lokaciju',
        'name'              => 'Ime',
        'personality_entry' => 'Detalji',
        'personality_name'  => 'Ciljevi, Ponašanje, Strahovi, Veze',
        'physical'          => 'Fizičke osobine',
        'race'              => 'Rasa',
        'sex'               => 'Spol',
        'title'             => 'Titula',
        'traits'            => 'Osobine',
        'type'              => 'Lik igrača, Lik kojim upravlja voditelj igre, Božanstvo',
    ],
    'quests'        => [
        'description'   => 'Zadaci u koje je lik uključen.',
        'helpers'       => [
            'quest_giver'   => 'Zadaci kojima je lik zadavatelj.',
            'quest_member'  => 'Zadaci kojih je lik član.',
        ],
        'title'         => 'Zadaci lika :name',
    ],
    'sections'      => [
        'appearance'    => 'Fizički izgled',
        'general'       => 'Općenite informacije',
        'personality'   => 'Osobnost',
    ],
    'show'          => [
        'description'   => 'Detaljan pregled lika',
        'tabs'          => [
            'conversations' => 'Razgovori',
            'dice_rolls'    => 'Rezultati bacanja kockica',
            'items'         => 'Predmeti',
            'journals'      => 'Dnevnici',
            'map'           => 'Mapa odnosa',
            'organisations' => 'Organizacije',
            'personality'   => 'Osobnost',
            'quests'        => 'Zadaci',
        ],
        'title'         => 'Lik :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Nemaš dopuštenje mijenjati osobine ovog lika.',
    ],
];
