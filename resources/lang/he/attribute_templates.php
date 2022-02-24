<?php

return [
    'attribute_templates'   => [
        'title' => 'תבניות מאפיינים של :name',
    ],
    'create'                => [
        'success'   => 'תבנית מאפיינים \':name\' נוצרה.',
        'title'     => 'תבנית מאפיינים חדשה',
    ],
    'destroy'               => [
        'success'   => 'תבנית מאפיינים \':name\' הוסרה.',
    ],
    'edit'                  => [
        'success'   => 'תבנית מאפיינים \':name, עודכה.',
        'title'     => 'ערוך תבנית מאפיינים :name',
    ],
    'fields'                => [
        'attribute_template'    => 'תבנית אם',
        'attributes'            => 'מאפיינים',
        'name'                  => 'שם',
    ],
    'hints'                 => [
        'automatic'                 => 'מאפיינים שנוצרו אוטומטית מהתבנית :link',
        'entity_type'               => 'אם נקבע, כל אובייקט חדש מסוג זה יקבל את המאפיינים של התבנית הזו.',
        'parent_attribute_template' => 'תבנית מאפיינים יכולה להיות צאצא של תבנית מאפיינים אחרת. אם מייחסים אובייקט לתבנית זו, הוא יקבל גם את המאפיינים של כל ההורים שלה.',
    ],
    'index'                 => [
        'add'       => 'תבנית מאפיינים חדשה',
        'header'    => 'תבניות המאפיינים של :name',
        'title'     => 'תבניות מאפיינים',
    ],
    'placeholders'          => [
        'attribute_template'    => 'בחר תבנית מאפיינים',
        'name'                  => 'שם תבנית המאפיינים',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'תבניות מאפיינים',
            'attributes'            => 'מאפיינים',
        ],
        'title' => 'תבנית מאפיינים :name',
    ],
];
