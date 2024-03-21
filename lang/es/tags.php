<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Añadir etiqueta nueva',
        ],
    ],
    'create'        => [
        'title' => 'Nueva etiqueta',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Entidades anidadas',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas las etiquetas sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'hints'         => [
        'children'  => 'Aquí se muestran todas las entidades que pertenecen directamente a esta etiqueta y a todas las etiquetas anidadas.',
        'tag'       => 'A continuación se muestran todas las etiquetas que están directamente bajo esta etiqueta.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Tradiciones, guerras, historia, religión...',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Entidades anidadas',
        ],
    ],
    'tags'          => [],
];
