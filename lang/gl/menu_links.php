<?php

return [
    'create'            => [
        'title' => 'Novo acceso directo',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Acceso directo ":name"',
    ],
    'fields'            => [
        'dashboard'         => 'Taboleiro',
        'default_dashboard' => 'Taboleiro por defecto',
        'entity'            => 'Entidade',
        'filters'           => 'Filtros',
        'is_nested'         => 'En árbore',
        'menu'              => 'Menú',
        'position'          => 'Posición',
        'random'            => 'Aleatorio',
        'random_type'       => 'Tipo de entidade aleatorio',
        'selector'          => 'Configuración do acceso directo',
        'type'              => 'Tipo de entidade',
    ],
    'helpers'           => [
        'dashboard'         => 'Fai que o acceso directo ligue a un dos taboleiros personalizados da campaña.',
        'default_dashboard' => 'Liga ao taboleiro por defecto da campaña. Un taboleiro personalizado aínda precisa ser seleccionado.',
        'entity'            => 'Configura este acceso directo para ir directamente a unha entidade. O campo :tab control a lapela á que se accede. O campo :menu control que subpáxina da entidade é aberta.',
        'position'          => 'Usa este campo para controlar en que orde ascendente aparecen as ligazóns no menú.',
        'random'            => 'Usa este campo para ter un acceso directo a unha entidade aleatoria. Podes filtralo para que so vaia a un tipo específico de entidade.',
        'selector'          => 'Configura a onde liga este acceso directo cando alguén fai clic nel.',
        'type'              => 'Configura este acceso directo para ir directamente a unha lista de entidades. Para filtrar os resultados, copia as partes da URL da lista filtrada a partir do signo :? no campo :filter.',
    ],
    'index'             => [],
    'placeholders'      => [
        'entity'    => 'Elixe unha entidade',
        'filters'   => 'location_id=15&type=cidade',
        'menu'      => 'Subpáxina do menú (usa a última parte da URL)',
        'name'      => 'Nome do acceso directo',
        'tab'       => 'Entrada, Relacións, Notas...',
    ],
    'random_no_entity'  => 'Entidade aleatoria non encontrada.',
    'random_types'      => [
        'any'   => 'Calquera entidade',
    ],
    'reorder'           => [
        'success'   => 'Accesos directos reordenados.',
        'title'     => 'Reordenar accesos directos',
    ],
    'show'              => [],
];
