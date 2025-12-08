<?php

return [
    'actions'       => [
        'copy'  => 'Kopiraj',
    ],
    'errors'        => [
        'permission'        => 'Nije ti dopušteno stvarati entitete te vrste u ciljanoj kampanji.',
        'permission_update' => 'Ne možeš premjestiti ovaj entitet.',
        'same_campaign'     => 'Moraš odabrati drugu kampanju u koju ćeš premjestiti entitet.',
        'unknown_campaign'  => 'Nepoznata kampanja.',
    ],
    'fields'        => [
        'campaign'      => 'Ciljana kampanja',
        'copy'          => 'Napravi kopiju',
        'select_one'    => 'Odaberi kampanju',
    ],
    'panel'         => [
        'description'           => 'Odaberi kampanju u koju želiš premjestiti ili napraviti kopiju ovog entiteta.',
        'description_bulk_copy' => 'Odaberi kampanju u koju želiš kopirati odabrane entitete.',
        'title'                 => 'Premjesti ili kopiraj entitet u drugu kampanju',
    ],
    'success'       => 'Entitet :name premješten.',
    'success_copy'  => 'Entitet :name kopiran.',
    'title'         => 'Premjesti :name',
];
