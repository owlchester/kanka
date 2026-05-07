<?php

return [
    'create'        => [
        'title' => 'Nová úloha',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'        => [
            'success'   => 'Objekt :entity pridaný k úlohe.',
            'title'     => 'Nový prvok pre :name',
        ],
        'destroy'       => [
            'success'   => 'Prvok úlohy :entity odstránený.',
        ],
        'edit'          => [
            'success'   => 'Prvok úlohy :entity aktualizovaný.',
            'title'     => 'Aktualizovať prvok úlohy pre :name',
        ],
        'fields'        => [
            'copy_entity_entry' => 'Použiť popis objektu',
            'entity_or_name'    => 'Zvoľ buď objekt kampane, alebo pomenuj tento prvok.',
        ],
        'helpers'       => [
            'copy_entity_entry' => 'Zobraziť prepojený text objektu namiesto vlastného popisu.',
        ],
        'placeholders'  => [
            'name'  => 'Názov prvku',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Kopírovať objekty priradené úlohám',
        'date'          => 'Dátum',
        'element_role'  => 'Rola',
        'instigator'    => 'Podnet od',
        'is_completed'  => 'Splnená',
        'location'      => 'Štartovacie miesto',
        'role'          => 'Rola',
        'status'        => 'Stav',
    ],
    'helpers'       => [
        'is_completed'  => 'Daná úloha je považovaná za splnenú.',
        'status'        => 'Aktuálny stav danej úlohy.',
    ],
    'hints'         => [
        'is_abandoned'  => 'Úloha bola opustená.',
        'is_completed'  => 'Úloha je splnená.',
        'is_ongoing'    => 'Plnenie úlohy prebieha.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Vytvor úlohy pre zaznamenávanie cieľov, príbehových liniek alebo motivácií postáv.',
    ],
    'placeholders'  => [
        'date'      => 'Reálny dátum zadania úlohy',
        'entity'    => 'Názov prvku v úlohe',
        'location'  => 'Štartovacie miesto úlohy',
        'role'      => 'Rola objektu v úlohe',
        'type'      => 'príbeh postavy, bočná úloha, hlavný dej',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Pridať prvok',
        ],
        'tabs'      => [
            'elements'  => 'Prvky',
        ],
    ],
    'status'        => [
        'abandoned'     => 'Opustená',
        'completed'     => 'Splnená',
        'not_started'   => 'Nezačatá',
        'ongoing'       => 'Prebiehajúca',
    ],
];
