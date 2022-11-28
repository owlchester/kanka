<?php

return [
    'actions'       => [
        'add'   => 'Добавить новую группу',
    ],
    'bulks'         => [
        'delete'    => '{1} Удалена :count группа.|[2,4] Удалено :count группы.|[5,*] Удалено :count групп.',
        'patch'     => '{1} Обновлена :count группа.|[2,4] Обновлено :count группы.|[5,*] Обновлено :count групп.',
    ],
    'create'        => [
        'success'   => 'Группа ":name" создана.',
        'title'     => 'Новая группа',
    ],
    'delete'        => [
        'success'   => 'Группа ":name" удалена.',
    ],
    'edit'          => [
        'success'   => 'Группа ":name" обновлена.',
        'title'     => 'Редактирование группы :name',
    ],
    'fields'        => [
        'is_shown'  => 'Показывать по умолчанию',
        'position'  => 'Позиция',
    ],
    'helper'        => [
        'amount_v3' => 'Метки можно объединять в группы. При исследовании карты группы меток можно скрыть или показать одним нажатием.',
    ],
    'hints'         => [
        'is_shown'  => 'Метки группы будут видны по умолчанию.',
    ],
    'index'         => [
        'title' => 'Группы карты :name',
    ],
    'pitch'         => [
        'error' => 'Достигнуто максимальное число групп.',
        'until' => 'Создавайте до :max групп на каждой карте.',
    ],
    'placeholders'  => [
        'name'          => 'Магазины, клады, NPC',
        'position'      => 'Первая',
        'position_list' => 'После :name',
    ],
    'reorder'       => [
        'save'      => 'Сохранить порядок',
        'success'   => '{1} Изменен порядок :count группы.|[2,*] Изменен порядок :count групп.',
        'title'     => 'Изменение порядка групп',
    ],
];
