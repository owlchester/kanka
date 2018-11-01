<?php

return [
    'create'        => [
        'description'   => 'Crear nueva nota',
        'success'       => 'Nota \':name\' creada.',
        'title'         => 'Nueva Nota',
    ],
    'destroy'       => [
        'success'   => 'Nota \':name\' eliminada.',
    ],
    'edit'          => [
        'success'   => 'Nota \':name\' actualizada.',
        'title'     => 'Editar nota :name',
    ],
    'fields'        => [
        'description'   => 'Descripción',
        'image'         => 'Imagen',
        'is_pinned'     => 'Fijada',
        'name'          => 'Nombre',
        'type'          => 'Tipo',
    ],
    'hints'         => [
        'is_pinned' => 'Se pueden fijar hasta 3 notas para que se muestren en el tablero.',
    ],
    'index'         => [
        'add'           => 'Nueva Nota',
        'description'   => 'Gestiona las notas de :name.',
        'header'        => 'Notas de :name',
        'title'         => 'Notas',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la nota',
        'type'  => 'Religión, Raza, Sistema politico',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la nota',
        'tabs'          => [
            'description'   => 'Descripción',
        ],
        'title'         => 'Nota :name',
    ],
];
