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
        'image'     => 'Imagen',
        'location'  => 'Localización',
        'name'      => 'Nombre',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'date'  => 'Este campo puede contener cualquier cosa y no está vinculado a los calendarios de la campaña. Para vincular este evento con un calendario, añádelo desde la pestaña de recordatorios o desde el mismo calendario.',
    ],
    'index'         => [
        'add'           => 'Nuevo evento',
        'description'   => 'Gestiona los eventos de :name.',
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
