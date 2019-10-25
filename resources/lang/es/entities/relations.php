<?php

return [
    'create'        => [
        'description'   => 'Crear nueva relación',
        'success'       => 'Relación de :name añadida.',
        'title'         => 'Crear Relación',
    ],
    'destroy'       => [
        'success'   => 'Relación de :name eliminada.',
    ],
    'edit'          => [
        'success'   => 'Relación de :name actualizada.',
        'title'     => 'Actualizar relaciones',
    ],
    'fields'        => [
        'attitude'  => 'Actitud',
        'is_star'   => 'Fijada',
        'relation'  => 'Relación',
        'target'    => 'Objetivo',
        'two_way'   => 'Reflejar relación creada',
    ],
    'hints'         => [
        'mirrored'  => [
            'text'  => 'Esta relación está reflejada en :link.',
            'title' => 'Reflejada',
        ],
        'two_way'   => 'Al reflejar una relación, ésta se copiará en el objetivo seleccionado. Sin embargo, si editas una, la otra no se verá afectada.',
    ],
    'placeholders'  => [
        'attitude'  => 'Desde -100 hasta 100, siendo 100 muy positiva.',
        'relation'  => 'Naturaleza de la relación',
        'target'    => 'Elige una entidad',
    ],
];
