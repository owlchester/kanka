<?php

return [
    'actions'       => [
        'apply_template'    => 'Aplicar plantilla de atributos',
        'load'              => 'Cargar',
        'manage'            => 'Administrar',
        'more'              => 'Más opciones',
        'remove_all'        => 'Eliminar todos',
        'save_and_edit'     => 'Aplicar y editar',
        'save_and_story'    => 'Aplicar y ver',
        'show_hidden'       => 'Mostrar atributos ocultos',
        'toggle_privacy'    => 'Privado/Público',
    ],
    'errors'        => [
        'loop'                  => '¡Hay un bucle infinito en el cálculo de este atributo!',
        'no_attribute_selected' => 'Selecciona uno o varios atributos primero.',
        'too_many_v2'           => 'Se ha alcanzado el máximo de campos (:count/:max). Elimina algunos atributos primero antes de poder añadir más.',
    ],
    'fields'        => [
        'attribute'             => 'Atributo',
        'community_templates'   => 'Plantillas de la comunidad',
        'is_private'            => 'Atributos privados',
        'is_star'               => 'Fijado',
        'preferences'           => 'Preferencias',
        'template'              => 'Plantilla',
        'value'                 => 'Valor',
    ],
    'filters'       => [
        'name'  => 'Nombre del atributo',
        'value' => 'Valor del atributo',
    ],
    'helpers'       => [
        'delete_all'    => '¿Seguro que quieres eliminar todos los atributos de esta entidad?',
        'is_private'    => 'Sólo permite ver los atributos de esta entidad a los miembros del rol :admin-role.',
        'setup'         => 'Puedes representar elementos como los PV o la inteligencia de un personaje mediante los atributos. Puedes añadirlos manualmente desde el botón de :manage, o aplicarlos desde una plantilla de atributos.',
    ],
    'hints'         => [],
    'index'         => [
        'success'   => 'Atributos de :entity actualizados.',
        'title'     => 'Atributos de :name',
    ],
    'labels'        => [
        'checkbox'  => 'Nombre de la casilla',
        'name'      => 'Nombre del atributo',
        'section'   => 'Nombre de la sección',
        'value'     => 'Valor del atributo',
    ],
    'live'          => [
        'success'   => 'Atributo :attribute actualizado.',
        'title'     => 'Actualizando :attribute',
    ],
    'placeholders'  => [
        'attribute' => 'Número de conquistas, Iniciativa, Población...',
        'block'     => 'Nombre del bloque',
        'checkbox'  => 'Nombre de la casilla',
        'icon'      => [
            'class' => 'Clase de FontAwesome o RPG Awesome: fas fa-users',
            'name'  => 'Nombre del icono',
        ],
        'number'    => 'Valor numérico',
        'random'    => [
            'name'  => 'Nombre del atributo',
            'value' => '1-100 o una lista de valores separados por comas',
        ],
        'section'   => 'Nombre de la sección',
        'template'  => 'Seleccionar plantilla',
        'value'     => 'Valor del atributo',
    ],
    'ranges'        => [
        'text'  => 'Opciones disponibles: :options',
    ],
    'sections'      => [
        'unorganised'   => 'Sin organizar',
    ],
    'show'          => [
        'hidden'    => 'Atributos ocultos',
        'title'     => 'Atributos de :name',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Plantilla cargada',
            'title'     => 'Cargar desde plantilla',
        ],
        'success'   => 'Plantilla de atributos :name aplicada a :entity',
        'title'     => 'Aplicar plantilla de atributos a :name',
    ],
    'title'         => 'Atributos',
    'toasts'        => [
        'bulk_deleted'  => 'Atributos eliminados',
        'bulk_privacy'  => 'Privacidad de atributos cambiada',
        'lock'          => 'Atributo bloqueado',
        'pin'           => 'Atributo fijado',
        'unlock'        => 'Atributo desbloqueado',
        'unpin'         => 'Atributo no fijado',
    ],
    'tutorials'     => [
        'character' => 'Por ejemplo, pueden tener una propiedad :hp y :str.',
        'general'   => 'Los atributos son pequeños fragmentos de información asociados a :name.',
        'location'  => 'Por ejemplo, pueden tener una propiedad :pop.',
    ],
    'types'         => [
        'attribute' => 'Atributo',
        'block'     => 'Bloque',
        'checkbox'  => 'Casilla',
        'icon'      => 'Icono',
        'number'    => 'Número',
        'random'    => 'Aleatorio',
        'section'   => 'Sección',
        'text'      => 'Texto multilínea',
    ],
    'update'        => [
        'success'   => 'Atributos de :entity actualizados.',
    ],
    'visibility'    => [
        'entry'     => 'El atributo se muestra en el menú de la entidad.',
        'private'   => 'Atributo visible solo para miembros con el rol "Admin".',
        'public'    => 'Atributo visible por todos los miembros.',
        'tab'       => 'El atributo se muestra solo en la pestaña de Atributos.',
    ],
];
