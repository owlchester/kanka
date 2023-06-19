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
        'warning'   => [
            'editing'   => [
                'description'   => 'Zdá sa, že iná osoba upravuje súčasne tento prvok úlohy! Chceš sa vrátiť a ignorovať toto varovanie aj s rizikom straty dát? Členstvo súčasne editujúce tento prvok:',
            ],
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Kopírovať objekty priradené úlohám',
        'date'          => 'Dátum',
        'element_role'  => 'Rola',
        'is_completed'  => 'Splnená',
        'role'          => 'Rola',
    ],
    'helpers'       => [
        'is_completed'      => 'Zaškrtni, ak je daná úloha považovaná za splnenú.',
        'nested_without'    => 'Zobraziť všetky úlohy, ktoré nemajú nadradenú úlohu. Kliknutím na riadok zobrazíš podradené úlohy.',
    ],
    'hints'         => [
        'quests'    => 'Sieť prepojených úloh je možné vytvoriť cez nadradenú úlohu.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'      => 'Reálny dátum zadania úlohy',
        'entity'    => 'Názov prvku v úlohe',
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
