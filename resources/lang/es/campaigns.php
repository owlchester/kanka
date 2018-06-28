<?php

return [
    'create'        => [
        'description'           => 'Crear nueva campaña',
        'helper'                => [
            'first' => '¡Gracias por probar nuestra web! Antes de que prosigamos, necesitamos que nos indiques algo muy simple: el nombre de tu <b> campaña </b>. El nombre de tu mundo que lo separa de los demás, así que tiene que ser único. Si aun no se te ocurre ninguno, no te preocupes, siempre <b>puedes cambiarlo despues</b>, o crear otras campañas.',
            'second'=> '¡Pero basta de parloteo! Así que... ¿cual escogerás?',
            'title' => '¡Bienvenido a :name!',
        ],
        'success'               => 'Campaña creada.',
        'success_first_time'    => '¡Tu campaña ha sido creada! Como es tu primera campaña, hemos rellenado algunas cosas para que te familiarices y con suerte proveerte con algo de inspiración, para que veas que puedes conseguir.',
        'title'                 => 'Nueva Campaña',
    ],
    'destroy'       => [
        'success'   => 'Campaña eliminada',
    ],
    'edit'          => [
        'description'   => 'Editar tu campaña',
        'success'       => 'Campaña actualizada.',
        'title'         => 'Editar campaña :campaign',
    ],
    'fields'        => [
        'description'   => 'Descripción',
        'image'         => 'Imagen',
        'locale'        => 'Lugar',
        'name'          => 'Nombre',
    ],
    'index'         => [
        'actions'       => [
            'new'   => [
                'description'   => 'Crear nueva campaña',
                'title'         => 'Nueva campaña',
            ],
        ],
        'add'           => 'Nueva campaña',
        'description'   => 'Gestionar tus campañas.',
        'list'          => 'Tus campañas',
        'select'        => 'Seleccionar una campaña',
        'title'         => 'Campañas',
    ],
    'invites'       => [
        'actions'       => [
            'add'   => 'Invitar',
        ],
        'create'        => [
            'button'        => 'Invitar',
            'description'   => 'Invita a un amigo a tu campaña',
            'success'       => 'Invitación enviada.',
            'title'         => 'Invita a alguien a tu campaña',
        ],
        'destroy'       => [
            'success'   => 'Invitación eliminada.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Unirse a la campaña de :name </a>',
            'subject'   => '¡:name te ha invitado a que te unas a su campaña ":campaign" en kanka.io! Usa el siguiente enlace para aceptar su invitación.',
            'title'     => 'Invitación de :name',
        ],
        'error'         => [
            'already_member'    => 'Ya eres un miembro de esta campaña.',
            'inactive_token'    => 'Este identificador ya ha sido usado o la campaña ya no existe.',
            'invalid_token'     => 'El identificador ya no es valido.',
            'login'             => 'Por favor inicia sesión o registrate para unirte a la campaña.',
        ],
        'fields'        => [
            'created'   => 'Enviado',
            'email'     => 'Correo electrónico',
            'role'      => 'Rol',
        ],
        'placeholders'  => [
            'email' => 'Correo electrónico de la persona a la que quieres invitar',
        ],
    ],
    'leave'         => [
        'confirm'   => '¿Seguro que quieres abandonar la campaña :name? No tendrás acceso a ella, a no ser que el dueño de la campaña te invite de nuevo.',
        'error'     => 'No puedes abandonar la campaña.',
        'success'   => 'Has abandonado la campaña.',
    ],
    'members'       => [
        'create'    => [
            'title' => 'Añade un miembro a tu campaña.',
        ],
        'edit'      => [
            'description'   => 'Editar un miembro de tu campaña',
            'title'         => 'Editar miembro :name',
        ],
        'fields'    => [
            'joined'    => 'Inscrito',
            'name'      => 'Usuario',
            'role'      => 'Rol',
            'roles'     => 'Roles',
        ],
        'help'      => 'No hay límite de miembros que puede tener una campaña, y como Administrador de la campaña, puedes eliminar miembros que ya no están activos.',
        'invite'    => [
            'description'   => 'Puedes invitar a tus amigos a unirse a la campaña si provees su correo electrónico. Una vez acepten la invitación, les verás añadidos como "Visitante". Siempre puedes cancelar la invitación en cualquier momento.',
            'title'         => 'Invitar',
        ],
        'roles'     => [
            'member'    => 'Miembro',
            'owner'     => 'Administrador',
            'viewer'    => 'Invitado',
        ],
        'your_role' => 'Tu eres un <i>:role</i>',
    ],
    'placeholders'  => [
        'description'   => 'Corto resumen de tu campaña',
        'locale'        => 'Código de idioma',
        'name'          => 'Nombre de tu campaña',
    ],
    'roles'         => [
        'actions'       => [
            'add'   => 'Añadir un rol',
        ],
        'create'        => [
            'success'   => 'Rol creado.',
            'title'     => 'Crear un nuevo rol para :name',
        ],
        'destroy'       => [
            'success'   => 'Rol eliminado.',
        ],
        'edit'          => [
            'success'   => 'Rol actualizado.',
            'title'     => 'Editar rol :name',
        ],
        'fields'        => [
            'name'          => 'Nombre',
            'permissions'   => 'Permisos',
            'users'         => 'Usuarios',
        ],
        'helper'        => [
            '1' => 'Una campaña puede tener tantos roles como se quiera. El rol "Admin" tiene acceso automáticamente a todo dentro de una campaña, pero cada uno de los demás roles puede tener permisos específicos en diferentes tipos de entidades (personaje, localización, etc).',
            '2' => 'Las entidades pueden tener permisos más afinados mediante la pestaña "Permisos" de una entidad. Esta pestaña aparece cuando tu campaña tiene varios roles o miembros.',
            '3' => 'Se puede usar un sistema de "exclusión", donde los roles tienen acceso a todas las entidades, y usar la casilla de "Privado" en las entidades que se quieran ocultar. O bien, pueden darse pocos permisos a los roles, y configurar cada entidad para que sea visible individualmente.',
        ],
        'hints'         => [
            'role_permissions'  => 'Habilitar el rol \':name\' para realizar las siguientes acciones en todas las entidades.',
        ],
        'members'       => 'Miembros',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crear',
                'delete'        => 'Eliminar',
                'edit'          => 'Editar',
                'permission'    => 'Administrar permisos',
                'read'          => 'Ver',
            ],
            'hint'      => 'Este rol tiene acceso automático a todo.',
        ],
        'placeholders'  => [
            'name'  => 'Nombre del rol',
        ],
        'show'          => [
            'description'   => 'Miembros y permisos de un rol de campaña',
            'title'         => 'Roles de campaña',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Añadir',
            ],
            'create'    => [
                'success'   => 'Usuario añadido al rol.',
                'title'     => 'Añadir un miembro al rol :name',
            ],
            'destroy'   => [
                'success'   => 'Usuario eliminado del rol.',
            ],
            'fields'    => [
                'name'  => 'Nombre',
            ],
        ],
    ],
    'settings'      => [
        'edit'      => [
            'success'   => 'Ajustes de campaña actualizados.',
        ],
        'helper'    => 'Puedes activar o desactivar fácilmente todos los módulos de una campaña. Desactivar un módulo solo ocultará sus elementos relacionados, no los eliminará. Este cambio afecta a todos los usuarios de una campaña, incluyendo a los Administradores.',
    ],
    'show'          => [
        'actions'       => [
            'leave' => 'Abandonar campaña',
        ],
        'description'   => 'Vista detallada de la campaña',
        'tabs'          => [
            'information'   => 'Información',
            'members'       => 'Miembros',
            'roles'         => 'Roles',
            'settings'      => 'Ajustes',
        ],
        'title'         => 'Campaña :name',
    ],
];
