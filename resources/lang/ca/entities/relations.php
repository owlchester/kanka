<?php

return [
    'actions'       => [
        'mode-map'      => 'Eina d\'exploració de relacions',
        'mode-table'    => 'Taula de relacions i connexions',
    ],
    'bulk'          => [
        'delete'    => '{1} S\'ha eliminat :count relació.|[2,*] S\'han esborrat :count relacions.',
        'success'   => [
            'editing'           => '{1} S\'ha actualitzat :count relació.|[2,*] S\'han actualitzat :count relacions.',
            'editing_partial'   => '{1} S\'ha actualitzat :count/:total relació.|[2,*] S\'han actualitzat :count/:total relacions.',
        ],
    ],
    'connections'   => [
        'map_point'         => 'Punt del mapa',
        'mention'           => 'Menció',
        'quest_element'     => 'Element de missió',
        'timeline_element'  => 'Element de línia temporal',
    ],
    'create'        => [
        'new_title' => 'Nova relació',
        'success'   => 'S\'ha afegit la relació :target a :entity.',
        'title'     => 'Nova relació per :name',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat la relació :target de :entity.',
    ],
    'fields'        => [
        'attitude'          => 'Actitud',
        'connection'        => 'Connexió',
        'is_star'           => 'Fixada',
        'owner'             => 'Origen',
        'relation'          => 'Relació',
        'target'            => 'Objectiu',
        'target_relation'   => 'Relació objectiu',
        'two_way'           => 'Emmiralla la relació',
    ],
    'helper'        => 'Crea relacions entre entitats i configura\'n l\'actitud i visibilitat. Les relacions també poden fixar-se al menú de l\'entitat.',
    'hints'         => [
        'attitude'          => 'Aquí es pot definir opcionalment l\'ordre en què les relacions apareixen per defecte de forma descendent.',
        'mirrored'          => [
            'text'  => 'Aquesta relació està emmirallada amb :link.',
            'title' => 'Emmirallada',
        ],
        'target_relation'   => 'La descripció de la relació a l\'objectiu. Deixeu-ho en blanc per a utilitzar el text d\'aquesta relació.',
        'two_way'           => 'Al emmirallar una relació, aquesta es copia a l\'objectiu seleccionat. Tanmateix, si editeu una, l\'atra no es veu afectada.',
    ],
    'index'         => [
        'add'   => 'Nova relació',
        'title' => 'Relacions',
    ],
    'options'       => [
        'mentions'  => 'Relacions + relacionades + mencions',
        'related'   => 'Relacions + relacionades',
        'relations' => 'Relacions',
        'show'      => 'Mostra',
    ],
    'panels'        => [
        'related'   => 'Relacionades',
    ],
    'placeholders'  => [
        'attitude'  => 'Des de -100 fins a 100, sent 100 molt positiva.',
        'relation'  => 'Rival, millor amic, germà...',
        'target'    => 'Trieu una entitat',
    ],
    'show'          => [
        'title' => 'Relacions de :name',
    ],
    'teaser'        => 'Milloreu la campanya per a accedir a l\'explorador de relacions. Cliqueu aquí per saber més sobre les campanyes millorades.',
    'types'         => [
        'family_member'         => 'Familiar',
        'organisation_member'   => 'Membre d\'organització',
    ],
    'update'        => [
        'success'   => 'S\'ha actualitzat la relació :target de :entity.',
        'title'     => 'Actualiza les relacions de :name',
    ],
];
