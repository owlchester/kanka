<?php

return [
    'create'        => [
        'description'   => 'Crear nuevo enlace de menú',
        'success'       => 'Enlace de menú \':name\' creado.',
        'title'         => 'Nuevo Enlace de Menú',
    ],
    'destroy'       => [
        'success'   => 'Enlace de menú \':name\' eliminado.',
    ],
    'edit'          => [
        'description'   => 'Editar ítem de menú',
        'success'       => 'Enlace de menú \':name\' actualizado.',
        'title'         => 'Enlace de menú :name',
    ],
    'fields'        => [
        'entity'    => 'Entidad',
        'filters'   => 'Filtros',
        'menu'      => 'Menú',
        'name'      => 'Nombre',
        'tab'       => 'Pestaña',
        'type'      => 'Tipo de entidad',
    ],
    'index'         => [
        'add'           => 'Nuevo enlace de menú',
        'description'   => 'Administrar enlaces de menú de :name.',
        'header'        => 'Enlace de menú de :name',
        'title'         => 'Enlaces de menú',
    ],
    'placeholders'  => [
        'entity'    => 'Elige una entidad',
        'filters'   => 'location_id=15&type=ciudad',
        'menu'      => 'Subpágina del menú (usa la última parte de la url)',
        'name'      => 'Nombre del enlace de menú',
        'tab'       => 'Historia, Relaciones, Notas',
    ],
    'show'          => [
        'description'   => 'Vista detallada del enlace de menú',
        'tabs'          => [
            'information'   => 'Información',
        ],
        'title'         => 'Enlace de menú :name',
    ],
];
