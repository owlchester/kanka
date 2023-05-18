<?php

return [
    'create'        => [
        'title' => 'Novo Diário',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Data',
    ],
    'helpers'       => [
        'journals'          => 'Exibir todos ou somente os sub-diários desse diário.',
        'nested_without'    => 'Exibindo todos os diários que não tem um diário primário. Clique em uma linha para ver os diários secundários.',
    ],
    'index'         => [],
    'journals'      => [],
    'placeholders'  => [
        'author'    => 'Quem escreveu o diário',
        'date'      => 'Data do mundo real do diário',
        'type'      => 'Sessão, One Shot, Rascunho',
    ],
    'show'          => [],
];
