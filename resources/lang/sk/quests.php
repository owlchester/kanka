<?php

return [

    'create'        => [
        'success'       => 'Úloha :name vytvorená.',
        'title'         => 'Nová úloha',
    ],
    'destroy'       => [
        'success'   => 'Úloha :name odstránená.',
    ],
    'edit'          => [
        'success'       => 'Úloha :name upravená.',
        'title'         => 'Upraviť úlohu :name',
    ],
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
            'quest'             => 'Úloha',
        ],
        'title'     => 'Prvky úlohy :name',
    ],
    'fields'        => [
        'character'     => 'Zadávateľ/ka',
        'copy_elements' => 'Kopírovať objekty priradené úlohám',
        'date'          => 'Dátum',
        'description'   => 'Popis',
        'image'         => 'Obrázok',
        'is_completed'  => 'Splnená',
        'name'          => 'Názov',
        'quest'         => 'Nadradená úloha',
        'quests'        => 'Podradená úloha',
        'role'          => 'Rola',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'is_completed'      => 'Zaškrtni, ak je daná úloha považovaná za splnenú.',
        'nested'            => 'Úlohy vieš usporiadať vnoreným zobrazením. Úlohy bez nadradenej úlohy sa zobrazia štandardným spôsobom. Úlohy s podradenými úlohami je možné rozkliknúť, dokiaľ nebudú existovať už žiadne ďalšie podradené úlohy.',
        'nested_parent'     => 'Zobraziť úlohy :parent.',
        'nested_without'    => 'Zobraziť všetky úlohy, ktoré nemajú nadradenú úlohu. Kliknutím na riadok zobrazíš podradené úlohy.',
    ],
    'hints'         => [
        'quests'    => 'Sieť prepojených úloh je možné vytvoriť cez nadradenú úlohu.',
    ],
    'index'         => [
        'add'           => 'Nová úloha',
        'header'        => 'Úlohy podradené :name',
        'title'         => 'Úlohy',
    ],
    'placeholders'  => [
        'date'  => 'Reálny dátum zadania úlohy',
        'name'  => 'Názov úlohy',
        'quest' => 'Nadradená úloha',
        'role'  => 'Rola objektu v úlohe',
        'type'  => 'príbeh postavy, bočná úloha, hlavný dej',
    ],
    'show'          => [
        'actions'       => [
            'add_element'       => 'Pridať prvok',
        ],
        'tabs'          => [
            'elements'      => 'Prvky',
            'quests'        => 'Úlohy',
        ],
        'title'         => 'Úloha :name',
    ],
];
