<?php

return [
    'attribute_templates'   => [
        'title' => ':name tulajdonságsablon',
    ],
    'create'                => [
        'description'   => 'Új tulajdonságsablon készítése',
        'success'       => '\':name\' tulajdonságsablon létrehoztuk.',
        'title'         => 'Új tulajdonságsablon',
    ],
    'destroy'               => [
        'success'   => '\':name\' tulajdonságsablon eltávolítottuk.',
    ],
    'edit'                  => [
        'description'   => 'Tulajdonságsablon szerkesztése',
        'success'       => '\':name\' tulajdonságsablon frissítettük.',
        'title'         => ':name tulajdonságsablon szerkesztése',
    ],
    'fields'                => [
        'attribute_template'    => 'Előd tulajdonságsablon',
        'attributes'            => 'Tulajdonságok',
        'name'                  => 'Név',
    ],
    'hints'                 => [
        'automatic'                 => 'A tulajdonságok automatikusan alkalmazásra kerülnek a :link tulajdonságsablonból.',
        'entity_type'               => 'Ha ez beállításra kerül, akkor egy új, ilyen típusú entitás létrehozásakor automatikusan alkalmazásra kerül rajta ez a tulajdonságsablon.',
        'parent_attribute_template' => 'Ez a tulajdonságsablon egy másik tulajdonságsablon leszármazottja lehet. Amikor alkalmazod ezt a tulajdonságsablont, ez és minden elődje alkalmazásra kerül.',
    ],
    'index'                 => [
        'add'           => 'Új tulajdonságsablon',
        'description'   => ':name tulajdonságsablon kezelése',
        'header'        => ':name tulajdonságsablon',
        'title'         => 'Tulajdonságsablonok',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Válassz egy tulajdonságsablont!',
        'name'                  => 'A tulajdonságsablon neve',
    ],
    'show'                  => [
        'description'   => 'Egy tulajdonságsablon részletes megjelenítése',
        'tabs'          => [
            'attribute_templates'   => 'Tulajdonságsablonok',
            'attributes'            => 'Tulajdonságok',
        ],
        'title'         => ':name tulajdonságsablon',
    ],
];
