<?php

return [
    'actions'   => [
        'add'                       => 'Adj hozzá egy képességet',
        'import_from_race'          => 'Faji képesség hozzáadása',
        'import_from_race_mobile'   => 'Faji képességek',
        'reset'                     => 'Aktiválások számának visszaállítása',
    ],
    'create'    => [
        'success'           => ':ability képesség hozzáadva a következő entitáshoz: :entity',
        'success_multiple'  => ':abilities képességeket hozzáadtuk ehhez: :entity',
        'title'             => 'Adj hozzá egy képességet ehhez: :name',
    ],
    'fields'    => [
        'note'      => 'Megjegyzés',
        'position'  => 'Pozíció',
    ],
    'helpers'   => [
        'note'  => 'Bővebb említésekkel is hivatkozhatsz entitásokra (pl. :code) és tulajdonságokra (pl. :attr) ebben a mezőben.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'A karakternek nincs faja.',
            'not_character' => 'Az entitás nem karakter.',
        ],
        'success'   => '{1} :count képességet importáltunk.|[2,*] :count képességet importáltunk.',
    ],
    'show'      => [
        'helper'    => 'Csatolj képességeket ehhez az entitáshoz. Bármikor megváltoztathatod a láthatóságát vagy eltávolíthatsz egy képességet. Az azonos szülő képességhez tartozó képességeket szűrőként jelenítjük meg.',
        'title'     => ':name entitás képességei',
    ],
    'update'    => [
        'title' => 'Entitásképesség neki: :name',
    ],
];
