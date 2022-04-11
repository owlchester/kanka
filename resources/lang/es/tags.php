<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Añadir etiqueta nueva',
        ],
        'create'    => [
            'success'   => 'Se ha añadido la etiqueta :name a la entidad.',
            'title'     => 'Añadir etiqueta a :name',
        ],
        'title'     => 'Descendientes de la etiqueta :name',
    ],
    'create'        => [
        'success'   => 'Etiqueta ":name" creada.',
        'title'     => 'Nueva etiqueta',
    ],
    'destroy'       => [
        'success'   => 'Etiqueta ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Etiqueta ":name" actualizada.',
        'title'     => 'Editar etiqueta :name',
    ],
    'fields'        => [
        'children'  => 'Entidades anidadas',
        'name'      => 'Nombre',
        'tag'       => 'Etiqueta superior',
        'tags'      => 'Subetiquetas',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent' => 'Mostrando etiquetas de :parent.',
        'nested_without'=> 'Mostrando todas las etiquetas sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'hints'         => [
        'children'  => 'Aquí se muestran todas las entidades que pertenecen directamente a esta etiqueta y a todas las etiquetas anidadas.',
        'tag'       => 'A continuación se muestran todas las etiquetas que están directamente bajo esta etiqueta.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'Vista anidada',
        ],
        'add'       => 'Nueva etiqueta',
        'header'    => 'Etiquetas en :name',
        'title'     => 'Etiquetas',
    ],
    'new_tag'       => 'Nueva etiqueta',
    'placeholders'  => [
        'name'  => 'Nombre de la etiqueta',
        'tag'   => 'Elige una etiqueta superior',
        'type'  => 'Tradiciones, guerras, historia, religión...',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Entidades anidadas',
            'tags'      => 'Etiquetas',
        ],
        'title' => 'Etiqueta :name',
    ],
    'tags'          => [
        'title' => 'Descendientes de la etiqueta :name',
    ],
];
