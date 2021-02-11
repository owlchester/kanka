<?php

return [
    'create'        => [
        'success'   => 'Acceso directo ":name" creado.',
        'title'     => 'Novo acceso directo',
    ],
    'destroy'       => [
        'success'   => 'Acceso directo ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Acceso directo ":name" actualizado.',
        'title'     => 'Acceso directo ":name"',
    ],
    'fields'        => [
        'entity'        => 'Entidade',
        'filters'       => 'Filtros',
        'menu'          => 'Menú',
        'name'          => 'Nome',
        'position'      => 'Posición',
        'random'        => 'Aleatorio',
        'random_type'   => 'Tipo de entidade aleatorio',
        'tab'           => 'Lapela',
        'type'          => 'Tipo de entidade',
    ],
    'helpers'       => [
        'entity'    => 'Configura este acceso directo para ir directamente a unha entidade. O campo :tab control a lapela á que se accede. O campo :menu control que subpáxina da entidade é aberta.',
        'position'  => 'Usa este campo para controlar en que orde ascendente aparecen as ligazóns no menú.',
        'random'    => 'Usa este campo para ter un acceso directo a unha entidade aleatoria. Podes filtralo para que so vaia a un tipo específico de entidade.',
        'type'      => 'Configura este acceso directo para ir directamente a unha lista de entidades. Para filtrar os resultados, copia as partes da URL da lista filtrada a partir do signo :? no campo :filter.',
    ],
    'index'         => [
        'add'   => 'Novo acceso directo',
        'title' => 'Accesos directos',
    ],
    'placeholders'  => [
        'entity'    => 'Elixe unha entidade',
        'filters'   => 'location_id=15&type=cidade',
        'menu'      => 'Subpáxina do menú (usa a última aprte da URL)',
        'name'      => 'Nome do acceso directo',
        'tab'       => 'Entrada, Relacións, Notas...',
    ],
    'random_types'  => [
        'any'   => 'Calquera entidade',
    ],
    'show'          => [
        'tabs'  => [
            'information'   => 'Información',
        ],
        'title' => 'Acceso directo ":name"',
    ],
];
