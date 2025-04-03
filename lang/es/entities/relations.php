<?php

return [
    'actions'           => [
        'mode-map'      => 'Explorador de relaciones',
        'mode-table'    => 'Tabla de relaciones y conexiones',
    ],
    'bulk'              => [
        'delete'    => '{1} Se ha eliminado :count relación.|[2,*] Se han eliminado :count relaciones.',
        'fields'    => [
            'delete_mirrored'   => 'Borrar duplicado',
            'unmirror'          => 'Desenlazar duplicado',
            'update_mirrored'   => 'Actualizar duplicado',
        ],
        'helpers'   => [
            'delete_mirrored'   => 'Elimina también las conexiones duplicadas.',
            'unmirror'          => 'Desenlazar conexiones duplicadas.',
            'update_mirrored'   => 'Actualizar las conexiones duplicadas.',
        ],
        'success'   => [
            'editing'           => '{1} Se ha actualizado :count relación.|[2,*] Se han actualizado :count relaciones.',
            'editing_partial'   => '{1} Se ha eliminado :count/:total relación.|[2,*] Se han eliminado :count/:total relaciones.',
        ],
    ],
    'call-to-action'    => 'Explore visualmente las conexiones de esta entidad y cómo se relaciona con el resto de la campaña.',
    'connections'       => [
        'map_point'         => 'Punto de mapa',
        'mention'           => 'Mención',
        'quest_element'     => 'Elemento de una misión',
        'timeline_element'  => 'Elemento de una línea de tiempo',
    ],
    'create'            => [
        'new_title'     => 'Nueva relación',
        'success_bulk'  => '{1} Se ha añadido :count conexión a :entity.|[2,*] Se han añadido :count conexiones a :entity.',
    ],
    'delete_mirrored'   => [
        'helper'    => 'Esta conexión se refleja en la entidad de destino. Seleccione esta opción para eliminar también la conexión duplicada.',
        'option'    => 'Borrar conexión duplicada',
    ],
    'destroy'           => [
        'mirrored'  => 'Esto también eliminará la conexión duplicada permanentemente.',
        'success'   => 'Relación :target eliminada de :entity.',
    ],
    'fields'            => [
        'attitude'          => 'Actitud',
        'connection'        => 'Conexión',
        'is_pinned'         => 'Fijado',
        'owner'             => 'Fuente',
        'relation'          => 'Relación',
        'target'            => 'Objetivo',
        'target_relation'   => 'Relación objetivo',
        'two_way'           => 'Reflejar relación',
        'unmirror'          => 'Desenlaza esta conexión.',
    ],
    'filters'           => [
        'connection'    => 'Relación de conexión',
        'name'          => 'Objetivo de la conexión',
    ],
    'helper'            => 'Crea relaciones entre entidades y configura su actitud y visibilidad. Las relaciones también se pueden fijar al menú de la entidad.',
    'helpers'           => [
        'no_relations'  => 'Esta entidad no tiene actualmente ninguna conexión con otras entidades de la campaña.',
        'popup'         => 'Las entidades de la campaña pueden vincularse entre sí mediante conexiones. Estas pueden tener una descripción, una valoración de actitud, una visibilidad para controlar quién ve una conexión, etc.',
    ],
    'hints'             => [
        'attitude'          => 'Aquí se puede definir opcionalmente el orden en el que las relaciones aparecen por defecto de forma descendiente.',
        'mirrored'          => [
            'text'  => 'Esta relación está reflejada en :link.',
            'title' => 'Reflejada',
        ],
        'target_relation'   => 'La descripción de la relación en el objetivo. Déjalo en blanco para usar el texto de esta relación.',
        'two_way'           => 'Al reflejar una relación, ésta se copiará en el objetivo seleccionado. Sin embargo, si editas una, la otra no se verá afectada.',
    ],
    'index'             => [
        'title' => 'Relaciones',
    ],
    'options'           => [
        'mentions'          => 'Relaciones + relacionadas + menciones',
        'only_relations'    => 'Sólo conexión directa',
        'related'           => 'Relaciones + relacionadas',
        'relations'         => 'Relaciones',
        'show'              => 'Mostrar',
    ],
    'panels'            => [
        'related'   => 'Eliminar',
    ],
    'placeholders'      => [
        'attitude'          => 'Desde -100 hasta 100, siendo 100 muy positiva.',
        'relation'          => 'Rival, mejor amiga, hermano...',
        'target'            => 'Elige una entidad',
        'target_relation'   => 'Dejar en blanco para utilizar la descripción',
    ],
    'show'              => [
        'title' => 'Relaciones de :name',
    ],
    'types'             => [
        'family_member'         => 'Familiar',
        'organisation_member'   => 'Miembro de organización',
    ],
    'update'            => [
        'success'   => 'Relación :target de :entity actualizada.',
        'title'     => 'Actualizar relaciones de :name',
    ],
];
