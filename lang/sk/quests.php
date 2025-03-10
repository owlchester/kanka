<?php

return [
    'create'        => [
        'title' => 'Nová úloha',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Objekt :entity pridaný k úlohe.',
            'title'     => 'Nový prvok pre :name',
        ],
        'destroy'   => [
            'success'   => 'Prvok úlohy :entity odstránený.',
        ],
        'edit'      => [
            'success'   => 'Prvok úlohy :entity aktualizovaný.',
            'title'     => 'Aktualizovať prvok úlohy pre :name',
        ],
        'fields'    => [
            'description'       => 'Popis',
            'entity_or_name'    => 'Zvoľ buď objekt kampane, alebo pomenuj tento prvok.',
            'name'              => 'Názov',
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
    ],
    'helpers'       => [
        'is_completed'  => 'Zaškrtni, ak je daná úloha považovaná za splnenú.',
    ],
    'hints'         => [
        'quests'    => 'Sieť prepojených úloh je možné vytvoriť cez nadradenú úlohu.',
    ],
    'index'         => [],
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
];
