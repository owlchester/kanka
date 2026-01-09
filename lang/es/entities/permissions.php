<?php

return [
    'privacy'   => [
        'text'      => 'Esta entidad está configurada como privada. Aún se pueden definir permisos personalizados, pero mientras la entidad sea privada, éstos serán ignorados y sólo los miembros del rol :admin de la campaña podrán ver la entidad.',
        'warning'   => 'Advertencia',
    ],
    'quick'     => [
        'empty-permissions' => 'Ningún rol o usuario fuera de los administradores de campaña tiene acceso a esta entidad.',
        'manage'            => 'Administrar permisos',
        'screen-reader'     => 'Abrir la configuración de privacidad',
        'success'           => [
            'private'   => ':entity ahora está oculta.',
            'public'    => ':entity es ahora visible.',
        ],
        'title'             => 'Permisos',
        'viewable-by'       => 'Visible por',
    ],
    'toggle'    => [
        'label'     => 'Privacidad de la entidad',
        'private'   => [
            'description'   => 'Visible solo para los miembros con el rol :admin.',
            'title'         => 'Privado',
        ],
        'public'    => [
            'description'   => 'Visible para los siguientes roles y miembros.',
            'title'         => 'Público',
        ],
    ],
];
