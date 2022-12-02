<?php

return [
    'actions'       => [
        'add_appearance'    => 'Afegeix aparença',
        'add_organisation'  => 'Afegeix una organització',
        'add_personality'   => 'Afegeix personalitat',
    ],
    'conversations' => [
        'title' => 'Converses de :name',
    ],
    'create'        => [
        'title' => 'Nou personatge',
    ],
    'destroy'       => [],
    'dice_rolls'    => [
        'hint'  => 'Es poden assignar tirades de daus a un personatge per utilitzar-les durant el joc.',
        'title' => 'Tirades de daus de :name',
    ],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Edat',
        'families'                  => 'Famílies',
        'is_appearance_pinned'      => 'Aparença fixada',
        'is_dead'                   => 'És mort',
        'is_personality_pinned'     => 'Personalitat fixada',
        'is_personality_visible'    => 'Personalitat visible',
        'life'                      => 'Biografia',
        'physical'                  => 'Aparença',
        'pronouns'                  => 'Pronoms',
        'sex'                       => 'Gènere',
        'title'                     => 'Títol',
        'traits'                    => 'Personalitat',
    ],
    'helpers'       => [
        'age'   => 'Es pot vincular aquesta entitat amb un calendari de la campanya per calcular automàticament la seva edat. :more',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Si està marcat, l\'aparença del personatge apareixerà sota l\'entrada principal a la pàgina.',
        'is_dead'                   => 'Aquest personatge és mort',
        'is_personality_pinned'     => 'Si està marcat, els trets de personalitat del personatge apareixeran sota l\'entrada principal a la pàgina.',
        'is_personality_visible'    => 'La secció de la personalitat es pot ocultar als usuaris no administradors.',
        'personality_not_visible'   => 'Els trets de personalitat d\'aquest personatge ara només són visibles pels administradors.',
        'personality_visible'       => 'Els trets de personalitat d\'aquest personatge són visibles per a tothom.',
    ],
    'index'         => [],
    'items'         => [
        'hint'  => 'Aquí es mostren els objectes assignats als personatges.',
        'title' => 'Objectes de :name',
    ],
    'journals'      => [
        'title' => 'Diaris de :name',
    ],
    'maps'          => [
        'title' => 'Mapa de relacions de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Afegeix una organització',
        ],
        'create'        => [
            'success'   => 'S\'ha afegit el personatge a l\'organització.',
            'title'     => 'Nova organització per a :name',
        ],
        'destroy'       => [
            'success'   => 'S\'ha tret el personatge de l\'organització.',
        ],
        'edit'          => [
            'success'   => 'S\'ha actualitzat l\'organització del personatge.',
            'title'     => 'Actualiza l\'organizació de :name',
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
        'personality_entry' => 'Detalls',
        'personality_name'  => 'Objectius, manies, pors, fortaleses...',
        'physical'          => 'Físic',
        'pronouns'          => 'Ell, ella...',
        'sex'               => 'Gènere',
        'title'             => 'Títol',
        'traits'            => 'Trets característics',
        'type'              => 'PNJ, Personatge Jugador, divinitat...',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Les missions que ha iniciat el personatge.',
            'quest_member'  => 'Les missions on el personatge és un membre.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Aparença',
        'general'       => 'Informació general',
        'personality'   => 'Personalitat',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organitzacions',
        ],
    ],
    'warnings'      => [
        'personality_hidden'    => 'No teniu permís per editar els trets de personalitat d\'aquest personatge.',
    ],
];
