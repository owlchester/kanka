<?php

return [
    'actions'           => [
        'back'      => 'Atrás',
        'copy'      => 'Copiar',
        'export'    => 'Exportar',
        'more'      => 'Más acciones',
        'move'      => 'Mover',
        'new'       => 'Nuevo',
        'private'   => 'Privado',
        'public'    => 'Público',
    ],
    'add'               => 'Añadir',
    'attributes'        => [
        'actions'       => [
            'add'               => 'Añadir atributo',
            'apply_template'    => 'Aplicar una plantilla de atributos',
            'manage'            => 'Administrar',
        ],
        'create'        => [
            'description'   => 'Crear nuevo atributo',
            'success'       => 'Atributo :name añadido a :entity.',
            'title'         => 'Nuevo atributo para :name',
        ],
        'destroy'       => [
            'success'   => 'Atributo :name de :entity eliminado.',
        ],
        'edit'          => [
            'description'   => 'Actualizar un atributo existente',
            'success'       => 'Atributo :name de :entity actualizado.',
            'title'         => 'Actualizar atributo a :name',
        ],
        'fields'        => [
            'attribute' => 'Atributo',
            'template'  => 'Plantilla',
            'value'     => 'Valor',
        ],
        'index'         => [
            'success'   => 'Atributos de :entity actualizados.',
            'title'     => 'Atributos de :name',
        ],
        'placeholders'  => [
            'attribute' => 'Número de conquistas, Iniciativa, Población',
            'template'  => 'Seleccionar plantilla',
            'value'     => 'Valor del atributo',
        ],
        'template'      => [
            'success'   => 'Plantilla de atributos :name aplicada en :entity',
            'title'     => 'Aplicar plantilla de atributos a :name',
        ],
    ],
    'bulk'              => [
        'errors'    => [
            'admin' => 'Solamente los administradores de la campaña pueden cambiar el estatus privado de las entidades.',
        ],
        'success'   => [
            'private'   => ':count entidad es ahora privada|:count entidades son ahora privadas.',
            'public'    => ':count entidad es ahora visible|:count son ahora visibles.',
        ],
    ],
    'cancel'            => 'Cancelar',
    'click_modal'       => [
        'close'     => 'Cerrar',
        'confirm'   => 'Confirmar',
        'title'     => 'Confirmar acción',
    ],
    'create'            => 'Crear',
    'delete_modal'      => [
        'close'         => 'Cerrar',
        'delete'        => 'Eliminar',
        'description'   => '¿Seguro que quieres eliminar :tag?',
        'title'         => 'Eliminar',
    ],
    'destroy_many'      => [
        'success'   => ':count entidad eliminada|:count entidades eliminadas.',
    ],
    'edit'              => 'Editar',
    'errors'            => [
        'node_must_not_be_a_descendant' => 'Nodo inválido (categoría, localización superior): sería un descendiente de sí mismo.',
    ],
    'events'            => [
        'hint'  => 'Los eventos del calendario asociados a esta entidad se muestran aquí.',
    ],
    'export'            => 'Exportar',
    'fields'            => [
        'attribute_template'    => 'Plantilla de atributos',
        'calendar'              => 'Calendario',
        'calendar_date'         => 'Fecha del calendario',
        'character'             => 'Personaje',
        'creator'               => 'Creador',
        'dice_roll'             => 'Tirada de dados',
        'entity'                => 'Entidad',
        'entry'                 => 'Entrada',
        'event'                 => 'Evento',
        'family'                => 'Familia',
        'files'                 => 'Archivos',
        'image'                 => 'Imagen',
        'is_private'            => 'Privado',
        'location'              => 'Localización',
        'name'                  => 'Nombre',
        'organisation'          => 'Organización',
        'race'                  => 'Raza',
        'tag'                   => 'Etiqueta',
        'tags'                  => 'Etiquetas',
    ],
    'files'             => [
        'actions'   => [
            'drop'      => 'Haz clic para añadir o arrastra un archivo',
            'manage'    => 'Administrar archivos de la entidad',
        ],
        'errors'    => [
            'max'   => 'Has alcanzado el número máximo (:max) de archivos para esta entidad.',
        ],
        'files'     => 'Archivos subidos',
        'hints'     => [
            'limit'         => 'Cada entidad puede tener un máximo de :max archivos.',
            'limitations'   => 'Formatos soportados: jpg, png, gif y pdf. Tamaño máximo de archivo: :size',
        ],
        'title'     => 'Archivos de :name',
    ],
    'filter'            => 'Filtrar',
    'filters'           => [
        'clear' => 'Quitar filtros',
        'hide'  => 'Ocultar filtros',
        'show'  => 'Mostrar filtros',
        'title' => 'Filtros',
    ],
    'forms'             => [
        'actions'   => [
            'calendar'  => 'Añadir fecha de calendario',
        ],
    ],
    'hidden'            => 'Oculto',
    'hints'             => [
        'attribute_template'    => 'Aplica una plantilla de atributos directamente al crear esta entidad.',
        'calendar_date'         => 'Las fechas de calendario hacen que sea más fácil filtrar las listas, y también fijan los eventos al calendario seleccionado.',
        'image_limitations'     => 'Formatos soportados: jpg, png y gif. Tamaño máximo del archivo: :size.',
        'image_patreon'         => 'Aumenta el límite apoyándonos en Patreon',
        'is_private'            => 'Ocultar a los "Invitados"',
    ],
    'history'           => [
        'created'   => 'Creado por <strong>:name</strong> <span data-toggle="tooltip" title=":realdate">:date</span>',
        'unknown'   => 'Desconocido',
        'updated'   => 'Última modificación por <strong>:name</strong> <span data-toggle="tooltip" title=":realdate">:date</span>',
    ],
    'image'             => [
        'error' => 'No hemos podido obtener la imagen. Puede que la página web no nos permita descargarla (típico de Squarespace o DeviantArt), o que el enlace ya no es válido.',
    ],
    'is_private'        => 'Esta entidad es privada y no será visible por los usuarios Invitados.',
    'linking_help'      => '¿Como puedo enlazar otras entradas?',
    'manage'            => 'Administrar',
    'move'              => [
        'description'   => 'Mover esta entidad a otro lugar',
        'errors'        => [
            'permission'        => 'No tienes permiso para crear entidades de este tipo en la campaña seleccionada.',
            'same_campaign'     => 'Debes seleccionar otra campaña donde mover la entidad.',
            'unknown_campaign'  => 'Campaña desconocida.',
        ],
        'fields'        => [
            'campaign'  => 'Nueva campaña',
            'target'    => 'Nuevo tipo',
        ],
        'hints'         => [
            'campaign'  => 'También puedes intentar mover esta entidad a otra campaña.',
            'target'    => 'Por favor ten en cuenta que algunos datos pueden perderse al mover un elemento de un tipo a otro.',
        ],
        'success'       => 'Entidad :name movida.',
        'title'         => 'Mover :name',
    ],
    'new_entity'        => [
        'error' => 'Por favor revisa lo introducido.',
        'fields'=> [
            'name'  => 'Nombre',
        ],
        'title' => 'Nueva entidad',
    ],
    'notes'             => [
        'actions'       => [
            'add'   => 'Añadir nota',
        ],
        'create'        => [
            'description'   => 'Crear nueva nota',
            'success'       => 'Nota \':name\' añadida a :entity.',
            'title'         => 'Nueva nota en :name',
        ],
        'destroy'       => [
            'success'   => 'Nota \':name\' de :entidad eliminada.',
        ],
        'edit'          => [
            'description'   => 'Actualizar nota existente',
            'success'       => 'Nota \':name\' de :entity actualizada.',
            'title'         => 'Actualizar nota de :name',
        ],
        'fields'        => [
            'creator'   => 'Creador',
            'entry'     => 'Entrada',
            'name'      => 'Nombre',
        ],
        'hint'          => 'La información que no encaja en los campos por defecto de una entidad o que han de mantenerse en privado pueden ser añadidos como Notas.',
        'index'         => [
            'title' => 'Notas de :name',
        ],
        'placeholders'  => [
            'name'  => 'Nombre de la nota, observación o comentario.',
        ],
    ],
    'or_cancel'         => 'o <a href=":url">Cancelar</a>',
    'panels'            => [
        'appearance'            => 'Apariencia',
        'attribute_template'    => 'Plantilla de atributos',
        'calendar_date'         => 'Fecha de calendario',
        'entry'                 => 'Presentación',
        'general_information'   => 'Información general',
        'move'                  => 'Mover',
        'system'                => 'Sistema',
    ],
    'permissions'       => [
        'action'    => 'Acción',
        'actions'   => [
            'delete'    => 'Eliminar',
            'edit'      => 'Editar',
            'read'      => 'Leer',
        ],
        'allowed'   => 'Permitido',
        'fields'    => [
            'member'    => 'Miembro',
            'role'      => 'Rol',
        ],
        'helper'    => 'Usa esta interfaz para afinar qué usuarios y roles pueden interactuar con esta entidad.',
        'success'   => 'Permisos guardados.',
        'title'     => 'Permisos',
    ],
    'placeholders'      => [
        'calendar'      => 'Escoge un calendario',
        'character'     => 'Escoge un personaje',
        'entity'        => 'Entidad',
        'event'         => 'Elige un evento',
        'family'        => 'Elige una familia',
        'image_url'     => 'Puedes subir una imagen desde una URL',
        'location'      => 'Escoge una localización',
        'organisation'  => 'Elige una organización',
        'race'          => 'Elige una raza',
        'tag'           => 'Elige una etiqueta',
    ],
    'relations'         => [
        'actions'   => [
            'add'   => 'Añadir una relación',
        ],
        'fields'    => [
            'location'  => 'Localización',
            'name'      => 'Nombre',
            'relation'  => 'Relación',
        ],
        'hint'      => 'Se pueden relacionar entidades para representar sus conexiones.',
    ],
    'remove'            => 'Eliminar',
    'rename'            => 'Renombrar',
    'save'              => 'Guardar',
    'save_and_close'    => 'Guardar y Cerrar',
    'save_and_new'      => 'Guardar y Crear',
    'save_and_update'   => 'Guardar y Actualizar',
    'save_and_view'     => 'Guardar y Ver',
    'search'            => 'Buscar',
    'select'            => 'Seleccionar',
    'tabs'              => [
        'attributes'    => 'Atributos',
        'calendars'     => 'Calendarios',
        'events'        => 'Eventos',
        'menu'          => 'Menú',
        'notes'         => 'Notas',
        'permissions'   => 'Permisos',
        'relations'     => 'Relaciones',
    ],
    'update'            => 'Actualizar',
    'users'             => [
        'unknown'   => 'Desconocido',
    ],
    'view'              => 'Ver',
];
