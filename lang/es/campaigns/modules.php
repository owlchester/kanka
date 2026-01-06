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
        'confirm'           => 'Escribe :code si estás seguro de que deseas eliminar definitivamente el módulo personalizado :name.',
        'confirm-button'    => '{0} Eliminar :name permanentemente| {1} Eliminar :name y :count entidad permanentemente| [2,*] Eliminar :name y :count entidades permanentemente',
        'entities'          => '{1} Esto eliminará :count entidad permanentemente. | [2,*] Esto eliminará :count entidades permanentemente.',
        'helper'            => '¿Estás seguro de que quieres eliminar el módulo personalizado :name ? Esto también eliminará permanentemente todas las entidades, marcadores y widgets vinculados a este módulo.',
        'success'           => 'Módulo :name eliminado.',
        'title'             => 'Eliminación de módulos',
    ],
    'errors'        => [
        'disabled'              => 'El módulo :name está desactivado. :fix',
        'empty-custom'          => 'Añade módulos personalizados para organizar datos que no encajan en los predeterminados.',
        'limit'                 => 'Actualmente, las campañas están limitadas a :max módulos personalizados mientras perfeccionamos esta nueva función.',
        'limit-title'           => 'Límite de módulos personalizados alcanzado',
        'subscription-limit'    => 'La campaña ha alcanzado el número máximo de módulos personalizados disponibles. La persona que desbloquea las funciones premium puede suscribirse a un nivel superior para aumentar este límite.',
    ],
    'fields'        => [
        'icon'          => 'Icono del módulo',
        'image'         => 'Imagen predeterminada',
        'plural'        => 'Nombre del módulo en plural',
        'singular'      => 'Nombre del módulo en singular',
        'status'        => 'Estado del módulo',
        'update_name'   => 'Renombrar el marcador del módulo con el nuevo nombre',
    ],
    'helpers'       => [
        'custom'    => 'Este es un módulo personalizado.',
        'icon'      => 'El icono :fontawesome, por ejemplo :ejemplo.',
        'plural'    => 'El nombre en plural de las entidades del nuevo módulo. Por ejemplo, pociones',
        'roles'     => 'Selecciona los roles que tienen permiso para ver las entidades de este nuevo módulo. Esto puede cambiarse posteriormente en los permisos de rol.',
        'singular'  => 'El nombre singular de una entidad del nuevo módulo. Por ejemplo, poción',
        'status'    => 'Los módulos desactivados se ocultan de la navegación y los menús. No se elimina ningún dato.',
        'tutorial'  => 'Los módulos controlan qué funciones son visibles en la campaña. Activa los que uses y oculta el resto. Desactivar un módulo nunca elimina datos; solo lo quita de la navegación y de los menús de creación.',
    ],
    'pitch'         => 'Cambia el nombre y el icono asociado a este módulo para toda la campaña.',
    'pitch-custom'  => 'Crea módulos personalizados para almacenar entidades únicas.',
    'pitch-title'   => 'Desbloquear módulos personalizados',
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
        'custom'        => 'Módulos personalizados',
        'default'       => 'Módulos predeterminados',
        'early-access'  => 'Acceso anticipado',
        'features'      => 'Funciones',
    ],
    'states'        => [
        'disable'   => 'Desactivar',
        'disabled'  => 'El módulo está desactivado',
        'enable'    => 'Activar',
        'enabled'   => 'El módulo está activado',
    ],
    'status'        => [
        'enabled'   => 'Módulo activado',
    ],
];
