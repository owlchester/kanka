<?php

return [
    'actions'       => [
        'add'       => 'Nueva nota',
        'add_user'  => 'Añadir usuario',
    ],
    'create'        => [
        'description'   => 'Crear nueva nota',
        'success'       => 'Nota \':name\' añadida a :entity.',
        'title'         => 'Nueva nota en :name',
    ],
    'destroy'       => [
        'success'   => 'Nota \':name\' eliminada de :entity.',
    ],
    'edit'          => [
        'description'   => 'Actualizar nota',
        'success'       => 'Nota \':name\' actualizada en :entity.',
        'title'         => 'Actualizar nota de :name',
    ],
    'fields'        => [
        'collapsed' => 'Nota cerrada por defecto',
        'creator'   => 'Creador',
        'entry'     => 'Entrada',
        'is_pinned' => 'Fijada',
        'name'      => 'Nombre',
        'position'  => 'Posición fijada',
    ],
    'hint'          => 'Aquí puedes añadir toda aquella información que no acaba de encajar en los campos por defecto de la entidad, o que quieres mantener en privado.',
    'hints'         => [
        'is_pinned' => 'Las notas fijadas se muestran bajo el texto de la entidad en la vista principal según el orden de posición.',
    ],
    'index'         => [
        'title' => 'Notas de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la nota, observación...',
    ],
    'show'          => [
        'advanced'  => 'Permisos avanzados',
        'title'     => 'Nota :name de :entity',
    ],
];
