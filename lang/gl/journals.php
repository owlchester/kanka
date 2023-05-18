<?php

return [
    'create'        => [
        'title' => 'Novo caderno',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Autoría',
        'date'      => 'Data',
    ],
    'helpers'       => [
        'journals'          => 'Mostrar todos os subcadernos ou só os descendentes directos deste caderno.',
        'nested_without'    => 'Mostrando todos os cadernos que non teñen un caderno pai. Fai clic nunha fila para ver os seus descendentes.',
    ],
    'index'         => [],
    'journals'      => [],
    'placeholders'  => [
        'author'    => 'Quen escribiu o caderno',
        'date'      => 'Data real do caderno',
        'type'      => 'Sesión, campaña, borrador...',
    ],
    'show'          => [],
];
