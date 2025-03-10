<?php

return [
    '403'               => [
        'body'  => 'Najwyraźniej nie masz uprawnień do przeglądania tej strony!',
        'title' => 'Brak dostępu',
    ],
    '403-form'          => [
        'help'  => 'Powodem może być zakończenie twojej sesji. Przed zapisaniem spróbuj zalogować się ponownie w nowym oknie.',
    ],
    '404'               => [
        'body'  => 'Niestety nie możemy znaleźć strony której szukasz.',
        'title' => 'Strony nie znaleziono',
    ],
    '500'               => [
        'body'  => [
            '1' => 'Ups, chyba coś poszło nie tak.',
            '2' => 'Otrzymaliśmy raport o napotkanym błędzie, ale czasem warto przekazać nam dokładniejszą informację, jakie działanie go spowodowało.',
        ],
        'title' => 'Błąd',
    ],
    '503'               => [
        'body'  => [
            '1' => 'Trwa konserwacja Kanki, co zwykle oznacza, że instalujemy aktualizację!',
            '2' => 'Przepraszamy za niedogodność. Za kilka minut wszystko wróci do normy.',
        ],
        'json'  => 'Właśnie trwa konserwacja Kanki, spróbuj za kilka minut.',
        'title' => 'Konserwacja',
    ],
    '503-form'          => [],
    'back-to-campaigns' => 'Wróć do jednej ze swoich kampanii.',
    'footer'            => 'Jeżeli potrzebujesz pomocy, skontaktuj się z nami przez hello@kanka.io albo na serwerze :discord',
    'log-in'            => 'Zalogowanie może pozwolić ci uzyskać dostęp.',
    'post_layout'       => 'Nieprawidłowy układ komentarza',
    'private-campaign'  => [
        'auth'  => [
            'helper'    => 'Nie masz dostępu do tej kampanii.',
        ],
        'guest' => [
            'helper'    => 'Kampania do której próbujesz się dostać jest prywatna i wymaga zalogowania.',
            'login'     => 'Dostęp do zawartości możesz uzyskać po zalogowaniu.',
        ],
        'title' => 'Kampania prywatna',
    ],
];
