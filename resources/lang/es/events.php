<?php

return [
    'create'        => [
        'description'   => 'Crear nuevo evento',
        'success'       => 'Se ha creado el evento ":name".',
        'title'         => 'Nuevo evento',
    ],
    'destroy'       => [
        'success'   => 'Se ha eliminado el evento ":name".',
    ],
    'edit'          => [
        'success'   => 'Se ha actualizado el evento ":name".',
        'title'     => 'Editar ":name"',
    ],
    'events'        => [
        'title' => 'Eventos del evento :name',
    ],
    'fields'        => [
        'date'      => 'Fecha',
        'event'     => 'Evento superior',
        'events'    => 'Eventos',
        'image'     => 'Imagen',
        'location'  => 'Localización',
        'name'      => 'Nombre',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'date'          => 'Este campo puede contener cualquier cosa y no está vinculado a los calendarios de la campaña. Para vincular este evento con un calendario, añádelo desde la pestaña de recordatorios o desde el mismo calendario.',
        'nested_parent' => 'Mostrando eventos de :parent.',
        'nested_without'=> 'Mostrando todos los eventos sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'index'         => [
        'add'           => 'Nuevo evento',
        'description'   => 'Gestiona los eventos de :name.',
        'header'        => 'Eventos de :name',
        'title'         => 'Eventos',
    ],
    'placeholders'  => [
        'date'      => 'Fecha del evento',
        'location'  => 'Elige un lugar',
        'name'      => 'Nombre del evento',
        'type'      => 'Ceremonia, festival, catástrofe, batalla, nacimiento...',
    ],
    'show'          => [
        'description'   => 'Vista detallada del evento',
        'tabs'          => [
            'information'   => 'Información',
        ],
        'title'         => 'Evento :name',
    ],
    'tabs'          => [
        'calendars' => 'Entradas del calendario',
    ],
];
