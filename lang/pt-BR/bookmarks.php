<?php

return [
    'actions'           => [
        'customise' => 'Personalizar barra lateral',
    ],
    'create'            => [
        'title' => 'Novo marcador',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Marcador :name',
    ],
    'fields'            => [
        'active'            => 'Ativo',
        'dashboard'         => 'Dashboard',
        'default_dashboard' => 'Dashboard padrão',
        'filters'           => 'Filtros',
        'menu'              => 'Sub-menu',
        'position'          => 'Posição',
        'random_type'       => 'Tipo Aleatório de Entidade',
        'selector'          => 'Configuração do Marcador',
        'target'            => 'Alvo',
    ],
    'helpers'           => [
        'active'            => 'Marcadores inativos não aparecerão na barra lateral.',
        'css'               => 'Adicione uma classe CSS que será adicionada ao link do marcador na barra lateral.',
        'dashboard'         => 'Faça com que o link rápido seja direcionado a um dos dashboards personalizados da campanha.',
        'default_dashboard' => 'Em vez disso, crie um link para o dashboard padrão da campanha. Um dashboard personalizado ainda precisa ser selecionado.',
        'entity'            => 'Configure este marcador para ir diretamente para uma entidade. O campo :menu controla qual subpágina da entidade será aberta.',
        'position'          => 'Use este campo para controlar em qual ordem crescente os links aparecem no menu.',
        'random'            => 'Use este campo para ter um marcador indo para uma entidade aleatória. Você pode filtrar o link para que ele vá para um tipo específico de entidade.',
        'selector'          => 'Configure para onde este marcador vai quando um usuário clica nele na barra lateral.',
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
        'success'   => 'Marcadores reordenados.',
        'title'     => 'Reordenar marcadores',
    ],
    'show'              => [],
    'targets'           => [
        'dashboard' => 'Um dos dashboards da campanha',
        'entity'    => 'Uma única entidade',
        'random'    => 'Uma entidade aleatória',
        'select'    => 'Escolha uma opção',
        'type'      => 'Lista de entidades de um tipo/módulo de entidade específico',
    ],
    'visibilities'      => [
        'is_active' => 'Mostrar o marcador na barra lateral',
    ],
];
