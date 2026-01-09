<?php

return [
    'create'        => [
        'title' => 'Nuevo evento',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Aquí se muestran los eventos que tienen esta entidad como evento padre.',
    ],
    'fields'        => [
        'date'  => 'Fecha',
    ],
    'helpers'       => [
        'date'  => 'Este campo puede contener cualquier cosa y no está vinculado a los calendarios de la campaña. Para vincular este evento con un calendario, añádelo desde la pestaña de recordatorios o desde el mismo calendario.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Añade momentos importantes como batallas, coronaciones o descubrimientos a la historia de tu mundo.',
    ],
    'placeholders'  => [
        'date'  => 'Fecha del evento',
        'type'  => 'Ceremonia, festival, catástrofe, batalla, nacimiento...',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Entradas del calendario',
    ],
];
