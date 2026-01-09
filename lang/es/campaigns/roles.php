<?php

return [
    'actions'       => [
        'status'    => 'Estado: :status',
    ],
    'create'        => [
        'helper'    => 'Crea un nuevo rol para la campaña.',
    ],
    'overview'      => [
        'limited'   => ':amount de :total roles creados.',
        'title'     => 'Roles disponibles',
        'unlimited' => ':amount de roles ilimitados creados.',
    ],
    'permissions'   => [
        'campaign-features' => 'Funciones de la campaña',
        'content-modules'   => 'Módulos de contenido',
        'toggle'            => [
            'action'    => 'Cambiar todo',
            'tooltip'   => 'Cambiar el permiso :action para todos los módulos.',
        ],
    ],
    'public'        => [
        'helpers'   => [
            'click'     => 'Haz clic en cualquier módulo para cambiar el acceso público a todas las entidades que contiene.',
            'intro'     => 'Controla lo que los no miembros pueden ver en la campaña.',
            'main'      => 'Selecciona qué módulos son visibles para cualquiera que vea la campaña, tanto si ha iniciado sesión como si no. Esto incluye a visitantes públicos y a usuarios de Kanka que no son miembros de la campaña.',
            'preview'   => 'Vista previa como no miembro',
        ],
    ],
    'show'          => [
        'title' => 'permisos de :role - :campaign',
    ],
    'toggle'        => [
        'disabled'  => 'Los miembros del rol :role ya no pueden :action :entities',
        'enabled'   => 'Los miembros del rol :role ahora pueden :action :entities',
    ],
    'warnings'      => [
        'adding-to-admin'   => 'Los miembros del rol :name tienen acceso a todo en la campaña, y no pueden ser eliminados por otros miembros del rol. Después de :amount de minutos, sólo ellos pueden darse de baja del rol.',
    ],
];
