<?php

return [
    'create'        => [
        'description'   => 'Crear nueva organización',
        'success'       => 'Organización ":name" creada.',
        'title'         => 'Nueva organización',
    ],
    'destroy'       => [
        'success'   => 'Organización ":name" borrada.',
    ],
    'edit'          => [
        'success'   => 'Organización ":name" actualizada.',
        'title'     => 'Editar organización ":name"',
    ],
    'fields'        => [
        'image'         => 'Imagen',
        'location'      => 'Lugar',
        'members'       => 'Miembros',
        'name'          => 'Nombre',
        'organisation'  => 'Organización superior',
        'organisations' => 'Suborganizaciones',
        'relation'      => 'Relación',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'descendants'   => 'Esta lista contiene todas las organizaciones que descienden de esta organización, no solo las que están directamente por debajo.',
        'nested_parent' => 'Mostrando organizaciones de :parent.',
        'nested_without'=> 'Mostrando todas las organizaciones sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'index'         => [
        'add'           => 'Nueva organización',
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
            'success'       => 'Miembro añadido a la organización.',
            'title'         => 'Nuevo miembro de :name',
        ],
        'destroy'       => [
            'success'   => 'Miembro borrado de la organización.',
        ],
        'edit'          => [
            'success'   => 'Miembro de la organización actualizado.',
            'title'     => 'Actualizar miembro de :name',
        ],
        'fields'        => [
            'character'     => 'Personaje',
            'organisation'  => 'Organización',
            'role'          => 'Rol',
        ],
        'helpers'       => [
            'all_members'   => 'Todos los personajes que son miembros de la organización y de los descendientes de esta.',
            'members'       => 'Todos los personajes que pertenecen a esta organización.',
        ],
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
        'location'  => 'Elegir localización',
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
            'organisations' => 'Organizaciones',
            'quests'        => 'Misiones',
            'relations'     => 'Relaciones',
        ],
        'title'         => 'Organización :name',
    ],
];
