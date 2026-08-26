<?php

return [
    'actions'           => [
        'add'   => 'Dodaj link',
    ],
    'call-to-action'    => 'Dodaj link do zasobów zewnętrznych, na przykład DnDBeyond albo odnośnej strony wiki. Zostanie wyświetlony bezpośrednio w opisie elementu, dla ułatwienia dostępu.',
    'create'            => [
        'helper'    => 'Dodaje do :name link zewnętrzny, na przykład do DnDBeyond.',
        'success'   => 'Dodano link :name do elementu :entity.',
        'title'     => 'Nowy link',
    ],
    'destroy'           => [
        'success'   => 'Usunięto link :name.',
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
        'description'   => 'Ten link prowadzi do :link. Czy na pewno chcesz tam trafić?',
        'title'         => 'Opuszczasz Kankę',
    ],
    'helpers'           => [
        'icon'      => 'Dostosuj ikonę wyświetlaną przy linku porzy pomocy :fontawesome, na przykład :example. Więcej o dostępności ikon przeczytasz w :docs.',
        'parent'    => 'Wyświetla skrót po tym elemencie w menu bocznym, a nie w sekcji "Skróty".',
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'W doładowanych kampaniach można dodawać elementom linki do stron zewnętrznych.',
        'title'     => 'Linki elementu :name',
    ],
    'unboosted'         => [],
    'update'            => [
        'success'   => 'Zaktualizowano link :name dla elementu :entity.',
        'title'     => 'Aktualizacja linku elementu :name',
    ],
];
