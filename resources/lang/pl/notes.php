<?php

return [
    'create'        => [
        'success'   => 'Stworzono notatkę \':name\'',
        'title'     => 'Nowa notatka',
    ],
    'destroy'       => [
        'success'   => 'Usunięto notatkę \':name\'',
    ],
    'edit'          => [
        'success'   => 'Zmieniono notatkę \':name\'',
        'title'     => 'Edycja notatki :name',
    ],
    'fields'        => [
        'description'   => 'Opis',
        'image'         => 'Obraz',
        'is_pinned'     => 'Przypięta',
        'name'          => 'Nazwa',
        'note'          => 'Notatka źródłowa',
        'notes'         => 'Notatki pochodne',
        'type'          => 'Rodzaj',
    ],
    'helpers'       => [
        'nested_parent' => 'Wyświetlono notatki pochodzące od :parent.',
        'nested_without'=> 'Wyświetlono wszystkie notatki nie posiadające źródła. Kliknij na rząd, by wyświetlić notatki pochodne.',
    ],
    'hints'         => [
        'is_pinned' => 'Na pulpicie można przypiąć do 3 notatek.',
    ],
    'index'         => [
        'title' => 'Notatki',
    ],
    'placeholders'  => [
        'name'  => 'Nazwa notatki',
        'note'  => 'Wybierz notatkę źródłową',
        'type'  => 'Religia, rasa, system polityczny',
    ],
    'show'          => [],
];
