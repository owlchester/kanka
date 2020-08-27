<?php

return [
    'create'        => [
        'description'   => 'Crear nuevo enlace rápido',
        'success'       => 'Enlace rápido \':name\' creado.',
        'title'         => 'Nuevo enlace rápido',
    ],
    'destroy'       => [
        'success'   => 'Enlace rápido \':name\' eliminado.',
    ],
    'edit'          => [
        'description'   => 'Editar enlace rápido',
        'success'       => 'Enlace rápido \':name\' actualizado.',
        'title'         => 'Enlace rápido :name',
    ],
    'fields'        => [
        'entity'    => 'Entidad',
        'filters'   => 'Filtros',
        'menu'      => 'Menú',
        'name'      => 'Nombre',
        'position'  => 'Posición',
        'tab'       => 'Pestaña',
        'type'      => 'Tipo de entidad',
    ],
    'helpers'       => [
        'entity'    => 'Configura este enlace rápido para acceder directamente a una entidad. El campo de :tab controla qué pestaña estará seleccionada. El campo de :menu controla qué subpágina de la entidad se abrirá.',
        'position'  => 'Usa este campo para controlar en qué orden ascendente aparecen los enlaces en el acceso rápido.',
        'type'      => 'Configura este enlace de menú para ir directamente a una lista de entidades. Para filtrar los resultados, copia las partes de la URL de la lista filtrada a partir del símbolo :? en el campo de :filter.',
    ],
    'index'         => [
        'add'           => 'Nuevo enlace rápido',
        'description'   => 'Administrar enlaces rápidos de :name.',
        'header'        => 'Enlace rápido de :name',
        'title'         => 'Acceso rápido',
    ],
    'placeholders'  => [
        'entity'    => 'Elige una entidad',
        'filters'   => 'location_id=15&type=ciudad',
        'menu'      => 'Subpágina del menú (usa la última parte de la url)',
        'name'      => 'Nombre del enlace rápido',
        'tab'       => 'Historia, Relaciones, Notas',
    ],
    'show'          => [
        'description'   => 'Vista detallada del enlace rápido',
        'tabs'          => [
            'information'   => 'Información',
        ],
        'title'         => 'Enlace rápido :name',
    ],
];
