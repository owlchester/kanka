<?php

return [
    'actions'       => [
        'copy'      => 'Copiar',
        'transfer'  => 'Transferir',
    ],
    'errors'        => [
        'permission'        => 'No tienes permiso para crear entidades de este tipo en la campaña objetivo.',
        'permission_update' => 'No tienes permiso para mover esta entidad.',
        'same_campaign'     => 'Tienes que seleccionar otra campaña adonde mover la entidad.',
        'unknown_campaign'  => 'Campaña desconocida.',
    ],
    'fields'        => [
        'campaign'      => 'Campaña objetivo',
        'copy'          => 'Hacer una copia',
        'select_one'    => 'Seleccionar campaña',
    ],
    'helpers'       => [
        'copy'  => 'Crea una copia de la entidad en la campaña destino.',
    ],
    'panel'         => [
        'description'           => 'Selecciona una campaña adonde quieras mover o copiar esta entidad.',
        'description_bulk_copy' => 'Selecciona una campaña adonde quieras copiar las entidades seleccionadas.',
        'title'                 => 'Mover o copiar una entidad a otra campaña',
    ],
    'success'       => 'Entidad :name movida.',
    'success_copy'  => 'Entidad :name copiada.',
    'title'         => 'Mover :name',
    'warnings'      => [
        'custom'    => 'Esta entidad no es de un módulo por defecto, sino de un tipo de entidad personalizada ":module". Se creará como una entidad Nota en la campaña de destino.',
    ],
];
