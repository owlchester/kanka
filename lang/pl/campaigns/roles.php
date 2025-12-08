<?php

return [
    'actions'   => [
        'status'    => 'Status :status',
    ],
    'create'    => [
        'helper'    => 'Tworzy nową rolę w kampanii.',
    ],
    'overview'  => [
        'limited'   => 'Stworzono :amount z :total ról.',
        'title'     => 'Dostępne role',
        'unlimited' => 'Stworzono :amount z nieograniczonej liczby ról.',
    ],
    'public'    => [],
    'show'      => [
        'title' => 'Uprawnienia :role - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Dla uczestników w roli :role działanie :action na :entities jest obecnie niedostępne.',
        'enabled'   => 'Dla uczestników w roli :role działanie :action na :entities jest obecnie możliwe.',
    ],
    'warnings'  => [
        'adding-to-admin'   => 'Uczestnicy posiadający rolę :role mają dostęp do wszystkich elementów kampanii i nie mogą zostać usunięci przez inne osoby w tej roli. Gdy minie :amount minut, mogą pozbyć się roli wyłącznie osobiście.',
    ],
];
