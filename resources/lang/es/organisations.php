<?php

return [
    'create'        => [
        'success'   => 'Organización ":name" creada.',
        'title'     => 'Nueva organización',
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
        'add'       => 'Nueva organización',
        'header'    => 'Organizaciones de :name',
        'title'     => 'Organizaciones',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Añadir miembro',
        ],
        'create'        => [
            'success'   => 'Miembro añadido a la organización.',
            'title'     => 'Nuevo miembro de :name',
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
            'parent'        => 'Superior',
            'pinned'        => 'Fijada',
            'role'          => 'Rol',
            'status'        => 'Estatus de miembro',
        ],
        'helpers'       => [
            'all_members'   => 'Todos los personajes que son miembros de la organización y de los descendientes de esta.',
            'members'       => 'Todos los personajes que pertenecen a esta organización.',
            'pinned'        => 'Elige esta opción si el miembro debe mostrarse en la sección fijada de las entidades asociadas a esta.',
        ],
        'pinned'        => [
            'both'          => 'Ambos',
            'character'     => 'Personaje',
            'none'          => 'Ninguno',
            'organisation'  => 'Organización',
        ],
        'placeholders'  => [
            'character' => 'Elegir personaje',
            'parent'    => 'Quién es el superior de este miembro',
            'role'      => 'Líder, Miembro, Maestro de Espías, Septón Supremo...',
        ],
        'status'        => [
            'active'    => 'Miembro activo',
            'inactive'  => 'Miembro inactivo',
            'unknown'   => 'Estatus desconocido',
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
    'quests'        => [],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizaciones',
            'quests'        => 'Misiones',
            'relations'     => 'Relaciones',
        ],
        'title' => 'Organización :name',
    ],
];
