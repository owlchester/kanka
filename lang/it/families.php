<?php

return [
    'create'        => [
        'title' => 'Nuova Famiglia',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Questa famiglia è estinta.',
        'members'       => 'I membri di una famiglia sono mostrati qui. Un personaggio può essere aggiunto alla famiglia modificando il personaggio, usando il selettore "Famiglia".',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'success'   => '{0} Nessun membro è stato aggiunto.|{1} 1 membro è stato aggiunto.|[2,*] :count membri sono stati aggiunti.',
            'title'     => 'Nuovi Membri',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nome della famiglia',
        'type'  => 'Famiglia Reale, Nobile, Estinta',
    ],
    'show'          => [
        'tabs'  => [
            'tree'  => 'Albero Genealogico',
        ],
    ],
];
