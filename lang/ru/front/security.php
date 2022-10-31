<?php

return [
    'communication' => [
        'description'   => 'Все данные пользователей транспортируются безопасно и конфиденциально образом, поскольку они шифруются in transit с помощью SSL. Шифрование данных in transit защищает их от несанкционированной слежки, модификации, а также от атак посредников.',
        'title'         => 'Безопасный обмен данными',
    ],
    'credit-card'   => [
        'description'   => 'Мы не сохраняем информацию Ваших кредитных карт. Вы используем Stripe для обработки кредитных карт. При этом вся коммуникация между Вами, нашими серверами и Stripe шифруется. Единственная информация кредитной карты, которую предоставляет Stripe и которую мы сохраняем, это дата окончания срока действия карты и ее марка. Это нужно для того, чтобы мы могли уведомить Вас об истечении срока действия карты.',
        'title'         => 'Кредитные карты',
    ],
    'data-backup'   => [
        'description'   => 'Наша база данных копируется два раз а в сутки для обеспечения безопасности и доступности Ваших данных. На наших резервных копиях регулярно проводятся тесты, удостоверяющиеся, что мы можем быстро восстановить данные при необходимости.',
        'title'         => 'Резервное копирование данных',
    ],
    'data-breach'   => [
        'description'   => 'В случае, если в базе данных Kanka произойдет утечка личных данных, мы уведомим местные власти, а также пострадавших пользователей.',
        'title'         => 'Утечки данных',
    ],
    'data-center'   => [
        'description'   => 'У Kanka есть несколько серверов для гарантии избыточности, а также подготовленные процедуры восстановления после катастроф, если что-то пойдет не так. Хостинг наших серверов осуществляется Hetzner.',
        'title'         => 'Безопасность центра обработки данных',
    ],
    'description'   => 'Наша небольшая команда делает все возможное, чтобы соответствовать высшим стандартам защиты данных, чтобы удостовериться, что Ваши данные с нами в безопасности.',
    'infrastructure'=> [
        'description'   => 'Хостинг наших серверов и всех Ваших данных проводится на серверах на территории Европейского Союза. Благодаря этому Kanka соответствует определенным нормативным требованиям и требованиям соответствия, гарантируя, что Ваши данные с нами в безопасности. Наши центры обработки данных предоставлены Hetzner и Amazon Cloud Europe,',
        'title'         => 'Хостинг инфраструктуры в ЕС',
    ],
    'logs'          => [
        'title' => 'Журналы событий',
    ],
    'title'         => 'Безопасность на Kanka',
];
