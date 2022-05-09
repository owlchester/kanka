<?php

return [
    'create'        => [
        'success'   => 'Nota ":name" creada.',
        'title'     => 'Nueva nota',
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
        'nested_parent' => 'Mostrando notas de :parent.',
        'nested_without'=> 'Mostrando todas las notas sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'hints'         => [
        'is_pinned' => 'Se pueden fijar hasta 3 notas para que se muestren en el tablero.',
    ],
    'index'         => [
        'title' => 'Notas',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la nota',
        'note'  => 'Elige una nota superior',
        'type'  => 'Religión, Raza, Sistema politico...',
    ],
    'show'          => [],
];
