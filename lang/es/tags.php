<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Añadir etiqueta nueva',
        ],
        'create'    => [
            'attach_success'    => '{1} Se ha añadido :count entidad a la etiqueta :name.|[2,*] Se han añadido :count entidades a la etiqueta :name.',
            'modal_title'       => 'Añadir entidades a :name',
        ],
    ],
    'create'        => [
        'title' => 'Nueva etiqueta',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'          => 'Entidades anidadas',
        'is_auto_applied'   => 'Aplicar automáticamente a nuevas entidades',
        'is_hidden'         => 'Oculto en la cabecera y en el tooltip',
    ],
    'helpers'       => [
        'no_children'   => 'Actualmente no hay entidades etiquetadas con esta etiqueta.',
    ],
    'hints'         => [
        'children'          => 'Aquí se muestran todas las entidades que pertenecen directamente a esta etiqueta y a todas las etiquetas anidadas.',
        'is_auto_applied'   => 'Aplicar automáticamente esta etiqueta a las entidades recién creadas.',
        'is_hidden'         => 'No mostrar esta etiqueta en la cabecera o tooltip de una entidad.',
        'tag'               => 'A continuación se muestran todas las etiquetas que están directamente bajo esta etiqueta.',
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
    'transfer'      => [
        'description'   => 'Mover las entidades de esta etiqueta a otra etiqueta.',
        'fail'          => 'Fallo al transferir entidades de :tag a :newTag',
        'success'       => 'Entidades de :tag transferidas con éxito a :newTag',
        'title'         => 'Transferir :name',
        'transfer'      => 'Transferir',
    ],
];
