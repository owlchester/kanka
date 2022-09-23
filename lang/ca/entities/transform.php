<?php

return [
    'actions'   => [
        'transform' => 'Transforma',
    ],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Tipus d\'entitat desconegut o no vàlid.',
        ],
        'success'   => '{1} S\'ha transformat :count entitat al nou tipus: :type.|[2,*] S\'han transformat :count entitts al nou tipus: :type.',
    ],
    'fields'    => [
        'select_one'    => 'Selecciona un',
        'target'        => 'Nou tipus d\'entitat',
    ],
    'panel'     => [
        'bulk_description'  => 'Canvia el tipus d\'entitat de múltiples entitats. Tingueu en compte que algunes dades es podrien perdre degut a la diferència entre els camps dels diferents tipus d\'entitat.',
        'bulk_title'        => 'Transforma entitats en grup',
        'description'       => 'Heu creat aquesta entitat com un tipus però us heu adonat que un altre en seria més adient? No passa res, podeu canviar el tipus d\'entitat en qualsevol moment. Tanmateix, tingueu en compte que algunes dades es podrien perdre degut a la diferència entre els camps de les entitats.',
        'title'             => 'Transforma una entitat',
    ],
    'success'   => 'S\'ha transformat l\'entitat :name.',
    'title'     => 'Trasnforma :name',
];
