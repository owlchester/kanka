<?php

return [
    'actions'       => [
        'status'    => 'Status :status',
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
        'content-modules'   => 'Moduły zawartości',
        'toggle'            => [
            'action'    => 'Przełącz wszystkie',
            'tooltip'   => 'Przełącz upoważnienie :action dla wszystkich modułów.',
        ],
    ],
    'public'        => [
        'helpers'   => [
            'click'     => 'Wybierz dowolny moduł by przełączyć publiczną widoczność wszystkich należących do niego elementów.',
            'intro'     => 'Kontroluje widoczność składników kampanii przez osby które w niej nie uczestniczą.',
            'main'      => 'Wybierz które moduły będą widoczne dla wszystkich przeglądajacych kampanię, w tym osób niezalogowanych. Kategoria obejmuje zarówno publiczność z zewnątrz, jak zalogowanych użytkowników Kanki którzy nie biorą udziału w kampanii.',
            'preview'   => 'Widok publiczności',
        ],
    ],
    'show'          => [
        'title' => 'Uprawnienia :role - :campaign',
    ],
    'toggle'        => [
        'disabled'  => 'Dla uczestników w roli :role działanie :action na :entities jest obecnie niedostępne.',
        'enabled'   => 'Dla uczestników w roli :role działanie :action na :entities jest obecnie możliwe.',
    ],
    'warnings'      => [
        'adding-to-admin'   => 'Uczestnicy posiadający rolę :role mają dostęp do wszystkich elementów kampanii i nie mogą zostać usunięci przez inne osoby w tej roli. Gdy minie :amount minut, mogą pozbyć się roli wyłącznie osobiście.',
    ],
];
