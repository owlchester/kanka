<?php

return [
    'create'        => [
        'description'   => 'Crear nuevo enlace rápido',
        'success'       => 'Enlace rápido ":name" creado.',
        'title'         => 'Nuevo enlace rápido',
    ],
    'destroy'       => [
        'success'   => 'Enlace rápido ":name" eliminado.',
    ],
    'edit'          => [
        'description'   => 'Editar enlace rápido',
        'success'       => 'Enlace rápido ":name" actualizado.',
        'title'         => 'Enlace rápido :name',
    ],
    'fields'        => [
        'dashboard'     => 'Tablero',
        'entity'        => 'Entidad',
        'filters'       => 'Filtros',
        'menu'          => 'Menú',
        'name'          => 'Nombre',
        'position'      => 'Posición',
        'random'        => 'Aleatorio',
        'random_type'   => 'Tipo de entidad aleatorio',
        'selector'      => 'Configuración del acceso rápido',
        'tab'           => 'Pestaña',
        'type'          => 'Tipo de entidad',
    ],
    'helpers'       => [
        'dashboard' => 'Puedes hacer que un enlace rápido lleve directamente a uno de los tableros personalizados de la campaña.',
        'entity'    => 'Configura este enlace rápido para acceder directamente a una entidad. El campo de :tab controla qué pestaña estará seleccionada. El campo de :menu controla qué subpágina de la entidad se abrirá.',
        'position'  => 'Usa este campo para controlar en qué orden ascendente aparecen los enlaces en el acceso rápido.',
        'random'    => 'Usa este campo para tener un enlace rápido a una entidad aleatoria. Puedes filtrar el enlace para que solo vaya a un tipo específico de entidad.',
        'selector'  => 'Configura adónde dirige este enlace rápido cuando un usuario hace clic en la barra lateral.',
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
    'random_types'  => [
        'any'   => 'Cualquier entidad',
    ],
    'show'          => [
        'description'   => 'Vista detallada del enlace rápido',
        'tabs'          => [
            'information'   => 'Información',
        ],
        'title'         => 'Enlace rápido :name',
    ],
];
