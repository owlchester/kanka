<?php

return [
    'actions'   => [
        'status'    => 'Estado: :status',
    ],
    'overview'  => [
        'limited'   => ':amount de :total roles creados.',
        'title'     => 'Roles disponibles',
        'unlimited' => ':amount de roles ilimitados creados.',
    ],
    'public'    => [
        'campaign'      => [
            'private'   => 'La campaña es privada actualmente.',
            'public'    => 'La campaña es pública actualmente.',
        ],
        'description'   => 'Establezca los permisos para que el rol público pueda ver las entidades de los siguientes módulos de la campaña. Se considera que un usuario tiene el rol público si está viendo la campaña sin ser uno de sus miembros.',
        'test'          => 'Para comprobar los permisos del rol público, abra el panel de control de la campaña :url en una ventana de incógnito.',
    ],
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
