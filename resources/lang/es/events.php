<?php

return [
    'create'        => [
        'description'   => 'Crear nuevo evento',
        'success'       => 'Evento \':name\' creado.',
        'title'         => 'Crear nuevo evento',
    ],
    'destroy'       => [
        'success'   => 'Evento \':name\' borrado.',
    ],
    'edit'          => [
        'success'   => 'Evento \':name\' actualizado.',
        'title'     => 'Editar evento :name',
    ],
    'fields'        => [
        'date'      => 'Fecha',
        'history'   => 'Biografia',
        'image'     => 'Imagen',
        'location'  => 'Localización',
        'name'      => 'Nombre',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nuevo evento',
        'description'   => 'Gestionar los eventos de :name.',
        'header'        => 'Eventos de :name',
        'title'         => 'Eventos',
    ],
    'placeholders'  => [
        'date'      => 'Fecha para tu evento',
        'location'  => 'Elige un lugar',
        'name'      => 'Nombre del Evento',
        'type'      => 'Ceremonia, Festival, Catástrofe, Batalla, Nacimiento...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de evento',
        'tabs'          => [
            'information'   => 'Información',
        ],
        'title'         => 'Evento :name',
    ],
    'tabs'          => [
        'calendars' => 'Entradas del calendario',
    ],
];
