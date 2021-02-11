<?php

return [
    'actions'       => [
        'add'   => 'Dodaj link',
    ],
    'create'        => [
        'success'   => 'Dodano link :name do elementu :entity.',
        'title'     => 'Dodaj link do :name',
    ],
    'destroy'       => [
        'success'   => 'Usunięto link :name z elementu :entity.',
    ],
    'fields'        => [
        'icon'      => 'Ikona',
        'name'      => 'Nazwa',
        'position'  => 'Pozycja',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'goto'      => 'Idź do :name',
        'icon'      => 'Możesz dostosować ikonę wyświetlaną przy linku. Użyj dowolnej ikony z :fontawesome albo zostaw to pole puste, by wyświetlać ikonę domyślną.',
        'leaving'   => 'Zaraz opuścisz Kankę i przejdziesz do strony zewnętrznej. Strona ta została załączona przez użytkownika i nie jest przez nas kontrolowana.',
        'url'       => 'Adres do którego zamierzasz przejść to :url.',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'W doładowanych kampaniach można dodawać elementom linki prowadzące do stron zewnętrznych.',
        'title'     => 'Linki dla :name',
    ],
    'update'        => [
        'success'   => 'Zaktualizowano link :name dla elementu :entity.',
        'title'     => 'Aktualizacja linka :name',
    ],
];
