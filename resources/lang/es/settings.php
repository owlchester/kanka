<?php

return [
    'account'   => [
        'actions'           => [
            'update_email'      => 'Actualizar email',
            'update_password'   => 'Actualizar contraseña',
        ],
        'description'       => 'Actualizar cuenta',
        'email'             => 'Cambiar email',
        'email_success'     => 'Email actualizado.',
        'password'          => 'Cambiar contraseña',
        'password_success'  => 'Contraseña actualizada.',
        'title'             => 'Cuenta',
    ],
    'api'       => [
        'description'           => 'Actualizar configuración de API',
        'experimental'          => '¡Bienvenido a las APIs de Kanka! Estas prestaciones aún son experimentales pero deberían ser lo suficientemente estables para que puedas comunicarte con las APIs. Crea un Token de Acceso Personal para usar en tus solicitudes de API, o usa el Token Cliente si quieres que tu app tenga acceso a datos de usuario.',
        'help'                  => 'Kanka ofrecerá próximamente una RESTful API para que aplicaciones terceras puedan conectarse a la app. Aquí se irán mostrando los detalles sobre cómo gestionar tus claves API.',
        'request_permission'    => 'Actualmente estamos construyendo una poderosa RESTful API para que aplicaciones terceras puedan conectarse a la app. Sin embargo, de momento limitamos el número de usuarios que pueden interactuar con la API mientras la pulimos. Si quieres acceder a la API y construir apps guays que interactúan con Kanka, contáctanos y te enviaremos toda la información que necesitas.',
        'title'                 => 'API',
    ],
    'layout'    => [
        'description'   => 'Actualizar opciones de diseño',
        'success'       => 'Opciones de diseño actualizadas.',
        'title'         => 'Diseño',
    ],
    'menu'      => [
        'account'           => 'Cuenta',
        'api'               => 'API',
        'layout'            => 'Diseño',
        'personal_settings' => 'Ajustes personales',
        'profile'           => 'Perfil',
    ],
    'profile'   => [
        'actions'       => [
            'update_profile'    => 'Actualizar perfil',
        ],
        'avatar'        => 'Foto de perfil',
        'description'   => 'Actualizar perfil',
        'success'       => 'Perfil actualizado.',
        'title'         => 'Perfil personal',
    ],
];
