<?php

return [
    'actions'       => [
        'add'   => 'Nueva nota',
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
        'creator'   => 'Creador',
        'entry'     => 'Entrada',
        'name'      => 'Nombre',
    ],
    'hint'          => 'Aquí puedes añadir toda aquella información que no acaba de encajar en los campos por defecto de la entidad, o que quieres mantener en privado.',
    'index'         => [
        'title' => 'Notas de :name',
    ],
    'placeholders'  => [
        'name'  => 'Nombre de la nota, observación...',
    ],
    'show'          => [
        'title' => 'Nota :name de :entity',
    ],
];
