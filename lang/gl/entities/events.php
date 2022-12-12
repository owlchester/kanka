<?php

return [
    'fields'    => [
        'type'  => 'Tipo de evento',
    ],
    'helpers'   => [
        'characters'    => 'Establecer o tipo como data de nacemento ou de morte calculará a idade da personaxe automáticamente. :more.',
        'founding'      => 'Establecer o tipo como :type calculará a idade da entidade automaticamente a partir da data na que foi fundada.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Engadir lembrete',
        ],
        'title'     => 'Lembretes de ":name"',
    ],
    'types'     => [
        'birth'     => 'Nacemento',
        'death'     => 'Morte',
        'founded'   => 'Fundación',
        'primary'   => 'Primario',
    ],
    'years-ago' => '{1} fai :count ano|[2,*] fai :count anos',
];
