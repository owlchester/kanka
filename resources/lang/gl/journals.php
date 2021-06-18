<?php

return [
    'create'        => [
        'description'   => 'Crear un novo caderno',
        'success'       => 'Caderno ":name" creado.',
        'title'         => 'Novo caderno',
    ],
    'destroy'       => [
        'success'   => 'Caderno ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Caderno ":name" actualizado.',
        'title'     => 'Editar o caderno ":name"',
    ],
    'fields'        => [
        'author'    => 'Autoría',
        'date'      => 'Data',
        'image'     => 'Imaxe',
        'journal'   => 'Caderno pai',
        'journals'  => 'Subcadernos',
        'name'      => 'Nome',
        'relation'  => 'Relación',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'journals'      => 'Mostrar todos os subcadernos ou só os descendentes directos deste caderno.',
        'nested_parent' => 'Mostrando os cadernos de ":parent".',
        'nested_without'=> 'Mostrando todos os cadernos que non teñen un caderno pai. Fai clic nunha fila para ver os seus descendentes.',
    ],
    'index'         => [
        'add'           => 'Novo caderno',
        'description'   => 'Xestiona os cadernos de ":name".',
        'header'        => 'Cadernos de ":name"',
        'title'         => 'Cadernos',
    ],
    'journals'      => [
        'title' => 'Subcadernos de ":name"',
    ],
    'placeholders'  => [
        'author'    => 'Quen escribiu o caderno',
        'date'      => 'Data real do caderno',
        'journal'   => 'Elixe un caderno pai',
        'name'      => 'Nome do caderno',
        'type'      => 'Sesión, campaña, borrador...',
    ],
    'show'          => [
        'description'   => 'Vista detallada dun caderno',
        'tabs'          => [
            'journals'  => 'Cadernos',
        ],
        'title'         => 'Caderno ":name"',
    ],
];
