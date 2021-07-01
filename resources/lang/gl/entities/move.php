<?php

return [
    'actions'       => [
        'copy'  => 'Copiar',
        'move'  => 'Mover',
    ],
    'errors'        => [
        'permission'        => 'Non tes permiso para crear entidades deste tipo na campaña obxectivo.',
        'permission_update' => 'Non tes permiso para mover esta entidade.',
        'same_campaign'     => 'Precisas selecionar outra campaña á que mover a entidade.',
        'unknown_campaign'  => 'Campaña descoñecida.',
    ],
    'fields'        => [
        'campaign'      => 'Campaña obxectivo',
        'copy'          => 'Facer unha copia',
        'select_one'    => 'Seleccionar unha campaña',
    ],
    'panel'         => [
        'description'           => 'Selecionar unha campaña á que queiras mover esta entidade ou na que facer unha copia dela.',
        'description_bulk_copy' => 'Selecciona unha campaña na que queiras copiar as entidades seleccionadas.',
        'title'                 => 'Mover ou copiar unha entidade a outra campaña',
    ],
    'success'       => 'Entidade ":name" movida.',
    'success_copy'  => 'Entidade ":name" copiada.',
    'title'         => 'Mover ":name"',
];
