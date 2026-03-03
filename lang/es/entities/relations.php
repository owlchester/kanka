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
        'helper'        => 'Crea una conexión entre :name y una o varias entidades.',
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
        'is_pinned'         => 'Fijado',
        'link'              => 'Enlace recíproco',
        'mirror_relation'   => 'Rol recíproco',
        'owner'             => 'Fuente',
        'role'              => 'Rol',
        'target'            => 'Objetivo',
        'targets'           => 'Entidades objetivo',
        'two_way'           => 'Reflejar relación',
        'unmirror'          => 'Desenlaza esta conexión.',
    ],
    'filters'           => [
        'connection'    => 'Relación de conexión',
        'name'          => 'Objetivo de la conexión',
    ],
    'helper'            => 'Crea relaciones entre entidades y configura su actitud y visibilidad. Las relaciones también se pueden fijar al menú de la entidad.',
    'helpers'           => [
        'description'       => 'Detalla la naturaleza de la conexión entre las dos entidades.',
        'link'              => 'Crear una relación coincidente en los objetivos.',
        'mirror_relation'   => 'Cómo ve el objetivo esta entrada (dejar en blanco para copiar lo anterior).',
        'no_relations'      => 'Esta entidad no tiene actualmente ninguna conexión con otras entidades de la campaña.',
    ],
    'hints'             => [
        'attitude'  => 'Aquí se puede definir opcionalmente el orden en el que las relaciones aparecen por defecto de forma descendiente.',
        'two_way'   => 'Al reflejar una relación, ésta se copiará en el objetivo seleccionado. Sin embargo, si editas una, la otra no se verá afectada.',
    ],
    'index'             => [
        'title' => 'Relaciones',
    ],
    'linked'            => [
        'break'             => 'Romper enlace',
        'helper'            => 'Esta relación está sincronizada con :link',
        'label'             => 'Relación vinculada',
        'unmirror-helper'   => 'Convertir esto en una relación independiente no eliminará nada.',
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
        'attitude'  => 'Desde -100 hasta 100, siendo 100 muy positiva.',
        'role'      => 'Rival, Mejor amigo, Hermano',
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
