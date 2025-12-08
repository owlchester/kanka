<?php

return [
    'actions'   => [
        'customise' => 'Personalizza',
    ],
    'fields'    => [
        'icon'      => 'Icona del Modulo',
        'plural'    => 'Nome plurale del modulo',
        'singular'  => 'Nome singolare del modulo',
    ],
    'helpers'   => [],
    'pitch'     => 'Rinomina e cambia l\'cona associata a questo modulo per l\'intera campagna.',
    'rename'    => [
        'helper'    => 'Cambia il nome e l\'icona del modulo durante la campagna. Lascia vuoto per utilizzare l\'icona predefinita di Kanka.',
        'success'   => 'Modulo personalizzato.',
        'title'     => 'Personalizza il modulo :module',
    ],
    'reset'     => [
        'success'   => 'I moduli della campagna sono stati ripristinati.',
        'title'     => 'Ripristina i nomi e le icone personalizzate del modulo',
        'warning'   => 'Sei sicuro di voler ripristinare i moduli della campagna con i nomi e le icone originali?',
    ],
    'states'    => [
        'disable'   => 'Disattiva',
        'enable'    => 'Attiva',
    ],
];
