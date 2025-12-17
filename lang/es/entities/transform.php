<?php

return [
    'actions'       => [
        'convert'   => 'Convertir a módulo',
    ],
    'bulk'          => [
        'errors'    => [
            'unknown_type'  => 'Tipo de entidad desconocido o no válido.',
        ],
        'success'   => '{1} Se ha transformado :count entidad al nuevo tipo: :type.|[2,*] Se han transformado :count entidades al nuevo tipo: :type.',
    ],
    'confirm'       => [
        'checkbox'  => 'Entiendo que al transformar :entity a otro módulo, se perderán los siguientes elementos:',
        'label'     => 'Confirmar pérdida de datos',
    ],
    'documentation' => 'Documentación: Conversión de módulos de entidades',
    'fields'        => [
        'current'       => 'Módulo actual',
        'select_one'    => 'Elige una',
        'target'        => 'Nuevo tipo de entidad',
    ],
    'panel'         => [
        'bulk_description'  => 'Cambia el tipo de entidad a múltiples entidades. Ten en cuenta que algunos datos podrían perderse debido a que hay diferentes campos en otras entidades.',
        'bulk_title'        => 'Transformar entidades en lota',
        'title'             => 'Transformar entidad',
        'warning'           => 'Algunos datos pueden no transferirse si el nuevo módulo utiliza campos diferentes.',
    ],
    'success'       => 'Entidad :name transformada.',
    'title'         => 'Transformar :name',
];
