<?php

return [
    'actions'       => [
        'add_element'   => 'Elem hozzáadása az korszakhoz: :era',
        'back'          => 'Vissza ide: :name',
        'edit'          => 'Idővonal szerkesztése',
        'save_order'    => 'Új sorrend mentése',
    ],
    'create'        => [
        'title' => 'Új idővonal',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_eras'     => 'Korszakok másolása',
        'eras'          => 'Korszakok',
        'reverse_order' => 'Fordított korszak sorrend',
        'timeline'      => 'Szülőidővonal',
        'timelines'     => 'Idővonalak',
    ],
    'helpers'       => [
        'nested_without'    => 'Minden idővonal megmutatása, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermekidővonalait.',
        'reverse_order'     => 'Pipáld ki, hogy a korszakok fordított időrendi sorrendben jelenjenek meg. (A legrégebbi korszak legelőször.)',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Az idővonal neve',
        'type'  => 'Elsődleges, Világkrónika, stb.',
    ],
    'show'          => [],
    'timelines'     => [
        'title' => ':name idővonal idővonalai',
    ],
];
