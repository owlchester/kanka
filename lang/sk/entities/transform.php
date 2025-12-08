<?php

return [
    'actions'   => [],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Neznámy alebo nesprávny typ objektu.',
        ],
        'success'   => '{1} :count objekt transformovaný na nový typ: :type.|[2,4] :count objekty transformované na nový typ: :type.|[5,*] :count objektov transformovaných na nový typ: :type.',
    ],
    'fields'    => [
        'select_one'    => 'Vyber jeden',
        'target'        => 'Nový typ objektu',
    ],
    'panel'     => [
        'bulk_description'  => 'Zmeň typ pre viacero objektov. Prosím, uvedom si, že niektoré údaje vzhľadom na rôzne polia v daných objektoch môžeš stratiť.',
        'bulk_title'        => 'Hromadne transformovať objekty',
        'title'             => 'Transformovať objekt',
    ],
    'success'   => 'Objekt :name transformovaný.',
    'title'     => 'Transformácia :name',
];
