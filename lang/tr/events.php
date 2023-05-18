<?php

return [
    'create'        => [
        'title' => 'Yeni Olay',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'date'  => 'Tarih',
    ],
    'helpers'       => [
        'date'  => 'Bu alan her şeyi içinde bulundurabilir ve serüvenin takvimlerine bağlı değildir. Bu olayı bir takvime bağlamak için, olayı takvimde ya da bu olayın hatırlatıcılar sekmesinde ekleyin.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Olayınız için bir tarih',
        'type'  => 'Seremoni, Festival, Felaket, Savaş, Doğum',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Takvim Girdileri',
    ],
];
