<?php

return [
    'copy_mention'  => [
        'copy_with_name'    => 'Copiar mención avanzada con el nombre del elemento',
        'success'           => 'Mención avanzada al elemento copiado en el portapapeles.',
    ],
    'create'        => [
        'success'   => 'Elemento añadido a la línea de tiempo.',
        'title'     => 'Nuevo elemento cronológico',
    ],
    'delete'        => [
        'success'   => 'Elemento ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Elemento actualizado.',
        'title'     => 'Editar elemento cronológico',
    ],
    'fields'        => [
        'date'              => 'Fecha',
        'era'               => 'Era',
        'icon'              => 'Icono',
        'use_entity_entry'  => 'Muestra la información de la entidad adjunta a continuación. El texto de este elemento se mostrará primero si está presente.',
        'use_event_date'    => 'Utiliza la fecha del evento vinculado.',
    ],
    'helpers'       => [
        'date'              => 'Si el elemento está vinculado a una entidad evento, muestra la fecha del evento.',
        'entity_is_private' => 'La entidad de este elemento es privada.',
        'icon'              => 'Copia el HTML de un icono de :fontawesome o :rpgawesome.',
        'is_collapsed'      => 'El elemento se muestra colapsado por defecto.',
    ],
    'placeholders'  => [
        'date'      => '22 de marzo, 1332-1337...',
        'name'      => 'Requerido si no hay ninguna entidad seleccionada',
        'position'  => 'Posición en la lista de elementos de la era. Déjalo en blanco para añadirlo al final.',
    ],
];
