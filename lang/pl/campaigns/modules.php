<?php

return [
    'actions'   => [
        'customise' => 'Modyfikuj',
    ],
    'fields'    => [
        'icon'      => 'Ikona modułu',
        'plural'    => 'Nazwa modułu w liczbie mnogiej',
        'singular'  => 'Nazwa modułu w liczbie pojedycznej',
    ],
    'helpers'   => [
        'info'  => 'Kampania podzielona jest na szereg powiązanych modułów. Możesz je włączać i wyłączać według potrzeb. Wyłączenie modułu nie powoduje usunięcia danych, tylko je ukrywa.',
    ],
    'pitch'     => 'Zmień nazwę i ikonę tego modułu dla całej kampanii.',
    'rename'    => [
        'helper'    => 'Zmień używaną w tej kampanii nazwę i ikonę modułu. Pozostaw puste, by używać opcji domyślnej.',
        'success'   => 'Zmodyfikowano moduł.',
        'title'     => 'Modyfikuj moduł :module',
    ],
    'reset'     => [
        'success'   => 'Przywrócono domyślne moduły kampanii',
        'title'     => 'Przywracanie domyślnych nazw i ikon',
        'warning'   => 'Czy na pewno przywrócić domyślne nazwy i ikony modułów kampanii?',
    ],
    'states'    => [
        'disable'   => 'Nieaktywny',
        'enable'    => 'Aktywny',
    ],
];
