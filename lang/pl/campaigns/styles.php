<?php

return [
    'actions'       => [
        'builder'   => 'Kreator Motywów',
        'current'   => 'Obecny motyw: :theme',
        'disable'   => 'Wyłącz',
        'enable'    => 'Uruchom',
        'new'       => 'Nowy styl',
        'new_first' => 'Stwórz pierwszy styl',
    ],
    'bulks'         => [
        'delete'    => '{1} Usunięto :count styl.|[2,4] Usunięto :count style.|[5,*] Usunięto :count stylów.',
        'disable'   => '{1} Wyłączono :count styl.|[2,4] Wyłączono :count style.|[5,*] Wyłączono :count stylów.',
        'enable'    => '{1} Uruchomiono :count styl.|[2,4] Uruchomiono :count style.|[5,*] Uruchomiono :count stylów.',
    ],
    'create'        => [
        'success'   => 'Stworzono nowy styl',
        'title'     => 'Nowy styl',
    ],
    'cta'           => [
        'helper'    => 'Ulepsz do wersji premium by pisać własne reguły CSS, wpływające na styl kampanii.',
        'lead'      => 'Ulepsz by pisać reguły CSS zmieniające styl kampanii.',
        'title'     => 'Własne reguły CSS są opcją premium.',
    ],
    'delete'        => [
        'success'   => 'Usunięto styl :name',
    ],
    'errors'        => [
        'max_content'   => 'Reguła CSS nie może być dłuższa niż :amount znaków.',
        'max_reached'   => 'Osiągniętą maksymalną liczbę (:max) stylów.',
    ],
    'fields'        => [
        'content'       => 'Reguły CSS',
        'is_enabled'    => 'Aktywna',
        'length'        => 'Długość',
        'modified'      => 'Zmieniona',
        'name'          => 'Nazwa',
        'order'         => 'Kolejność',
    ],
    'helpers'       => [
        'empty'         => 'Brak własnych stylów',
        'here'          => 'z naszego bloga',
        'is_enabled'    => 'Użyj tego motywu na każdej stronie',
        'main'          => 'Możesz tworzyć własne style CSS w doładowanych kampaniach. Będą ładowane po stylach pobranych z biblioteki. Więcej o tworzeniu stylów dowiesz się :here.',
        'tutorial'      => 'Kontroluje estetykę kampanii. Pozwala wybrać kolory, preferencje układu treści i inne elementy wizualne. Modyfikacje dotyczą tylko tej kampanii i można je w każdej chwili zmienić.',
        'what'          => 'Użyj Kreatora Motywów by tworzyć style według przepisu albo twórz je od zera z pomocą reguł CSS.',
    ],
    'pitch'         => 'Twórz własne style CSS by nadać kampanii indywidualny charakter.',
    'placeholders'  => [
        'name'  => 'Nazwa stylu',
    ],
    'reorder'       => [
        'save'      => 'Zapisz kolejność',
        'success'   => '{1} Zmieniono kolejność :count stylu.|[2,*] Zmieniono kolejność :count stylów.',
        'title'     => 'Zmiana kolejności stylów',
    ],
    'theme'         => [
        'none'      => 'Użyj preferencji użytkownika',
        'override'  => 'Motyw nadrzędny',
        'success'   => 'Zmieniono motyw nadrzędny.',
        'title'     => 'Zmień motyw nadrzędy',
    ],
    'title'         => 'Motywy kampanii',
    'toggle'        => [
        'disable'   => 'Usunięto styl.',
        'enable'    => 'Zastosowano styl.',
    ],
    'update'        => [
        'success'   => 'Zmieniono styl :name.',
        'title'     => 'Zmiana stylu',
    ],
];
