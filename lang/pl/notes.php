<?php

return [
    'create'        => [
        'title' => 'Nowa notatka',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Notatki pochodne',
    ],
    'helpers'       => [
        'nested_without'    => 'Wyświetlono wszystkie notatki nieposiadające źródła. Kliknij na rząd, by wyświetlić notatki pochodne.',
    ],
    'hints'         => [
        'is_pinned' => 'Na pulpicie można przypiąć do 3 notatek.',
    ],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Wybierz notatkę źródłową',
        'type'  => 'Religia, rasa, system polityczny',
    ],
    'show'          => [],
];
