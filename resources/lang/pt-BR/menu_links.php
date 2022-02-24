<?php

return [
    'create'            => [
        'success'   => 'Link rápido \':name\' criado',
        'title'     => 'Novo link rápido',
    ],
    'destroy'           => [
        'success'   => 'Menu rápido \':name\' removido',
    ],
    'edit'              => [
        'success'   => 'Link rápido \':name\' atualizado',
        'title'     => 'Link rápido :name',
    ],
    'fields'            => [
        'dashboard'     => 'Dashboard',
        'entity'        => 'Entidade',
        'filters'       => 'Filtros',
        'is_nested'     => 'Aninhado',
        'menu'          => 'Menu',
        'name'          => 'Nome',
        'position'      => 'Posição',
        'random'        => 'Aleatório',
        'random_type'   => 'Tipo aleatório de entidade',
        'selector'      => 'Configuração do Link Rápido',
        'tab'           => 'Aba',
        'type'          => 'Tipo de entidade',
    ],
    'helpers'           => [
        'dashboard' => 'Faça com que o link rápido seja direcionado a um dos dashboards personalizados da campanha.',
        'entity'    => 'Configure este link rápido para ir diretamente a uma entidade. O campo :tab controla qual das abas está focada. O campo :menu controla qual subpágina da entidade é aberta.',
        'position'  => 'Use este campo para controlar em qual ordem crescente os links aparecem no menu.',
        'random'    => 'Use este campo para ter um link rápido indo para uma entidade aleatória. Você pode filtrar o link para que ele vá para um tipo específico de entidade.',
        'selector'  => 'Configure para onde este link rápido vai quando um usuário clica nele na barra lateral.',
        'type'      => 'Configure este link rápido para ir diretamente para uma lista de entidades. Para filtrar os resultados, copie partes da url na lista de entidades filtradas após o sinal :? no campo de filtro :filter.',
    ],
    'index'             => [
        'add'   => 'Novo link rápido',
        'title' => 'Links rápidos',
    ],
    'placeholders'      => [
        'entity'    => 'Escolha uma entidade',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Subpágina do menu (use o último texto da url)',
        'name'      => 'Nome do link rápido',
        'tab'       => 'Registro, relações, notas',
    ],
    'random_no_entity'  => 'Nenhuma entidade aleatória encontrada.',
    'random_types'      => [
        'any'   => 'Qualquer entidade',
    ],
    'reorder'           => [
        'success'   => 'Links rápidos reordenados.',
        'title'     => 'Reordenar links rápidos',
    ],
    'show'              => [
        'tabs'  => [
        ],
        'title' => 'Link rápido :name',
    ],
];
