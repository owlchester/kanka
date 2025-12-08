<?php

return [
    'actions'   => [
        'status'    => 'Estado: :status',
    ],
    'create'    => [
        'helper'    => 'Crea un nuevo rol para la campaña.',
    ],
    'overview'  => [
        'limited'   => ':amount de :total roles creados.',
        'title'     => 'Roles disponibles',
        'unlimited' => ':amount de roles ilimitados creados.',
    ],
    'public'    => [],
    'show'      => [
        'title' => 'permisos de :role - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Los miembros del rol :role ya no pueden :action :entities',
        'enabled'   => 'Los miembros del rol :role ahora pueden :action :entities',
    ],
    'warnings'  => [
        'adding-to-admin'   => 'Los miembros del rol :name tienen acceso a todo en la campaña, y no pueden ser eliminados por otros miembros del rol. Después de :amount de minutos, sólo ellos pueden darse de baja del rol.',
    ],
];
