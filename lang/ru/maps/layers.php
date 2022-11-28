<?php

return [
    'actions'       => [
        'add'   => 'Новый слой',
    ],
    'base'          => 'Основной слой',
    'bulks'         => [
        'delete'    => '{1} Удален :count слой.|[2,4] Удалено :count слоя.|[5,*] Удалено :count слоев.',
        'patch'     => '{1} Обновлен :count слой.|[2,4] Обновлено :count слоя.|[5,*] Обновлено :count слоев.',
    ],
    'create'        => [
        'success'   => 'Слой ":name" создан.',
        'title'     => 'Новый слой',
    ],
    'delete'        => [
        'success'   => 'Слой ":name" удален.',
    ],
    'edit'          => [
        'success'   => 'Слой ":name" обновлен.',
        'title'     => 'Редактирование слоя :name',
    ],
    'fields'        => [
        'position'  => 'Позиция',
        'type'      => 'Тип слоя',
    ],
    'helper'        => [
        'amount_v2' => 'Загружайте слои карты в виде переключаемых фоновых изображений, показываемых под метками, или перекрывающих, показываемых поверх карты, но под метками.',
        'is_real'   => 'Слои не доступны при использовании OpenStreetMaps.',
    ],
    'index'         => [
        'title' => 'Слои карты :name',
    ],
    'pitch'         => [
        'error' => 'Достигнуто максимальное число слоев.',
        'until' => 'Загружайте до :max слоев для каждой карты.',
    ],
    'placeholders'  => [
        'name'          => 'Подземный этаж, уровень 2, затонувший корабль',
        'position'      => 'Первая',
        'position_list' => 'После :name',
    ],
    'reorder'       => [
        'save'      => 'Сохранить порядок',
        'success'   => '{1} Изменен порядок :count слоя.|[2,*] Изменен порядок :count слоев.',
        'title'     => 'Изменение порядка слоев',
    ],
    'short_types'   => [
        'overlay'       => 'Перекрывающий (скрытый)',
        'overlay_shown' => 'Перекрывающий (видимый)',
        'standard'      => 'Обычный',
    ],
    'types'         => [
        'overlay'       => 'Перекрывающий, скрытый по умолчанию',
        'overlay_shown' => 'Перекрывающий, видимый по умолчанию',
        'standard'      => 'Обычный (самостоятельный)',
    ],
];
