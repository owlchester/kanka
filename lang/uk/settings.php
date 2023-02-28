<?php

return [
    'account'       => [
        '2fa'               => [
            'actions'               => [
                'disable'   => 'Вимкнути двофакторну авторизацію',
                'finish'    => 'Завершити налаштування та увійти',
            ],
            'activation_helper'     => 'Щоб завершити налаштування двофакторної авторизації свого акаунту, будь ласка, виконайте наступні інструкції.',
            'disable'               => [
                'helper'    => 'Якщо ви хочете вимкнути двофакторну авторизацію, клікніть на кнопку внизу. Пам\'ятайте, що це робить ваш акаунт вразливим, якщо хтось знає ваші дані для входу.',
                'title'     => 'Вимкнути двофакторну авторизацію',
            ],
            'enable_instructions'   => 'Щоб почати процес активації, згенеруйте QR-код автентифікації, відскануйте його додатком Google Authenticator (:ios, :android) або іншим подібним додатком.',
            'enabled'               => 'Двофакторна авторизація для вашого акаунта зараз увімкнена.',
            'error_enable'          => 'Неправильний код, спробуйте знову',
            'fields'                => [
                'otp'       => 'Вкажіть одноразовий пароль (ОТР), наданий авторизаційним додатком.',
                'qrcode'    => 'Відскануйте наступний QR-код своїм додатком автентифікації, щоб згенерувати одноразовий пароль (ОТР)',
            ],
            'generate_qr'           => 'Згенерувати QR-код',
            'helper'                => 'Двофакторна авторизація (2FA) посилює безпеку доступу, вимагаючи два способи (також названі факторами) для підтвердження вашої особи під час кожного входу.',
            'learn_more'            => 'Дізнайтеся більше про двофакторну авторизацію.',
            'social'                => 'Двофакторна авторизація Kanka доступна тільки для користувачів, які входять за допомогою ел.пошти та пароля. Змініть свій метод входу в налаштування акаунта, перш ніж увімкнути цю функцію.',
            'success_disable'       => 'Двофакторну авторизацію успішно вимкнено.',
            'success_enable'        => 'Двофакторну авторизацію успішно ввімкнено. Будь ласка, увійдіть знову, щоб завершити налаштування.',
            'success_key'           => 'Ваш QR-код безпеки було успішно згенеровано. Будь ласка, завершіть налаштування, щоб увімкнути двофакторну авторизацію.',
            'title'                 => 'Двофакторна авторизація',
        ],
        'actions'           => [
            'social'            => 'Перемкнутися на логін Kanka',
            'update_email'      => 'Оновити ел.пошту',
            'update_password'   => 'Оновити пароль',
        ],
        'email'             => 'Змінити ел.пошту',
        'email_success'     => 'Ел.пошту оновлено.',
        'password'          => 'Змінити пароль',
        'password_success'  => 'Пароль оновлено.',
        'social'            => [
            'error'     => 'Ви вже використовуєте вхід Kanka для цього акаунту.',
            'helper'    => 'Вашим акаунтом зараз керує :provider. Ви можете припинити це й перемкнутися на стандартний логін Kanka, встановивши пароль.',
            'success'   => 'Тепер ваш акаунт використовує логін Kanka.',
            'title'     => 'Соц.мережі до Kanka',
        ],
        'title'             => 'Акаунт',
    ],
    'api'           => [
        'helper'    => 'Вітаємо у Kanka API. Згенеруйте персональний токен доступу для використання в запитах нашого АРІ для збирання інформації про кампанії, де ви берете участь.',
        'link'      => 'Читати документацію АРІ',
        'title'     => 'АРІ',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Приєднати',
            'remove'    => 'Видалити',
        ],
        'benefits'  => 'Kanka надає кілька інтеграції зі сторонніми сервісами. Більше таких інтеграції заплановано в майбутньому.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Під час приєднання вашого акаунту Discord до Kanka сталася помилка. Будь ласка, спробуйте знову. Якщо це повториться, перевірте, чи ви не досягли ліміту Discord на приєдання до 100 серверів через АРІ.',
            ],
            'success'   => [
                'add'       => 'Ваш акаунт Discord приєднано.',
                'remove'    => 'Ваш акаунт Discord від\'єднано.',
            ],
            'text'      => 'Автоматичний доступ до ролей передплати.',
            'unlock'    => 'Розблокувати ролі Discord',
        ],
        'title'     => 'Інтеграція додатка',
    ],
    'boost'         => [
        'exceptions'    => [
            'already_boosted'       => 'Кампанія :name уже підсилена.',
            'exhausted_boosts'      => 'У вас немає доступних для використання бустерів. Виделіть бустер із кампанії, перш ніж передати його.',
            'exhausted_superboosts' => 'У вас немає бустерів. Вам потрібні 3 бустери, щоб суперпідсилити кампанію.',
        ],
    ],
    'countries'     => [
        'austria'       => 'Австрія',
        'belgium'       => 'Бельгія',
        'france'        => 'Франція',
        'germany'       => 'Німеччина',
        'italy'         => 'Італія',
        'netherlands'   => 'Нідерланди',
        'spain'         => 'Іспанія',
    ],
    'layout'        => [
        'title' => 'Шаблон',
    ],
    'menu'          => [
        'account'               => 'Акаунт',
        'api'                   => 'АРІ',
        'appearance'            => 'Вигляд',
        'apps'                  => 'Додатки',
        'boosters'              => 'Бустери',
        'notifications'         => 'Сповіщення',
        'other'                 => 'Інше',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Варіанти оплати',
        'personal_settings'     => 'Особисті налаштування',
        'profile'               => 'Публічний профіль',
        'settings'              => 'Налаштування',
        'subscription'          => 'Передплата',
        'subscription_status'   => 'Статус передплати',
    ],
    'patreon'       => [
        'deprecated'    => 'Застаріла функція - Якщо ви хочете підтримати Kanka, будь ласка, зробіть це шляхом :subscription. Приєднаний Patreon залишається активним для тих наших патронів, хто приєднав акаунт раніше, ніж ми відійшли від Patreon.',
        'pledge'        => 'Pledge: :name',
        'remove'        => [
            'button'    => 'Від\'єднати акаунт Patreon',
            'success'   => 'Ваш акаунт Patreon від\'єднано.',
            'text'      => 'Від\'єднання акаунту Patreon від Kanka видалить ваші бонуси, ваше ім\'я у залі слави, бусти кампаній та інші функції, пов\'язані із підтримкою Kanka. Жоден із ваших бустерів не буде втрачено (наприклад, назви сутностей). Передплативши знову, ви матимете доступ до усіх попередніх даних, включно зі здатністю продовжити підсилення своїх кампаній.',
            'title'     => 'Від\'єднати акаунт Patreon від Kanka',
        ],
        'title'         => 'Patreon',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Оновити профіль',
        ],
        'avatar'    => 'Зображення профілю',
        'success'   => 'Профіль оновлено.',
        'title'     => 'Публічний профіль',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Скасувати передплату',
            'subscribe'         => 'Передплата',
            'update_currency'   => 'Зберегти бажану валюту',
        ],
        'billing'               => [
            'helper'    => 'Ваша платіжна інформація обробляється та безпечно зберігається у :stripe. Цей метод платежу використовується для всіх ваших передплат.',
            'saved'     => 'Збережений метод платежу',
        ],
        'cancel'                => [
            'options'   => [
                'competitor'        => 'Переходжу до конкурента',
                'financial'         => 'Передплата занадто дорога',
                'missing_features'  => 'Бракує функцій',
                'not_for'           => 'Передплата не для мене',
                'not_using'         => 'Не користуюся Kanka зараз',
                'other'             => 'Інше',
            ],
            'text'      => 'Так прикро, що ви йдете! Попри скасування, ваша передплата буде активна до :date, після чого ви втратите бустери кампаній та інші привілеї, пов\'язані з підтримкою Kanka. Будь ласка, заповніть наступну форму, щоб ми знали, що привело до такого рішення та як ми можемо змінитися на краще.',
        ],
        'cancelled'             => 'Ваша передплата скасована. Ви можете оновити передплату, щойно завершиться поточний цикл передплати, після :date.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Ви передплачуєте рівень :tier, із оплатою :amount щомісяця.',
                'yearly'    => 'Ви передплачуєте рівень :tier, із оплатою :amount щороку.',
            ],
            'title' => 'Змінити рівень передплати',
        ],
        'coupon'                => [
            'check'         => 'Перевірити промокод',
            'invalid'       => 'Неправильний промокод.',
            'label'         => 'Промокод',
            'percent_off'   => 'Ми робимо для вас знижку :percent% на вашу першу річну передплату!',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Змінити бажану валюту оплати',
        ],
        'errors'                => [
            'callback'      => 'Наш провайдер оплати повідомив про помилку. Будь ласка, спробуйте знову, або повідомте нам, якщо помилка повторюється.',
            'subscribed'    => 'Не можеом обробити вашу передплату. Stripe надав наступне пояснення.',
        ],
        'fields'                => [
            'active_since'      => 'Активна від',
            'active_until'      => 'Активна до',
            'billing'           => 'Платежі',
            'currency'          => 'Валюта платежів',
            'payment_method'    => 'Метод платежу',
            'plan'              => 'Поточний план',
            'reason'            => 'Причина',
        ],
        'helpers'               => [
            'alternatives'          => 'Оплатіть свою передплату з використанням :method. Цей метод платежу не буде оновлений автоматично в кінці платіжного циклу. :method доступний тільки для євро.',
            'alternatives_warning'  => 'Підвищення передплати з використанням цього методу неможливе. Будь ласка, передплатіть знову, коли завершитья ваша поточна передплата.',
            'alternatives_yearly'   => 'Через обмеження щодо повторюваних платежів, :method доступний тільки для річної передплати',
            'paypal'                => 'Хочете натомість використати Paypal? Напишіть нам на :email, якщо хочете сплатити за річну передплату через Paypal.',
            'paypal_v2'             => 'Ми приймаємо PayPal для річної підписки. Зв’яжіться з нами за адресою :email, вказавши електронну адресу свого облікового запису Kanka, рівень, на який ви бажаєте підписатися, і валюту (USD або EUR), у якій ви хочете сплатити рахунок.',
            'stripe'                => 'Ваша платіжна інформація обробляється та безпечно зберігається у :stripe.',
        ],
        'manage_subscription'   => 'Керувати передплатою',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Додати метод платежу',
                'change'            => 'Змінити метод платежу',
                'save'              => 'Зберегти метод платежу',
                'show_alternatives' => 'Інші можливості оплати',
            ],
            'add_one'       => 'У вас немає збережених методів платежу.',
            'alternatives'  => 'Ви можете передплатити з використанням інших можливостей оплати. Ця дія спише кошти лише раз і не продовжуватиме вашу передплату щомісяця.',
            'card'          => 'Картка',
            'card_name'     => 'Ім\'я на картці',
            'country'       => 'Країна проживання',
            'ending'        => 'Завершується',
            'helper'        => 'Ця картка буде використана для усіх ваших передплат.',
            'new_card'      => 'Додати новий платіжний метод',
            'saved'         => ':brand завершується на :last4',
        ],
        'periods'               => [
            'monthly'   => 'Щомісяця',
            'yearly'    => 'Щороку',
        ],
        'placeholders'          => [
            'downgrade_reason'  => 'Необов\'язково: скажіть нам, чому ви знижуєте рівень передплати.',
            'reason'            => 'Необов\'язково: скажіть нам, чому ви більше не підтримуєте Kanka. Якої функції бракує? Змінилася ваша фінансова ситуація?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':currency :amount для сплати щомісяця',
            'cost_yearly'   => ':currency :amount для сплати щороку',
        ],
        'sub_status'            => 'Інформація про передплату',
        'subscription'          => [
            'actions'   => [
                'cancel'            => 'Скасувати передплату',
                'downgrading'       => 'Будь ласка, напишіть нам для зниження рівня',
                'rollback'          => 'Змінити на Кобольда',
                'subscribe'         => 'Змінити на :tier щомісяця',
                'subscribe_annual'  => 'Змінити на :tier щороку',
            ],
        ],
        'success'               => [
            'alternative'   => 'Ваш платіж зареєстровано. Ви отримаєте сповіщення, щойно платіж буде оброблено, і ваша передплата активується.',
            'callback'      => 'Ваша передплата успішна. Ваш акаунт буде оновлено, щойно платіжний провайдер повідомить нам про зміни (це може зайняти кілька хвилин).',
            'cancel'        => 'Вашу передплату було скасовано. Вона буде активною до завершення вашого поточного платіжного циклу.',
            'currency'      => 'Налаштування валюти було оновлено.',
            'subscribed'    => 'Ви стали передплатником! Підпишіться на розсилку Вибір спільноти, щоб отримати сповіщення, коли настане час вибирати. Також ви можете приєднатися до нашого дискорду й стати частиною спільноти.',
        ],
        'tiers'                 => 'Рівні передплати',
        'trial_period'          => 'У нас діє правило 14 днів для скасування річної передплати. Зв\'яжіться з нами за :email, якщо хочете скасувати свою річну передплату й повернути кошти.',
        'upgrade_downgrade'     => [
            'button'    => 'Інформація про зміну рівнів',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Ваші бонуси будуть активні до завершення поточного платіжного циклу.',
                    'boosts'    => 'Те саме стається із вашими підсиленими кампаніями. Підсилені функцію стануть невидимими, але не будуть видалені з кампаній, які більше не підсилені.',
                    'kobold'    => 'Щоб скасувати передплату, виберіть рівень Кобольд.',
                ],
                'title'     => 'Скасовуючи свою передплату',
            ],
            'downgrade' => [
                'bullets'           => [
                    'end'   => 'Ваш поточний рівень залишатиметься активним до кінця поточного платіжного циклу, після його вашу передплату буде знижено до нового рівня.',
                ],
                'provide_reason'    => 'Будь ласка, поділіться з нами, чому ви знижуєте рівень передплати.',
                'title'             => 'Змінюючи рівень на нижчий',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Ваш метод оплати буде задіяно негайно, і ви отримаєте доступ до нового рівня.',
                    'prorate'   => 'Змінюючи рівень з Ведмесови на Стихійника, ви сплатите тільки різницю з вашим новим рівнем.',
                ],
                'title'     => 'Змінюючи рівень на вищий',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Нам не вдалося отримати оплату з вашої картки. Будь ласка, оновіть платіжну інформацію, і ми спробуємо стягнути оплату в наступні кілька днів. Якщо це знову не вдасться, вашу передплату буде скасовано.',
            'patreon'       => 'Ваш акаунт заразр приєднано до Patreon. Будь ласка, від\'єднайте свій акаунт у налаштуваннях :patreon, перш ніж перемнутися на передплату Kanka/',
        ],
    ],
];
