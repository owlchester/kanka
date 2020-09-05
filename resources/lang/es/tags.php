<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Añadir etiqueta nueva',
        ],
        'create'        => [
            'title' => 'Añadir etiqueta a :name',
        ],
        'description'   => 'Entidades etiquetadas',
        'title'         => 'Descendientes de la etiqueta :name',
    ],
    'create'        => [
        'description'   => 'Crear nueva etiqueta',
        'success'       => 'Etiqueta ":name" creada.',
        'title'         => 'Nueva etiqueta',
    ],
    'destroy'       => [
        'success'   => 'Etiqueta ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Etiqueta ":name" actualizada.',
        'title'     => 'Editar etiqueta :name',
    ],
    'fields'        => [
        'characters'    => 'Personajes',
        'children'      => 'Entidades anidadas',
        'name'          => 'Nombre',
        'tag'           => 'Etiqueta superior',
        'tags'          => 'Subetiquetas',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Con la vista anidada se muestran las etiquetas de forma agrupada. Las etiquetas que no tengan ninguna superior se mostrarán aquí por defecto. Las que tengan subetiquetas anidadas se pueden ir clicando para mostrarlas. Puedes seguir haciendo click hasta que no haya más etiquetas anidadas que ver.',
    ],
    'hints'         => [
        'children'  => 'Aquí se muestran todas las entidades que pertenecen directamente a esta etiqueta y a todas las etiquetas anidadas.',
        'tag'       => 'A continuación se muestran todas las etiquetas que están directamente bajo esta etiqueta.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Vista anidada',
        ],
        'add'           => 'Nueva etiqueta',
        'description'   => 'Gestiona las etiquetas de :name.',
        'header'        => 'Etiquetas en :name',
        'title'         => 'Etiquetas',
    ],
    'new_tag'       => 'Nueva etiqueta',
    'placeholders'  => [
        'name'  => 'Nombre de la etiqueta',
        'tag'   => 'Elige una etiqueta superior',
        'type'  => 'Tradiciones, guerras, historia, religión...',
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
    'tags'          => [
        'description'   => 'Subetiquetas',
        'title'         => 'Descendientes de la etiqueta :name',
    ],
];
