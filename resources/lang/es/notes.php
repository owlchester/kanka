<?php

return [
    'create'        => [
        'description'   => 'Crear nueva nota',
        'success'       => 'Nota ":name" creada.',
        'title'         => 'Nueva nota',
    ],
    'destroy'       => [
        'success'   => 'Nota ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Nota ":name" actualizada.',
        'title'     => 'Editar nota :name',
    ],
    'fields'        => [
        'description'   => 'Descripción',
        'image'         => 'Imagen',
        'is_pinned'     => 'Fijada',
        'name'          => 'Nombre',
        'note'          => 'Nota superior',
        'notes'         => 'Subnotas',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'    => 'Primero se muestran las notas sin nota superior. Haz clic en una nota para explorar sus subnotas.',
    ],
    'hints'         => [
        'is_pinned' => 'Se pueden fijar hasta 3 notas para que se muestren en el tablero.',
    ],
    'index'         => [
        'add'           => 'Nueva nota',
        'description'   => 'Gestiona las notas de :name.',
        'header'        => 'Notas de :name',
        'title'         => 'Notas',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la nota',
        'note'  => 'Elige una nota superior',
        'type'  => 'Religión, Raza, Sistema politico...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la nota',
        'tabs'          => [
            'description'   => 'Descripción',
        ],
        'title'         => 'Nota :name',
    ],
];
