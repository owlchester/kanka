<?php

return [
    'actions'   => [
        'gallery'   => 'Z galerii',
        'url'       => 'Pobierz obraz z odnośnika',
    ],
    'browse'    => [
        'layouts'       => [
            'large' => 'Duże miniatury',
            'small' => 'Małe miniatury',
        ],
        'search'        => [
            'placeholder'   => 'Wyszukaj obraz w galerii',
        ],
        'title'         => 'Galeria',
        'unauthorized'  => 'Żadna z twoich ról nie posiada uprawień do "przeglądania galerii".',
    ],
    'cta'       => [
        'action'    => 'Odblokuj większy magazyn',
        'helper'    => 'Uzyskaj do :size GB magazynu w :premium-campaign.',
        'title'     => 'Magazy jest pełny',
    ],
    'delete'    => [
        'success'   => '[0] Usunięto 0 elementów|[1] Usunięto jeden element|{2,4} Usunięto :count elementy|{5,*} Usunięto :count elementów',
    ],
    'download'  => [
        'errors'    => [
            'copy_failed'           => 'Nasz serwer nie mógł pobrać obrazu',
            'gallery_full_free'     => 'Galeria jest pełna. Odblokuj wersję premium by zwiększyć ilość miejsca.',
            'gallery_full_premium'  => 'Galeria jest pełna. Najpierw usuń nieużywane pliki.',
            'invalid_format'        => 'Niewłaściwy rodzaj pliku.',
            'too_big'               => 'Plik jest zbyt duży.',
            'unauthorized'          => 'Żadna z twoich ról nie posiada uprawień do "przesyłania obrazów".',
        ],
    ],
    'file'      => [
        'saved' => 'Zapisano',
    ],
    'filters'   => [
        'only_unused'   => 'Pokaż tylko nieużywane pliki',
        'sort'          => 'Sortuj według',
    ],
    'move'      => [
        'success'   => '[0] Przeniesiono 0 elementów|[1] Przeniesiono jeden element|{2,4} Przeniesiono :count elementy|{5,*} Przeniesiono :count elementów',
    ],
    'update'    => [
        'home'      => 'Folder domowy',
        'success'   => '[0] Zmieniono 0 elementów|[1] Zmieniono jeden element|{2,4} Zmieniono :count elementy|{5,*} Zmieniono :count elementów',
    ],
];
