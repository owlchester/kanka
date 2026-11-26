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
    'share'     => [
        'add_member'            => 'Conceder o restringir el acceso a un miembro…',
        'advanced'              => 'Permisos avanzados',
        'custom'                => 'Personalizado',
        'default'               => 'Predeterminado (heredado)',
        'edit'                  => 'Puede editar',
        'inherited_allow'       => 'Heredado: puede ver',
        'inherited_deny'        => 'Heredado: sin acceso',
        'members_empty'         => 'Ningún miembro tiene permisos de acceso personalizados. Usa el campo de búsqueda de arriba para agregar uno.',
        'members_title'         => 'Miembros con acceso personalizado',
        'no_access'             => 'Sin acceso',
        'overridden_private'    => 'No se aplica si la entrada es privada',
        'remove'                => 'Quitar permiso personalizado',
        'roles_title'           => 'Roles',
        'view'                  => 'Puede ver',
    ],
    'toggle'    => [
        'current'   => 'Actual',
        'label'     => 'Privacidad de la entidad',
        'private'   => [
            'description'   => 'Visible solo para los miembros con el rol :admin.',
            'title'         => 'Privado',
        ],
        'public'    => [
            'description'   => 'Visible para los siguientes roles y miembros.',
            'helper'        => 'Cualquier persona con acceso a este mundo puede ver esta entrada, según los permisos de su rol.',
            'title'         => 'Público',
        ],
    ],
];
