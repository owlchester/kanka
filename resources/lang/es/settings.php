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
    'boost'     => [
        'benefits'      => [
            'first'     => 'Para asegurar un progreso contínuo en Kanka, algunas características de campaña se pueden desbloquear mejorando la campaña. Las mejoras se desbloquean mediante :patreon. Cualquiera que pueda ver una campaña puede mejorarla; así el máster no tiene que pagar la cuenta siempre. Una campaña permanece mejorada mientras un usuario la esté mejorando y continúe apoyando a Kanka en :patreon. Si una campaña deja de estar mejorada, los datos no se pierden: solo permanecen ocultos hasta que la campaña vuelva a ser mejorada.',
            'header'    => 'Imágenes de cabecera para las entidades.',
            'more'      => 'Saber más sobre todas las características.',
            'second'    => 'Mejorar una campaña activa los siguientes beneficios:',
            'theme'     => 'Tema y estilo personalizado a nivel de campaña.',
            'tooltip'   => 'Descripciones emergentes personalizadas para las entidades.',
            'upload'    => 'Capacidad de subida de archivos ampliada para todos los miembros de la campaña.',
        ],
        'buttons'       => [
            'boost' => 'Mejorar',
        ],
        'campaigns'     => 'Campañas mejoradas :count / :max',
        'exceptions'    => [
            'already_boosted'   => 'La campaña :name ya está mejorada.',
            'exhausted_boosts'  => 'Te has quedado sin mejoras. Elimina tu mejora de una campaña antes de dársela a otra.',
        ],
        'success'       => [
            'boost' => 'Campaña :name mejorada.',
            'delete'=> 'Tu mejora de :name se ha eliminado.',
        ],
        'title'         => 'Mejorar',
    ],
    'layout'    => [
        'description'   => 'Actualizar opciones de diseño',
        'success'       => 'Opciones de diseño actualizadas.',
        'title'         => 'Diseño',
    ],
    'menu'      => [
        'account'           => 'Cuenta',
        'api'               => 'API',
        'boost'             => 'Mejorar',
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
