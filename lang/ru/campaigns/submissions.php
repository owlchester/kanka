<?php

return [
    'actions'       => [
        'accept'        => 'Принять',
        'applications'  => 'Заявки: :status',
        'change'        => 'Изменить',
        'reject'        => 'Отклонить',
    ],
    'apply'         => [
        'apply'         => 'Отправить',
        'help'          => 'Эта кампания открыта для новых участников. Чтобы вступить в нее, заполните эту форму. Вы получите уведомление, когда админы кампании рассмотрят вашу заявку.',
        'remove_text'   => 'вашу заявку',
        'success'       => [
            'apply' => 'Ваша заявка сохранена. Вы в любой момент можете ее изменить или удалить. Вы получите уведомление, когда админы кампании ее рассмотрят.',
            'remove'=> 'Ваша заявка удалена.',
            'update'=> 'Ваша заявка обновлена. Вы в любой момент можете ее изменить или удалить. Вы получите уведомление, когда админы кампании ее рассмотрят.',
        ],
        'title'         => 'Вступление в :name',
    ],
    'errors'        => [
        'not_open'  => 'Эта кампания не открыта для новых участников. Если вы хотите позволить пользователям вступать в кампанию, измените ее настройки.',
    ],
    'fields'        => [
        'application'   => 'Заявка',
        'approval'      => 'Причина принятия',
        'rejection'     => 'Причина отклонения',
    ],
    'helpers'       => [
        'filter-helper'     => 'Эта кампания принимает заявки!',
        'modal'             => 'Публичные кампании с открытыми заявками позволяют пользователям подавать заявки на вступление в них.',
        'no_applications'   => 'В данным момент в кампании нет заявок, ожидающих рассмотрения. Пользователи могут подавать заявки с помощью кнопки :button в обзоре кампании.',
        'not_open'          => 'В данный момент эта кампания не принимает заявок на вступление.',
        'open_not_public'   => 'Эта кампания принимает заявки, но не является публичной. Из-за этого подавать заявки никто не может. Это можно исправить в настройках кампании.',
    ],
    'placeholders'  => [
        'note'  => 'Напишите свою заявку на вступление в кампанию.',
    ],
    'statuses'      => [
        'closed'    => 'Закрыты',
        'open'      => 'Открыты',
    ],
    'toggle'        => [
        'closed'    => 'Не принимать заявки',
        'label'     => 'Статус',
        'open'      => 'Принимать заявки',
        'success'   => 'Статус принятия заявок на вступление в кампанию обновлен.',
        'title'     => 'Принятие заявок',
    ],
    'update'        => [
        'approve'   => 'Выберите роль, в которую будет добавлен пользователь.',
        'approved'  => 'Заявка принята.',
        'reject'    => 'Вы можете написать пользователю пояснение причины отклонения его заявки.',
        'rejected'  => 'Заявка отклонена.',
    ],
];
