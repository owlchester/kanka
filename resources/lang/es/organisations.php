<?php

return [
    'create'        => [
        'success'   => 'Organización \':name\' creada.',
        'title'     => 'Crear nueva organización',
    ],
    'destroy'       => [
        'success'   => 'Organización \':name\' borrada.',
    ],
    'edit'          => [
        'success'   => 'Organización \':name\' actualizada.',
        'title'     => 'Editar Organización \':name\'',
    ],
    'fields'        => [
        'history'   => 'Historia',
        'image'     => 'Imagen',
        'location'  => 'Lugar',
        'members'   => 'Miembros',
        'name'      => 'Nombre',
        'relation'  => 'Vinculo',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nueva Organización',
        'description'   => 'Gestionar las organizaciones de :name.',
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
            'title'         => 'Nuevo Miembro para :name',
        ],
        'destroy'       => [
            'success'   => 'Miembro borrado de la organización',
        ],
        'edit'          => [
            'success'   => 'Miembro actualizado',
            'title'     => 'Actualizar Miembro de :name',
        ],
        'fields'        => [
            'character' => 'Personaje',
            'role'      => 'Rol',
        ],
        'placeholders'  => [
            'character' => 'Elegir personaje',
            'role'      => 'Lider, Miembro, Maestro de Espias, Septón Supremo...',
        ],
    ],
    'placeholders'  => [
        'location'  => 'Elegir una localización',
        'name'      => 'Nombre de la organización',
        'type'      => 'Culto, banda, Rebelión, Gremio...',
    ],
    'show'          => [
        'description'   => 'Vista detallada de una organización',
        'tabs'          => [
            'history'   => 'Historia',
            'members'   => 'Miembros',
            'relations' => 'Vinculos',
        ],
        'title'         => 'Organización :name',
    ],
];
