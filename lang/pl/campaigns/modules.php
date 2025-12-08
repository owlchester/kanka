<?php

return [
    'actions'       => [
        'create'    => 'Stwórz moduł',
        'customise' => 'Modyfikuj',
    ],
    'create'        => [
        'helper'    => 'Stwórz nowy moduł dla elementów, które nie pasują do żadnego innego.',
        'success'   => 'Stworzono nowy moduł.',
        'title'     => 'Nowy moduł',
    ],
    'delete'        => [
        'confirm'   => 'Wpisz :code jeżeli na pewno chcesz usunąć moduł własny :name.',
        'helper'    => 'Czy na pewno usunąć moduł własny :name? Usunięte zostaną również wszystkie związane z nim elementy, zakładki i widżety.',
        'success'   => 'Usunięto moduł :name.',
        'title'     => 'Usunięcie modułu',
    ],
    'errors'        => [
        'disabled'              => 'Moduł :name jest wyłączony. :fix',
        'limit'                 => 'Ponieważ wciąż pracujemy nad tą funkcją, kampania może na razie posiadać :max modułów własnych.',
        'limit-title'           => 'Osagnięto limit własnych modułów',
        'subscription-limit'    => 'Kampania osiągnęła limit własnych modudłów. By go zwiększyć, osoba która odblokowała funkcje premium musi podnieść poziom subskrybcji.',
    ],
    'fields'        => [
        'icon'          => 'Ikona modułu',
        'plural'        => 'Nazwa modułu w liczbie mnogiej',
        'singular'      => 'Nazwa modułu w liczbie pojedycznej',
        'update_name'   => 'Zmiana nazwy modułu',
    ],
    'helpers'       => [
        'custom'    => 'To jest moduł własny.',
        'icon'      => 'Ikona :fontawesome, na przykład :example.',
        'plural'    => 'Nazwa elementów nowego modułu w liczbie mnogiej. Na przykład: eliksiry.',
        'roles'     => 'Wybierz role, które będą widziały nowy moduł. Można je potem zmienić w menu uprawień ról.',
        'singular'  => 'Nazwa elementów nowego modułu w liczbie pojedynczej. Na przykład: eliksir.',
    ],
    'pitch'         => 'Zmień nazwę i ikonę tego modułu dla całej kampanii.',
    'pitch-custom'  => 'Twórz własne moduły dla niecodziennych elementów.',
    'rename'        => [
        'helper'    => 'Zmień używaną w tej kampanii nazwę i ikonę modułu. Pozostaw puste, by używać opcji domyślnej.',
        'success'   => 'Zmodyfikowano moduł.',
        'title'     => 'Modyfikuj moduł :module',
    ],
    'reset'         => [
        'default'   => 'Przywraca stan wyjściowy modułów domyślnych, ale nie własnych.',
        'success'   => 'Przywrócono domyślne moduły kampanii',
        'title'     => 'Przywracanie domyślnych nazw i ikon',
        'warning'   => 'Czy na pewno przywrócić domyślne nazwy i ikony modułów kampanii?',
    ],
    'sections'      => [
        'custom'        => 'Moduły własne',
        'default'       => 'Moduły domyślne',
        'early-access'  => 'Wczesny dostęp',
        'features'      => 'Opcje elementów',
    ],
    'states'        => [
        'disable'   => 'Nieaktywny',
        'enable'    => 'Aktywny',
    ],
];
