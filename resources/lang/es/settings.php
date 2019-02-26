<?php

return [
    'account'   => [
        'actions'           => [
            'social'            => 'Cambiar a inicio de sesión en Kanka',
            'update_email'      => 'Actualizar email',
            'update_password'   => 'Actualizar contraseña',
        ],
        'description'       => 'Actualizar cuenta',
        'email'             => 'Cambiar email',
        'email_success'     => 'Email actualizado.',
        'password'          => 'Cambiar contraseña',
        'password_success'  => 'Contraseña actualizada.',
        'social'            => [
            'error'     => 'Ya estás utilizando el inicio de sesión de Kanka con esta cuenta.',
            'helper'    => 'Tu cuenta está vinculada con :provider. Puedes dejar de usarla y cambiar al inicio de sesión estándar de Kanka escribiendo una contraseña.',
            'success'   => 'Tu cuenta ahora usa el inicio de sesión de Kanka.',
            'title'     => 'De social a Kanka',
        ],
        'title'             => 'Cuenta',
    ],
    'api'       => [
        'description'           => 'Actualizar configuración de API',
        'experimental'          => '¡Bienvenido a las APIs de Kanka! Estas prestaciones aún son experimentales pero deberían ser lo suficientemente estables para que puedas comunicarte con las APIs. Crea un Token de Acceso Personal para usar en tus solicitudes de API, o usa el Token Cliente si quieres que tu app tenga acceso a datos de usuario.',
        'help'                  => 'Kanka ofrecerá próximamente una RESTful API para que aplicaciones terceras puedan conectarse a la app. Aquí se irán mostrando los detalles sobre cómo gestionar tus claves API.',
        'link'                  => 'Leer la documentación de la API',
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
        'patreon'           => 'Patreon',
        'personal_settings' => 'Ajustes personales',
        'profile'           => 'Perfil',
    ],
    'patreon'   => [
        'actions'       => [
            'link'  => 'Enlazar cuenta',
            'view'  => 'Visita la página de Patreon de Kanka',
        ],
        'benefits'      => 'Si nos ayudas en Patreon podrás subir imágenes más pesadas, y así nos ayudarás a cubrir los costes del servidor y a dedicarle más tiempo a trabajar en Kanka.',
        'description'   => 'Sincronizando con Patreon',
        'errors'        => [
            'invalid_token' => '¡Token no válido! Patreon no ha podido validar tu petición.',
            'missing_code'  => '¡Falta el código! Patreon no ha enviado un código para identificar tu cuenta.',
            'no_pledge'     => '¡Sin "pledge"! Patreon ha identificado tu cuenta, pero no detecta ningún "pledge" activo.',
        ],
        'link'          => 'Usa el siguiente botón si estás apoyando a Kanka en Patreon actualmente. ¡Esto te dará acceso a más cosas fantásticas extras!',
        'linked'        => '¡Gracias por apoyar a Kanka en Patreon! Se ha enlazado tu cuenta.',
        'pledge'        => 'Pledge :name',
        'success'       => '¡Gracias por apoyar a Kanka en Patreon!',
        'title'         => 'Patreon',
        'wrong_pledge'  => 'Añadimos manualmente tu nivel de "pledge", así que ten en cuenta que podemos tardar unos pocos días. Si al cabo de un tiempo sigue sin estar bien, contáctanos por favor.',
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
