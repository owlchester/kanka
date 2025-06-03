<?php

return [
    'actions'           => [
        'add'   => 'Dodaj odnośnik',
    ],
    'call-to-action'    => 'Dodaj odnośnik do zasobów zewnętrznych, na przykład DnDBeyond. Zostanie wyświetlony bezpośrednio w opisie elementu.',
    'create'            => [
        'helper'    => 'Dodaje do :name odnośnik prowadzący na zewnątrz, na przykład do DnDBeyond.',
        'success'   => 'Dodano odnośnik :name do elementu :entity.',
        'title'     => 'Dodaj odnośnik do :name',
    ],
    'destroy'           => [
        'success'   => 'Usunięto odnośnik :name z elementu :entity.',
    ],
    'fields'            => [
        'icon'      => 'Ikona',
        'name'      => 'Nazwa',
        'position'  => 'Kolejność',
        'url'       => 'URL',
    ],
    'go'                => [
        'actions'       => [
            'confirm'   => 'Tak, na pewno',
            'trust'     => 'Nie pytaj ponownie',
        ],
        'description'   => 'Ten odnośnik prowadzi do :link. Czy na pewno chcesz tam trafić?',
        'title'         => 'Opuszczasz Kankę',
    ],
    'helpers'           => [
        'icon'      => 'Możesz dostosować ikonę wyświetlaną przy odnośniku. Użyj dowolnej ikony z :fontawesome albo zostaw to pole puste, by wyświetlać ikonę domyślną.',
        'parent'    => 'Wyświetla skrót po tym elemencie w menu bocznym, a nie w sekcji "Skróty".',
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'W doładowanych kampaniach można dodawać elementom odnośniki do stron zewnętrznych.',
        'title'     => 'Odnośniki elementu :name',
    ],
    'unboosted'         => [],
    'update'            => [
        'success'   => 'Zaktualizowano odnośnik :name dla elementu :entity.',
        'title'     => 'Aktualizacja odnośnika elementu :name',
    ],
];
