<?php

return [
    'sync'  => [
        'actions'   => [
            'sync'  => 'Synkroniser',
        ],
        'errors'    => [
            'invalid_uuid'  => 'Ugyldig LFGM kampanje id. Vennligst prøv på nytt.',
        ],
        'helper'    => 'Velg en kampanje å synkronisere dine kommende hendelser fra :lfgm. Dette vil legge til et Notat ved dine kommende hendelser til den kampanjen og pinne den til kampanje dashbordet.',
        'successes' => [
            'sync'  => 'LFGM kalender synkronisert.',
        ],
        'title'     => 'LookingForGM.com Kampanje Sync',
    ],
];
