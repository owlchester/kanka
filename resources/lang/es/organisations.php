<?php

return [
    'create'        => [
        'description'   => 'Crear nueva organización',
        'success'       => 'Organización \':name\' creada.',
        'title'         => 'Nueva Organización',
    ],
    'destroy'       => [
        'success'   => 'Organización \':name\' borrada.',
    ],
    'edit'          => [
        'success'   => 'Organización \':name\' actualizada.',
        'title'     => 'Editar organización \':name\'',
    ],
    'fields'        => [
        'image'     => 'Imagen',
        'location'  => 'Lugar',
        'members'   => 'Miembros',
        'name'      => 'Nombre',
        'relation'  => 'Vínculo',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nueva Organización',
        'description'   => 'Gestiona las organizaciones de :name.',
        'header'        => 'Organizaciones de :name',
        'title'         => 'Organizaciones',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Añadir miembro',
        ],
        'create'        => [
            'description'   => 'Añadir miembro a la organización',
            'success'       => 'Miembro añadido a la organización',
            'title'         => 'Nuevo miembro para :name',
        ],
        'destroy'       => [
            'success'   => 'Miembro borrado de la organización',
        ],
        'edit'          => [
            'success'   => 'Miembro actualizado',
            'title'     => 'Actualizar miembro de :name',
        ],
        'fields'        => [
            'character' => 'Personaje',
            'role'      => 'Rol',
        ],
        'hint'          => 'Muchas organizaciones necesitan miembros para funcionar bien.',
        'placeholders'  => [
            'character' => 'Elegir personaje',
            'role'      => 'Líder, Miembro, Maestro de Espías, Septón Supremo...',
        ],
    ],
    'placeholders'  => [
        'location'  => 'Elegir una localización',
        'name'      => 'Nombre de la organización',
        'type'      => 'Culto, banda, Rebelión, Gremio...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la organización',
        'tabs'          => [
            'members'   => 'Miembros',
            'relations' => 'Vínculos',
        ],
        'title'         => 'Organización :name',
    ],
];
