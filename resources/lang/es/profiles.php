<?php

return [
    'avatar'        => [
        'success'   => 'Avatar actualizado.',
    ],
    'description'   => 'Actualiza los detalles de tu perfil',
    'edit'          => [
        'success'   => 'Perfil actualizado',
    ],
    'editors'       => [
        'legacy'        => 'Obsoleto (TinyMCE 4)',
        'summernote'    => 'Summernote',
    ],
    'fields'        => [
        'avatar'                    => 'Avatar',
        'email'                     => 'Correo Electronico',
        'hide_subscription'         => 'Ocultar mi nombre del :hall_of_fame.',
        'last_login_share'          => 'Compartir la última vez que estuve en línea con otros miembros de la campaña.',
        'name'                      => 'Nombre',
        'new_password'              => 'Contraseña nueva',
        'new_password_confirmation' => 'Confirmar nueva contraseña',
        'newsletter'                => 'Me gustaría recibir noticias de la web por correo electrónico.',
        'password'                  => 'Contraseña actual',
        'settings'                  => 'Ajustes',
        'theme'                     => 'Tema',
    ],
    'newsletter'    => [
        'links'     => [
            'community-vote'    => 'Votación comunitaria',
            'news'              => 'Novedades',
        ],
        'settings'  => [
            'news'          => 'Novedades - Notificarme cuando haya :news',
            'newsletter'    => 'Newsletter - Recibe la newsletter de Kanka',
            'votes'         => 'Votaciones comunitarias - Notificarme cuando una nueva :vote esté disponible',
        ],
        'title'     => 'Newsletters',
    ],
    'password'      => [
        'success'   => 'Contraseña actualizada',
    ],
    'placeholders'  => [
        'email'                     => 'Tu correo electrónico',
        'name'                      => 'Tu nombre de usuario',
        'new_password'              => 'Tu nueva contraseña',
        'new_password_confirmation' => 'Confirma tu nueva contraseña',
        'password'                  => 'Escribe tu contraseña actual para aplicar los cambios',
    ],
    'sections'      => [
        'delete'    => [
            'delete'    => 'Eliminar cuenta',
            'helper'    => 'Eliminar tu cuenta también eliminara cualquier campaña de la que seas el único miembro. Esta acción es permanente y no se puede deshacer.',
            'title'     => 'Elimina tu cuenta',
            'warning'   => 'Al eliminar tu cuenta todos tus datos serán borrados. ¿Estás seguro?',
        ],
        'password'  => [
            'title' => 'Cambia tu contraseña',
        ],
    ],
    'settings'      => [
        'fields'    => [
            'advanced_mentions'     => 'Menciones avanzadas',
            'date_format'           => 'Formato de fecha',
            'default_nested'        => 'Vista anidada por defecto',
            'editor'                => 'Editor de texto',
            'new_entity_workflow'   => 'Nuevo flujo de creación de entidades',
            'pagination'            => 'Paginación (elementos por página)',
        ],
        'helpers'   => [
            'editor_v2' => 'El editor de texto obsoleto (TinyMCE) no soporta menciones en dispositivos móviles ni algunas funcionalidades como la galería de campaña.',
        ],
        'hints'     => [
            'advanced_mentions'     => 'Al activarlo, las menciones siempre se renderizarán como [entity:123] al editar una entidad.',
            'default_nested'        => 'Activa esta opción si quieres que las listas estén en vista anidada por defecto (cuando sea posible).',
            'new_entity_workflow'   => 'Al crear una nueva entidad, por defecto se te redirecciona a la lista de entidades. En vez de esto, puedes ir directamente a la entidad que acabas de crear.',
        ],
        'success'   => 'Ajustes cambiados.',
    ],
    'theme'         => [
        'success'   => 'Tema cambiado.',
        'themes'    => [
            'dark'      => 'Oscuro',
            'default'   => 'Por defecto',
            'future'    => 'Futuro',
            'midnight'  => 'Azul medianoche',
        ],
    ],
    'title'         => 'Actualizar perfil',
    'workflows'     => [
        'created'   => 'Ir a la entidad recién creada',
        'default'   => 'Lista de entidades',
    ],
];
