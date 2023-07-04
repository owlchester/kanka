<?php

return [
    'fields'    => [
        'type'  => 'Tipo di Promemoria',
    ],
    'helpers'   => [
        'characters'    => 'Impostando il tipo come data di nascita o di morte di questo personaggio, si calcolerà automaticamente la sua età. :more.',
        'founding'      => 'Impostando il tipo come :type si calcolerà automaticamente l\'età dell\'entità dalla fondazione.',
        'no_events_v2'  => 'Questa entità può essere legata ai calendari della campagna tramite promemoria, che sono visualizzati qui.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Aggiungi promemoria',
        ],
        'title'     => 'Promemoria :name',
    ],
    'types'     => [
        'birth'     => 'Nascita',
        'death'     => 'Morte',
        'founded'   => 'Fondazione',
        'primary'   => 'Primario',
    ],
    'years-ago' => '{1} :count anno fa|[2,*] :count anni fa',
];
