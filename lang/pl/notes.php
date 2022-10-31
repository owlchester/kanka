<?php

return [
    'create'        => [
        'title' => 'Nowa notatka',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_pinned' => 'Przypięta',
        'note'      => 'Notatka źródłowa',
        'notes'     => 'Notatki pochodne',
    ],
    'helpers'       => [
        'nested_without'    => 'Wyświetlono wszystkie notatki nie posiadające źródła. Kliknij na rząd, by wyświetlić notatki pochodne.',
    ],
    'hints'         => [
        'is_pinned' => 'Na pulpicie można przypiąć do 3 notatek.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Nazwa notatki',
        'note'  => 'Wybierz notatkę źródłową',
        'type'  => 'Religia, rasa, system polityczny',
    ],
    'show'          => [],
];
