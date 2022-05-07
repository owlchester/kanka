<?php

return [
    'actions'       => [
        'mode-map'      => 'Explorador de relaciones',
        'mode-table'    => 'Tabla de relaciones y conexiones',
    ],
    'bulk'          => [
        'delete'    => '{1} Se ha eliminado :count relación.|[2,*] Se han eliminado :count relaciones.',
        'success'   => [
            'editing'           => '{1} Se ha actualizado :count relación.|[2,*] Se han actualizado :count relaciones.',
            'editing_partial'   => '{1} Se ha eliminado :count/:total relación.|[2,*] Se han eliminado :count/:total relaciones.',
        ],
    ],
    'connections'   => [
        'map_point'         => 'Punto de mapa',
        'mention'           => 'Mención',
        'quest_element'     => 'Elemento de una misión',
        'timeline_element'  => 'Elemento de una línea de tiempo',
    ],
    'create'        => [
        'new_title' => 'Nueva relación',
        'success'   => 'Relación :target añadida a :entity.',
        'title'     => 'Nueva relación para :name',
    ],
    'destroy'       => [
        'success'   => 'Relación :target eliminada de :entity.',
    ],
    'fields'        => [
        'attitude'          => 'Actitud',
        'connection'        => 'Conexión',
        'is_star'           => 'Fijada',
        'owner'             => 'Fuente',
        'relation'          => 'Relación',
        'target'            => 'Objetivo',
        'target_relation'   => 'Relación objetivo',
        'two_way'           => 'Reflejar relación',
    ],
    'helper'        => 'Crea relaciones entre entidades y configura su actitud y visibilidad. Las relaciones también se pueden fijar al menú de la entidad.',
    'hints'         => [
        'attitude'          => 'Aquí se puede definir opcionalmente el orden en el que las relaciones aparecen por defecto de forma descendiente.',
        'mirrored'          => [
            'text'  => 'Esta relación está reflejada en :link.',
            'title' => 'Reflejada',
        ],
        'target_relation'   => 'La descripción de la relación en el objetivo. Déjalo en blanco para usar el texto de esta relación.',
        'two_way'           => 'Al reflejar una relación, ésta se copiará en el objetivo seleccionado. Sin embargo, si editas una, la otra no se verá afectada.',
    ],
    'index'         => [
        'title' => 'Relaciones',
    ],
    'options'       => [
        'mentions'  => 'Relaciones + relacionadas + menciones',
        'related'   => 'Relaciones + relacionadas',
        'relations' => 'Relaciones',
        'show'      => 'Mostrar',
    ],
    'panels'        => [
        'related'   => 'Eliminar',
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
        'family_member'         => 'Familiar',
        'organisation_member'   => 'Miembro de organización',
    ],
    'update'        => [
        'success'   => 'Relación :target de :entity actualizada.',
        'title'     => 'Actualizar relaciones de :name',
    ],
];
