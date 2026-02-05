<?php

return [
    'actions'       => [
        'current'   => 'Obecny motyw: :theme',
        'disable'   => 'Wyłącz',
        'enable'    => 'Uruchom',
        'new'       => 'Nowy styl',
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
    'delete'        => [
        'success'   => 'Usunięto styl :name',
    ],
    'errors'        => [
        'max_content'   => 'Regułą CSS nie może być dłuższa niż :amount znaków.',
        'max_reached'   => 'Osiągniętą maksymalną liczne (:max) stylów.',
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
        'here'          => 'z naszego bloga',
        'is_enabled'    => 'Użyj tego motywu na każdej stronie',
        'main'          => 'Możesz tworzyć własne style CSS w doładowanych kampaniach. Będą ładowane po załadowaniu stylów pobranych z targowiska. Więcej o tworzeniu stylów dowiesz się :here.',
        'tutorial'      => 'Kontroluje estetykę kampanii. Pozwala wybrać kolory, preferencje układu treści i inne elementy wizualne. Modyfikacje dotyczą tylko tej kampanii i można je w każdej chwili zmienić.',
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
        'success'   => 'Zmieniono motyw kampanii.',
        'title'     => 'Zmień motyw kampanii',
    ],
    'title'         => 'Motywy kampanii',
    'toggle'        => [
        'disable'   => 'Skutecznie zastosowano styl.',
        'enable'    => 'Skuteczne usunięto styl.',
    ],
    'update'        => [
        'success'   => 'Zmieniono styl :name.',
        'title'     => 'Zmiana stylu',
    ],
];
