<?php

return [
    'actions'   => [
        'add'   => 'Dodaj zdolności',
        'reset' => 'Odśwież użycia zdolności',
        'sync'  => 'Dodaj rasowe',
    ],
    'charges'   => [
        'left'  => 'Pozostało :amount',
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
    'groups'    => [
        'unorganised'   => 'Nieprzypisane',
    ],
    'helpers'   => [
        'note'      => 'W tym polu możesz oznaczać za pomocą zaawansowanych wzmianek elementy (np. :code) oraz cechy elementów (np. :attr).',
        'recharge'  => 'Odśwież wszystkie wykorzystane użycia zdolności.',
        'sync'      => 'Importuje zdolności związane z rasą postaci.',
    ],
    'import'    => [
        'errors'    => [
            'no_race'       => 'Ta postać nie ma rasy.',
            'not_character' => 'Ten element nie jest postacią.',
        ],
        'success'   => 'Importowano {1} :count zdolność.|Importowano [2,*] :count zdolności.',
    ],
    'recharge'  => [
        'success'   => 'Odświeżono wszystkie użycia.',
    ],
    'reorder'   => [
        'parentless'    => 'Bez źródła',
        'success'       => 'Zmieniono kolejność zdolności.',
    ],
    'show'      => [
        'helper'    => 'Dodaj zdolności, które posiada ten element. Możesz w każdej chwili zmienić ich widoczność albo je usunąć. Zdolności wywodzące się z tego samego źródła wyświetlane są jako kafelki.',
        'reorder'   => 'Zmień kolejność',
        'title'     => 'Zdolności elementu :name',
    ],
    'types'     => [
        'unorganised'   => 'Zdolności podzielone są ze względu na źródło - pozostałe wymieniono niżej.',
    ],
    'update'    => [
        'success'   => 'Zmieniono zdolność :ability elementu.',
        'title'     => 'Zdolność elementu :name',
    ],
];
