<?php

return [
    'create'        => [
        'success'   => 'Nota ":name" creada.',
        'title'     => 'Nova nota',
    ],
    'destroy'       => [
        'success'   => 'Nota ":name" eliminada.',
    ],
    'edit'          => [
        'success'   => 'Nota ":name" actualizada.',
        'title'     => 'Editar nota ":name"',
    ],
    'fields'        => [
        'description'   => 'Descrición',
        'image'         => 'Imaxe',
        'is_pinned'     => 'Fixada',
        'name'          => 'Nome',
        'note'          => 'Nota superior',
        'notes'         => 'Subnotas',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested_parent' => 'Mostrando as notas de :parent.',
        'nested_without'=> 'Mostrando todas as notas que non teñen unha nota superior. Fai clic nunha fila para ver as súas descendentes.',
    ],
    'hints'         => [
        'is_pinned' => 'Pódense fixar ata 3 notas para ser mostradas no taboleiro.',
    ],
    'index'         => [
        'add'       => 'Nova nota',
        'header'    => 'Notas de ":name"',
        'title'     => 'Notas',
    ],
    'placeholders'  => [
        'name'  => 'Nome da nota',
        'note'  => 'Elixe unha nota superior',
        'type'  => 'Relixión, raza, sistema político...',
    ],
    'show'          => [
        'title' => 'Nota ":name"',
    ],
];
