<?php

return [
    'create'        => [
        'success'   => 'Acceso directo ":name" creado.',
        'title'     => 'Nuevo acceso directo',
    ],
    'destroy'       => [
        'success'   => 'Acceso directo ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Acceso directo ":name" actualizado.',
        'title'     => 'Acceso directo :name',
    ],
    'fields'        => [
        'dashboard'     => 'Tablero',
        'entity'        => 'Entidad',
        'filters'       => 'Filtros',
        'is_nested'     => 'Anidado',
        'menu'          => 'Menú',
        'name'          => 'Nombre',
        'position'      => 'Posición',
        'random'        => 'Aleatorio',
        'random_type'   => 'Tipo de entidad aleatorio',
        'selector'      => 'Configuración del acceso directo',
        'tab'           => 'Pestaña',
        'type'          => 'Tipo de entidad',
    ],
    'helpers'       => [
        'dashboard' => 'Puedes hacer que un acceso directo lleve directamente a uno de los tableros personalizados de la campaña.',
        'entity'    => 'Configura este acceso directo para acceder directamente a una entidad. El campo de :tab controla qué pestaña estará seleccionada. El campo de :menu controla qué subpágina de la entidad se abrirá.',
        'position'  => 'Usa este campo para controlar en qué orden ascendente aparecen los enlaces en el acceso directo.',
        'random'    => 'Usa este campo para tener un acceso directo a una entidad aleatoria. Puedes filtrar el enlace para que solo vaya a un tipo específico de entidad.',
        'selector'  => 'Configura adónde dirige este acceso directo cuando un usuario le hace clic en la barra lateral.',
        'type'      => 'Configura este acceso directo para ir directamente a una lista de entidades. Para filtrar los resultados, copia las partes de la URL de la lista filtrada a partir del símbolo :? en el campo de :filter.',
    ],
    'index'         => [
        'add'   => 'Nuevo acceso directo',
        'title' => 'Accesos directos',
    ],
    'placeholders'  => [
        'entity'    => 'Elige una entidad',
        'filters'   => 'location_id=15&type=ciudad',
        'menu'      => 'Subpágina del menú (usa la última parte de la url)',
        'name'      => 'Nombre del acceso directo',
        'tab'       => 'Historia, Relaciones, Notas',
    ],
    'random_types'  => [
        'any'   => 'Cualquier entidad',
    ],
    'reorder'       => [
        'success'   => 'Enlaces reordenados.',
        'title'     => 'Reordenar los enlaces',
    ],
    'show'          => [
        'tabs'  => [
            'information'   => 'Información',
        ],
        'title' => 'Acceso directo :name',
    ],
];
