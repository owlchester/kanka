<?php

return [
    'create'        => [
        'template'  => [
            'helper'    => 'Los administradores de la campaña han definido los siguientes posts como plantillas que pueden reutilizarse.',
        ],
        'title'     => 'Nuevo post',
    ],
    'fields'        => [
        'name'  => 'Nombre',
    ],
    'helpers'       => [
        'new'           => 'Añadir un nuevo post a esta entidad.',
        'visibility'    => 'Cambia la visibilidad del post :name.',
    ],
    'move'          => [
        'copy'      => [
            'helper'    => 'Mantén una copia del post en :name.',
        ],
        'helper'    => 'Mueve o copia el post :name a una entidad diferente.',
        'title'     => 'Mover post',
    ],
    'permissions'   => [
        'actions'   => [
            'members'   => 'Agregar miembros',
            'roles'     => 'Agregar roles',
        ],
        'helpers'   => [
            'members'   => 'Agrega uno o varios miembros para que tengan permisos especiales en este post.',
            'roles'     => 'Agrega uno o varios roles para que tengan permisos especiales en este post.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Nombre del post',
    ],
    'position'      => [
        'dont_change'   => 'No cambiar',
        'first'         => 'Primero',
        'last'          => 'Último',
    ],
    'remove'        => [
        'title' => 'Eliminar publicación',
    ],
    'visibility'    => [
        'helper'    => 'Cambia la visibilidad del post :name.',
        'title'     => 'Visibilidad del post',
    ],
];
