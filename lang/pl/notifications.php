<?php

return [
    'apps'              => [
        'discord'   => [
            'invalid'   => 'Token Discord stracił ważność. Zsynchronizuj Discord i Kankę ponownie.',
        ],
    ],
    'campaign'          => [
        'application'       => [
            'approved'              => 'Przyjęto twoje zgłoszenie do kampanii :campaign.',
            'approved_message'      => 'Twoje zgłoszenie do kampanii :campaign zostało przyjęte. Dołączono wiadomość: :reason.',
            'new'                   => 'Nowe zgłoszenie do kampanii :campaign.',
            'rejected'              => 'Odrzucono twoje zgłoszenie do kampanii :campaign. Oto powód: :reason',
            'rejected_no_message'   => 'Odrzucono twoje zgłoszenie do kampanii :campaign.',
        ],
        'asset_export'      => 'Można pobrać wyeksportowane pliki kampanii. Link będzie dostępny przez :time minut.',
        'boost'             => [
            'add'           => 'Kampania :campaign została doładowana przez :user.',
            'remove'        => ':user nie doładowuje już kampanii :campaign.',
            'superboost'    => 'Kampania :campaign została turbodoładowana przez :user.',
        ],
        'created'           => 'Stworzono :campaign.',
        'deleted'           => 'Usunięto kampanię :campaign',
        'export'            => 'Można pobrać wyeksportowaną kampanię. Link będzie dostępny przez :time minut.',
        'export_error'      => 'Podczas eksportowania :campaign wystąpił błąd. Jeżeli wystąpi ponownie, skontaktuj się z nami.',
        'hidden'            => 'Kampania :campaign została usunięta z listy kampanii publicznych.',
        'import'            => [
            'csv_ready'     => 'Import CSV kampanii :campaign jest gotowy.',
            'csv_success'   => 'Zaimportowano :count elementów z pliku CSV do kampanii :campaign.',
            'failed'        => 'Import do :campaign nieudany.',
            'success'       => 'Import do :campaign zakończony.',
        ],
        'join'              => ':user dołącza do kampanii :campaign.',
        'leave'             => ':user opuszcza do kampanię :campaign.',
        'new_owner'         => 'Jesteś teraz administratorem :campaign.',
        'plugin'            => [
            'deleted'   => 'Wtyczka :plugin została usunięta z targowiska, więc usunięto ją również z kampanii :campaign.',
        ],
        'premium'           => [
            'add'       => 'Dzięki :user odblokowano opcje premium dla :campaign',
            'remove'    => ':user nie odblokowuje już opcji premium :campaign',
        ],
        'removed-image'     => 'Obraz lub nagłówek elementu :entity został usunięty ze względu na prawa autorskie.',
        'role'              => [
            'add'       => 'Nadano ci rolę :role w kampanii :campaign.',
            'remove'    => 'Odebrano ci rolę :role w kampanii :campaign.',
        ],
        'troubleshooting'   => [
            'joined'    => ':user z zespołu Kanki dołączył do kampanii :campaign',
        ],
    ],
    'clear'             => [
        'action'    => 'Wyczyść wszystkie',
        'success'   => 'Usunięto powiadomienia',
        'title'     => 'Wyczyść powiadomienia',
    ],
    'features'          => [
        'approved'  => 'Zaaprobowaliśmy twój pomysł na :feature.',
        'finished'  => 'Twój pomysł :feature stał się częścią Kanki!',
        'rejected'  => 'Odrzuciliśmy twój pomysł na :feature. Przyczyna: :reason.',
    ],
    'header'            => 'Masz :count powiadomień.',
    'index'             => [
        'title' => 'Powiadomienia',
    ],
    'map'               => [
        'chunked'   => 'Zakończono przetwarzanie mapy :name i można już jej używać.',
    ],
    'no_notifications'  => 'Powiadomienia pojawią się tutaj, gdy tylko je otrzymasz.',
    'plugins'           => [
        'comments'  => [
            'new_comment'   => ':user zamieścił nowy komentarz o dodatku :plugin.',
            'new_reply'     => ':user odpowiedział na twój komentarz o :plugin',
        ],
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Wystąpił problem w czasie przetwarzania płatności. Odczekaj chwilę i spróbuj jeszcze raz. Jeżeli nic się nie zmieni, skontaktuj się z nami.',
        'deleted'       => 'Po zbyt wielu nieudanych próbach obciążenia twojej karty skasowaliśmy twoją subskrypcję Kanki. Wejdź do ustawień subskrypcji i uaktualnij metodę płatności.',
        'ended'         => 'Twoja subskrypcja została zakończona. Usunięto funkcj premium i kanał na Discordzie. Do zobaczenia niedługo!',
        'failed'        => 'Nie można pobrać płatności. Uaktualnij ustawienia metody płatności.',
        'started'       => 'Subskrybujesz od teraz Kankę.',
        'trial'         => 'Zakończył się darmowy okres próbny Kanki. Mamy nadzieję, że ci się podobało i jeszcze do nas wrócisz!',
    ],
    'unread'            => 'Nowe powiadomienie',
];
