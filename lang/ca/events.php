<?php

return [
    'create'        => [
        'title' => 'Nou esdeveniment',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Aquí es mostren els esdeveniments que tenen aquesta entitat com el seu esdeveniment pare.',
    ],
    'fields'        => [
        'date'  => 'Data',
    ],
    'helpers'       => [
        'date'  => 'Aquest camp pot contenir qualsevol cosa i no està vinculat als calendaris de la campanya. Per vincular aquest esdeveniment amb un calendari, afegiu-lo des de la pestanya de recordatoris o des del mateix calendari.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Data de l\'esdeveniment',
        'type'  => 'Cerimònia, festival, catàstrofe, batalla, naixement...',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Entrades del calendari',
    ],
];
