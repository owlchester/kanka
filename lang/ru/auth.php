<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы аутентификации
    |--------------------------------------------------------------------------
    |
    | Следующие языковые ресурсы используются во время аутентификации для
    | различных сообщений которые мы должны вывести пользователю на экран.
    | Вы можете свободно изменять эти языковые ресурсы в соответствии
    | с требованиями вашего приложения.
    |
    */

    'banned'    => [
        'permanent' => 'Вы были заблокированы навсегда.',
        'temporary' => '{1} Вы были заблокированы на :days день.|[2,4] Вы были заблокированы на :days дня.|[5,20] Вы были заблокированы на :days дней.|[21,*] Вы были заблокированы на :days дн.',
    ],
    'confirm'   => [
        'confirm'   => 'Подтвердить',
        'error'     => 'Неверный пароль. Пожалуйста, попробуйте еще раз.',
        'helper'    => 'Пожалуйста, подтвердите свой пароль, прежде чем вы сможете продолжить.',
        'title'     => 'Подтверждение пароля',
    ],
    'failed'    => 'Недействительные учетные данные.',
    'helpers'   => [
        'password'  => 'Показать / Скрыть пароль',
    ],
    'login'     => [
        'fields'                => [
            '2fa'       => 'Одноразовый пароль',
            'email'     => 'Электронная почта',
            'password'  => 'Пароль',
        ],
        'or'                    => 'ИЛИ',
        'password_forgotten'    => 'Забыли пароль?',
        'submit'                => 'Войти',
        'title'                 => 'Вход',
    ],
    'register'  => [
        'already'   => 'Уже есть аккаунт? :login',
        'errors'    => [
            'email_already_taken'   => 'Аккаунт с такой электронной почтой уже зарегистрирован.',
            'general_error'         => 'При создании вашего аккаунта произошла ошибка. Пожалуйста, попробуйте еще раз.',
        ],
        'fields'    => [
            'email'     => 'Электронная почта',
            'name'      => 'Имя пользователя',
            'password'  => 'Пароль',
        ],
        'log-in'    => 'Войти',
        'submit'    => 'Зарегистрироваться',
        'title'     => 'Регистрация',
        'tos'       => 'Регистрируясь, вы подтверждаете, что прочли :terms и :privacy и согласны с ними.',
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Адрес электронной почты',
            'password'              => 'Пароль',
            'password_confirmation' => 'Подтвердите ваш пароль',
        ],
        'send'      => 'Отправить ссылку на восстановление пароля',
        'submit'    => 'Восстановить пароль',
        'title'     => 'Восстановление пароля',
    ],
    'tfa'       => [
        'helper'    => 'Двухфакторная аутентификация включена. Пожалуйста, предоставьте одноразовый пароль (OTP), предоставленный вашим приложением-аутентификатором.',
        'title'     => 'Двухфакторная аутентификация',
    ],
    'throttle'  => 'Лимит попыток входа. Пожалуйста, попробуйте снова через :seconds сек.',
];
