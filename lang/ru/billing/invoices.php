<?php

return [
    'actions'       => [
        'download'  => 'Скачать PDF',
    ],
    'description'   => 'Показаны счета за последние 24 месяца.',
    'empty'         => 'Счетов не найдено.',
    'fields'        => [
        'amount'    => 'Сумма',
        'date'      => 'Дата',
        'invoice'   => 'Счет',
        'status'    => 'Статус',
    ],
    'status'        => [
        'paid'      => 'Оплачен',
        'pending'   => 'Обрабатывается',
    ],
    'title'         => 'История счетов',
];
