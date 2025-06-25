<?php

return [
    'call-to-action'    => [
        'max'       => [
            'helper'    => 'No puedes adjuntar más archivos a menos que elimines uno existente.',
            'limit'     => 'Esta entidad ha alcanzado su límite de archivos.',
        ],
        'upgrade'   => [
            'limit'     => 'Has alcanzado el límite de :limit archivos para esta entidad.',
            'upgrade'   => 'Actualiza a una campaña premium para adjuntar hasta :limit archivos y desbloquear aún más flexibilidad creativa.',
        ],
    ],
    'create'            => [
        'helper'            => 'Agrega un archivo a :name. El archivo contará para el límite de almacenamiento de la galería.',
        'success_plural'    => '{1} Archivo :name añadido.|[2,*] :count archivos añadidos.',
        'title'             => 'Nuevo archivo para :entity',
    ],
    'destroy'           => [
        'success'   => 'Archivo :file eliminado.',
    ],
    'fields'            => [
        'file'  => 'Archivo',
        'files' => 'Archivos',
        'name'  => 'Nombre del archivo',
    ],
    'max'               => [
        'title' => 'Límite alcanzado',
    ],
    'update'            => [
        'success'   => 'Archivo :file actualizado.',
        'title'     => 'Actualizar archivo',
    ],
];
