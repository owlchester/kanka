<?php

return [
    'actions'           => [
        'customise' => 'Personalizar la barra lateral',
    ],
    'create'            => [
        'title' => 'Nuevo acceso directo',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Acceso directo :name',
    ],
    'fields'            => [
        'active'            => 'Activo',
        'dashboard'         => 'Tablero',
        'default_dashboard' => 'Cuadro de mandos por defecto',
        'filters'           => 'Filtros',
        'menu'              => 'Menú',
        'position'          => 'Posición',
        'random_type'       => 'Tipo de entidad aleatorio',
        'selector'          => 'Configuración del acceso directo',
        'target'            => 'Destino',
    ],
    'helpers'           => [
        'active'            => 'Los enlaces rápidos inactivos no aparecerán en la barra lateral.',
        'dashboard'         => 'Puedes hacer que un acceso directo lleve directamente a uno de los tableros personalizados de la campaña.',
        'default_dashboard' => 'Enlace al panel de control predeterminado de la campaña. Es necesario seleccionar un panel de control personalizado.',
        'entity'            => 'Configura este acceso directo para acceder directamente a una entidad. El campo de :tab controla qué pestaña estará seleccionada. El campo de :menu controla qué subpágina de la entidad se abrirá.',
        'position'          => 'Usa este campo para controlar en qué orden ascendente aparecen los enlaces en el acceso directo.',
        'random'            => 'Usa este campo para tener un acceso directo a una entidad aleatoria. Puedes filtrar el enlace para que solo vaya a un tipo específico de entidad.',
        'selector'          => 'Configura adónde dirige este acceso directo cuando un usuario le hace clic en la barra lateral.',
        'type'              => 'Configura este acceso directo para ir directamente a una lista de entidades. Para filtrar los resultados, copia las partes de la URL de la lista filtrada a partir del símbolo :? en el campo de :filter.',
    ],
    'index'             => [],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=ciudad',
        'menu'      => 'Subpágina del menú (usa la última parte de la url)',
        'tab'       => 'Historia, Relaciones, Notas',
    ],
    'random_no_entity'  => 'No se ha encontrado ninguna entidad aleatoria.',
    'random_types'      => [
        'any'   => 'Cualquier entidad',
    ],
    'reorder'           => [
        'success'   => 'Enlaces reordenados.',
        'title'     => 'Reordenar los enlaces',
    ],
    'show'              => [],
    'visibilities'      => [
        'is_active' => 'Mostrar el enlace rápido en la barra lateral',
    ],
];
