<?php

return [
    'create'        => [
        'title' => 'Nová diskusia',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_closed'     => 'Uzavretá',
        'messages'      => 'Správy',
        'participants'  => 'Účastníci',
    ],
    'hints'         => [
        'participants'  => 'Prosím, pridaj do diskusiu účastníkov tým, že klikneš na symbol :icon hore vpravo.',
    ],
    'index'         => [],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Správa odstránená.',
        ],
        'is_updated'    => 'Upravená',
        'load_previous' => 'Nahrať predchádzajúce správy',
        'placeholders'  => [
            'message'   => 'Tvoja správa',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Účastník :entity pridaný do diskusie.',
        ],
        'destroy'   => [
            'success'   => 'Účastník :entity odstránený z diskusie.',
        ],
        'modal'     => 'Účastníci',
        'title'     => 'Účastníci :name',
    ],
    'placeholders'  => [
        'name'  => 'Názov diskusie',
        'type'  => 'V hre, príprave, deji',
    ],
    'show'          => [
        'is_closed' => 'Diskusia je uzavretá.',
    ],
    'tabs'          => [
        'participants'  => 'Účastníci',
    ],
    'targets'       => [
        'characters'    => 'Postavy',
        'members'       => 'Členovia',
    ],
];
