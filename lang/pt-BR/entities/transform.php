<?php

return [
    'actions'   => [],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Tipo de entidade desconhecida ou inválida.',
        ],
        'success'   => '{1} :count entidade transformada ao novo tipo: :type.|[2,*] :count entidades transformadas ao novo tipo: :type',
    ],
    'fields'    => [
        'current'       => 'Módulo atual',
        'select_one'    => 'Selecione um',
        'target'        => 'Novo tipo de entidade',
    ],
    'panel'     => [
        'bulk_description'  => 'Altere o tipo de entidade de várias entidades. Esteja ciente de que alguns dados podem ser perdidos devido aos diferentes campos entre os tipos de entidade.',
        'bulk_title'        => 'Transformar entidades em massa',
        'title'             => 'Transformar uma entidade',
    ],
    'success'   => 'Entidade :name transformada.',
    'title'     => 'Transformar :name',
];
