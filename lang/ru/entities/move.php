<?php

return [
    'actions'       => [
        'copy'  => 'Копировать',
        'move'  => 'Переместить',
    ],
    'errors'        => [
        'permission'        => 'У вас нет разрешения на создание объектов этого типа в данной кампании.',
        'permission_update' => 'У вас нет разрешения на перемещение этого объекта.',
        'same_campaign'     => 'Выберите кампанию, в которую нужно переместить объект.',
        'unknown_campaign'  => 'Неизвестная кампания.',
    ],
    'fields'        => [
        'campaign'      => 'Кампания',
        'copy'          => 'Создать копию',
        'select_one'    => 'Выберите кампанию',
    ],
    'panel'         => [
        'description'           => 'Выберите кампанию, в которую вы хотите переместить или копировать этот объект.',
        'description_bulk_copy' => 'Выберите кампанию, в которую вы хотите копировать выбранные объекты.',
        'title'                 => 'Перемещение или копирование объекта в другую кампанию',
    ],
    'success'       => 'Объект ":name" перемещен.',
    'success_copy'  => 'Объект ":name" скопирован.',
    'title'         => 'Перемещение :name',
];
