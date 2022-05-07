<?php

return [
    'actions'       => [
        'add_element'   => 'Elem hozzáadása az korszakhoz: :era',
        'back'          => 'Vissza ide: :name',
        'edit'          => 'Idővonal szerkesztése',
        'reorder'       => 'Átrendezés',
        'save_order'    => 'Új sorrend mentése',
    ],
    'create'        => [
        'success'   => 'A \':name\' idővonalat létrehoztuk.',
        'title'     => 'Új idővonal',
    ],
    'destroy'       => [
        'success'   => 'A \':name\' idővonalat eltávolítottuk.',
    ],
    'edit'          => [
        'success'   => 'A \':name\' idővonalat frissítettük.',
        'title'     => ':name idővonal szerkesztése',
    ],
    'fields'        => [
        'copy_eras'     => 'Korszakok másolása',
        'eras'          => 'Korszakok',
        'name'          => 'Név',
        'reverse_order' => 'Fordított korszak sorrend',
        'timeline'      => 'Szülőidővonal',
        'timelines'     => 'Idővonalak',
        'type'          => 'Típus',
    ],
    'helpers'       => [
        'nested_parent'     => ':parent idővonalainak megmutatása',
        'nested_without'    => 'Minden idővonal megmutatása, aminek nincs szülője. Klikkelj egy sorra, hogy lásd a gyermekidővonalait.',
        'reorder'           => 'Fogd és vidd az elemeket az átrendezésükhöz.',
        'reorder_tooltip'   => 'Klikkelj a fodg és vidd manuális sorbarendezés eléréséhez.',
        'reverse_order'     => 'Pipáld ki, hogy a korszakok fordított időrendi sorrendben jelenjenek meg. (A legrégebbi korszak legelőször.)',
    ],
    'index'         => [
        'title' => 'Idővonalak',
    ],
    'placeholders'  => [
        'name'  => 'Az idővonal neve',
        'type'  => 'Elsődleges, Világkrónika, stb.',
    ],
    'show'          => [],
    'timelines'     => [
        'title' => ':name idővonal idővonalai',
    ],
];
