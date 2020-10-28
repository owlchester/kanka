<?php

return [
    'actions'       => [
        'return'        => 'Torna als esdeveniments',
        'send'          => 'Participa',
        'show_ongoing'  => 'Veu l\'esdeveniment i participa-hi',
        'show_past'     => 'Veu l\'esdeveniment i els guanyadors',
        'update'        => 'Actualitza l\'entrega',
        'view'          => 'Mira l\'entrega',
    ],
    'description'   => 'Oferim esdeveniments pels creadors de móns de la nostra comunitat i mostrem els nostres preferits.',
    'fields'        => [
        'comment'       => 'Comentari',
        'entity_link'   => 'Enllaç a l\'entitat',
        'rank'          => 'Rang',
        'submitter'     => 'Remitent',
    ],
    'index'         => [
        'ongoing'   => 'Esdeveniments actuals',
        'past'      => 'Esdeveniments finalitzats',
    ],
    'participate'   => [
        'description'   => 'Us sentiu inspirats? Creeu una entitat en una campanya pública i envieu-nos l\'enllaç des del següent formulari. Podeu canviar o esborrar l\'entrega en qualsevol moment.',
        'login'         => 'Entreu al vostre compte per a participar a l\'esdeveniment.',
        'participated'  => 'Ja heu fet una entrega per aquest esdeveniment. Podeu editar-la o esborrar-la.',
        'success'       => [
            'modified'  => 'S\'han guardat els canvis a l\'entrega.',
            'removed'   => 'S\'ha eliminat l\'entrega.',
            'submit'    => 'S\'ha enviat l\'entrega. Podeu editar-la o eliminar-la en qualsevol moment.',
        ],
        'title'         => 'Participació a l\'esdeveniment',
    ],
    'placeholders'  => [
        'comment'       => 'Observacions respecte a l\'entrega (opcional)',
        'entity_link'   => 'Copieu i enganxeu aquí l\'enllaç de l\'entitat',
    ],
    'results'       => [
        'description'       => 'El nostre jurat ha escollit els següents guanyadors de l\'esdeveniment.',
        'title'             => 'Guanyadors de l\'esdeveniment',
        'waiting_results'   => 'L\'esdeveniment ha acabat! El jurat farà un cop d\'ull a les entregues i mostrarem aquí els guanyadors en quant siguin seleccionats.',
    ],
    'show'          => [
        'participants'  => '{1} :number entrega enviada.|[2,*] :number entregues enviades.',
        'title'         => 'Esdeveniment :name',
    ],
    'title'         => 'Esdeveniments',
];
