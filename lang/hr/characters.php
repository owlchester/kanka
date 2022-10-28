<?php

return [
    'actions'       => [
        'add_appearance'    => 'Dodaj fizički izgled',
        'add_organisation'  => 'Dodaj organizaciju',
        'add_personality'   => 'Dodaj osobnost',
    ],
    'conversations' => [
        'title' => 'Razgovori s likom :name',
    ],
    'create'        => [
        'title' => 'Novi lik',
    ],
    'destroy'       => [],
    'dice_rolls'    => [
        'hint'  => 'Rezultati bacanja kockica se mogu dodijeliti liku za korištenje unutar igre.',
        'title' => 'Rezultati bacanja kockica lika :name',
    ],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Starosna dob',
        'is_dead'                   => 'Mrtav/a/o',
        'is_personality_visible'    => 'Osobnost vidljiva',
        'life'                      => 'Život',
        'physical'                  => 'Fizičke osobine',
        'pronouns'                  => 'Zamjenice',
        'sex'                       => 'Spol',
        'title'                     => 'Titula',
        'traits'                    => 'Osobine',
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
    'index'         => [],
    'items'         => [
        'hint'  => 'Predmeti se mogu dodijeliti na likove i bit će prikazani ovdje.',
        'title' => 'Predmeti lika :name',
    ],
    'journals'      => [
        'title' => 'Dnevnici lika :name',
    ],
    'maps'          => [
        'title' => 'Mapa odnosa za lika :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Dodaj organizaciju',
        ],
        'create'        => [
            'success'   => 'Lik je dodan u organizaciju.',
            'title'     => 'Nova organizacija za :name',
        ],
        'destroy'       => [
            'success'   => 'Organizacija lika uklonjena.',
        ],
        'edit'          => [
            'success'   => 'Organizacija lika ažurirana.',
            'title'     => 'Ažuriraj organizaciju za :name',
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
        'personality_entry' => 'Detalji',
        'personality_name'  => 'Ciljevi, Ponašanje, Strahovi, Veze',
        'physical'          => 'Fizičke osobine',
        'pronouns'          => 'On, Ona, Oni',
        'sex'               => 'Spol',
        'title'             => 'Titula',
        'traits'            => 'Osobine',
        'type'              => 'Lik igrača, Lik kojim upravlja voditelj igre, Božanstvo',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Zadaci kojima je lik zadavatelj.',
            'quest_member'  => 'Zadaci kojih je lik član.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Fizički izgled',
        'general'       => 'Općenite informacije',
        'personality'   => 'Osobnost',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizacije',
        ],
    ],
    'warnings'      => [
        'personality_hidden'    => 'Nemaš dopuštenje mijenjati osobine ovog lika.',
    ],
];
