<?php

return [
    'create'        => [
        'success'   => 'Relación :target añadida a :entity.',
        'title'     => 'Nueva relación para :name',
    ],
    'destroy'       => [
        'success'   => 'Relación :target eliminada de :entity.',
    ],
    'fields'        => [
        'attitude'  => 'Actitud',
        'is_star'   => 'Fijada',
        'relation'  => 'Relación',
        'target'    => 'Objetivo',
        'two_way'   => 'Reflejar relación',
    ],
    'helper'        => 'Crea relaciones entre entidades y configura su actitud y visibilidad. Las relaciones también se pueden fijar al menú de la entidad.',
    'hints'         => [
        'attitude'  => 'Aquí se puede definir opcionalmente el orden en el que las relaciones aparecen por defecto de forma descendiente.',
        'mirrored'  => [
            'text'  => 'Esta relación está reflejada en :link.',
            'title' => 'Reflejada',
        ],
        'two_way'   => 'Al reflejar una relación, ésta se copiará en el objetivo seleccionado. Sin embargo, si editas una, la otra no se verá afectada.',
    ],
    'placeholders'  => [
        'attitude'  => 'Desde -100 hasta 100, siendo 100 muy positiva.',
        'relation'  => 'Rival, mejor amiga, hermano...',
        'target'    => 'Elige una entidad',
    ],
    'show'          => [
        'title' => 'Relaciones de :name',
    ],
    'teaser'        => 'Mejora la campaña para acceder al mapa de relaciones. Haz clic aquí para saber más sobre las campañas mejoradas.',
    'types'         => [
        'family_member' => 'Familiar',
    ],
    'update'        => [
        'success'   => 'Relación :target de :entity actualizada.',
        'title'     => 'Actualizar relaciones de :name',
    ],
];
