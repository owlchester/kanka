<?php

return [
    'actions'   => [
        'current'   => 'Текущая тема: :theme',
        'disable'   => 'Отключить',
        'enable'    => 'Включить',
        'new'       => 'Новый стиль',
    ],
    'bulks'     => [
        'delete'    => '{1} Удален :count стиль.|[2,4] Удалено :count стиля.|[5,20] Удалено :count стилей.|{21} Удален :count стиль.|[22,24] Удалено :count стиля.|[25,*] Удалено :count стилей.',
        'disable'   => '{1} Отключен :count стиль.|[2,4] Отключено count стиля.|[5,20] Отключено :count стилей.|{21} Отключен :count стиль.|[22,24] Отключено :count стиля.|[25,*] Отключено :count стилей.',
        'enable'    => '{1} Включен :count стиль.|[2,4] Включено count стиля.|[5,20] Включено :count стилей.|{21} Включен :count стиль.|[22,24] Включено :count стиля.|[25,*] Включено :count стилей.',
    ],
    'create'    => [
        'success'   => 'Новый стиль создан.',
        'title'     => 'Новый стиль',
    ],
    'delete'    => [
        'success'   => 'Стиль ":name" удален.',
    ],
    'errors'    => [
        'max_content'   => 'CSS правило не может быть содержать более :amount символов.',
        'max_reached'   => 'Достигнуто максимальное количество стилей (:max).',
    ],
    'fields'    => [
        'content'       => 'CSS',
        'is_enabled'    => 'Включен',
        'length'        => 'Длина',
        'modified'      => 'Изменен',
        'name'          => 'Название',
        'order'         => 'Порядок',
    ],
    'helpers'   => [
        'here'  => 'в нашем блоге',
        'main'  => 'Вы можете создавать собственные CSS стили для своих усиленных кампаний. Эти стили применяются после всех тем из Каталога, примененных к кампании. Больше о стилях кампаний можно узнать :here.',
    ],
    'pitch'     => 'Напишите собственный код на CSS, для полного контроля над видом и атмосферой кампании.',
    'reorder'   => [
        'save'      => 'Сохранить новый порядок',
        'success'   => '{1} Изменен порядок :count стиля.|[2,20] Изменен порядок :count стилей.|{21} Изменен порядок :count стиля.|[22,*] Изменен порядок :count стилей.',
        'title'     => 'Изменение порядка стилей',
    ],
    'theme'     => [
        'success'   => 'Тема кампании обновлена.',
        'title'     => 'Изменение темы кампании',
    ],
    'title'     => 'Стили кампании',
    'update'    => [
        'success'   => 'Стиль ":name" обновлен.',
        'title'     => 'Редактирование стиля',
    ],
];
