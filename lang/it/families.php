<?php

return [
    'create'        => [
        'title' => 'Nuova Famiglia',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Membri',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Questa famiglia è estinta.',
        'members'       => 'I membri di una famiglia sono mostrati qui. Un personaggio può essere aggiunto alla famiglia modificando il personaggio, usando il selettore "Famiglia".',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'submit'    => 'Aggiungi membri',
            'success'   => '{0} Nessun membro è stato aggiunto.|{1} 1 membro è stato aggiunto.|[2,*] :count membri sono stati aggiunti.',
            'title'     => 'Nuovi Membri',
        ],
        'helpers'   => [
            'all_members'       => 'La lista seguente contiene tutti i personaggi che appartengono alla famiglia ed a tutte le famiglie discendenti.',
            'direct_members'    => 'La maggior parte delle famiglie hanno membri che le gestiscono o che le hanno fatte diventare famose. Di seguito i personaggi che sono membri di questa famiglia.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nome della famiglia',
        'type'  => 'Famiglia Reale, Nobile, Estinta',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Membri',
            'tree'      => 'Albero Genealogico',
        ],
    ],
];
