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
        'image'         => 'Imagen',
        'location'      => 'Lugar',
        'members'       => 'Miembros',
        'name'          => 'Nombre',
        'organisation'  => 'Organización superior',
        'relation'      => 'Relación',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contiene todas las organizaciones que descienden de esta organización, no solo las que están directamente por debajo.',
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
        'helpers'       => [
            'all_members'       => 'Esta lista contiene todos los personajes que forman parte de esta organización y de todas las organizaciones inferiores.',
            'direct_members'    => 'Las organizaciones necesitan miembros para funcionar bien. Esta lista contiene todos los personajes que forman parte de esta organización.',
        ],
        'hint'          => 'Muchas organizaciones necesitan miembros para funcionar bien.',
        'placeholders'  => [
            'character' => 'Elegir personaje',
            'role'      => 'Líder, Miembro, Maestro de Espías, Septón Supremo...',
        ],
        'title'         => 'Miembros de :name',
    ],
    'organisations' => [
        'title' => 'Organizaciones de :name',
    ],
    'placeholders'  => [
        'location'  => 'Elegir una localización',
        'name'      => 'Nombre de la organización',
        'type'      => 'Culto, banda, Rebelión, Gremio...',
    ],
    'quests'        => [
        'description'   => 'Misiones en las que participa la organización.',
        'title'         => 'Misiones de :name',
    ],
    'show'          => [
        'description'   => 'Vista detallada de la organización',
        'tabs'          => [
            'all_members'   => 'Todos los miembros',
            'members'       => 'Miembros directos',
            'organisations' => 'Organizaciones',
            'quests'        => 'Misiones',
            'relations'     => 'Relaciones',
        ],
        'title'         => 'Organización :name',
    ],
];
