<?php

return [
    'create'        => [
        'success'   => 'Журнал ":name" создан.',
        'title'     => 'Новый журнал',
    ],
    'destroy'       => [
        'success'   => 'Журнал ":name" удален.',
    ],
    'edit'          => [
        'success'   => 'Журнал ":name" обновлен.',
        'title'     => 'Редактирование журнала :name',
    ],
    'fields'        => [
        'author'    => 'Автор',
        'date'      => 'Дата',
        'image'     => 'Изображение',
        'journal'   => 'Родительский журнал',
        'journals'  => 'Журналы-потомки',
        'name'      => 'Название',
        'type'      => 'Тип',
    ],
    'helpers'       => [
        'journals'      => 'Потомков потомков этого журнала можно скрыть.',
        'nested_parent' => 'Показаны журналы, входящие в :parent.',
        'nested_without'=> 'Показаны все журналы, у которых нет родительских журналов. Нажмите на строку журнала, чтобы увидеть список его журналов-потомков.',
    ],
    'index'         => [
        'title' => 'Журналы',
    ],
    'journals'      => [
        'title' => 'Потомки журнала :name',
    ],
    'placeholders'  => [
        'author'    => 'Тот, кто написал этот журнал',
        'date'      => 'Дата реального мира для журнала',
        'journal'   => 'Выберите родительский журнал',
        'name'      => 'Название журнала',
        'type'      => 'Сессия, one-shot, черновик',
    ],
    'show'          => [
        'tabs'  => [
            'journals'  => 'Журналы',
        ],
    ],
];
