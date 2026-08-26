<?php

return [
    'actions'       => [
        'status'    => 'Widoczność :status',
    ],
    'create'        => [
        'helper'    => 'Tworzy nową rolę w kampanii.',
    ],
    'overview'      => [
        'limited'   => 'Stworzono :amount z :total ról.',
        'title'     => 'Dostępne role',
        'unlimited' => 'Stworzono :amount z nieograniczonej liczby ról.',
    ],
    'permissions'   => [
        'campaign-features' => 'Składniki kampanii',
        'content-modules'   => 'Kategorie zawartości',
        'toggle'            => [
            'action'    => 'Przełącz wszystkie',
            'tooltip'   => 'Przełącz upoważnienie :action dla wszystkich kategorii.',
        ],
    ],
    'public'        => [
        'helpers'   => [
            'click'     => 'Wybierz dowolną kategorię by przełączyć widoczność wszystkich jej elementów.',
            'intro'     => 'Kontroluje, co widzą osoby nie będące uczestnikami kampanii.',
            'main'      => 'Wybierz które kategorie będą widoczne dla wszystkich przeglądajacych kampanię, w tym osób niezalogowanych. To znaczy: i osób z zewnątrz, i zalogowanych użytkowników Kanki którzy nie biorą udziału w kampanii.',
            'preview'   => 'Widok publiczności',
        ],
    ],
    'show'          => [
        'title' => 'Uprawnienia :role - :campaign',
    ],
    'toggle'        => [
        'disabled'  => 'Dla uczestników w roli :role działanie :action na :entities jest niedostępne.',
        'enabled'   => 'Dla uczestników w roli :role działanie :action na :entities jest możliwe.',
    ],
    'warnings'      => [
        'adding-to-admin'   => 'Uczestnicy posiadający rolę :role mają dostęp do wszystkich elementów kampanii i nie mogą zostać usunięci przez inne osoby w tej roli. Gdy minie :amount minut, mogą pozbyć się roli wyłącznie osobiście.',
    ],
];
