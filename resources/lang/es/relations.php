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
        'relation'  => 'Relación',
        'target'    => 'Objetivo',
        'two_way'   => 'Reflejar relación creada',
    ],
    'hints'         => [
        'two_way'   => 'Al reflejar una relación, ésta se copiará en el objetivo seleccionado. Sin embargo, si editas una, la otra no se verá afectada.',
    ],
    'placeholders'  => [
        'relation'  => 'Naturaleza de la relación',
        'target'    => 'Elige una entidad',
    ],
];
