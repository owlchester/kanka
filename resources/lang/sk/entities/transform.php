<?php

return [
    'actions'   => [
        'transform' => 'Transformovať',
    ],
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
        'description'       => 'Podarilo sa ti vytvoriť tento objekt ako daný typ, ale myslíš si, že iný by sa mu hodil viac? Bez problému môžeš hocikedy zmeniť jeho umiestnenie. Je nutné mať ale na pozore, že niektoré dáta sa môžu vzhľadom na rôzne polia medzi objektami stratiť.',
        'title'             => 'Transformovať objekt',
    ],
    'success'   => 'Objekt :name transformovaný.',
    'title'     => 'Transformácia :name',
];
