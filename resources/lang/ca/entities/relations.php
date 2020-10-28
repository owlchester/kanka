<?php

return [
    'create'        => [
        'success'   => 'S\'ha afegit la relació :target a :entity.',
        'title'     => 'Nova relació per :name',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat la relació :target de :entity.',
    ],
    'fields'        => [
        'attitude'  => 'Actitud',
        'is_star'   => 'Fixada',
        'relation'  => 'Relació',
        'target'    => 'Objectiu',
        'two_way'   => 'Emmiralla la relació',
    ],
    'helper'        => 'Crea relacions entre entitats i configura\'n l\'actitud i visibilitat. Les relacions també poden fixar-se al menú de l\'entitat.',
    'hints'         => [
        'attitude'  => 'Aquí es pot definir opcionalment l\'ordre en què les relacions apareixen per defecte de forma descendent.',
        'mirrored'  => [
            'text'  => 'Aquesta relació està emmirallada amb :link.',
            'title' => 'Emmirallada',
        ],
        'two_way'   => 'Al emmirallar una relació, aquesta es copia a l\'objectiu seleccionat. Tanmateix, si editeu una, l\'atra no es veu afectada.',
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
        'family_member' => 'Familiar',
    ],
    'update'        => [
        'success'   => 'S\'ha actualitzat la relació :target de :entity.',
        'title'     => 'Actualiza les relacions de :name',
    ],
];
