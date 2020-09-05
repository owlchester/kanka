<?php

return [
    'actions'       => [
        'add_appearance'    => 'Afegeix aparença',
        'add_organisation'  => 'Afegeix una organització',
        'add_personality'   => 'Afegeix personalitat',
    ],
    'conversations' => [
        'description'   => 'Converses on el personatge participa.',
        'title'         => 'Converses de :name',
    ],
    'create'        => [
        'description'   => 'Crea un nou personatge',
        'success'       => 'S\'ha creat el personatge «:name».',
        'title'         => 'Nou personatge',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat el personatge «:name».',
    ],
    'dice_rolls'    => [
        'description'   => 'Tirades de daus assignades al personatge.',
        'hint'          => 'Es poden assignar tirades de daus a un personatge per utilitzar-les durant el joc.',
        'title'         => 'Tirades de daus de :name',
    ],
    'edit'          => [
        'description'   => 'Edita el personatge',
        'success'       => 'S\'ha actualitzat el personatge «:name».',
        'title'         => 'Edita el personatge :name',
    ],
    'fields'        => [
        'age'                       => 'Edat',
        'family'                    => 'Família',
        'image'                     => 'Imatge',
        'is_dead'                   => 'És mort',
        'is_personality_visible'    => 'Personalitat visible',
        'life'                      => 'Biografia',
        'location'                  => 'Procedència',
        'name'                      => 'Nom',
        'physical'                  => 'Aparença',
        'race'                      => 'Raça',
        'relation'                  => 'Relació',
        'sex'                       => 'Gènere',
        'title'                     => 'Títol',
        'traits'                    => 'Personalitat',
        'type'                      => 'Tipus',
    ],
    'helpers'       => [
        'age'   => 'Es pot vincular aquesta entitat amb un calendari de la campanya per calcular automàticament la seva edat. :more',
        'free'  => '¿No encuentras el campo "Libre"? Si este personaje tenía uno, ha sido movido a la nueva pestaña de Notas.',
    ],
    'hints'         => [
        'hide_personality'          => 'Es pot ocultar aquesta pestanya puede ocultarse als usuaris no administradors desactivant la opció «Personalitat visible» a l\'edició del personatge.',
        'is_dead'                   => 'Aquest personatge és mort',
        'is_personality_visible'    => 'La secció de la personalitat es pot ocultar als usuaris no administradors.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Nou personatge aleatori',
        ],
        'add'           => 'Nou personatge',
        'description'   => 'Gestiona els personatges de :name.',
        'header'        => 'Personatges de :name',
        'title'         => 'Personatges',
    ],
    'items'         => [
        'description'   => 'Els objectes que duu el personatge.',
        'hint'          => 'Aquí es mostren els objectes assignats als personatges.',
        'title'         => 'Objectes de :name',
    ],
    'journals'      => [
        'description'   => 'Diaris que ha escrit el personatge.',
        'title'         => 'Diaris de :name',
    ],
    'maps'          => [
        'description'   => 'Mapa de relacions d\'un personatge.',
        'title'         => 'Mapa de relacions de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Afegeix una organització',
        ],
        'create'        => [
            'description'   => 'Associa una organització a un personatge',
            'success'       => 'S\'ha afegit el personatge a l\'organització.',
            'title'         => 'Nova organització per a :name',
        ],
        'description'   => 'Organizacions on es troba el personatge.',
        'destroy'       => [
            'success'   => 'S\'ha tret el personatge de l\'organització.',
        ],
        'edit'          => [
            'description'   => 'Actualiza l\'organizació d\'un personatge',
            'success'       => 'S\'ha actualitzat l\'organització del personatge.',
            'title'         => 'Actualiza l\'organizació de :name',
        ],
        'fields'        => [
            'organisation'  => 'Organització',
            'role'          => 'Rol',
        ],
        'hint'          => 'Els personatges poden formar part de moltes organitzacions, per representar per a qui treballen o a quina secta van tots els divendres a la tarda.',
        'placeholders'  => [
            'organisation'  => 'Trieu una organització',
        ],
        'title'         => 'Organitzacions de :name',
    ],
    'placeholders'  => [
        'age'               => 'Edat',
        'appearance_entry'  => 'Descripció',
        'appearance_name'   => 'Cabells, ulls, pell, alçada...',
        'family'            => 'Seleccioneu un personatge',
        'image'             => 'Imatge',
        'location'          => 'Seleccioneu una procedència',
        'name'              => 'Nom',
        'personality_entry' => 'Detalls',
        'personality_name'  => 'Objectius, manies, pors, fortaleses...',
        'physical'          => 'Físic',
        'race'              => 'Raça',
        'sex'               => 'Gènere',
        'title'             => 'Títol',
        'traits'            => 'Trets característics',
        'type'              => 'PNJ, Personatge Jugador, divinitat...',
    ],
    'quests'        => [
        'description'   => 'Les missions on participa el personatge.',
        'helpers'       => [
            'quest_giver'   => 'Les missions que ha iniciat el personatge.',
            'quest_member'  => 'Les missions on el personatge és un membre.',
        ],
        'title'         => 'Missions de :name',
    ],
    'sections'      => [
        'appearance'    => 'Aparença',
        'general'       => 'Informació general',
        'personality'   => 'Personalitat',
    ],
    'show'          => [
        'description'   => 'Vista detallada del personatge',
        'tabs'          => [
            'conversations' => 'Converses',
            'dice_rolls'    => 'Tirades de daus',
            'items'         => 'Objectes',
            'journals'      => 'Diaris',
            'map'           => 'Mapa de relacions',
            'organisations' => 'Organitzacions',
            'personality'   => 'Trets',
            'quests'        => 'Missions',
        ],
        'title'         => 'Personatge :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'No teniu permís per editar els trets de personalitat d\'aquest personatge.',
    ],
];
