<?php

return [
    'create'        => [
        'title' => 'Новая заметка',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Подзаметки',
    ],
    'helpers'       => [
        'nested_without'    => 'Показаны все заметки без родительских заметок. Нажмите на строку заметки, чтобы увидеть список ее подзаметок.',
    ],
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Выберите родительскую заметку',
        'type'  => 'Религия, раса, политика',
    ],
    'show'          => [],
];
