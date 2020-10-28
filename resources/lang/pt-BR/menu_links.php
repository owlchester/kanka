<?php

return [
    'create'        => [
        'success'   => 'Link rápido \':name\' criado',
        'title'     => 'Novo link rápido',
    ],
    'destroy'       => [
        'success'   => 'Menu rápido \':name\' removido',
    ],
    'edit'          => [
        'success'   => 'Link rápido \':name\' atualizado',
        'title'     => 'Link rápido :name',
    ],
    'fields'        => [
        'entity'    => 'Entidade',
        'filters'   => 'Filtros',
        'menu'      => 'Menu',
        'name'      => 'Nome',
        'position'  => 'Posição',
        'tab'       => 'Aba',
        'type'      => 'Tipo de entidade',
    ],
    'helpers'       => [
        'entity'    => 'Configure este link rápido para ir diretamente a uma entidade. O campo :tab controla qual das abas está focada. O campo :menu controla qual subpágina da entidade é aberta.',
        'position'  => 'Use este campo para controlar em qual ordem crescente os links aparecem no menu.',
        'type'      => 'Configure este link rápido para ir diretamente para uma lista de entidades. Para filtrar os resultados, copie partes da url na lista de entidades filtradas após o sinal :? no campo de filtro :filter.',
    ],
    'index'         => [
        'add'   => 'Novo link rápido',
        'title' => 'Links rápidos',
    ],
    'placeholders'  => [
        'entity'    => 'Escolha uma entidade',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Subpágina do menu (use o último texto da url)',
        'name'      => 'Nome do link rápido',
        'tab'       => 'Registro, relações, notas',
    ],
    'show'          => [
        'tabs'  => [
            'information'   => 'Informação',
        ],
        'title' => 'Link rápido :name',
    ],
];
