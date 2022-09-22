<?php

return [
    'actions'   => [
        'transform' => 'Transformar',
    ],
    'bulk'      => [
        'errors'    => [
            'unknown_type'  => 'Tipo de entidade descoñecido ou inválido.',
        ],
        'success'   => '{1} :count entidade transformada ao novo tipo: :type.|[2,*] :count entidades transformadas ao novo tipo: type.',
    ],
    'fields'    => [
        'select_one'    => 'Selecciona un',
        'target'        => 'Novo tipo de entidade',
    ],
    'panel'     => [
        'bulk_description'  => 'Muda o tipo de múltiplos entidades. Ten en conta que algúns datos poden ser perdidos debido aos diferentes campos que hai en distintos tipos de entidade.',
        'bulk_title'        => 'Transformar entidades en bloque',
        'description'       => 'Creaches esta entidade nun tipo pero decatácheste de que quedaba mellor noutro tipo? Non te preocupes, podes cambiar o tipo da entidade en calquera momento. Por favor, ten en conta que algúns datos poden ser perdidos debido aos diferentes campos que hai en distintos tipos de entidade.',
        'title'             => 'Transformar unha entidade',
    ],
    'success'   => 'Entidade ":name" transformada.',
    'title'     => 'Transformar ":name"',
];
