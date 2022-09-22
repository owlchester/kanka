<?php

return [
    'actions'   => [
        'add'                       => 'Dodaj zdolności',
        'import_from_race'          => 'Dodaj zdolności rasy',
        'import_from_race_mobile'   => 'Zdolności rasy',
        'reset'                     => 'Odśwież użycia zdolności',
    ],
    'create'    => [
        'success'           => 'Zdolność :ability dodano do :entity',
        'success_multiple'  => 'Zdolności :ability dodano do :entity',
        'title'             => 'Dodaj zdolności dla :name',
    ],
    'fields'    => [
        'note'      => 'Opis',
        'position'  => 'Kolejność',
    ],
    'helpers'   => [
        'note'  => 'W tym polu możesz oznaczać za pomocą zaawansowanych wzmianek elementy (np. :code) oraz cechy elementów (np. :attr).',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Ta postać nie ma rasy.',
            'not_character' => 'Ten element nie jest postacią.',
        ],
        'success'   => 'Importowano {1} :count zdolność.|Importowano [2,*] :count zdolności.',
    ],
    'show'      => [
        'helper'    => 'Dodaj zdolności, które posiada ten element. Możesz w każdej chwili zmienić ich widoczność albo je usunąć. Zdolności wywodzące się z tego samego źródła wyświetlane są jako kafelki.',
        'title'     => 'Zdolności elementu :name',
    ],
    'update'    => [
        'title' => 'Zdolność elementu :name',
    ],
];
