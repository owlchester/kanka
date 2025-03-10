<?php

return [
    'actions'       => [
        'create'    => 'Crear módulo',
        'customise' => 'Personalizar',
    ],
    'create'        => [
        'helper'    => 'Crear un nuevo módulo personalizado para almacenar entidades que no encajan en los otros módulos.',
        'success'   => 'Se ha creado un nuevo módulo.',
        'title'     => 'Nuevo módulo',
    ],
    'delete'        => [
        'confirm'   => 'Escribe :code si estás seguro de que deseas eliminar definitivamente el módulo personalizado :name.',
        'helper'    => '¿Estás seguro de que quieres eliminar el módulo personalizado :name ? Esto también eliminará permanentemente todas las entidades, marcadores y widgets vinculados a este módulo.',
        'success'   => 'Módulo :name eliminado.',
        'title'     => 'Eliminación de módulos',
    ],
    'errors'        => [
        'disabled'  => 'El módulo :name está desactivado. :fix',
        'limit'     => 'Actualmente, las campañas están limitadas a :max módulos personalizados mientras perfeccionamos esta nueva función.',
    ],
    'fields'        => [
        'icon'      => 'Icono del módulo',
        'plural'    => 'Nombre del módulo en plural',
        'singular'  => 'Nombre del módulo en singular',
    ],
    'helpers'       => [
        'custom'    => 'Este es un módulo personalizado.',
        'icon'      => 'El icono :fontawesome, por ejemplo :ejemplo.',
        'info'      => 'Una campaña se divide en varios módulos que interactúan entre sí. Habilita o deshabilita los que no necesites. Deshabilitar un módulo no elimina ninguno de sus datos, solo los oculta.',
        'plural'    => 'El nombre en plural de las entidades del nuevo módulo. Por ejemplo, pociones',
        'roles'     => 'Selecciona los roles que tienen permiso para ver las entidades de este nuevo módulo. Esto puede cambiarse posteriormente en los permisos de rol.',
        'singular'  => 'El nombre singular de una entidad del nuevo módulo. Por ejemplo, poción',
    ],
    'pitch'         => 'Cambia el nombre y el icono asociado a este módulo para toda la campaña.',
    'pitch-custom'  => 'Crea módulos personalizados para almacenar entidades únicas.',
    'rename'        => [
        'helper'    => 'Cambia el nombre y el icono del módulo a lo largo de la campaña. Déjalo en blanco para usar el predeterminado de Kanka.',
        'success'   => 'Módulo personalizado.',
        'title'     => 'Personalizar el módulo :module',
    ],
    'reset'         => [
        'default'   => 'Esto sólo restablecerá los módulos predeterminados, no los personalizados.',
        'success'   => 'Los módulos de la campaña se han restablecido.',
        'title'     => 'Restablecer los nombres e iconos personalizados de los módulos',
        'warning'   => '¿Estás seguro de que quieres restablecer los nombres e iconos originales de los módulos de campaña?',
    ],
    'sections'      => [
        'custom'    => 'Módulos personalizados',
        'default'   => 'Módulos predeterminados',
        'features'  => 'Funciones',
    ],
    'states'        => [
        'disable'   => 'Desactivar',
        'enable'    => 'Activar',
    ],
];
