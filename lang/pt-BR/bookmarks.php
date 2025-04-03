<?php

return [
    'actions'           => [
        'customise' => 'Personalizar barra lateral',
    ],
    'create'            => [
        'title' => 'Novo Link Rápido',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Link rápido :name',
    ],
    'fields'            => [
        'active'            => 'Ativo',
        'dashboard'         => 'Dashboard',
        'default_dashboard' => 'Dashboard padrão',
        'filters'           => 'Filtros',
        'menu'              => 'Sub-menu',
        'position'          => 'Posição',
        'random_type'       => 'Tipo Aleatório de Entidade',
        'selector'          => 'Configuração do Link Rápido',
        'target'            => 'Alvo',
    ],
    'helpers'           => [
        'active'            => 'Links rápidos inativos não aparecerão na barra lateral.',
        'dashboard'         => 'Faça com que o link rápido seja direcionado a um dos dashboards personalizados da campanha.',
        'default_dashboard' => 'Em vez disso, crie um link para o dashboard padrão da campanha. Um dashboard personalizado ainda precisa ser selecionado.',
        'entity'            => 'Configure este link rápido para ir diretamente a uma entidade. O campo :tab controla qual das abas está focada. O campo :menu controla qual subpágina da entidade é aberta.',
        'position'          => 'Use este campo para controlar em qual ordem crescente os links aparecem no menu.',
        'random'            => 'Use este campo para ter um link rápido indo para uma entidade aleatória. Você pode filtrar o link para que ele vá para um tipo específico de entidade.',
        'selector'          => 'Configure para onde este link rápido vai quando um usuário clica nele na barra lateral.',
        'type'              => 'Configure este link rápido para ir diretamente para uma lista de entidades. Para filtrar os resultados, copie partes da url na lista de entidades filtradas após o sinal :? no campo de filtro :filter.',
    ],
    'index'             => [],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Subpágina do menu (use o último texto da url)',
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
    'show'              => [],
    'visibilities'      => [
        'is_active' => 'Mostrar o link rápido na barra lateral',
    ],
];
