<?php

return [
    'privacy'   => [
        'text'      => 'Esta entidad está configurada como privada. Aún se pueden definir permisos personalizados, pero mientras la entidad sea privada, éstos serán ignorados y sólo los miembros del rol :admin de la campaña podrán ver la entidad.',
        'warning'   => 'Advertencia',
    ],
    'quick'     => [
        'empty-permissions' => 'Ningún rol o usuario fuera de los administradores de campaña tiene acceso a esta entidad.',
        'field'             => 'Edición rápida',
        'manage'            => 'Administrar permisos',
        'options'           => [
            'private'   => 'Privado a todos menos a los administradores',
            'visible'   => 'Visible para',
        ],
        'private'           => 'Solo los administradores pueden ver esta entidad.',
        'public'            => 'Actualmente esta entidad es visible por cualquier usuario o rol con acceso a ella.',
        'screen-reader'     => 'Abrir la configuración de privacidad',
        'success'           => [
            'private'   => ':entity ahora está oculta.',
            'public'    => ':entity es ahora visible.',
        ],
        'title'             => 'Permisos',
        'viewable-by'       => 'Visible por',
    ],
];
