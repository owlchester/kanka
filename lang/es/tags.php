<?php

return [
    'children'      => [
        'actions'   => [
            'add'           => 'Añadir etiqueta nueva',
            'add_entity'    => 'Añadir a entidad',
        ],
        'create'    => [
            'attach_success'        => '{1} Se ha añadido :count entidad a la etiqueta :name.|[2,*] Se han añadido :count entidades a la etiqueta :name.',
            'attach_success_entity' => 'Etiquetas actualizadas con éxito para :name.',
            'entity'                => 'Añadir etiquetas a :name',
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
        'no_posts'      => 'Actualmente no hay entradas etiquetadas con esta etiqueta.',
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
        'fail'          => 'Fallo al transferir entidades de :tag a :newTag',
        'fail_post'     => 'Error al transferir entradas de :tag a :newTag',
        'success'       => 'Entidades de :tag transferidas con éxito a :newTag',
        'success_post'  => 'Se han transferido correctamente las entradas de :tag a :newTag',
        'transfer'      => 'Transferir',
    ],
];
