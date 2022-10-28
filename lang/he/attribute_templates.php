<?php

return [
    'attribute_templates'   => [
        'title' => 'תבניות מאפיינים של :name',
    ],
    'create'                => [
        'title' => 'תבנית מאפיינים חדשה',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attribute_template'    => 'תבנית אם',
        'attributes'            => 'מאפיינים',
    ],
    'hints'                 => [
        'automatic'                 => 'מאפיינים שנוצרו אוטומטית מהתבנית :link',
        'entity_type'               => 'אם נקבע, כל אובייקט חדש מסוג זה יקבל את המאפיינים של התבנית הזו.',
        'parent_attribute_template' => 'תבנית מאפיינים יכולה להיות צאצא של תבנית מאפיינים אחרת. אם מייחסים אובייקט לתבנית זו, הוא יקבל גם את המאפיינים של כל ההורים שלה.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'attribute_template'    => 'בחר תבנית מאפיינים',
        'name'                  => 'שם תבנית המאפיינים',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'תבניות מאפיינים',
            'attributes'            => 'מאפיינים',
        ],
    ],
];
