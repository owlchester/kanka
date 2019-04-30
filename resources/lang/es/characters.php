<?php

return [
    'actions'       => [
        'add_appearance'    => 'Añadir apariencia',
        'add_personality'   => 'Añadir personalidad',
    ],
    'conversations' => [
        'description'   => 'Conversaciones en las que el personaje está participando.',
        'title'         => 'Conversaciones de :name',
    ],
    'create'        => [
        'description'   => 'Crear nuevo personaje',
        'success'       => 'Se ha creado el personaje \':name\'.',
        'title'         => 'Nuevo Personaje',
    ],
    'destroy'       => [
        'success'   => 'Personaje \':name\' borrado.',
    ],
    'dice_rolls'    => [
        'description'   => 'Tiradas de dados asignadas al personaje.',
        'hint'          => 'Se pueden asignar tiradas de dados a un personaje para usarlas en el juego.',
        'title'         => 'Tiradas de dados de :name',
    ],
    'edit'          => [
        'description'   => 'Editar personaje',
        'success'       => 'Personaje \':name\' actualizado.',
        'title'         => 'Editar el personaje :name',
    ],
    'fields'        => [
        'age'                       => 'Edad',
        'family'                    => 'Familia',
        'image'                     => 'Imagen',
        'is_dead'                   => 'Muerto',
        'is_personality_visible'    => 'Personalidad visible',
        'location'                  => 'Procedencia',
        'name'                      => 'Nombre',
        'physical'                  => 'Apariencia',
        'race'                      => 'Raza',
        'relation'                  => 'Relación',
        'sex'                       => 'Género',
        'title'                     => 'Título',
        'traits'                    => 'Personalidad',
        'type'                      => 'Tipo',
    ],
    'helpers'       => [
        'free'  => '¿No encuentras el campo "Libre"? Si este personaje tenía uno, ha sido movido a la nueva pestaña de Notas.',
    ],
    'hints'         => [
        'hide_personality'          => 'Esta pestaña puede ocultarse a los usuarios no administradores desactivando la opción "Personalidad visible" en la edición del personaje.',
        'is_dead'                   => 'Este personaje está muerto',
        'is_personality_visible'    => 'Puedes ocultar a los Invitados la sección de personalidad.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Nuevo personaje aleatorio',
        ],
        'add'           => 'Nuevo Personaje',
        'description'   => 'Gestiona los personajes de :name.',
        'header'        => 'Personajes en :name',
        'title'         => 'Personajes',
    ],
    'items'         => [
        'description'   => 'Los objetos que tiene el personaje.',
        'hint'          => 'A los personajes se les puede asignar objetos, que se mostrarán aquí.',
        'title'         => 'Objetos de :name',
    ],
    'journals'      => [
        'description'   => 'Diarios cuyo autor es el personaje.',
        'title'         => 'Diarios de :name',
    ],
    'maps'          => [
        'description'   => 'Mapa de relaciones de un personaje.',
        'title'         => 'Mapa de relaciones de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Añadir organización',
        ],
        'create'        => [
            'description'   => 'Asociar una organización a un personaje',
            'success'       => 'Personaje añadido a la organización.',
            'title'         => 'Nueva organización para :name',
        ],
        'description'   => 'Organizaciones de las que el personaje forma parte.',
        'destroy'       => [
            'success'   => 'Personaje borrado de la organización.',
        ],
        'edit'          => [
            'description'   => 'Actualizar la organización de un personaje',
            'success'       => 'Organización del personaje actualizada.',
            'title'         => 'Actualizar organización para :name',
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
        'appearance_name'   => 'Pelo, Ojos, Piel, Altura...',
        'family'            => 'Por favor selecciona un personaje',
        'image'             => 'Imagen',
        'location'          => 'Selecciona una procedencia',
        'name'              => 'Nombre',
        'personality_entry' => 'Detalles',
        'personality_name'  => 'Objetivos, Manías, Miedos, Lazos...',
        'physical'          => 'Físico',
        'race'              => 'Raza',
        'sex'               => 'Género',
        'title'             => 'Título',
        'traits'            => 'Personalidad',
        'type'              => 'PNJ, Personaje Jugador, Divinidad...',
    ],
    'quests'        => [
        'description'   => 'Las misiones de las que el personaje forma parte.',
        'helpers'       => [
            'quest_giver'   => 'Misiones que el personaje ha promovido',
            'quest_member'  => 'Misiones de las que el personaje es miembro.',
        ],
        'title'         => 'Misiones de :name',
    ],
    'sections'      => [
        'appearance'    => 'Apariencia',
        'general'       => 'Información general',
        'personality'   => 'Personalidad',
    ],
    'show'          => [
        'description'   => 'Vista detallada del personaje',
        'tabs'          => [
            'conversations' => 'Conversaciones',
            'dice_rolls'    => 'Tiradas de dados',
            'items'         => 'Objetos',
            'journals'      => 'Diarios',
            'map'           => 'Mapa de relaciones',
            'organisations' => 'Organizaciones',
            'personality'   => 'Personalidad',
            'quests'        => 'Misiones',
        ],
        'title'         => 'Personaje :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'No puedes editar los rasgos de personalidad de este personaje.',
    ],
];
