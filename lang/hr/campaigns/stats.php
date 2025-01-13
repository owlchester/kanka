<?php

return [
    'achievements'  => [
        'calendars' => [
            'goal'  => 'Kalendari',
            'title' => 'Čuvar Vremena',
        ],
        'murderer'  => [
            'goal'  => 'Mrtvi likovi',
            'title' => 'Ubojica',
        ],
    ],
    'helper'        => 'Prati svoj napredak u otključavanju različitih dostignuća svoje kampanje. Ovi se brojevi ažuriraju svaka 24 sata.',
    'placeholder'   => ':amount od :target',
    'targets'       => [
        'calendars' => '{1}Kreiraj :target kalendar|[2,*]Kreiraj :target kalendara',
        'characters'=> '{1}Kreiraj :target lika|[2,4]Kreiraj :target lika|[5, *]Kreiraj :target likova',
        'dead'      => '{1}Ubij :target lika|[2,4]Ubij :target lika|[5, *]Ubij :target likova',
        'families'  => '{1}Kreiraj :target familiju|[2,4]Kreiraj :target familije|[5, *]Kreiraj :target familija',
        'locations' => '{1}Kreiraj :target lokaciju|[2,4]Kreiraj :target lokacije|[5, *]Kreiraj :target lokacija',
        'races'     => '{1}Kreiraj :target rasu|[2,4]Kreiraj :target rase|[5, *]Kreiraj :target rasa',
    ],
    'titles'        => [
        'calendars' => 'Čuvar Vremena razina :level',
        'characters'=> 'Davatelj Imena razina :level',
        'dead'      => 'Ubojica razina :level',
        'families'  => 'Planiranje Obitelji razina :level',
        'locations' => 'Graditelj razina :level',
        'quests'    => 'Organizator razina :level',
        'races'     => 'Uzgajivač razina :level',
    ],
];
