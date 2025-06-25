<?php

return [
    'create'        => [
        'title' => 'Nueva organización',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'Extinta',
        'members'       => 'Miembros',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_defunct'    => 'Esta organización ha desaparecido.',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'           => 'Añadir miembro',
            'add_multiple'  => 'Agregar miembros',
        ],
        'create'        => [
            'helper'            => 'Agregar uno o varios miembros a :name.',
            'success_multiple'  => '{1} Se agregó :count miembro a :name.|[2,*] Se agregaron :count miembros a :name.',
            'title_multiple'    => 'Nuevos miembros',
        ],
        'destroy'       => [
            'success'   => 'Miembro borrado de la organización.',
        ],
        'edit'          => [
            'success'   => 'Miembro de la organización actualizado.',
            'title'     => 'Actualizar miembro de :name',
        ],
        'fields'        => [
            'parent'    => 'Superior',
            'pinned'    => 'Fijada',
            'role'      => 'Rol',
            'status'    => 'Estatus de miembro',
        ],
        'helpers'       => [
            'all_members'   => 'Todos los personajes que son miembros de la organización y de los descendientes de esta.',
            'members'       => 'Todos los personajes que pertenecen a esta organización.',
            'pinned'        => 'Elige esta opción si el miembro debe mostrarse en la sección fijada de las entidades asociadas a esta.',
        ],
        'pinned'        => [
            'both'  => 'Ambos',
            'none'  => 'Ninguno',
        ],
        'placeholders'  => [
            'parent'    => 'Quién es el superior de este miembro',
            'role'      => 'Líder, Miembro, Maestro de Espías, Septón Supremo...',
        ],
        'status'        => [
            'active'    => 'Miembro activo',
            'inactive'  => 'Miembro inactivo',
            'unknown'   => 'Estatus desconocido',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Culto, banda, Rebelión, Gremio...',
    ],
    'quests'        => [],
    'show'          => [],
];
