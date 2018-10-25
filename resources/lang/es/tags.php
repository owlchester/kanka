<?php

return [
    'create'        => [
        'description'   => 'Crear nueva etiqueta',
        'success'       => 'Etiqueta \':name\' creada.',
        'title'         => 'Nueva Etiqueta',
    ],
    'destroy'       => [
        'success'   => 'Etiqueta \':name\' eliminada.',
    ],
    'edit'          => [
        'success'   => 'Etiqueta \':name\' actualizada.',
        'title'     => 'Editar Etiqueta \':name',
    ],
    'fields'        => [
        'characters'    => 'Personajes',
        'children'      => 'Entidades anidadas',
        'name'          => 'Nombre',
        'tag'           => 'Etiqueta',
        'tags'          => 'Subetiquetas',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'En la Vista de Exploración puedes ver tus etiquetas de forma anidada. Las etiquetas que no tengan ninguna superior se mostrarán aquí por defecto. Las que tengan subetiquetas anidadas se pueden ir clicando para mostrarlas. Puedes seguir haciendo click hasta que no haya más etiquetas anidadas que ver.',
    ],
    'hints'         => [
        'children'  => 'Esta lista contiene todas las entidades que pertenecen directamente a esta etiqueta y a todas las etiquetas anidadas.',
        'tag'       => 'A continuación se muestran todas las etiquetas que están directamente bajo esta etiqueta.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Vista de exploración',
        ],
        'add'           => 'Nueva Etiqueta',
        'description'   => 'Administrar etiquetas de :name.',
        'header'        => 'Etiquetas en :name',
        'title'         => 'Etiquetas',
    ],
    'new_tag'       => 'Nueva Etiqueta',
    'placeholders'  => [
        'name'  => 'Nombre de la etiqueta',
        'tag'   => 'Elige una etiqueta superior',
        'type'  => 'Tradiciones, Guerras, Historia, Religión...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la etiqueta',
        'tabs'          => [
            'children'      => 'Entidades anidadas',
            'information'   => 'Información',
            'tags'          => 'Etiquetas',
        ],
        'title'         => 'Etiqueta :name',
    ],
];
