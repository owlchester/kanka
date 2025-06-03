<?php

return [
    'call-to-action'    => [],
    'create'            => [
        'helper'            => 'Dodaje plik do :name. Zostanie doliczony do limitu pojemności galerii.',
        'success_plural'    => '{1} Dodano plik :name.|[2,4] Dodano :count pliki.|[5,*] Dodano :count plików.',
        'title'             => 'Nowy plik elementu :entity',
    ],
    'destroy'           => [
        'success'   => 'Usunięto plik :file.',
    ],
    'fields'            => [
        'file'  => 'Plik',
        'files' => 'Pliki',
        'name'  => 'Nazwa pliku',
    ],
    'max'               => [
        'title' => 'Osiągnięto limit',
    ],
    'update'            => [
        'success'   => 'Zaktualizowano plik :file.',
        'title'     => 'Zamieszanie plików elementu',
    ],
];
