<?php

return [
    'actions'   => [
        'status'    => 'Status :status',
    ],
    'public'    => [
        'campaign'      => [
            'private'   => 'Kampania jest obecnie prywatna.',
            'public'    => 'Kampania jest obecnie publiczna.',
        ],
        'description'   => 'Kontroluj widoczność elementów dla użytkowników w roli publicznej. Użytkownik otrzymuje ją automatycznie, jeżeli przegląda kampanię, ale nie jest jej uczestnikiem.',
        'test'          => 'By przetestować uprawnienia roli publicznej, otwórz kampanię :url w trybie incognito.',
    ],
    'show'      => [
        'title' => 'Uprawnienia :role - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Dla uczestników w roli :role działanie :action na :entities jest obecnie niedostępne.',
        'enabled'   => 'Dla uczestników w roli :role działanie :action na :entities jest obecnie możliwe.',
    ],
];
