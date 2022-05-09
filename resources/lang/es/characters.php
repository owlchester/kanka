<?php

return [
    'actions'       => [
        'add_appearance'    => 'Añadir apariencia',
        'add_organisation'  => 'Añadir organización',
        'add_personality'   => 'Añadir personalidad',
    ],
    'conversations' => [
        'title' => 'Conversaciones de :name',
    ],
    'create'        => [
        'success'   => 'Se ha creado el personaje ":name".',
        'title'     => 'Nuevo Personaje',
    ],
    'destroy'       => [
        'success'   => 'Personaje ":name" eliminado.',
    ],
    'dice_rolls'    => [
        'hint'  => 'Se pueden asignar tiradas de dados a un personaje para usarlas en el juego.',
        'title' => 'Tiradas de dados de :name',
    ],
    'edit'          => [
        'success'   => 'Personaje ":name" actualizado.',
        'title'     => 'Editar el personaje :name',
    ],
    'fields'        => [
        'age'                       => 'Edad',
        'families'                  => 'Familias',
        'family'                    => 'Familia',
        'image'                     => 'Imagen',
        'is_appearance_pinned'      => 'Apariencia fijada',
        'is_dead'                   => 'Muerto',
        'is_personality_pinned'     => 'Personalidad fijada',
        'is_personality_visible'    => 'Personalidad visible',
        'life'                      => 'Biografía',
        'location'                  => 'Procedencia',
        'name'                      => 'Nombre',
        'physical'                  => 'Apariencia',
        'pronouns'                  => 'Pronombres',
        'race'                      => 'Raza',
        'races'                     => 'Razas',
        'sex'                       => 'Género',
        'title'                     => 'Título',
        'traits'                    => 'Características',
        'type'                      => 'Tipo',
    ],
    'helpers'       => [
        'age'   => 'Puedes vincular esta entidad con un calendario de la campaña para calcular automáticamente su edad. :more',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Si está seleccionado, la apariencia del personaje aparecerá bajo la entrada principal de la página.',
        'is_dead'                   => 'Este personaje está muerto',
        'is_personality_pinned'     => 'Si está seleccionado, los rasgos de personalidad del personaje aparecerán bajo la entrada principal en la página.',
        'is_personality_visible'    => 'Se puede ocultar la sección de personalidad a los usuarios no administradores.',
        'personality_not_visible'   => 'Los rasgos de personalidad de este personaje actualmente solo son visibles para los administradores.',
        'personality_visible'       => 'Los rasgos de personalidad de este personaje son visibles para todos.',
    ],
    'index'         => [
        'actions'   => [
            'random'    => 'Nuevo personaje aleatorio',
        ],
        'title'     => 'Personajes',
    ],
    'items'         => [
        'hint'  => 'Aquí se muestran los objetos que se han asignado a los personajes.',
        'title' => 'Objetos de :name',
    ],
    'journals'      => [
        'title' => 'Diarios de :name',
    ],
    'maps'          => [
        'title' => 'Mapa de relaciones de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Añadir organización',
        ],
        'create'        => [
            'success'   => 'Personaje añadido a la organización.',
            'title'     => 'Nueva organización para :name',
        ],
        'destroy'       => [
            'success'   => 'Personaje quitado de la organización.',
        ],
        'edit'          => [
            'success'   => 'Organización del personaje actualizada.',
            'title'     => 'Actualizar organización de :name',
        ],
        'fields'        => [
            'organisation'  => 'Organización',
            'role'          => 'Rol',
        ],
        'hint'          => 'Los personajes pueden formar parte de muchas organizaciones, que representan para quién trabajan o de qué sociedad secreta forman parte.',
        'placeholders'  => [
            'organisation'  => 'Elegir una organización',
        ],
        'title'         => 'Organizaciones de :name',
    ],
    'placeholders'  => [
        'age'               => 'Edad',
        'appearance_entry'  => 'Descripción',
        'appearance_name'   => 'Cabello, ojos, piel, altura...',
        'family'            => 'Selecciona un personaje',
        'image'             => 'Imagen',
        'location'          => 'Selecciona una procedencia',
        'name'              => 'Nombre',
        'personality_entry' => 'Detalles',
        'personality_name'  => 'Objetivos, manías, miedos, lazos...',
        'physical'          => 'Físico',
        'pronouns'          => 'Él, ella, elle',
        'race'              => 'Raza',
        'races'             => 'Elegir razas',
        'sex'               => 'Género',
        'title'             => 'Título',
        'traits'            => 'Características',
        'type'              => 'PNJ, Personaje Jugador, divinidad...',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Misiones que el personaje ha promovido.',
            'quest_member'  => 'Misiones de las que el personaje es miembro.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Apariencia',
        'general'       => 'Información general',
        'personality'   => 'Personalidad',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizaciones',
        ],
    ],
    'warnings'      => [
        'personality_hidden'    => 'No puedes editar los rasgos de personalidad de este personaje.',
    ],
];
