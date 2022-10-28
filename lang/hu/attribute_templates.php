<?php

return [
    'attribute_templates'   => [
        'title' => ':name tulajdonságsablon',
    ],
    'create'                => [
        'title' => 'Új tulajdonságsablon',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attribute_template'    => 'Előd tulajdonságsablon',
        'attributes'            => 'Tulajdonságok',
    ],
    'hints'                 => [
        'automatic'                 => 'A tulajdonságok automatikusan alkalmazásra kerülnek a :link tulajdonságsablonból.',
        'entity_type'               => 'Ha ez beállításra kerül, akkor egy új, ilyen típusú entitás létrehozásakor automatikusan alkalmazásra kerül rajta ez a tulajdonságsablon.',
        'parent_attribute_template' => 'Ez a tulajdonságsablon egy másik tulajdonságsablon leszármazottja lehet. Amikor alkalmazod ezt a tulajdonságsablont, ez és minden elődje alkalmazásra kerül.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'attribute_template'    => 'Válassz egy tulajdonságsablont!',
        'name'                  => 'A tulajdonságsablon neve',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Tulajdonságsablonok',
            'attributes'            => 'Tulajdonságok',
        ],
    ],
];
