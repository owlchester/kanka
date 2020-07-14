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
        'position'  => 'Posición',
        'tab'       => 'Pestaña',
        'type'      => 'Tipo de entidad',
    ],
    'helpers'       => [
        'entity'    => 'Configura este enlace de menú para acceder directamente a una entidad. El campo de :tab controla qué pestaña estará seleccionada. El campo de :menu controla qué subpágina de la entidad se abrirá.',
        'position'  => 'Usa este campo para controlar en qué orden ascendente aparecen los enlaces en el menú.',
        'type'      => 'Configura este enlace de menú para ir directamente a una lista de entidades. Para filtrar los resultados, copia las partes de la URL de la lista filtrada a partir del símbolo :? en el campo de :filter.',
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
