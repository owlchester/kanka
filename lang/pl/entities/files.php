<?php

return [
    'call-to-action'    => [
        'max'       => [
            'helper'    => 'Nie możesz dołączać nowych plików, póki któregoś nie usuniesz.',
            'limit'     => 'Element osiągnął limit dołączonych plików.',
        ],
        'upgrade'   => [
            'limit'     => 'Osiągnięto limit :limit plików dla tego elementu.',
            'upgrade'   => 'Ulepsz kampanię do poziomu premium by zwiększyć limit plików do :limit i zyskać większą swobodę twórczą.',
        ],
    ],
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
