<?php

return [
    'create'        => [
        'title' => 'Novo evento',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Os eventos que teñen esta entidade como o seu evento superior son mostrados aquí.',
    ],
    'fields'        => [
        'date'  => 'Data',
    ],
    'helpers'       => [
        'date'  => 'Este campo pode conter calquera cousa e non está ligado aos calendarios da campaña. Para ligar este evento a un calendario, faino dende o propio calendario ou na lapela "Lembretes" deste evento.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Data do teu evento',
        'type'  => 'Cerimonia, festival, desastre, batalla, nacemento...',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Entradas en calendarios',
    ],
];
