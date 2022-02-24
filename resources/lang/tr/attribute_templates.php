<?php

return [
    'attribute_templates'   => [
        'title' => ':name özellik taslakları',
    ],
    'create'                => [
        'success'   => '\':name\' Özellik Taslağı yaratıldı.',
        'title'     => 'Yeni Özellik Taslağı',
    ],
    'destroy'               => [
        'success'   => '\':name\' Özellik Taslağı kaldırıldı.',
    ],
    'edit'                  => [
        'success'   => '\':name\' Özellik Taslağı güncellendi.',
        'title'     => ':name Özellik Taslağını Düzenle',
    ],
    'fields'                => [
        'attribute_template'    => 'Ana Özellik Taslağı',
        'attributes'            => 'Özellikler',
        'name'                  => 'Ad',
    ],
    'hints'                 => [
        'automatic'                 => 'Özellikler :link Özellik Taslağından otomatik olarak uygulanır.',
        'entity_type'               => 'Eğer seçilirse, bu türde yeni bir varlık yaratmak otomatik olarak bu taslağı ona uygular.',
        'parent_attribute_template' => 'Bu özellik taslağı başka bir özellik taslağının alt taslağı olabilir. Bu özellik taslağı uygulanırken, kendisi ve bütün üst taslakları uygulanacak.',
    ],
    'index'                 => [
        'add'       => 'Yeni Özellik Taslağı',
        'header'    => ':name Özellik Taslakları',
        'title'     => 'Özellik Taslakları',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Bir özellik taslağı seçin',
        'name'                  => 'Özellik Taslağının adı',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Özellik Taslakları',
            'attributes'            => 'Özellikler',
        ],
        'title' => ':name Özellik Taslağı',
    ],
];
