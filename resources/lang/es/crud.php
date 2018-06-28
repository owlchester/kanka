<?php

return [
    'actions'       => [
        'back'      => 'Atrás',
        'copy'      => 'Copiar',
        'export'    => 'Exportar',
        'more'      => 'Más acciones',
        'move'      => 'Mover',
        'new'       => 'Nuevo',
        'private'   => 'Privado',
        'public'    => 'Público',
    ],
    'add'           => 'Añadir',
    'attributes'    => [
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
            'success'   => 'Atributo :name para :entity eliminado.',
        ],
        'edit'          => [
            'description'   => 'Actualizar un atributo existente',
            'success'       => 'Atributo :name para :entity actualizado.',
            'title'         => 'Actualizar atributo para :name',
        ],
        'fields'        => [
            'attribute' => 'Atributo',
            'template'  => 'Plantilla',
            'value'     => 'Valor',
        ],
        'index'         => [
            'success'   => 'Atributos para :entity actualizados.',
            'title'     => 'Atributos para :name',
        ],
        'placeholders'  => [
            'attribute' => 'Número de conquistas, Iniciativa, Población',
            'template'  => 'Seleccionar plantilla',
            'value'     => 'Valor del atributo',
        ],
        'template'      => [
            'success'   => 'Plantilla de atributos :name aplicada en :entity',
            'title'     => 'Aplicar plantilla de atributos para :name',
        ],
    ],
    'bulk'          => [
        'errors'    => [
            'admin' => 'Solamente los administradores de la campaña pueden cambiar el estatus privado de las entidades.',
        ],
        'success'   => [
            'private'   => ':count entidad es ahora privada|:count entidades son ahora privadas.',
            'public'    => ':count entidad es ahora visible|:count son ahora visibles.',
        ],
    ],
    'cancel'        => 'Cancelar',
    'clear_filters' => 'Borrar filtros',
    'click_modal'   => [
        'close'     => 'Cerrar',
        'confirm'   => 'Confirmar',
        'title'     => 'Confirmar acción',
    ],
    'create'        => 'Crear',
    'delete_modal'  => [
        'close'         => 'Cerrar',
        'delete'        => 'Eliminar',
        'description'   => '¿Seguro que quieres eliminar :tag?',
        'title'         => 'Eliminar',
    ],
    'destroy_many'  => [
        'success'   => ':count entidad eliminada|:count entidades eliminadas.',
    ],
    'edit'          => 'Editar',
    'errors'        => [
        'node_must_not_be_a_descendant' => 'Nodo inválido (categoría, localización superior): sería un descendiente de sí mismo.',
    ],
    'events'        => [
        'hint'  => 'Los eventos del calendario asociados a esta entidad se muestran aquí.',
    ],
    'export'        => 'Exportar',
    'fields'        => [
        'character'     => 'Personaje',
        'creator'       => 'Creador',
        'description'   => 'Descripción',
        'dice_roll'     => 'Tirada de dados',
        'entity'        => 'Entidad',
        'entry'         => 'Entrada',
        'event'         => 'Evento',
        'family'        => 'Familia',
        'history'       => 'Historia',
        'image'         => 'Imagen',
        'is_private'    => 'Privado',
        'location'      => 'Localización',
        'name'          => 'Nombre',
        'organisation'  => 'Organización',
        'section'       => 'Categoría',
    ],
    'filter'        => 'Filtrar',
    'filters'       => 'Filtros',
    'hidden'        => 'Oculto',
    'hints'         => [
        'is_private'    => 'Ocultar a los "Invitados"',
    ],
    'image'         => [
        'error' => 'No hemos podido obtener la imagen. Puede que la página web no nos permita descargarla (típico de Squarespace o DeviantArt), o que el enlace ya no es válido.',
    ],
    'is_private'    => 'Esta entidad es privada y no será visible por los usuarios Invitados.',
    'linking_help'  => '¿Como puedo enlazar otras entradas?',
    'manage'        => 'Administrar',
    'move'          => [
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
    'new_entity'    => [
        'error' => 'Por favor revisa lo introducido.',
        'fields'=> [
            'name'  => 'Nombre',
        ],
        'title' => 'Nueva entidad',
    ],
    'notes'         => [
        'actions'       => [
            'add'   => 'Añadir nota',
        ],
        'create'        => [
            'description'   => 'Crear nueva nota',
            'success'       => 'Nota \':name\' añadida a :entity.',
            'title'         => 'Nueva nota para :name',
        ],
        'destroy'       => [
            'success'   => 'Nota \':name\' para :entidad eliminada.',
        ],
        'edit'          => [
            'description'   => 'Actualizar nota existente',
            'success'       => 'Nota \':name\' para :entity actualizada.',
            'title'         => 'Actualizar nota para :name',
        ],
        'fields'        => [
            'creator'   => 'Creador',
            'entry'     => 'Entrada',
            'name'      => 'Nombre',
        ],
        'hint'          => 'La información que no encaja en los campos por defecto de una entidad o que han de mantenerse en privado pueden ser añadidos como Notas.',
        'index'         => [
            'title' => 'Notas para :name',
        ],
        'placeholders'  => [
            'name'  => 'Nombre de la nota, observación o comentario.',
        ],
    ],
    'or_cancel'     => 'o <a href=":url">Cancelar</a>',
    'panels'        => [
        'appearance'            => 'Apariencia',
        'description'           => 'Descripción',
        'general_information'   => 'Información general',
        'history'               => 'Historia',
        'move'                  => 'Mover',
    ],
    'permissions'   => [
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
    'placeholders'  => [
        'character'     => 'Escoge un personaje',
        'entity'        => 'Entidad',
        'event'         => 'Elige un evento',
        'family'        => 'Elige una familia',
        'image_url'     => 'Puedes subir una imagen desde una URL',
        'location'      => 'Escoge una localización',
        'organisation'  => 'Elige una organización',
        'section'       => 'Elige una categoría',
    ],
    'relations'     => [
        'actions'   => [
            'add'   => 'Añadir un vínculo',
        ],
        'fields'    => [
            'location'  => 'Localización',
            'name'      => 'Nombre',
            'relation'  => 'Vínculo',
        ],
        'hint'      => 'Se pueden vincular entidades para representar sus conexiones.',
    ],
    'remove'        => 'Eliminar',
    'save'          => 'Guardar',
    'save_and_new'  => 'Guardar y Crear',
    'search'        => 'Buscar',
    'select'        => 'Seleccionar',
    'tabs'          => [
        'attributes'    => 'Atributos',
        'events'        => 'Eventos',
        'notes'         => 'Notas',
        'permissions'   => 'Permisos',
        'relations'     => 'Vínculos',
    ],
    'update'        => 'Actualizar',
    'view'          => 'Ver',
];
