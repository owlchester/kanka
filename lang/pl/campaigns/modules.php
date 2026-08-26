<?php

return [
    'actions'       => [
        'create'    => 'Stwórz kategorię',
        'customise' => 'Dostosuj',
    ],
    'create'        => [
        'helper'    => 'Stwórz nową kategorię dla elementów, które nie pasują do żadnej innej.',
        'success'   => 'Stworzono nową kategorię.',
        'title'     => 'Nowa kategoria',
    ],
    'delete'        => [
        'confirm'           => 'Wpisz :code jeżeli na pewno chcesz usunąć kategorię dodatkową :name.',
        'confirm-button'    => '{0} Trwale usunęto :name|{1} Trwale usunięto :name i :count element|[2,4] Trwale usunięto :name i :count elementy|[5,*] Trwale usunięto :name i :count elementów',
        'entities'          => '{1} Usunie trwale :count element.|[2,4] usunie trwale :count elementy.|[5,*] usunie trwale :count elementów.',
        'helper'            => 'Czy na pewno usunąć kategorię :name? Usunięte zostaną również wszystkie związane z nią elementy, skróty i widżety.',
        'success'           => 'Usunięto kategorię :name.',
        'title'             => 'Usunięcie kategorii',
    ],
    'errors'        => [
        'disabled'              => 'Kategoria :name jest nieaktywna. :fix',
        'empty-custom'          => 'Dodaje dodatkową kategorię, pozwalającą organizować dane nie posiadające kategorii podstawowej.',
        'limit'                 => 'Ponieważ wciąż pracujemy nad tą funkcją, kampania może na razie posiadać :max kategorii dodatkowych.',
        'limit-title'           => 'Osagnięto limit kategorii dodatkowych',
        'subscription-limit'    => 'Kampania osiągnęła limit kategorii dodatkowych. By go zwiększyć, osoba która odblokowała funkcje premium musi podnieść poziom subskrybcji.',
    ],
    'fields'        => [
        'icon'          => 'Ikona kategorii',
        'image'         => 'Miniatura',
        'plural'        => 'Nazwa kategorii w liczbie mnogiej',
        'singular'      => 'Nazwa kategorii w liczbie pojedycznej',
        'status'        => 'Status kategorii',
        'update_name'   => 'Zmiana nazwy kategorii w menu bocznym',
    ],
    'helpers'       => [
        'custom'    => 'To jest kategoria dodatkowa',
        'icon'      => 'Daje kategorii specjalną ikonę :fontawesome, na przykład :example.',
        'plural'    => 'Używana podczas nawigacji i na listach (np. "wyświetl wszystkie eliksiry").',
        'roles'     => 'Wybierz role, które będą widziały nową kategorię. Można je potem zmienić w menu uprawień ról.',
        'singular'  => 'Używana gdy mowa o pojedynczym elemencie (np. "nowy eliksir")',
        'status'    => 'Nieaktywne kategorie nie są wyświetlane w menu, ale żadne dane nie zostają usunięte.',
        'tutorial'  => 'Kategorie pozwalają zarządzać widocznością elementów kampanii. Włącz te, których używasz, i wyłącz pozostałe. Wyłączenie kategorii nie powoduje utraty danych - ukrywa ją tylko w menu i opcjach nawigacji.',
    ],
    'pitch'         => 'Zmień nazwę i ikonę tej kategorii, by lepiej pasowała do stylu kampanii. Pozwala dopasować doświadczenie do świata oraz graczy.',
    'pitch-custom'  => 'Twórz własne kategorie, których ten świat potrzebuje: bóstwa, eliksiry, prawa dziedziczenia i inne charakterystyczne składniki kampanii. Opcje premium dają ci pełną swobodę.',
    'pitch-title'   => 'Odblokuj kategorie dodatkowe',
    'rename'        => [
        'helper'    => 'Zmień sposob wyświetlania kategorii w kampanii. Pozostaw puste, by używać opcji domyślnej.',
        'success'   => 'Dostosowano kategorię.',
        'title'     => 'Dostosowanie kategorii :module',
    ],
    'reset'         => [
        'default'   => 'Przywraca stan wyjściowy kategorii podstawowych, ale nie dodatkowych.',
        'success'   => 'Przywrócono domyślne kategorie kampanii',
        'title'     => 'Przywracanie domyślnych nazw i ikon',
        'warning'   => 'Czy na pewno przywrócić domyślne nazwy i ikony kategorii kampanii?',
    ],
    'sections'      => [
        'custom'        => 'Kategorie dodatkowe',
        'default'       => 'Kategorie podstawowe',
        'early-access'  => 'Wczesny dostęp',
        'features'      => 'Opcje',
    ],
    'states'        => [
        'disable'   => 'Nieaktywna',
        'disabled'  => 'Kategoria nieaktywna',
        'enable'    => 'Aktywna',
        'enabled'   => 'Kategoria aktywna',
    ],
    'status'        => [
        'enabled'   => 'Włączono kategorię',
    ],
];
