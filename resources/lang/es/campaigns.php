<?php

return [
    'create'        => [
        'helper'                => [
            'first' => '¡Gracias por probar nuestra web! Antes de que prosigamos, necesitamos que nos indiques algo muy simple: el nombre de tu <b> campaña </b>. El nombre de tu mundo que lo separa de los demás, así que tiene que ser único. Si aun no se te ocurre ninguno, no te preocupes, siempre <b>puedes cambiarlo despues</b>, o crear otras campañas.',
            'second'=> '¡Pero basta de parloteo! Así que... ¿cual escogerás?',
            'title' => '¡Bienvenido a :name!',
        ],
        'success'               => 'Campaña creada.',
        'success_first_time'    => '¡Tu campaña ha sido creada! Como es tu primera campaña, hemos rellenado algunas cosas para que te familiarices y con suerte proveerte con algo de inspiración, para que veas que puedes conseguir.',
        'title'                 => 'Crear nueva campaña',
    ],
    'destroy'       => [
        'success'   => 'Campaña eliminada',
    ],
    'edit'          => [
        'success'   => 'Campaña actualizada.',
        'title'     => 'Editar Campaña :campaign',
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
            'button'    => 'Invitar',
            'success'   => 'Invitación enviada.',
            'title'     => 'Invita a alguien a tu campaña',
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
            'title' => 'Editar miembro :name',
        ],
        'fields'    => [
            'joined'    => 'Inscrito',
            'name'      => 'Usuario',
            'role'      => 'Rol',
        ],
        'invite'    => [
            'description'   => 'Puedes invitar a tus amigos a unirse a la campaña si provees su correo electrónico. Una vez acepten la invitación, les veras añadidos como "Visitante". Siempre puedes cancelar la invitación en cualquier momento.',
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
        'description'   => 'Sumario de tu campaña.',
        'locale'        => 'Código de idioma',
        'name'          => 'Nombre de tu campaña',
    ],
    'settings'      => [
        'edit'      => [
            'success'   => 'Ajustes de tu campaña actualizados.',
        ],
        'helper'    => 'Puedes desactivar fácilmente elementos de tu campaña que permanecerán ocultos. Los elementos creados en las categorías ocultas no serán eliminados, solo estarán ocultos.',
    ],
    'show'          => [
        'actions'       => [
            'leave' => 'Abandonar campaña',
        ],
        'description'   => 'Vista detallada de la campaña',
        'tabs'          => [
            'information'   => 'Información',
            'members'       => 'Miembros',
            'settings'      => 'Ajustes',
        ],
        'title'         => 'Campaña :name',
    ],
];
